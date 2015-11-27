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
 * @version 		$Id: api.class.php 5129 2013-01-14 12:38:16Z Raymond_Benc $
 */
class Comment_Service_Api extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('comment');
		$this->_oApi = Phpfox::getService('api');	
	}

	public function get($iId = null)
	{
		/*
		@title
		@info Get comments for a specific item.
		@method GET
		@extra module=#{Module name.|string|yes}&id=#{Item ID#|int|yes}
		@return profile_user_id=#{Poster user ID#|int}&profile_user_name=#{Poster user name|string}&profile_full_name=#{Poster full name|string}&profile_image=#{Poster profile image|string}&time_stamp=#{Time stamp|int}&post_convert_time=#{User friendly time stamp|string}&text=#{Comment text|string}
		*/		
		$aComments = array();
		$aRows = Phpfox::getService('comment')->getCommentsForFeed($this->_oApi->get('module'), $this->_oApi->get('id'), 50, null, $iId);
		foreach ($aRows as $iKey => $aRow)
		{
			$aComments[$iKey] = Phpfox::getService('apps')->buildUser($aRow);
			$aComments[$iKey]['time_stamp'] = $aRow['time_stamp'];
			$aComments[$iKey]['post_convert_time'] = $aRow['post_convert_time'];
			$aComments[$iKey]['text'] = Phpfox::getLib('parse.output')->parse($aRow['text']);
		}
		
		if ($iId !== null)
		{
			return $aComments[0];
		}
		
		return $aComments;	
	}
	
	public function add()
	{
		/*
		@title
		@info Add a new comment
		@method GET
		@extra module=#{Module name.|string|yes}&id=#{Item ID#|int|yes}&text=#{Comment text|string|yes}
		@return profile_user_id=#{Poster user ID#|int}&profile_user_name=#{Poster user name|string}&profile_full_name=#{Poster full name|string}&profile_image=#{Poster profile image|string}&time_stamp=#{Time stamp|int}&post_convert_time=#{User friendly time stamp|string}&text=#{Comment text|string}
		*/		
		$aVals = array(
				'type' => $this->_oApi->get('module'),
				'item_id' => $this->_oApi->get('id'),
				'parent_id' => '0',
				'is_via_feed' => '0',
				'text' => $this->_oApi->get('text')							
				);
		
		if (($mReturn = Phpfox::getService('comment.process')->add($aVals)) !== false)
		{		
			return $this->get($mReturn);
		}
		
		return false;
	}
}

?>