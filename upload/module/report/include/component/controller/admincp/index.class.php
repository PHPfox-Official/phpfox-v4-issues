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
 * @version 		$Id: index.class.php 1522 2010-03-11 17:56:49Z Miguel_Espinoza $
 */
class Report_Component_Controller_Admincp_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if ($iId = $this->request()->getInt('view'))
		{
			if ($sRedirect = Phpfox::getService('report')->getRedirect($iId))
			{
				$this->url()->forward($sRedirect);	
			}
		}
		
		if ($aIds = $this->request()->getArray('id'))
		{
			if ($this->request()->get('ignore'))
			{
				foreach ($aIds as $iId)
				{
					if (!is_numeric($iId))
					{
						continue;
					}
					
					Phpfox::getService('report.data.process')->ignore($iId);
				}
				
				$this->url()->send('admincp.report', null, Phpfox::getPhrase('report.report_s_successfully_ignored'));
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
			'added' => Phpfox::getPhrase('core.time')
		);
		
		$aFilters = array(
			'search' => array(
				'type' => 'input:text',
				'search' => "AND c.name LIKE '%[VALUE]%'"
			),	
			'user' => array(
				'type' => 'input:text',
				'search' => "AND u.user_name LIKE '%[VALUE]%'"
			),						
			'display' => array(
				'type' => 'select',
				'options' => $aDisplays,
				'default' => '10'
			),
			'sort' => array(
				'type' => 'select',
				'options' => $aSorts,
				'default' => 'added',
				'alias' => 'rd'
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
				'type' => 'reports',
				'filters' => $aFilters,
				'search' => 'search'
			)
		);
		
		$iLimit = $oSearch->getDisplay();
		
		list($iCnt, $aReports) = Phpfox::getService('report')->get($oSearch->getConditions(), $oSearch->getSort(), $oSearch->getPage(), $iLimit);
		
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iLimit, 'count' => $oSearch->getSearchTotal($iCnt)));		
		
		$this->template()->setTitle(Phpfox::getPhrase('report.reports'))
			->setBreadcrumb(Phpfox::getPhrase('report.reports'), $this->url()->makeUrl('admincp.report'))
			->assign(array(
					'aReports' => $aReports
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('report.component_controller_admincp_index_clean')) ? eval($sPlugin) : false);
	}
}

?>