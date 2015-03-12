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
 * @version 		$Id: admin-stat.class.php 4093 2012-04-16 12:54:05Z Raymond_Benc $
 */
class Core_Component_Block_Admin_Stat extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aStats = Phpfox::getService('core.stat')->getSiteStatsForAdmin(0, 0);
		
		$this->template()->assign(array(
					'aStats' => $aStats			
				)
			);		
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