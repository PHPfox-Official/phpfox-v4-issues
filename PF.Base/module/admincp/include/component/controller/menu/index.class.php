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
	 * Controller
	 */
	public function process()
	{	
		if ($iDeleteId = $this->request()->getInt('delete'))
		{
			if (Admincp_Service_Menu_Process::instance()->delete($iDeleteId))
			{
				$this->url()->send('admincp.menu', null, Phpfox::getPhrase('admincp.menu_successfully_deleted'));	
			}
		}
		
		if ($aVals = $this->request()->getArray('val'))
		{
			if (Admincp_Service_Menu_Process::instance()->updateOrder($aVals))
			{
				// $this->url()->send('admincp.menu', array('parent' => $this->request()->getInt('parent')), Phpfox::getPhrase('admincp.menu_order_successfully_updated'));
				return [
					'updated' => true
				];
			}			
		}
		
		$iParentId = $this->request()->getInt('parent');		
		if ($iParentId > 0)
		{
			$aMenu = Admincp_Service_Menu_Menu::instance()->getForEdit($iParentId);
			if (isset($aMenu['menu_id']))
			{
				$this->template()->assign('aParentMenu', $aMenu);
			}
			else 
			{
				$iParentId = 0;
			}
		}
		
		$aTypes = Admincp_Service_Menu_Menu::instance()->getTypes();
		$aRows = Admincp_Service_Menu_Menu::instance()->get(($iParentId > 0 ? array('menu.parent_id = ' . (int) $iParentId) : array('menu.parent_id = 0 AND menu.m_connection IN(\'main\', \'footer\')')));
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
			->setSectionTitle('Menus')
			->setActionMenu([
				'Add Menu' => [
					'class' => 'popup',
					'url' => $this->url()->makeUrl('admincp.menu.add')
				]
			])
			->setHeader(array(
					'drag.js' => 'static_script',
					'<script type="text/javascript">$Behavior.coreDragInit = function() { Core_drag.init({table: \'#js_drag_drop\', ajax: \'' . $this->url()->makeUrl('admincp.menu') . '\'}); }</script>'
				)
			)
			->assign(array(
				'aMenus' => $aMenus,
				'aModules' => $aModules,
				'iParentId' => $iParentId
			)
		);
	}
}

?>
