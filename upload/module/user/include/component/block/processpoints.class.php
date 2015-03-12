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
 * @version 		$Id: processpoints.class.php 5022 2012-11-13 08:05:06Z Raymond_Benc $
 */
class User_Component_Block_Processpoints extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aPurchase = explode('|', $this->request()->get('purchase'));
		
		$iPurchaseId = Phpfox::getService('user.process')->addPointsPurchase($aPurchase[1], $aPurchase[0]);	
		
		$this->setParam('gateway_data', array(
				'item_number' => 'user|' . $iPurchaseId,
				'currency_code' => Phpfox::getService('core.currency')->getDefault(),
				'amount' => $aPurchase[1],
				'item_name' => $aPurchase[0] . ' ' . Phpfox::getPhrase('user.activity_points'),
				'return' => $this->url()->makeUrl('user.completepoints'),			
				'recurring' => '',
				'recurring_cost' => '',
				'alternative_cost' => '',
				'alternative_recurring_cost' => '',
				'no_purchase_with_points' => true
			)
		);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_block_processpoints_clean')) ? eval($sPlugin) : false);
	}
}

?>