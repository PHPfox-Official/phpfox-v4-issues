<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Service
 * @version 		$Id: api.class.php 7059 2014-01-22 14:20:10Z Fern $
 */
class Video_Service_Api extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('video');
		$this->_oApi = Phpfox::getService('api');	
	}
	
	public function add()
	{
		/*
		@title
		@info Add a video. To share a video you can simply pass a URL of a that has a video. 
		@method POST
		@extra url=#{Url of the video to share.|string|yes}
		@return id=#{Item ID#|int}&title=#{Title of the item|string}&description=#{Description of the item|string}&likes=#{Total number of likes|int}&permalink=#{Link to the item|string}
		*/		
		if (Phpfox::getService('video.grab')->get($this->_oApi->get('url')))
		{
			$aVals = array(
					'url' => $this->_oApi->get('url')
					);
			
			if (($iId = Phpfox::getService('video.process')->addShareVideo($aVals)) !== false)
			{
				return $this->get($iId);				
			}	
		}	
	}
	
	public function get($iLinkId = 0)
	{
		/*
		@title
		@info Get all public videos. If you pass a user ID# it will return just the videos for that user. If you pass a video ID# it will return just that video.
		@method GET
		@extra user_id=#{Pass a user_id if you want to return videos from a specific user.|int|no}&id=#{Pass a video ID to get a specific link.|int|no}
		@return id=#{Item ID#|int}&title=#{Title of the item|string}&description=#{Description of the item|string}&likes=#{Total number of likes|int}&permalink=#{Link to the item|string}&embed_code=#{HTML embed code|string}
		*/
		if ((int) $this->_oApi->get('user_id') !== 0)
		{
			$iUserId = $this->_oApi->get('user_id');
		}
		
		if ((int) $this->_oApi->get('id') !== 0)
		{
			$iLinkId = $this->_oApi->get('id');
		}
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_sTable, 'p')
			->where(($iLinkId > 0 ? 'p.video_id = ' . (int) $iLinkId : (isset($iUserId) ? 'p.user_id = ' . (int) $iUserId . ' AND ' : '') . ' p.privacy = 0 AND p.in_process = 0 AND p.view_id = 0'))
			->execute('getSlaveField');
		
		$this->_oApi->setTotal($iCnt);
		
		$iOffset = ($this->_oApi->get('page') * 10);
		
		if (Phpfox::isModule('like'))
		{
			$this->database()->select('lik.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'lik', 'lik.type_id = \'video\' AND lik.item_id = p.video_id AND lik.user_id = ' . Phpfox::getUserId());
		}		
		
		$aRows = $this->database()->select('p.*, vt.text_parsed, ve.embed_code, ' . Phpfox::getUserField())
			->from($this->_sTable, 'p')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = p.user_id')			
			->join(Phpfox::getT('video_text'), 'vt', 'vt.video_id = p.video_id')
			->leftJoin(Phpfox::getT('video_embed'), 've', 've.video_id = p.video_id')
			->where(($iLinkId > 0 ? 'p.video_id = ' . (int) $iLinkId : (isset($iUserId) ? 'p.user_id = ' . (int) $iUserId . ' AND ' : '') . ' p.privacy = 0 AND p.in_process = 0 AND p.view_id = 0'))
			->limit($iOffset, 10)
			->order('p.time_stamp DESC')
			->execute('getSlaveRows');		
		
		$aReturns = array();
		foreach ($aRows as $aRow)
		{
			if (!$aRow['is_stream'])
			{
				$sConfig = '{\'clip\':{';
				$sConfig .= '\'baseUrl\': \'' . Phpfox::getParam('video.url') . '\',';
				$sConfig .= '\'url\': \'' . $aRow['destination'] . '\',';
				$sConfig .= '\'autoBuffering\': true,';
				$sConfig .= '\'autoPlay\': false';
				$sConfig .= '}';
				$sConfig .= '}';
				
				$aRow['embed_code'] = '<object width="430" height="344">';
				$aRow['embed_code'] .= '<embed width="430" height="344" type="application/x-shockwave-flash" wmode="transparent" src="' . Phpfox::getParam('core.url_static_script') . 'player/flowplayer/flowplayer.swf?config=' . $sConfig . '"></embed>';
				$aRow['embed_code'] .= '</object>';				
			}
			
			$sUserImage = Phpfox::getLib('image.helper')->display(array(
					'user' => $aRow,
					'suffix' => '_50_square',
					'return_url' => true
					)
			);			
			
			$sVideoPhoto = Phpfox::getLib('image.helper')->display(array(
					'path' => 'video.url_image',
					'server_id' => $aRow['image_server_id'],
					'file' => $aRow['image_path'],
					'suffix' => '_120',
					'return_url' => true
				)
			);			
			
			$aReturns[] = array(
					'id' => $aRow['video_id'],
					'title' => $aRow['title'],
					'description' => Phpfox::getLib('parse.output')->parse($aRow['text_parsed']),
					'likes' => $aRow['total_like'],
					'permalink' => Phpfox::getLib('url')->permalink('video', $aRow['video_id'], $aRow['title']),
					'embed_code' => $aRow['embed_code'],
					'photo' => $sVideoPhoto,
					'is_liked' => (empty($aRow['is_liked']) ? false : true),					
					'comments' => $aRow['total_comment'],
					'uploaded_by' => $aRow['full_name'],
					'uploaded_by_id' => $aRow['user_id'],
					'uploaded_by_url' => Phpfox::getLib('url')->makeUrl($aRow['user_name']),
					'uploaded_by_username' => $aRow['user_name'],		
					'uploaded_by_image' => $sUserImage,
					'convert_time_stamp' => Phpfox::getLib('date')->convertTime($aRow['time_stamp'], 'comment.comment_time_stamp')
					);
		}
		
		if ($iLinkId && count($aReturns))
		{
			return $aReturns[0];
		}
		
		return $aReturns;		
	}
}

?>
