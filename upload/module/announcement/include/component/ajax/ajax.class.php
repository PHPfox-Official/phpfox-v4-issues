<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox_Ajax
 * @version 		$Id: ajax.class.php 1371 2009-12-28 19:39:30Z Miguel_Espinoza $
 */
class Announcement_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function changeLanguage()
	{
		(($sPlugin = Phpfox_Plugin::get('announcement.component_ajax_changelanguage__start')) ? eval($sPlugin) : false);
		$sLanguage = $this->get('sLanguage');
		$aAnnouncements = Phpfox::getService('announcement')->getAnnouncementsByLanguage($sLanguage);
		Phpfox::getBlock('announcement.manage', array('aAnnouncements' => $aAnnouncements));

		$this->call('$("#js_announcements").hide("slow", function(){$(this).html("'.$this->getContent().'");});');
		(($sPlugin = Phpfox_Plugin::get('announcement.component_ajax_changelanguage__end')) ? eval($sPlugin) : false);
	}	

	/**
	 * Sets the new state of the announcements (active / inactive)
	 */
	public function setActive()
	{
		(($sPlugin = Phpfox_Plugin::get('announcement.component_ajax_setactive__start')) ? eval($sPlugin) : false);
		$iId = (int)$this->get('id');
		$iState = (int)$this->get('active'); // we dont parse because its a potential risk since 0 is a valid value
		
		if ($iId < 1 || ($iState > 1 || $iState < 0))
			return false;

		$mUpdate = Phpfox::getService('announcement.process')->setStatus($iId, $iState);
		if ($mUpdate !== true)
		{
			$this->alert($mUpdate);
		}
		(($sPlugin = Phpfox_Plugin::get('announcement.component_ajax_setactive__end')) ? eval($sPlugin) : false);
		return false;
	}

	/**
	 * Hides the announcement block from the Dashboard
	 */
	public function hide()
	{
		(($sPlugin = Phpfox_Plugin::get('announcement.component_ajax_hide__start')) ? eval($sPlugin) : false);
		if (Phpfox::getUserParam('announcement.can_close_announcement') == true)
		{
			if(Phpfox::getService('announcement.process')->hide($this->get('id')))
			{
				$this->call(' $("#announcement").remove();');
				return true;
			}
		}
		(($sPlugin = Phpfox_Plugin::get('announcement.component_ajax_hide__end')) ? eval($sPlugin) : false);
		$this->alert(Phpfox::getPhrase('announcement.im_afraid_you_are_not_allowed_to_close_this_announcement'));
		return false;
		
	}
}

?>