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
 * @version 		$Id: block.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Apps_Component_Block_Menu extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$iPageLimit = 15;

		$aInstalledApps = Phpfox::getService('apps')->getInstalledApps($iPageLimit);
		$aInstalledPages = (Phpfox::isModule('pages') ? Phpfox::getService('pages')->getMyAdminPages($iPageLimit) : array());
		if (empty($aInstalledApps) && empty($aInstalledPages))
		{
			return false;
		}
		$this->template()->assign(array(
				'aInstalledApps' => $aInstalledApps,
				'aInstalledPages' => $aInstalledPages,
				'iPageLimit' => $iPageLimit
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
		(($sPlugin = Phpfox_Plugin::get('apps.component_block_menu_clean')) ? eval($sPlugin) : false);
	}
}

?>