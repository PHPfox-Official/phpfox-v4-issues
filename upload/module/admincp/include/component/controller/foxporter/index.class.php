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
 * @version 		$Id: index.class.php 1571 2010-05-05 19:47:25Z Raymond_Benc $
 */
class Admincp_Component_Controller_Foxporter_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		require(PHPFOX_DIR_LIB . 'foxporter' . PHPFOX_DS . 'foxporter.class.php');

		$oFoxporter = new Foxporter();
		
		$this->template()->setTitle(Phpfox::getPhrase('admincp.foxporter'))
			->setBreadcrumb(Phpfox::getPhrase('admincp.foxporter'), $this->url()->makeUrl('admincp.foxporter'));
		
		if (($sModule = $this->request()->get('module')))
		{
			$mReturn = $oFoxporter->processStep($sModule, $this->request()->get('step'));	
			
			$this->template()->setBreadcrumb(Phpfox::getPhrase('admincp.module') . ': ' . $sModule, null, true);
			$this->template()->assign(array(
					'aData' => $mReturn,
					'sCurrentModule' => $sModule
				)
			);
		}
		else 
		{		
			$this->template()->assign(array(
					'aImportModules' => $oFoxporter->getModules()
				)
			);
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_foxporter_index_clean')) ? eval($sPlugin) : false);
	}
}

?>