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
 * @version 		$Id: add.class.php 3386 2011-10-31 13:19:54Z Miguel_Espinoza $
 */
 
class Input_Component_Controller_Admincp_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$aModulesEnabled = Phpfox::massCallback('getEnabledInputField');
		$jLanguages = json_encode(Phpfox::getService('language')->getForAdminCp());
		$bIsEdit = false;
		$aUserGroups = Phpfox::getService('user.group')->get();
		$sJsAction = 'prepareAdd();';
		
		$aOut = array();
		foreach ($aModulesEnabled as $aInput)
		{
			if (isset($aInput['module_id']))
			{
				$aOut[] = $aInput;
			}
			else
			{
				foreach ($aInput as $aSub)
				{
					$aOut[] = $aSub;
				}
				
			}
		}
		$aModulesEnabled = $aOut;		
		
		if (($iId = $this->request()->getInt('id')))
		{
			if ( ($aVals = $this->request()->getArray('val')) )
			{
				if (Phpfox::getService('input.process')->update(array_merge($aVals, array('field_id' => $iId))))
				{
					$this->url()->send('admincp.input.add', array('id' => $iId), 'Field updated successfully');
				}
				else
				{
					Phpfox_Error::set('Oops');
				}
			}
			$aInput = Phpfox::getService('input')->getForEdit($iId);
			$sJsAction = 'prepareEdit(\''. json_encode($aInput) .'\');';
			$bIsEdit = $iId;
			$this->template()
				->setHeader(array(
					'drag.js' => 'static_script',
					'jquery/ui.js' => 'static_script',
					'<script type="text/javascript">$Behavior.addSort  = function(){Core_drag.init({table: \'.js_drag_drop\', ajax: \'input.optionsOrdering\'});}</script>'
				));
		}
		
		if ( ($aVal = $this->request()->get('val')) )
		{
			if (Phpfox::getService('input.process')->add($aVal))
			{
				$this->url()->send('admincp.input.add',null, 'New field added successfully');
			}
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('input.add_input_field'))
			->setBreadcrumb(Phpfox::getPhrase('input.add_input_field'), null, true)
		->setHeader(array(
			'admin.js' => 'module_input',
			'admin.css' => 'module_input',
			'<script type="text/javascript"> $Behavior.initInput = function(){$Core.input.setLanguages(\''. $jLanguages .'\'); $Core.input.'. $sJsAction.' }</script>'
		))
		->assign(array(
			'bIsEdit' => $bIsEdit,
			'aModulesEnabled' => $aModulesEnabled,
			'aUserGroups' => $aUserGroups
		));
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('custom.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
	}
}

?>