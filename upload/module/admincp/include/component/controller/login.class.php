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
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Admincp_Component_Controller_Login extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (($aVals = $this->request()->getArray('val')))
		{
			if (!empty($aVals['email']) && !empty($aVals['password']))
			{
				if (Phpfox::getService('user.auth')->loginAdmin($aVals['email'], $aVals['password']))
				{
					$this->url()->send('current');
				}
			}
		}
		
		$this->template()->setHeader('login.css', 'style_css');
		$this->template()->setTemplate('blank');	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_login_clean')) ? eval($sPlugin) : false);
	}
}

?>