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
class Profile_Service_Api extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('video');
		$this->_oApi = Phpfox::getService('api');	
	}
	
	public function comment()
	{
		/*
		@title 
		@info Comment on a users profile. It will return <b>true</b> on success, <b>false</b> on failure.
		@method POST
		@extra user_id=#{User ID# of the user we will post the comment to|int|yes}&message=#{Comment to post|string|yes}
		@return
		*/		
		$aVals = array(
				'parent_user_id' => $this->_oApi->get('user_id'),
				'user_status' => $this->_oApi->get('message')
				);
		if (($iId = Phpfox::getService('feed.process')->addComment($aVals)) !== false)
		{
			return true;
		}
		
		return false;
	}
}

?>