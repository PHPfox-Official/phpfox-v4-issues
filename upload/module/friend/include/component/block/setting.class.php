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
 * @version 		$Id: setting.class.php 605 2009-05-29 21:44:00Z Raymond_Benc $
 */
class Friend_Component_Block_Setting extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$bIsProfile = ($this->request()->get('type_id') == 'profile' ? true : false);
		
		$this->template()->assign(array(
				'bIsProfile' => $bIsProfile,
				'iDefaultSetting' => Phpfox::getComponentSetting(Phpfox::getUserId(), 'friend.friend_display_limit_' . ($bIsProfile ? 'profile' : 'dashboard'), Phpfox::getParam('friend.friend_display_limit')),
				'sSettingName' => 'friend.friend_display_limit_' . ($bIsProfile ? 'profile' : 'dashboard'),
				'aSettings' => Phpfox::getParam('friend.friend_user_feed_display_limit'),
				'bNoDeleteLink' => ($this->request()->get('no_delete_link') ? true : false),
				'bIsEditTop' => ($this->request()->get('is_edit_top') ? true : false)
			)
		);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('friend.component_block_setting_clean')) ? eval($sPlugin) : false);
	}
}

?>