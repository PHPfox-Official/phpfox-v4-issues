<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Admincp
 * @version 		$Id: add.class.php 4565 2012-07-26 12:02:50Z Miguel_Espinoza $
 */
class Admincp_Component_Controller_Menu_Add extends Phpfox_Component 
{
	/**
	 * Controller
	 */
	public function process()
	{	
		$oAdmincpMenu =  Admincp_Service_Menu_Menu::instance();
		$bIsEdit = false;
		$bIsPage = false;
		
		if (Phpfox::isModule('page') && ($sPage = $this->request()->get('page')))
		{
			$aPage = Phpfox::getService('page')->getPage($sPage, true);			
			if (isset($aPage['page_id']))
			{
				$bIsPage = true;	
				$this->template()->assign(array(
						'aPage' => $aPage,
						'sModuleValue' => ($aPage['module_id'] ? $aPage['module_id'] . '|' . $aPage['module_id'] : 'page|page'),
						'aAccess' => (empty($aPage['disallow_access']) ? null : unserialize($aPage['disallow_access']))
					)
				);
			}
		}
		
		if (($iEditId = $this->request()->getInt('id')) || ($iEditId = $this->request()->getInt('menu_id')))
		{
			$aRow = $oAdmincpMenu->getForEdit($iEditId);			
			$aLanguages = Phpfox::getService('language')->getWithPhrase($aRow['var_name']);
			$bIsEdit = true;
			$aTypes = Admincp_Service_Menu_Menu::instance()->getTypes();
			if (!in_array($aRow['m_connection'], $aTypes))
			{
				$aRow['m_connection'] = $aRow['m_connection'];
			}
			$this->template()->assign(array(
					'aForms' => $aRow,
					'aAccess' => (empty($aRow['disallow_access']) ? null : unserialize($aRow['disallow_access']))
				)
			);
		}
		else 
		{
			$aLanguages = Phpfox::getService('language')->get();
		}
		
		if ($aVals = $this->request()->getArray('val'))
		{			
			if ($bIsEdit)
			{
				$sMessage = Phpfox::getPhrase('admincp.menu_successfully_updated');
				Admincp_Service_Menu_Process::instance()->update($aRow['menu_id'], $aVals);
			}
			else 
			{
				$sMessage = Phpfox::getPhrase('admincp.menu_successfully_added');
				Admincp_Service_Menu_Process::instance()->add($aVals);
			}
			
			if (isset($aVals['is_page']))
			{
				$this->url()->send($aVals['url_value'], null, Phpfox::getPhrase('admincp.page_menu_successfully_added'));
			}
			
			if ($bIsEdit)
			{
				$this->url()->send('admincp.menu', null, $sMessage);
			}
			else 
			{
				$this->url()->send('admincp.menu', null, $sMessage);
			}
		}
		
		$this->template()->assign(array(
				'aProducts' => Admincp_Service_Product_Product::instance()->get(),
				'aModules' => Phpfox::getService('admincp.module')->getModules(),
				'aParents' => Admincp_Service_Menu_Menu::instance()->get(array('menu.parent_id = 0 AND menu.m_connection IN(\'main\', \'main_right\')'), false),
				'aControllers' => Phpfox::getService('admincp.component')->get(true),
				'aPages' => Phpfox::getService('page')->getCache(),
				'aLanguages' => $aLanguages,
				'aUserGroups' => Phpfox::getService('user.group')->get(),
				'aTypes' => $oAdmincpMenu->getTypes(),
				'bIsEdit' => $bIsEdit,
				'bIsPage' => $bIsPage
			)
		)
		->setBreadcrumb(Phpfox::getPhrase('admincp.add_new_menu'), $this->url()->makeUrl('current'), true)
		->setTitle(Phpfox::getPhrase('admincp.add_new_menu'));
	}
}

?>