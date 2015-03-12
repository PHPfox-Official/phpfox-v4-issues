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
 * @version 		$Id: service.class.php 67 2009-01-20 11:32:45Z Raymond_Benc $
 */
class Pages_Service_Browse extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('pages');
	}
	
	public function processRows(&$aRows)
	{
		foreach ($aRows as $iKey => $aRow)
		{	
			$aRows[$iKey]['link'] = Phpfox::getService('pages')->getUrl($aRow['page_id'], $aRow['title'], $aRow['vanity_url']);
			$aRows[$iKey]['aFeed'] = array(			
				'feed_display' => 'mini',	
				'comment_type_id' => 'pages',
				'privacy' => 0,
				'comment_privacy' => 0,
				'like_type_id' => 'pages',				
				'feed_is_liked' => (isset($aRow['is_liked']) ? $aRow['is_liked'] : false),
				'feed_is_friend' => (isset($aRow['is_friend']) ? $aRow['is_friend'] : false),
				'item_id' => $aRow['page_id'],
				'user_id' => $aRow['user_id'],
				'total_comment' => $aRow['total_comment'],
				'feed_total_like' => $aRow['total_like'],
				'total_like' => $aRow['total_like'],
				'feed_link' => Phpfox::getService('pages')->getUrl($aRow['page_id'], $aRow['title'], $aRow['vanity_url']),
				'feed_title' => $aRow['title'],
				'type_id' => 'pages'
			);
		}
	}
	
	public function query()
	{
		$this->database()->select('pu.vanity_url, ')->leftJoin(Phpfox::getT('pages_url'), 'pu', 'pu.page_id = pages.page_id');
		$this->database()->select('pc.page_type, pc.name AS category_name, ')->leftJoin(Phpfox::getT('pages_category'), 'pc', 'pc.category_id = pages.category_id');
		$this->database()->select('u2.server_id AS profile_server_id, u2.user_image AS profile_user_image, ')->leftJoin(Phpfox::getT('user'), 'u2', 'u2.profile_page_id = pages.page_id');
		
		if (Phpfox::isUser() && Phpfox::isModule('like'))
		{
			$this->database()->select('lik.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'lik', 'lik.type_id = \'pages\' AND lik.item_id = pages.page_id AND lik.user_id = ' . Phpfox::getUserId());
		}		
	}
	
	public function getQueryJoins($bIsCount = false, $bNoQueryFriend = false)
	{
		if (Phpfox::isModule('friend') && Phpfox::getService('friend')->queryJoin($bNoQueryFriend))
		{
			$this->database()->join(Phpfox::getT('friend'), 'friends', 'friends.user_id = pages.user_id AND friends.friend_user_id = ' . Phpfox::getUserId());	
		}	
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
		if ($sPlugin = Phpfox_Plugin::get('pages.service_browse__call'))
		{
			eval($sPlugin);
			return;
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
}

?>
