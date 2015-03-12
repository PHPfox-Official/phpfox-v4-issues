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
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Admincp_Component_Controller_Maintain_Duplicate extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aModules = Phpfox::massCallback('removeDuplicateList');
		$sCheck = $this->request()->get('table');
		
		$aLists = array();
		foreach ($aModules as $sModule => $aList)
		{
			if (isset($aList['name']))
			{
				$aList = array($aList);
			}
			
			foreach ($aList as $iKey => $aRow)
			{				
				if (!empty($sCheck) && $aRow['table'] == $sCheck)
				{
					$mReturn = Phpfox::getService('admincp.maintain')->removeDuplicates($aRow);
					
					if ($mReturn === true)
					{
						$this->url()->send('admincp.maintain.duplicate', null, Phpfox::getPhrase('admincp.successfully_removed_duplicate_entries'));
					}
					
					break;
				}
			}
			
			$aLists = array_merge($aLists, $aList);
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('admincp.remove_duplicates'))
			->setBreadcrumb(Phpfox::getPhrase('admincp.remove_duplicates'))
			->assign(array(
					'aLists' => $aLists
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_maintain_duplicate_clean')) ? eval($sPlugin) : false);
	}
}

?>