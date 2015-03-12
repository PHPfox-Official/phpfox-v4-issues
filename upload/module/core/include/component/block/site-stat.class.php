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
 * @version 		$Id: site-stat.class.php 5502 2013-03-18 08:25:12Z Miguel_Espinoza $
 */
class Core_Component_Block_Site_Stat extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aStats = array();
		
		$aOnline = Phpfox::getService('log.session')->getOnlineStats();

		$aStats[Phpfox::getPhrase('admincp.online')] = array(
			array(
				'phrase' => Phpfox::getPhrase('admincp.members'),
				'value' => $aOnline['members'],
				'link' => $this->url()->makeUrl('admincp.user.browse', array('view' => 'online'))
			)
			
		);
		
        if (Phpfox::getParam('core.log_site_activity'))
        {
            $aStats[Phpfox::getPhrase('admincp.online')][] = array(
				'phrase' => Phpfox::getPhrase('admincp.guests'),
				'value' => $aOnline['guests'],
				'link' => $this->url()->makeUrl('admincp.core.online-guest')
			);
        }
		$aPendingCallback = Phpfox::massCallback('pendingApproval');	
		$aStats[Phpfox::getPhrase('admincp.pending_approval')] = array();
		$iTotalApprove = 0;		
		foreach ($aPendingCallback as $sModule => $aPendings)
		{
			if (isset($aPendings['value']))
			{
				if (!$aPendings['value'])
				{
					continue;
				}
				
				$iTotalApprove++;
				$aStats[Phpfox::getPhrase('admincp.pending_approval')][] = $aPendings;
			}
			else 
			{
				foreach ($aPendings as $sKey => $aValue)
				{
					if (!$aValue['value'])
					{
						continue;
					}
					
					$iTotalApprove++;
					$aStats[Phpfox::getPhrase('admincp.pending_approval')][] = $aValue;					
				}
			}
		}		
		
		if ($iTotalApprove === 0)
		{
			unset($aStats[Phpfox::getPhrase('admincp.pending_approval')]);
		}
		
		if (Phpfox::isModule('report'))
		{
			$aReports = Phpfox::getService('report')->getActiveReports();
			if (count($aReports))
			{
				$aStats[Phpfox::getPhrase('admincp.reported_items_users')] = array();
				foreach ($aReports as $aReport)
				{			
					$aStats[Phpfox::getPhrase('admincp.reported_items_users')][] = $aReport;
				}
			}
		}
		
		$aSpamCallback = Phpfox::massCallback('spamCheck');
		$aStats[Phpfox::getPhrase('admincp.spam')] = array();
		$iTotalSpam = 0;
		foreach ($aSpamCallback as $sModule => $aSpam)
		{
			if (!$aSpam['value'])
			{
				continue;
			}
			
			$iTotalSpam++;
			$aStats[Phpfox::getPhrase('admincp.spam')][] = $aSpam;
		}		
		
		if ($iTotalSpam === 0)
		{
			unset($aStats[Phpfox::getPhrase('admincp.spam')]);
		}
		
		$aSiteStatsForAdmins = Phpfox::massCallback('getSiteStatsForAdmins');		
		$aStats[Phpfox::getPhrase('admincp.today_s_site_stats')] = array();
		$iTotalStats = 0;
		foreach ($aSiteStatsForAdmins as $sModule => $aSiteStatsForAdmin)
		{
			if (!$aSiteStatsForAdmin['value'])
			{
				continue;
			}
			
			$iTotalStats++;
			
			$aStats[Phpfox::getPhrase('admincp.today_s_site_stats')][] = $aSiteStatsForAdmin;
		}		
		
		if ($iTotalStats === 0)
		{
			unset($aStats[Phpfox::getPhrase('admincp.today_s_site_stats')]);
		}		

		/*
		if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
		{
			$this->template()->assign(Phpfox::getService('admincp')->getHostingStats());
		}
		*/

		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('admincp.site_statistics'),
				'aStats' => $aStats
			)
		);	
		
		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_block_site_stat_clean')) ? eval($sPlugin) : false);
	}
}

?>