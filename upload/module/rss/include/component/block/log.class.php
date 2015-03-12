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
 * @version 		$Id: log.class.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
class Rss_Component_Block_Log extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aParam = $this->getParam('rss');
		
		$aLogs = Phpfox::getService('rss.log')->get($aParam);		
		$sNames = '';
		$sCounts = '';
		$iMaxLogDisplay = 5;
		$iCnt = 0;
		$iOtherCount = 0;
		foreach ($aLogs as $aLog)
		{
			$iCnt++;
			
			if ($iCnt <= $iMaxLogDisplay)
			{
				$sNames .= $aLog['user_agent_chart'] . '|';
				$sCounts .= $aLog['total_agent_count'] . ',';
			}
			else 
			{
				$iOtherCount += $aLog['total_agent_count'];
			}
		}
		if ($iOtherCount > 0)
		{
			$sNames .= Phpfox::getPhrase('rss.other') . '|';
			$sCounts .= $iOtherCount . ',';
		}
		
		$aUsers = array();
		if (isset($aParam['users']))
		{
			list($iCnt, $aUsers) = Phpfox::getService('rss.log')->getUsers($aParam, $this->request()->get('page'), 20);
			
			Phpfox::getLib('pager')->set(array('page' => $this->request()->get('page'), 'size' => 20, 'count' => $iCnt));
		}
		
		$this->template()->assign(array(				
				'sNames' => rtrim($sNames, '|'),
				'sCounts' => rtrim($sCounts, ','),
				'aLogs' => $aLogs,
				'aUsers' => $aUsers
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('rss.component_block_log_clean')) ? eval($sPlugin) : false);
	}
}

?>