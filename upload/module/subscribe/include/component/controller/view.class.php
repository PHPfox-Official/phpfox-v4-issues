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
 * @version 		$Id: view.class.php 1339 2009-12-19 00:37:55Z Raymond_Benc $
 */
class Subscribe_Component_Controller_View extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!($aPurchase = Phpfox::getService('subscribe.purchase')->getInvoice($this->request()->getInt('id'))))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('subscribe.unable_to_find_this_invoice'));
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('subscribe.membership_packages'))
			->setBreadcrumb(Phpfox::getPhrase('subscribe.membership_packages'), $this->url()->makeUrl('subscribe'))
			->setBreadcrumb(Phpfox::getPhrase('subscribe.subscriptions'), $this->url()->makeUrl('subscribe.list'))
			->setBreadcrumb(Phpfox::getPhrase('subscribe.order_purchase_id_title', array(
					'purchase_id' => $aPurchase['purchase_id'],
					'title' => Phpfox::getLib('locale')->convert($aPurchase['title'])
				)
			), null, true)
			->assign(array(
				'aPurchase' => $aPurchase
			)
		);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('subscribe.component_controller_view_clean')) ? eval($sPlugin) : false);
	}
}

?>