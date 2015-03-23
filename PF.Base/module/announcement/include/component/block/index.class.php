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
 * @version 		$Id: index.class.php 3830 2011-12-19 12:55:57Z Miguel_Espinoza $
 */
class Announcement_Component_Block_Index extends Phpfox_Component
{
	public function process()
	{
		(($sPlugin = Phpfox_Plugin::get('announcement.component_block_index__start')) ? eval($sPlugin) : false);
		$aAnnouncement = Phpfox::getService('announcement')->getLatest(null, true, Phpfox::getTime());
		
		if ($aAnnouncement === false) 
		{
			return false;
		}
		$aAnnouncement = reset($aAnnouncement);
		if (isset($aAnnouncement['is_seen']) && $aAnnouncement['is_seen'] == true) return false;
   
		
		if (Phpfox::getLib('phpfox.locale')->isPhrase($aAnnouncement['intro_var']))
		{			
			$sIntro = Phpfox::getPhrase($aAnnouncement['intro_var']);
			
			if (empty($sIntro))
			{
				$aAnnouncement['intro_var'] = $aAnnouncement['content_var'];
				$this->template()->assign(array('bHideViewMore' => true));
			}
		}
		
		$this->template()->assign(array(
				'aAnnouncement' => $aAnnouncement
			)
		);
		(($sPlugin = Phpfox_Plugin::get('announcement.component_block_index__end')) ? eval($sPlugin) : false);
	}
}
?>
