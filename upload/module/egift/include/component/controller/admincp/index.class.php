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
class Egift_Component_Controller_Admincp_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aCategories = Phpfox::getService('egift')->getCategories();
		$aEgifts = Phpfox::getService('egift')->getEgifts();			

		if (($aVals = $this->request()->getArray('upload')) && ($this->request()->get('action') == 'upload'))
		{			
			$aVals = array_merge($aVals, $_FILES);
			
			if (Phpfox::getService('egift.process')->addGift($aVals))
			{
				$this->url()->send('admincp.egift', array(), Phpfox::getPhrase('egift.egift_added_successfully'));
			}
		}
		else if ($iEdit = $this->request()->getInt('edit'))
		{
			$aToEdit = Phpfox::getService('egift')->getForEdit($iEdit,$aEgifts, $aCategories);			
			$this->template()->assign('aEdit', $aToEdit);
		}
		else if ($this->request()->get('action') == 'edit')
		{
			if (Phpfox::getService('egift.process')->editGift($aVals))
			{
				$this->url()->send('admincp.egift', array(), Phpfox::getPhrase('egift.egift_edited_successfully'));
			}
		}
		else if ($iId = $this->request()->getInt('delete'))
		{
			if (Phpfox::getService('egift.process')->deleteGift($iId))
			{
				$this->url()->send('admincp.egift', array(), Phpfox::getPhrase('egift.egift_deleted_successfully'));
			}
		}

		$this->template()->assign(array(
			'aCategories' => $aCategories,
			'aEgifts' => $aEgifts
			))
			->setBreadcrumb('Manage EGift', $this->url()->makeUrl('admincp.egift'))
			->setHeader(array(
				'admincp.js' => 'module_egift',
				'admincp.css' => 'module_egift'
			));
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('egift.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>
