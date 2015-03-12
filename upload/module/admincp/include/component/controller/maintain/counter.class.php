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
 * @version 		$Id: counter.class.php 1335 2009-12-17 14:47:04Z Raymond_Benc $
 */
class Admincp_Component_Controller_Maintain_Counter extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aModules = Phpfox::massCallback('updateCounterList');	
		$iLimit = 100;
		$iPage = $this->request()->getInt('page');
		$bRefresh = false;
		$iTotalPages = 0;
		$iCurrentPage = 0;
		
		if (($sModule = $this->request()->get('module')))
		{
			$iCnt = Phpfox::callback($sModule . '.updateCounter', $this->request()->get('id'), $iPage, $iLimit);		
			
			if ($iCnt !== false)
			{			
				Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iLimit, 'count' => $iCnt));
				
				$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();		
				$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();		
				$iPage = (int) Phpfox::getLib('pager')->getNextPage();			
				
				if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
				{
					$this->url()->send('admincp.maintain.counter', null, Phpfox::getPhrase('admincp.update_of_counter_successfully_completed'));
				}
				else 
				{
					$bRefresh = true;
					$this->template()->setHeader('<meta http-equiv="refresh" content="2;url=' . $this->url()->makeUrl('admincp.maintain.counter', array('module' => $sModule, 'page' => $iPage, 'id' => $this->request()->get('id'))) . '">');
				}
			}			
		}
		
		$aLists = array();
		$iSubCount = 0;
		foreach ($aModules as $sModule => $aList)
		{
			if (isset($aList['name']))
			{
				$aList = array($aList);
			}
			
			foreach ($aList as $mKey => $aItem)
			{
				$iSubCount++;
				
				$aList[$mKey]['count'] = $iSubCount;
			}
			
			$aLists[$sModule]= $aList;
		}				
		
		$this->template()->setTitle(Phpfox::getPhrase('admincp.update_counters'))
			->setBreadcrumb(Phpfox::getPhrase('admincp.update_counters'))
			->assign(array(
					'aLists' => $aLists,
					'bRefresh' => $bRefresh,
					'iTotalPages' => $iTotalPages,
					'iCurrentPage' => $iCurrentPage
				)
			);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_maintain_counter_clean')) ? eval($sPlugin) : false);
	}
}

?>