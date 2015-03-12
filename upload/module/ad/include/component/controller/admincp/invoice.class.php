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
 * @version 		$Id: invoice.class.php 2019 2010-11-01 14:17:16Z Raymond_Benc $
 */
class Ad_Component_Controller_Admincp_Invoice extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (($iId = $this->request()->getInt('delete')))
		{
			if (Phpfox::getService('ad.process')->deleteInvoice($iId))
			{
				$this->url()->send('admincp.ad.invoice', null, Phpfox::getPhrase('ad.invoice_successfully_deleted'));
			}
		}
		$iPage = $this->request()->getInt('page');
		
		$aPages = array(5, 10, 15, 20);
		$aDisplays = array();
		foreach ($aPages as $iPageCnt)
		{
			$aDisplays[$iPageCnt] = Phpfox::getPhrase('core.per_page', array('total' => $iPageCnt));
		}	

		$aSorts = array(
			'time_stamp' => Phpfox::getPhrase('ad.recently_added')			
		);
		
		$aFilters = array(
			'status' => array(
				'type' => 'select',
				'options' => array(
					'1' => Phpfox::getPhrase('ad.paid'),
					'2' => Phpfox::getPhrase('ad.pending_payment'),
					'3' => Phpfox::getPhrase('ad.cancelled')
				),
				'add_any' => true
			),
			'display' => array(
				'type' => 'select',
				'options' => $aDisplays,
				'default' => '10'
			),
			'sort' => array(
				'type' => 'select',
				'options' => $aSorts,
				'default' => 'ad_id'				
			),
			'sort_by' => array(
				'type' => 'select',
				'options' => array(
					'DESC' => Phpfox::getPhrase('core.descending'),
					'ASC' => Phpfox::getPhrase('core.ascending')
				),
				'default' => 'DESC'
			)
		);		
		
		$oSearch = Phpfox::getLib('search')->set(array(
				'type' => 'invoices',
				'filters' => $aFilters,
				'search' => 'search'
			)
		);		
		
		$sStatus = $oSearch->get('status');
		switch ($sStatus)
		{
			case '1':
				$oSearch->setCondition('ai.status = \'completed\'');
				break;
			case '2':
				$oSearch->setCondition('(ai.status = \'pending\' OR ' . Phpfox::getLib('database')->isNull('ai.status') . ')');
				break;
			case '3':
				$oSearch->setCondition('ai.status = \'cancel\'');
				break;				
			default:
				
				break;
		}
		
		$iLimit = $oSearch->getDisplay();
		
		list($iCnt, $aInvoices) = Phpfox::getService('ad')->getInvoices($oSearch->getConditions(), $oSearch->getSort(), $oSearch->getPage(), $iLimit);		
		
		$this->template()->setTitle(Phpfox::getPhrase('ad.ad_invoices'))
			->setBreadcrumb(Phpfox::getPhrase('ad.invoices'))
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
		(($sPlugin = Phpfox_Plugin::get('ad.component_controller_admincp_invoice_clean')) ? eval($sPlugin) : false);
	}
}

?>