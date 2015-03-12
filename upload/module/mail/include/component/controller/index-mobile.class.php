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
class Mail_Component_Controller_Index_Mobile extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aCond = array();
		$iPage = $this->request()->getInt('page');
		$iPageSize = 10;				
		$bIsSentbox = ($this->request()->get('req2') == 'sent' ? true : false);
		$bIsSearch = false;
		
		if ($bIsSentbox)
		{
			$aCond[] = 'm.owner_user_id = ' . Phpfox::getUserId() . ' AND m.owner_type_id = 0';
		}
		else
		{
			$aCond[] = 'm.viewer_folder_id = 0 AND m.viewer_user_id = ' . Phpfox::getUserId() . ' AND m.viewer_type_id = 0';
		}		
		
		if (($sSearch = $this->request()->get('search')) || ($this->request()->get('search-query')))
		{
			if ($this->request()->get('search-query'))
			{
				$sSearch = Phpfox::getLib('session')->get('mfsearch');
			}
			
			$bIsSearch = true;
			$aCond[] = "AND (m.subject LIKE '%" . Phpfox::getLib('database')->escape($sSearch) . "%' OR m.preview LIKE '%" . Phpfox::getLib('database')->escape($sSearch) . "%')";	
			$this->url()->setParam('search-query', 'true');
			
			Phpfox::getLib('session')->set('mfsearch', $sSearch);
		}		
		
		if ($bIsSearch == false)
		{
			Phpfox::getLib('session')->remove('mfsearch');
		}		
		
		list($iCnt, $aMessages, $aInputs) = Phpfox::getService('mail')->get($aCond, 'm.time_updated DESC', $iPage, $iPageSize, $bIsSentbox);
		
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt));
				
		$this->template()->assign(array(
				'bMobileInboxIsActive' => true,
				'aMessages' => $aMessages,
				'bIsSearch' => $bIsSearch,
				'bIsSentbox' => $bIsSentbox,
				'aMobileSubMenus' => array(
					$this->url()->makeUrl('mail') => Phpfox::getPhrase('mail.mobile_messages'),
					$this->url()->makeUrl('mail', 'sent') => Phpfox::getPhrase('mail.sent'),
					$this->url()->makeUrl('mail', 'compose') => Phpfox::getPhrase('mail.compose')
				),
				'sActiveMobileSubMenu' => $this->url()->makeUrl('mail', ($this->request()->get('req2') == '' ? null : $this->request()->get('req2')))					
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('mail.component_controller_index_mobile_clean')) ? eval($sPlugin) : false);
	}
}

?>