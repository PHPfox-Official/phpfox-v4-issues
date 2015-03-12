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
 * @version 		$Id: active-admin.class.php 982 2009-09-16 08:11:36Z Raymond_Benc $
 */
class Core_Component_Block_Active_Admin extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('admincp.active_admins'),
				'aActiveAdmins' => Phpfox::getService('core.admincp')->getActiveAdmins()
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
		(($sPlugin = Phpfox_Plugin::get('core.component_block_active_admin_clean')) ? eval($sPlugin) : false);
	}
}

?>