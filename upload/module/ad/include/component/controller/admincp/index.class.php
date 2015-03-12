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
 * @version 		$Id: index.class.php 3640 2011-12-02 06:20:26Z Raymond_Benc $
 */
class Ad_Component_Controller_Admincp_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
	    (($sPlugin = Phpfox_Plugin::get('ad.component_controller_admincp_process__start')) ? eval($sPlugin) : false);
	    
		$iPage = $this->request()->getInt('page');
		
		if (($iId = $this->request()->getInt('approve')))
		{			
			if (Phpfox::getService('ad.process')->approve($iId))
			{
				$this->url()->send('admincp.ad', null, Phpfox::getPhrase('ad.ad_successfully_approved'));
			}
		}		
		
		if (($iId = $this->request()->getInt('deny')))
		{
			if (Phpfox::getService('ad.process')->deny($iId))
			{
				$this->url()->send('admincp.ad', null, Phpfox::getPhrase('ad.ad_successfully_denied'));
			}
		}			
		
		if (($iId = $this->request()->getInt('delete')))
		{
			if (Phpfox::getService('ad.process')->delete($iId))
			{
				$this->url()->send('admincp.ad', null, Phpfox::getPhrase('ad.ad_successfully_deleted'));
			}
		}
		
		if (($aVals = $this->request()->getArray('val')))
		{
			if (Phpfox::getService('ad.process')->updateActivity($aVals))
			{
				$this->url()->send('admincp.ad', null, Phpfox::getPhrase('ad.ad_s_successfully_updated'));
			}
		}		
		
		$aPages = array(5, 10, 15, 20);
		$aDisplays = array();
		foreach ($aPages as $iPageCnt)
		{
			$aDisplays[$iPageCnt] = Phpfox::getPhrase('core.per_page', array('total' => $iPageCnt));
		}	

		$aSorts = array(
			'ad_id' => Phpfox::getPhrase('ad.recently_added')			
		);
		
		$aFilters = array(
			'status' => array(
				'type' => 'select',
				'options' => array(
					'1' => Phpfox::getPhrase('ad.pending_approval'),
					'2' => Phpfox::getPhrase('ad.pending_payment'),
					'4' => Phpfox::getPhrase('ad.denied')
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
				'type' => 'campaigns',
				'filters' => $aFilters,
				'search' => 'search'
			)
		);
		
		$sStatus = $oSearch->get('status');
		$sView = $this->request()->get('view');
		$iLocation = $this->request()->getInt('location');
		
		if ($sStatus == '1')
		{
			$oSearch->setCondition('is_custom = 2');
		}
		elseif ($sStatus == '2')
		{
			$oSearch->setCondition('is_custom = 1');
		}
		elseif ($sStatus == '4')
		{
			$oSearch->setCondition('is_custom = 4');
		}		
		else 
		{			
			switch ($sView)
			{
				case 'pending':
					$oSearch->setCondition('is_custom = 2');
					break;
				default:
					// $oSearch->setCondition('is_custom IN(0,2,3)');	
					break;	
			}			
		}	
		
		if ($iLocation > 0)
		{
			$oSearch->setCondition('AND location = ' . (int) $iLocation);
		}
		
		$iLimit = $oSearch->getDisplay();		 	    
		
		list($iCnt, $aAds) = Phpfox::getService('ad')->get($oSearch->getConditions(), $oSearch->getSort(), $oSearch->getPage(), $iLimit);
		
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iLimit, 'count' => $oSearch->getSearchTotal($iCnt)));
		
		$this->template()->setTitle(Phpfox::getPhrase('ad.manage_ad_campaigns'))
			->setBreadcrumb(Phpfox::getPhrase('ad.manage_ad_campaigns'), $this->url()->makeUrl('admincp.ad'))
			->assign(array(
					'aAds' => $aAds,
					'iPendingCount' => (int) Phpfox::getService('ad')->getPendingCount(),
					'sPendingLink' => Phpfox::getLib('url')->makeUrl('admincp.ad', array('view' => 'pending')),
					'bIsSearch' => ($this->request()->get('search-id') ? true : false),
					'sView' => $sView
				)
			);
			
		(($sPlugin = Phpfox_Plugin::get('ad.component_controller_admincp_process__end')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('ad.component_controller_admincp_index_clean')) ? eval($sPlugin) : false);
	}
}

?>