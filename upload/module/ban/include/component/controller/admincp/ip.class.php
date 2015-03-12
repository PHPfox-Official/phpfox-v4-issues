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
 * @version 		$Id: ip.class.php 979 2009-09-14 14:05:38Z Raymond_Benc $
 */
class Ban_Component_Controller_Admincp_Ip extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->setParam('aBanFilter', array(
				'title' => Phpfox::getPhrase('ban.ip_addresses'),
				'type' => 'ip',
				'url' => 'admincp.ban.ip',
				'form' => Phpfox::getPhrase('ban.ip_address')
			)
		);
		
		return Phpfox::getLib('module')->setController('ban.admincp.default');		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('ban.component_controller_admincp_ip_clean')) ? eval($sPlugin) : false);
	}
}

?>