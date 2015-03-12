<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox_Component
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Apps_Service_Browse extends Phpfox_Service 
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
			$aRows[$iKey]['link'] = Phpfox::permalink('apps', $aRow['app_id'], $aRow['app_title']);//Phpfox::getService('pages')->getUrl($aRow['page_id'], $aRow['title'], $aRow['vanity_url']);
			$aRows[$iKey]['aFeed'] = array(			
				'feed_display' => 'mini',	
				'comment_type_id' => 'pages',
				'privacy' => 0,
				'comment_privacy' => 0,
				'like_type_id' => 'pages',				
				'feed_is_liked' => (isset($aRow['is_liked']) ? $aRow['is_liked'] : false),
				//'feed_is_friend' => (isset($aRow['is_friend']) ? $aRow['is_friend'] : false),
				'item_id' => $aRow['page_id'],
				'user_id' => $aRow['user_id'],
				'total_comment' => $aRow['total_comment'],
				'feed_total_like' => $aRow['total_like'],
				'total_like' => $aRow['total_like'],
				'feed_link' => Phpfox::getService('pages')->getUrl($aRow['page_id'], $aRow['pages_title'], $aRow['vanity_url']),
				'feed_title' => $aRow['app_title']			
			);			
		}		
	}	
	
	public function query()
	{
		$this->database()->select('pages.page_id, pages.title AS pages_title, pages.total_like, pages.total_comment, pagesurl.vanity_url, ')
			->join(Phpfox::getT('pages'), 'pages','pages.app_id = app.app_id')
			->leftJoin(Phpfox::getT('pages_url'), 'pagesurl','pagesurl.page_id = pages.page_id');
		
		if (Phpfox::isUser() && Phpfox::isModule('like'))
		{
			$this->database()->select('lik.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'lik', 'lik.type_id = \'pages\' AND lik.item_id = pages.page_id AND lik.user_id = ' . Phpfox::getUserId());
		}
		
		if (Phpfox::getLib('request')->get('req2') != 'category')
		{
			$this->database()->select('ac.name AS category_name, ');
			$this->database()->leftJoin(Phpfox::getT('app_category_data'), 'cdd','cdd.app_id = app.app_id');
			$this->database()->leftJoin(Phpfox::getT('app_category'), 'ac','ac.category_id = cdd.category_id');			
		}
	}
	
	/**
	 * This function runs when running the Count and when fetching the items
	 * @param type $bIsCount
	 * @param type $bNoQueryFriend 
	 */
	public function getQueryJoins($bIsCount = false, $bNoQueryFriend = false)
	{
		$oReq = Phpfox::getLib('request');
		if ($oReq->get('view') == 'installed')
		{
			if ($bIsCount === false)
			{
				$this->database()
					->join(Phpfox::getT('app_installed'), 'ai', 'ai.app_id = app.app_id AND ai.user_id = ' . Phpfox::getUserId())
					->select('ai.install_id as is_installed, ')
					->group('app.app_id');
			}		
		}	
		
		if ($oReq->get('req2') == 'category')
		{
			$this->database()->join(Phpfox::getT('app_category_data'), 'cdd','cdd.app_id = app.app_id AND cdd.category_id = ' . $oReq->getInt('req3'));
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
