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
 * @version 		$Id: setting.class.php 704 2009-06-21 18:50:42Z Raymond_Benc $
 */
class User_Component_Block_Setting extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aUser = Phpfox::getService('user')->get(Phpfox::getUserId(), true);		
		
		if (!empty($aUser['birthday']))
		{
			$aUser = array_merge($aUser, Phpfox::getService('user')->getAgeArray($aUser['birthday']));
		}		
		
		$this->template()->assign(array(
				'aForms' => $aUser,
				'aSettings' => Phpfox::getService('custom')->getForEdit(array('user_panel'), $aUser['user_id'], $aUser['user_group_id']),
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_block_setting_clean')) ? eval($sPlugin) : false);
	}
}

?>