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
 * @version 		$Id: offline.class.php 681 2009-06-15 20:24:37Z Raymond_Benc $
 */
class Core_Component_Controller_Offline extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->template()->assign(array(
				'sOfflineMessage' => Phpfox::getParam('core.site_offline_message')
			)
		);
		
		if (Phpfox::getParam('core.site_offline_no_template'))
		{
			$this->template()->setTemplate('blank');
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_controller_offline_clean')) ? eval($sPlugin) : false);
	}
}

?>