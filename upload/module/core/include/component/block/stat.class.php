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
 * @version 		$Id: stat.class.php 1491 2010-03-03 15:34:04Z Raymond_Benc $
 */
class Core_Component_Block_Stat extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!Phpfox::getParam('core.display_site_stats'))
		{
			return false;
		}
		
		$aSiteStats = Phpfox::getService('core.stat')->getSiteStats();
		
		if (is_bool($aSiteStats))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('core.site_stats'),
				'aSiteStats' => $aSiteStats
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
		(($sPlugin = Phpfox_Plugin::get('core.component_block_stat_clean')) ? eval($sPlugin) : false);
	}
}

?>