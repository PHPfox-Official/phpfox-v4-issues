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
 * @version 		$Id: oncloud.class.php 6553 2013-08-30 11:25:23Z Raymond_Benc $
 */
class Admincp_Component_Block_Oncloud extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		if (!defined('PHPFOX_IS_HOSTED_SCRIPT') || defined('PHPFOX_GROUPLY_TEST'))
		{
			return false;
		}
		
		$sCacheId = Phpfox::getLib('cache')->set('admincp_site_package');
		if (!($aHostingPackage = Phpfox::getLib('cache')->get($sCacheId, 1 * 60 * 60))) // cache is in hours
		{
			$aHostingPackage = Phpfox::getService('admincp')->getHostingInfo('package', array('domain' => PHPFOX_IS_HOSTED_SCRIPT));
			Phpfox::getLib('cache')->save($sCacheId, $aHostingPackage);
		}
		
		if (!$aHostingPackage)
		{
			return 'block';
		}

		$bNewUpgrade = false;
		if (md5(Phpfox::VERSION) != md5($aHostingPackage['latest_version']))
		{
			$bNewUpgrade = true;
		}
		
		$this->template()->assign(Phpfox::getService('admincp')->getHostingStats());
		$this->template()->assign(array(
					'sHeader' => 'OnCloud',
					'aHostingPackage' => $aHostingPackage,
					'$bNewUpgrade' => $bNewUpgrade
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
		(($sPlugin = Phpfox_Plugin::get('admincp.component_block_oncloud_clean')) ? eval($sPlugin) : false);
	}
}

?>