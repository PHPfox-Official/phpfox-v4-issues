<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

use MediaEmbed\MediaEmbed;

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Service
 * @version 		$Id: link.class.php 7240 2014-03-31 15:22:15Z Fern $
 */
class Link_Service_Link extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('link');	
	}
	
	public function getLink($sUrl)
	{
		if (substr($sUrl, 0, 7) != 'http://' && substr($sUrl, 0, 8) != 'https://')
		{
			$sUrl = 'http://' . $sUrl;
		}
			
		$aParts = parse_url($sUrl);	
				
		if (!isset($aParts['host']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('link.not_a_valid_link'), true);
		}

		/*
		$key = '';
		$aReturn = array();		
		$oVideo = json_decode(Phpfox_Request::instance()->send('http://api.embed.ly/1/oembed?key=' . $key . '&format=json&maxwidth=400&url=' . urlencode($sUrl), array(), 'GET', $_SERVER['HTTP_USER_AGENT']));
		if (isset($oVideo->error_code)) {
			throw new \Exception($oVideo->error_message);
		}

		if(!isset($oVideo->thumbnail_url))
		{
			if(preg_match('/facebook/i', $sUrl))
			{
				$aRegexes = array(
					'/https?:\/\/www\.facebook\.com\/v\/([0-9]+)/i', // Flash Embed
					'/https?:\/\/www\.facebook\.com\/.*\?v=([0-9]+)/i', // New Flash Embed
					'/https?:\/\/www\.facebook\.com\/video\/embed\?video_id=([0-9]+)/i' // iFrame Embed
				);
				
				foreach($aRegexes as $sRegex)
				{
					if (preg_match($sRegex, $sUrl, $aMatches)) 
					{
						$iId = $aMatches[1];
					}
				}
				
				$oThumbnail = json_decode(Phpfox_Request::instance()->send('https://graph.facebook.com/' . $iId . '/picture?redirect=false', array(), 'GET', $_SERVER['HTTP_USER_AGENT']));
				$oVideo->thumbnail_url = $oThumbnail->data->url;
				$oVideo->type = 'video';
				$oVideo->html = '<iframe src="https://www.facebook.com/video/embed?video_id=' . $iId . '" width="400" height="300" frameborder="0"></iframe>';
			}
		}

		if (isset($oVideo->provider_url) || (isset($oVideo->photo)))
		{
			$aReturn = array(
				'link' => $sUrl,
				'title' => (isset($oVideo->title) ? strip_tags($oVideo->title) : ''),
				'description' => (isset($oVideo->description) ? strip_tags($oVideo->description) : ''),
				'default_image' => ($oVideo->type == 'photo' ? $oVideo->url : (isset($oVideo->thumbnail_url) ? $oVideo->thumbnail_url : '')),
				'embed_code' => ($oVideo->type == 'video' ? $oVideo->html : '')
			);
					
			return $aReturn;
		}	
		*/

		$aParseBuild = array();
		$sContent = Phpfox_Request::instance()->send($sUrl, array(), 'GET', $_SERVER['HTTP_USER_AGENT'], null, true);
		preg_match_all('/<(meta|link)(.*?)>/i', $sContent, $aRegMatches);
		if (preg_match('/<title>(.*?)<\/title>/is', $sContent, $aMatches)) {
			$aParseBuild['title'] = $aMatches[1];
		}

		if (isset($aRegMatches[2]))
		{
			foreach ($aRegMatches as $iKey => $aMatch)
			{
				if ($iKey !== 2)
				{
					continue;
				}				
				
				foreach ($aMatch as $sLine)
				{
					$sLine = rtrim($sLine, '/');
					$sLine = trim($sLine);

					preg_match('/(property|name|rel|image_src)=("|\')(.*?)("|\')/is', $sLine, $aType);
					if (count($aType) && isset($aType[3]))
					{
						$sType = $aType[3];
						preg_match('/(content|type)=("|\')(.*?)("|\')/i', $sLine, $aValue);
						if (count($aValue) && isset($aValue[3]))
						{						
							if ($sType == 'alternate')
							{
								$sType = $aValue[3];
								preg_match('/href=("|\')(.*?)("|\')/i', $sLine, $aHref);
								if (isset($aHref[2]))
								{
									$aValue[3] = $aHref[2];
								}
							}
							$aParseBuild[$sType] = $aValue[3];
						}
					}
				}
			}
		}

		$image = '';
		$embed = '';
		$MediaEmbed = new MediaEmbed();
		$MediaObject = $MediaEmbed->parseUrl($sUrl);
		if (!$MediaObject instanceof \MediaEmbed\Object\MediaObject) {
			// $xml = simplexml_load_string($sContent, 'SimpleXMLElement', LIBXML_NOERROR |  LIBXML_ERR_NONE);
			// throw new Exception('Does not look like a URL we can embed.');
			if (isset($aParseBuild['og:image'])) {
				$image = $aParseBuild['og:image'];
			}
		}
		else {
			$image = $MediaObject->image();
			$embed = $MediaObject->getEmbedCode();
		}

		if (isset($aParseBuild['title'])) {
			$aParseBuild['og:title'] = $aParseBuild['title'];
			$aParseBuild['og:description'] = $aParseBuild['description'];
		}

		if (!$image && isset($aParseBuild['og:image'])) {
			$image = $aParseBuild['og:image'];
		}

		return [
			'link' => $sUrl,
			'title' => (isset($aParseBuild['og:title']) ? $aParseBuild['og:title'] : ''),
			'description' => (isset($aParseBuild['og:description']) ? $aParseBuild['og:description'] : ''),
			'default_image' => $image,
			'embed_code' => $embed
		];
	}
	
	/**
	 * Takes into account redirects.
	 */
	public function getHTML($sUrl)
	{
		$iMaxCount = 2;
		$sContent = '';
		while( ($iMaxCount--) > 0)
		{
			$sContent = Phpfox_Request::instance()->send($sUrl, array(), 'GET', $_SERVER['HTTP_USER_AGENT'], null, true);
			$sHeaders = substr($sContent, 0, strpos($sContent, '<'));
			// if (strpos($sHeaders, 'Moved') !== false && 
			d($sHeaders);
			//d($sContent, true);
			die();
		}
	}
	
	public function getEmbedCode($iId, $bIsPopUp = false)
	{
		$aLinkEmbed = $this->database()->select('embed_code')	
			->from(Phpfox::getT('link_embed'))
			->where('link_id = ' . (int) $iId)
			->execute('getSlaveRow');

		$iWidth = 640;
		$iHeight = 390;
		if (!$bIsPopUp)
		{
			$iWidth = 480;
			$iHeight = 295;
		}
		
		$aLinkEmbed['embed_code'] = preg_replace('/width=\"(.*?)\"/i', 'width="' . $iWidth . '"', $aLinkEmbed['embed_code']);
		$aLinkEmbed['embed_code'] = preg_replace('/height=\"(.*?)\"/i', 'height="' . $iHeight . '"', $aLinkEmbed['embed_code']);
		$aLinkEmbed['embed_code'] = str_replace(array('&lt;', '&gt;', '&quot;'), array('<', '>', '"'), $aLinkEmbed['embed_code']);

		/*
		$aLinkEmbed['embed_code'] = preg_replace_callback('/<object(.*?)>(.*?)<\/object>/is', array($this, '_embedWmode'), $aLinkEmbed['embed_code']);
		if (Phpfox::isModule('video') && Phpfox::getParam('video.disable_youtube_related_videos'))
		{
			 if (preg_match('/src=(["\'])(.*?)\1/', $aLinkEmbed['embed_code'], $aMatch) > 0)
			 {
				$aLinkEmbed['embed_code'] = str_replace($aMatch[2], $aMatch[2] . '&amp;rel=0', $aLinkEmbed['embed_code']);
			 }
		}
		*/
		
		// http://www.phpfox.com/tracker/view/14676/
		if(Phpfox::getParam('core.force_https_secure_pages') && Phpfox::getParam('core.force_secure_site'))
		{
			$aLinkEmbed['embed_code'] = str_replace('http://', 'https://', $aLinkEmbed['embed_code']);
		}
		
		return $aLinkEmbed['embed_code'];
	}
	
	public function getLinkById($iId)
	{
		$aLink = $this->database()->select('l.*, u.user_name')
			->from(Phpfox::getT('link'), 'l')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = l.user_id')
			->where('l.link_id = ' . (int) $iId)
			->execute('getSlaveRow');
		
		if (!isset($aLink['link_id']))
		{
			return false;
		}
		
		return $aLink;
	}
	
	/* Havent tested this */
	public function getInfoForAction($aItem)
	{
		if (is_numeric($aItem))
		{
			$aItem = array('item_id' => $aItem);
		}
		$aRow = $this->database()->select('l.link_id, l.title, l.user_id, u.gender, u.full_name')
			->from(Phpfox::getT('link'), 'l')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = l.user_id')
			->where('l.link_id = ' . (int) $aItem['item_id'])
			->execute('getSlaveRow');
		
		$aRow['link'] = Phpfox_Url::instance()->permalink('link', $aRow['link_id'], $aRow['title']);
		return $aRow;
	}
	
	/**
	 * If a call is made to an unknown method attempt to connect
	 * it to a specific plug-in with the same name thus allowing 
	 * plug-in developers the ability to extend classes.
	 *
	 * @param string $sMethod is the name of the method
	 * @param array $aArguments is the array of arguments of being passed
	 */
	public function __call($sMethod, $aArguments)
	{
		/**
		 * Check if such a plug-in exists and if it does call it.
		 */
		if ($sPlugin = Phpfox_Plugin::get('link.service_link__call'))
		{
			eval($sPlugin);
			return;
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
	
    private function _embedWmode($aMatches)
    {
    	return '<object ' . $aMatches[1] . '><param name="wmode" value="transparent"></param>' . str_replace('<embed ', '<embed  wmode="transparent" ', $aMatches[2]) . '</object>';
    }	
}

?>
