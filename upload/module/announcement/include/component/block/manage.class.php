<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Display the image details when viewing an image.
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_<INSERT MODULE NAME HERE>
 * @version 		$Id: manage.class.php 670 2009-06-11 12:02:58Z Miguel_Espinoza $
 */
class Announcement_Component_Block_Manage extends Phpfox_Component
{
	public function process()
	{
		(($sPlugin = Phpfox_Plugin::get('announcement.component_block_manage_start')) ? eval($sPlugin) : false);

		$sLanguage = $this->getParam('sLanguage');

		$aAnnouncements = Phpfox::getService('announcement')->getAnnouncementsByLanguage($sLanguage);
	
		$this->template()->assign(array(
			'aAnnouncements' =>$aAnnouncements
		));
	
		(($sPlugin = Phpfox_Plugin::get('announcement.component_block_manage_end')) ? eval($sPlugin) : false);
	}

	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('announcement.component_block_manage_clean')) ? eval($sPlugin) : false);
	}
}
?>
