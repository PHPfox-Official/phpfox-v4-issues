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
 * @package 		Phpfox_Component
 * @version 		$Id: add.class.php 1274 2009-11-25 15:22:46Z Miguel_Espinoza $
 */
class Announcement_Component_Controller_Admincp_Add extends Phpfox_Component
{
/**
 * Class process method wnich is used to execute this component.
 */
    public function process()
    {
	$bIsEdit = false;
	$aLanguages = Phpfox::getService('language')->get();
	
	if ($iEdit = $this->request()->getInt('id'))
	{
	    if ($aAnnouncement = Phpfox::getService('announcement')->getAnnouncementById($iEdit))
	    {
	    // set the access user groups
		$this->template()->assign(array(
		    'aAnnouncement' => $aAnnouncement,
		    'aForms' => $aAnnouncement,
		    'aAccess' => $aAnnouncement['user_group']
		    ))
		    ->setBreadcrumb(Phpfox::getPhrase('announcement.edit_an_announcement'), null, true);

		$bIsEdit = true;
	    }
	}
	else
	{
	    $this->template()->setBreadcrumb(Phpfox::getPhrase('announcement.add_an_announcement'), null, true);
	    $aAnnouncement = array();
	    foreach ($aLanguages as $aLanguage)
	    {
		$aAnnouncement['language'][$aLanguage['language_id']] = array(
		    'subject' => '',
		    'intro' => '',
		    'content' => '',
		    'language_id' => $aLanguage['language_id'],
		    'title' => $aLanguage['title'],
		    'is_default' => $aLanguage['is_default']
		);
	    }
	}

	// Is user submitting a form?
	if ($aVal = $this->request()->get('val'))
	{
	// security check
	    if (!empty($aVal))
	    {
		if ($bIsEdit === false)
		{ // user is adding
		    if ($bAdd = Phpfox::getService('announcement.process')->add($aVal))
		    {
			$this->url()->send('admincp.announcement', null, Phpfox::getPhrase('announcement.announcement_successfully_added'));
		    }
		}
		else
		{
		    if ($bEdit = Phpfox::getService('announcement.process')->editAnnouncement($aAnnouncement['announcement_id'], $aVal))
		    {
			$this->url()->send('admincp.announcement.add', array('id' => $aAnnouncement['announcement_id']), Phpfox::getPhrase('announcement.announcement_successfully_updated'));
		    }
		}
	    }

	}

	// get the languages and pass them on to the template
	
	$aAge = array();
	for ($i = 18; $i <= 68; $i++)
	{
	    $aAge[$i] = $i;
	}
	

	$this->template()->setTitle(Phpfox::getPhrase('announcement.add_an_announcement'))
	    ->setBreadcrumb(Phpfox::getPhrase('announcement.announcements'), $this->url()->makeUrl('admincp.announcement'))
	    ->setEditor()
	    ->setPhrase(array(
		'announcement.min_age_cannot_be_higher_than_max_age',
		'announcement.max_age_cannot_be_lower_than_the_min_age'
		)
	    )
	    ->assign(array(
		'aLanguages' => $aLanguages,
		'aAnnouncement' => $aAnnouncement,
		'aUserGroups' => Phpfox::getService('user.group')->get(),
		'aAge' => $aAge,
		'iUser' => Phpfox::getUserId()
	    ))
	    ->setHeader(array('admin_manage.js' => 'module_announcement'));
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
	(($sPlugin = Phpfox_Plugin::get('announcement.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
    }
}

?>