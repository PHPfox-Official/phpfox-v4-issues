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
 * @version 		$Id: setting.class.php 679 2009-06-15 19:45:45Z Raymond_Benc $
 */
class Log_Component_Block_Setting extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->template()->assign(array(
				'iDefaultSetting' => (int) Phpfox::getComponentSetting(Phpfox::getUserId(), 'log.user_login_display_limit', '0')
			)
		);			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('log.component_block_setting_clean')) ? eval($sPlugin) : false);
	}
}

?>