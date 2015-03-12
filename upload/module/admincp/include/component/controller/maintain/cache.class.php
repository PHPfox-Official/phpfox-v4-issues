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
 * @package  		Module_Admincp
 * @version 		$Id: cache.class.php 6584 2013-09-05 09:59:17Z Miguel_Espinoza $
 */
class Admincp_Component_Controller_Maintain_Cache extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		Phpfox::getUserParam('admincp.can_clear_site_cache', true);
		
		if ($this->request()->get('unlock'))
		{
			Phpfox::getLib('cache')->unlock();
			
			$this->url()->send('admincp.maintain.cache', null, Phpfox::getPhrase('admincp.cache_system_unlocked'));
		}
		
		if ($this->request()->get('all'))
		{
			Phpfox::getLib('cache')->remove();
			Phpfox::getLib('template.cache')->remove();
			Phpfox::getLib('cache')->removeStatic();
			
			$aParams = array('maintain', 'cache', 'clear' => 'done');
			if ($sPlugin = Phpfox_Plugin::get('admincp.component_controller_maintain_1'))
			{
				eval($sPlugin);
			}
			
			$this->url()->send('admincp', $aParams, Phpfox::getPhrase('admincp.cached_cleared'));
		}
		
		if ($aIds = $this->request()->getArray('id'))
		{			
			foreach ($aIds as $sKey => $aItems)
			{				
				foreach ($aItems as $sId)
				{					
					Phpfox::getLib('cache')->remove($sId, 'path');	
				}						
			}			

			$this->url()->send('admincp', array('maintain', 'cache'), Phpfox::getPhrase('admincp.cached_cleared'));
		}
		
		$iPage = $this->request()->getInt('page');
		
		$aPages = array(20, 30, 40, 50);
		$aDisplays = array();
		foreach ($aPages as $iPageCnt)
		{
			$aDisplays[$iPageCnt] = Phpfox::getPhrase('core.per_page', array('total' => $iPageCnt));
		}		
		
		$aSorts = array(
			'time_stamp' => Phpfox::getPhrase('admincp.timestamp'),
			'file_name' => Phpfox::getPhrase('admincp.cache_name'),
			'data_size' => Phpfox::getPhrase('admincp.data_size')
		);
		
		$aFilters = array(
			'search' => array(
				'type' => 'input:text',
				'search' => "AND file_name LIKE '%[VALUE]%'"
			),				
			'display' => array(
				'type' => 'select',
				'options' => $aDisplays,
				'default' => '20'
			),
			'sort' => array(
				'type' => 'select',
				'options' => $aSorts,
				'default' => 'time_stamp'				
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
				'type' => 'cache',
				'filters' => $aFilters,
				'search' => 'search'
			)
		);
		
		$iLimit = $oSearch->getDisplay();				
	
		list($iCnt, $aCaches) = Phpfox::getLib('cache')->getCachedFiles($oSearch->getConditions(), $oSearch->getSort(), $oSearch->getPage(), $iLimit);			
		
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iLimit, 'count' => $oSearch->getSearchTotal($iCnt)));				
		
		if ($this->request()->get('clear'))
		{
			$aCaches = array();
			$iCnt = 0;	
		}	

		if (Phpfox::isModule('Ad'))
		{
		    $this->template()->setTitle(Phpfox::getPhrase('ad.cache_manager'))
				->setBreadCrumb(Phpfox::getPhrase('ad.cache_manager'));
		}
		$this->template()
			->assign(array(
				'iCacheCnt' => $iCnt,
				'aCaches' => $aCaches,
				'aStats' => Phpfox::getLib('cache')->getStats(),
				'bCacheLocked' => (file_exists(PHPFOX_DIR_CACHE . 'cache.lock') ? true : false),
				'sUnlockCache' => $this->url()->makeUrl('admincp.maintain.cache', array('unlock' => 'true'))
			)
		);		
	}
}

?>