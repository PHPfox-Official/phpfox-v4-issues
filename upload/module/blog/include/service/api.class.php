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
 * @version 		$Id: api.class.php 5112 2013-01-11 06:56:25Z Raymond_Benc $
 */
class Blog_Service_Api extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('blog');
		$this->_oApi = Phpfox::getService('api');	
	}

	public function add()
	{
		/*
		@title
		@info Create a blog for a user.
		@method POST
		@extra title=#{Title of the blog|string|yes}&text=#{Content for the blog|string|yes}
		@return id=#{ID# for the blog|int}&title=#{Title of the blog|string}&likes=#{Total number of likes|int}&content=#{Blog content|string}&created_by=#{User that created the blog|string}&created_by_url=#{Link to the users profile|string}
		*/
	
		if ($this->_oApi->isAllowed('blog.add_blog') == false)
		{
			return $this->_oApi->error('blog.add_blog', 'Unable to add a blog for this user.');
		}
	
		$aInsert = array(
				'title' => $this->_oApi->get('title'),
				'text' => $this->_oApi->get('text')
		);
	
		$iId = Phpfox::getService('blog.process')->add($aInsert);
		if (!$iId)
		{
			return $this->_oApi->error('blog.unable_to_create_blog', implode('', Phpfox_Error::get()));
		}
	
		$aRows = $this->get($iId);
	
		return $aRows[0];
	}
	
	public function get($iId = 0)
	{
		/*
		@title
		@info Get all public blogs. If you pass a user ID# it will return the blogs for that user. If you pass a blog ID# it will just return that blog.
		@method GET
		@extra user_id=#{User ID# of a specific user|int|no}&id=#{Blog ID# if you wish to return a specific blog|int|no}
		@return id=#{ID# for the blog|int}&title=#{Title of the blog|string}&permalink=#{Link to the blog|string}&likes=#{Total number of likes|int}&content=#{Blog content|string}&created_by=#{User that created the blog|string}&created_by_url=#{Link to the users profile|string}
		*/
		
		if ((int) $this->_oApi->get('id') !== 0)
		{
			$iId = $this->_oApi->get('id');
		}		
	
		$iUserId = $this->_oApi->get('user_id');
	
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_sTable, 'b')
			->where((empty($iId) ? '' . (empty($iUserId) ? '' : 'b.user_id = ' . (int) $iUserId . ' AND ') . ' b.is_approved = 1 AND b.privacy = 0 AND b.post_status = 1' : 'b.blog_id = ' . (int) $iId))
			->execute('getSlaveField');
	
		$this->_oApi->setTotal($iCnt);
	
		$aRows = $this->database()->select('b.*, bt.text_parsed, ' . Phpfox::getUserField())
			->from($this->_sTable, 'b')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
			->join(Phpfox::getT('blog_text'), 'bt', 'bt.blog_id = b.blog_id')
			->where((empty($iId) ? '' . (empty($iUserId) ? '' : 'b.user_id = ' . (int) $iUserId . ' AND ') . ' b.is_approved = 1 AND b.privacy = 0 AND b.post_status = 1' : 'b.blog_id = ' . (int) $iId))
			->limit($this->_oApi->get('page'), 10, $iCnt)
			->order('b.time_stamp DESC')
			->execute('getSlaveRows');
	
		$aReturn = array();
		foreach ($aRows as $iKey => $aRow)
		{
			$aReturn[$iKey] = array(
					'id' => $aRow['blog_id'],
					'title' => $aRow['title'],
					'likes' => $aRow['total_like'],
					'permalink' => Phpfox::permalink('blog', $aRow['blog_id'], $aRow['title']),
					'content' => Phpfox::getLib('parse.output')->parse($aRow['text_parsed']),
					'created_by' => $aRow['full_name'],
					'created_by_url' => Phpfox::getLib('url')->makeUrl($aRow['user_name'])
			);
		}
	
		return $aReturn;
	}	
}

?>