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
 * @version 		$Id: profile.class.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
class Rss_Component_Controller_Profile extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$aUser = $this->getParam('aUser');
		
		if (!Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'rss.can_subscribe_profile'))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('rss.user_has_disabled_rss_feeds'));
		}
		
		if (($sContent = Phpfox::getService('rss')->getUserFeed($aUser)))
		{			
			header('Content-type: text/xml; charset=utf-8');
			echo $sContent;
			exit;
		}		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('rss.component_controller_profile_clean')) ? eval($sPlugin) : false);
	}
}

?>