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
 * @version 		$Id: purchasepoints.class.php 4747 2012-09-25 05:23:01Z Raymond_Benc $
 */
class User_Component_Block_Purchasepoints extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aPurchasePoints = array(10, 20, 30, 40, 50);
		
		$aConversion = Phpfox::getParam('user.points_conversion_rate');
		$sDefault = Phpfox::getService('core.currency')->getDefault();
		$iDefaultPrice = (isset($aConversion[$sDefault]) ? $aConversion[$sDefault] : 0);	

		foreach ($aPurchasePoints as $iKey => $sPurchasePoint)
		{
			$iPayTotal = ($sPurchasePoint * $iDefaultPrice);

			$aPurchasePoints[$iKey] = array(
				'id' => (int) $sPurchasePoint . '|' . $iPayTotal,
				'cost' => $sPurchasePoint . ' (' . Phpfox::getService('core.currency')->getCurrency($iPayTotal) . ')'
			);
		}

		$this->template()->assign(array(
				'aPurchasePoints' => $aPurchasePoints	
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_block_purchasepoints_clean')) ? eval($sPlugin) : false);
	}
}

?>