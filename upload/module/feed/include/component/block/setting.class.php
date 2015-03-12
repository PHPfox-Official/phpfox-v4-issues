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
 * @version 		$Id: setting.class.php 1084 2009-09-26 09:59:57Z Raymond_Benc $
 */
class Feed_Component_Block_Setting extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$bIsProfile = ($this->request()->get('type_id') == 'profile' ? true : false);
		
		$this->template()->assign(array(
				'bIsProfile' => $bIsProfile,
				'iDefaultSetting' => Phpfox::getComponentSetting(Phpfox::getUserId(), 'feed.feed_display_limit_' . ($bIsProfile ? 'profile' : 'dashboard'), Phpfox::getParam('feed.feed_display_limit')),
				'sSettingName' => 'feed.feed_display_limit_' . ($bIsProfile ? 'profile' : 'dashboard'),
				'aSettings' => Phpfox::getParam('feed.user_feed_display_limit'),
				'iProfileUserId' => Phpfox::getUserId()
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('feed.component_block_setting_clean')) ? eval($sPlugin) : false);
	}
}

?>