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
 * @package  		Module_Announcement
 * @version 		$Id: index.class.php 979 2009-09-14 14:05:38Z Raymond_Benc $
 */
class Announcement_Component_Controller_Admincp_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		if ($iDelete = $this->request()->getInt('delete'))
		{
			if ($bDel = Phpfox::getService('announcement.process')->delete((int) $iDelete))
			{
				$this->url()->send('admincp.announcement', null, Phpfox::getPhrase('announcement.announcement_successfully_deleted'));
			}
		}
		
		// find the default language to pass it to the template so it can load the appropriate announcements
		// by calling the block manage only once.
		// get available languages
		$aLanguages = Phpfox::getService('language')->get();
		$sDefLanguage = '';
		foreach ($aLanguages as $aLanguage)
		{
			if ($aLanguage['is_default']) 
			{
				$sDefLanguage = $aLanguage['language_id'];
			}
		}
		
		$aAnnouncements = Phpfox::getService('announcement')->getAnnouncementsByLanguage($sDefLanguage);

		$this->template()->setTitle(Phpfox::getPhrase('announcement.announcements'))
			->setBreadcrumb(Phpfox::getPhrase('announcement.announcements'), $this->url()->makeUrl('admincp.announcement'))
			->assign(array(
				'aLanguages' => $aLanguages,
				'sDefaultLanguage' => $sDefLanguage,
				'aAnnouncements' => $aAnnouncements
			)
		);
	}
}
?>
