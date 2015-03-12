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
 * @version 		$Id: list.class.php 4359 2012-06-26 13:52:30Z Raymond_Benc $
 */
class Subscribe_Component_Controller_Admincp_List extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		if (($iDeleteId = $this->request()->getInt('delete')))
		{
			if (Phpfox::getService('subscribe.purchase.process')->delete($iDeleteId))
			{
				$this->url()->send('admincp.subscribe.list', null, Phpfox::getPhrase('subscribe.purchase_order_successfully_deleted'));
			}
		}		
		
		$aPages = array(20, 30, 40, 50);
		$aDisplays = array();
		foreach ($aPages as $iPageCnt)
		{
			$aDisplays[$iPageCnt] = Phpfox::getPhrase('core.per_page', array('total' => $iPageCnt));
		}		
		
		$sStatus = $this->request()->get('status');
		
		$aSorts = array(
			'time_stamp' => Phpfox::getPhrase('subscribe.time'),
			'status' => Phpfox::getPhrase('subscribe.status'),
			'price' => Phpfox::getPhrase('subscribe.price')
		);

		$aFilters = array(
			'package' => array(
				'type' => 'input:text',
				'search' => 'AND sp.package_id = \'[VALUE]\''
			),
			'status' => array(
				'type' => 'select',
				'options' => array(
					'completed' => Phpfox::getPhrase('subscribe.active'),
					'cancel' => Phpfox::getPhrase('subscribe.canceled'),
					'pending' => Phpfox::getPhrase('subscribe.pending_payment'),
					'pendingaction' => Phpfox::getPhrase('subscribe.pending_action')
				),
				'add_any' => true,
				'search' => ($sStatus == 'pendingaction' ? 'AND (sp.status IS NULL OR sp.status = \'\')' : 'AND sp.status = \'[VALUE]\'')
			),
			'display' => array(
				'type' => 'select',
				'options' => $aDisplays,
				'default' => '12'
			),
			'sort' => array(
				'type' => 'select',
				'options' => $aSorts,
				'default' => 'time_stamp',
				'alias' => 'sp'
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
		
		$oFilter = Phpfox::getLib('search')->live()
			->setRequests()
			->set(array(
				'type' => 'subscribe',
				'filters' => $aFilters,
				'redirect' => true,
				'redirect_url' => 'admincp.subscribe.list'		
			)
		);				

		$iPage = $this->request()->getInt('page');
		$iPageSize = $oFilter->getDisplay();	
		
		list($iCnt, $aPurchases) = Phpfox::getService('subscribe.purchase')->getSearch($oFilter->getConditions(), $oFilter->getSort(), $oFilter->getPage(), $iPageSize);
		
		$iCnt = $oFilter->getSearchTotal($iCnt);		
		
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt));		
		
		$this->template()->setTitle(Phpfox::getPhrase('subscribe.subscription_purchase_orders'))	
			->setBreadcrumb(Phpfox::getPhrase('subscribe.subscription_packages'), $this->url()->makeUrl('admincp.subscribe'))
			->setBreadcrumb(Phpfox::getPhrase('subscribe.purchase_orders'), $this->url()->makeUrl('admincp.subscribe.list'), true)
			->assign(array(
					'aPurchases' => $aPurchases,
					'bIsSearching' => $oFilter->isSearching()
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('subscribe.component_controller_admincp_list_clean')) ? eval($sPlugin) : false);
	}
}

?>