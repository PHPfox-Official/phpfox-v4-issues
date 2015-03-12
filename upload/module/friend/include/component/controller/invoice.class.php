<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');
define('PHPFOX_SKIP_POST_PROTECTION', true);
/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox_Component
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Friend_Component_Controller_Invoice extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (($sId = $this->request()->get('item_number')) != '')
		{
		    $this->url()->send('friend.invoice',array(),Phpfox::getPhrase('egift.thank_you_for_your_purchase'));
		}
		
		$aInvoices = (Phpfox::isModule('egif') ? Phpfox::getService('egift')->getSentEcards(Phpfox::getUserId ()) : array());


		$this->template()->setTitle(Phpfox::getPhrase('friend.invoices'))
			->setBreadcrumb(Phpfox::getPhrase('friend.friend'), $this->url()->makeUrl('friend'))
			->setBreadcrumb(Phpfox::getPhrase('friend.invoices'), null, true)
			->setHeader('cache', array(
					'table.css' => 'style_css'
				)
			)
			->assign(array(
					'aInvoices' => $aInvoices
				)
			);
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