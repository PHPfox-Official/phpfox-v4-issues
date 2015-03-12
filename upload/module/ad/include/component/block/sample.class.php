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
 * @version 		$Id: block.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Ad_Component_Block_Sample extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aPlans = Phpfox::getService('ad')->getPlans();//($this->getParam('block_id'));
		$iBlockId = $this->getParam('block_id');
		
		foreach ($aPlans as $iKey => $aPlan)
		{
			if ($aPlan['is_active'] != 1 || $aPlan['block_id'] != $this->getParam('block_id'))
			{
				unset($aPlans[$iKey]);
				continue;
			}
			
			if (!empty($aPlan['cost']) && Phpfox::getLib('parse.format')->isSerialized($aPlan['cost']))
			{
				
				$aCosts = unserialize($aPlan['cost']);	
				
				$iLastCost = 0;
				$iLastCurrency = null;
				foreach ($aCosts as $sKey => $iCost)
				{
					if (strtolower(Phpfox::getService('core.currency')->getDefault()) == strtolower($sKey))
					{
						$aPlans[$iKey]['default_cost'] = $aPlan['default_cost'] = $iCost;
						$aPlans[$iKey]['default_currency_id'] = $aPlan['default_curency'] = $sKey;
						
					}						
				}					
			}	
			$aPlan = array(
				'block_id' => $iBlockId,
				'default_cost' => $aPlan['default_cost'],
				'd_width' => $aPlan['d_width'],
				'd_height' => $aPlan['d_height'],
				'is_cpm' => $aPlan['is_cpm'],
				'plan_id' => $aPlan['plan_id']
			);
			
			$aPlans[$iKey]['sSizes'] = '<a href="#" onclick="window.parent.$Core.Ad.setPlan(' . $this->getParam('block_id') . ', '. $aPlan['plan_id'] . ',' 
			. $aPlan['default_cost'] . ',' 
			. $aPlan['d_width'] . ',' 
			. $aPlan['d_height'] . ',' 
			. $aPlan['is_cpm'] . ');">'. $aPlan['d_width'] . 'x' . $aPlan['d_height'] . '</a>';
			//$(\'#location\').val(' . $iBlockId . '); window.parent.$Core.Ad.oPlan.default_cost = ' . $aPlan['default_cost'] .';window.parent.$Core.Ad.blockPlacementCallback(\'' . $aPlan['d_width'] . '\', \'' . $aPlan['d_height'] . '\',\'' . $iBlockId . '\',\''. $aPlan['is_cpm'].'\'); window.parent.tb_remove();
		
		}
		
		
		if (empty($aPlans))//!isset($aPlan['plan_id']))
		{
			return false;
		}
		
		$this->template()->assign(array(
			'aPlans' => $aPlans,
			'sBlockLocation' => $this->getParam('block_id')
			));
		
		
		
		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('ad.component_block_sample_clean')) ? eval($sPlugin) : false);
	}
}

?>