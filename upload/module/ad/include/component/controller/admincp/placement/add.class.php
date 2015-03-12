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
 * @version 		$Id: add.class.php 4132 2012-04-25 13:38:46Z Raymond_Benc $
 */
class Ad_Component_Controller_Admincp_Placement_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$bIsEdit = false;
		if (($iId = $this->request()->getInt('id')) && ($aPlacement = Phpfox::getService('ad')->getPlacement($iId)))
		{
			$bIsEdit = true;
			$this->setParam('currency_value_val[cost]', unserialize($aPlacement['cost']));	
			$this->template()->assign(array(
					'aForms' => $aPlacement
				)
			);
		}
		
		if (($aVals = $this->request()->getArray('val')))
		{
			if ($bIsEdit)
			{
				if (Phpfox::getService('ad.process')->updatePlacement($aPlacement['plan_id'], $aVals))
				{
					$this->url()->send('admincp.ad.placement.add', array('id' => $aPlacement['plan_id']), Phpfox::getPhrase('ad.ad_placement_successfully_updated'));
				}
			}
			else 
			{
				if (Phpfox::getService('ad.process')->addPlacement($aVals))
				{
					$this->url()->send('admincp.ad.placement', null, Phpfox::getPhrase('ad.ad_placement_successfully_added'));
				}
			}
		}
		
		$aPlans = Phpfox::getService('ad')->getPlans(true);
		
		$aCount = array();
		for ($i = 1; $i <= 12; $i++)
		{
			if (isset($aPlans[$i]))
			{
				//continue;
			}
			
			$aCount[$i] = $i;
		}
		
		if ($bIsEdit)
		{
			$aCount[$aPlacement['block_id']] = $aPlacement['block_id'];
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('ad.add_ad_placement'))	
			->setBreadcrumb(Phpfox::getPhrase('ad.manage_placements'), $this->url()->makeUrl('admincp.ad.placement'))
			->setBreadcrumb(($bIsEdit ? 'Edit Ad Placement' : Phpfox::getPhrase('ad.add_ad_placement')), null, true)
			->assign(array(
					'bIsEdit' => $bIsEdit,
					'aPlanBlocks' => $aCount
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('ad.component_controller_admincp_placement_add_clean')) ? eval($sPlugin) : false);
	}
}

?>