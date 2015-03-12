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
 * @package 		Phpfox_Component
 * @version 		$Id: index-mobile.class.php 1491 2010-03-03 15:34:04Z Raymond_Benc $
 */
class Friend_Component_Controller_Index_Mobile extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		
		$iPageSize = 10;
		$iPage = $this->request()->getInt('page');
		$bIsSearch = false;
		
		$aCond = array();
		$aCond[] = 'AND friend.user_id = ' . Phpfox::getUserId();		
		if (($sSearch = $this->request()->get('search')) || ($this->request()->get('search-query')))
		{
			if ($this->request()->get('search-query'))
			{
				$sSearch = Phpfox::getLib('session')->get('mfsearch');
			}
			
			$bIsSearch = true;
			$aCond[] = "AND (u.full_name LIKE '%" . Phpfox::getLib('database')->escape($sSearch) . "%' OR u.email LIKE '%" . Phpfox::getLib('database')->escape($sSearch) . "%' OR u.user_name LIKE '%" . Phpfox::getLib('database')->escape($sSearch) . "%')";	
			$this->url()->setParam('search-query', 'true');
			
			Phpfox::getLib('session')->set('mfsearch', $sSearch);
		}		
		
		if ($bIsSearch == false)
		{
			Phpfox::getLib('session')->remove('mfsearch');
		}
		
		list($iCnt, $aFriends) = Phpfox::getService('friend')->get($aCond, 'u.full_name ASC', $iPage, $iPageSize);	
		
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt));
		
		$this->template()->assign(array(
				'aFriends' => $aFriends,
				'bMobileFriendIsActive' => true,
				'bIsSearch' => $bIsSearch,
				'bIsFriendSelect' => ($this->request()->get('req2') == 'select' ? true : false)				
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('friend.component_controller_index_mobile_clean')) ? eval($sPlugin) : false);
	}
}

?>