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
 * @package 		Phpfox_Component
 * @version 		$Id: index.class.php 2197 2010-11-22 15:26:08Z Raymond_Benc $
 */
class Input_Component_Controller_Admincp_Manage extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getUserParam('custom.can_manage_custom_fields', true);
		
		if ( ($iId = $this->request()->getInt('delete')) )
		{
			if (Phpfox::getService('input.process')->deleteField($iId))
			{
				$this->url()->send('admincp.input.manage', null, 'Field deleted successfully');
			}
		}
		
		$aInputs = Phpfox::getService('input')->getAll();
		
		$this->template()->setTitle(Phpfox::getPhrase('custom.manage_custom_fields'))
			->setBreadcrumb(Phpfox::getPhrase('custom.manage_custom_fields'))
			->setPhrase(array(
					'custom.are_you_sure_you_want_to_delete_this_custom_option'
				)
			)			
			->setHeader(array(
					'admin.js' => 'module_input',
					'drag.js' => 'static_script',
					'jquery/ui.js' => 'static_script',
					'<script type="text/javascript">$Behavior.addSort  = function(){Core_drag.init({table: \'.js_drag_drop\', ajax: \'input.blockOrdering\'});}</script>'
				)
			)
			->assign(array(
					'aInputs' => $aInputs
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('custom.component_controller_admincp_index_clean')) ? eval($sPlugin) : false);
	}
}

?>