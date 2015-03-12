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
 * @version 		$Id: view-admincp-login.class.php 892 2009-08-24 13:23:36Z Raymond_Benc $
 */
class Core_Component_Block_View_Admincp_Login extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isAdmin(true);
		
		if (!($aLog = Phpfox::getService('core.admincp')->getAdminLoginLog($this->request()->get('login_id'))))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'aLog' => $aLog
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_block_view_admincp_login_clean')) ? eval($sPlugin) : false);
	}
}

?>