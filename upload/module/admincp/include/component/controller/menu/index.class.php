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
 * @version 		$Id: index.class.php 6739 2013-10-07 14:14:51Z Fern $
 */
class Admincp_Component_Controller_Menu_Index extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{	
		if ($iDeleteId = $this->request()->getInt('delete'))
		{
			if (Phpfox::getService('admincp.menu.process')->delete($iDeleteId))
			{
				$this->url()->send('admincp.menu', null, Phpfox::getPhrase('admincp.menu_successfully_deleted'));	
			}
		}
		
		if ($aVals = $this->request()->getArray('val'))
		{
			if (Phpfox::getService('admincp.menu.process')->updateOrder($aVals))
			{
				$this->url()->send('admincp.menu', array('parent' => $this->request()->getInt('parent')), Phpfox::getPhrase('admincp.menu_order_successfully_updated'));	
			}			
		}
		
		$iParentId = $this->request()->getInt('parent');		
		if ($iParentId > 0)
		{
			$aMenu = Phpfox::getService('admincp.menu')->getForEdit($iParentId);
			if (isset($aMenu['menu_id']))
			{
				$this->template()->assign('aParentMenu', $aMenu);
			}
			else 
			{
				$iParentId = 0;
			}
		}
		
		$aTypes = Phpfox::getService('admincp.menu')->getTypes();
		$aRows = Phpfox::getService('admincp.menu')->get(($iParentId > 0 ? array('menu.parent_id = ' . (int) $iParentId) : array('menu.parent_id = 0')));
		$aMenus = array();
		$aModules = array();
		
		foreach ($aRows as $iKey => $aRow)
		{
			if(Phpfox::isModule($aRow['module_id']))
			{
				if (!$iParentId && in_array($aRow['m_connection'], $aTypes))
				{
					$aMenus[$aRow['m_connection']][] = $aRow;
				}
				else 
				{
					$aModules[$aRow['m_connection']][] = $aRow;
				}			
			}
		}
		unset($aRows);		
	
		$this->template()->setBreadcrumb(Phpfox::getPhrase('admincp.menu_manager'), $this->url()->makeUrl('admincp.menu'))
			->setTitle(Phpfox::getPhrase('admincp.menu_manager'))
			->assign(array(
				'aMenus' => $aMenus,
				'aModules' => $aModules,
				'iParentId' => $iParentId
			)
		);
	}
}

?>
