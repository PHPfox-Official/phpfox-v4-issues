<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Displays a welcome message to a user in the sites index page. 
 * Also contains by default the users profile URL, current time stamp and link to site themes.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Core
 * @version 		$Id: welcome.class.php 7265 2014-04-10 17:06:18Z Fern $
 */
class Core_Component_Block_Welcome extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if( ($this->template()->getThemeFolder() == 'nebula') || ($this->template()->getParentThemeFolder() == 'nebula') )
		{
			return false;
		}
		
		// If the user is not a member don't display this block
		if (!Phpfox::isUser())
		{
			return false;
		}
		
		$sUserProfileImage = Phpfox::getLib('image.helper')->display(array_merge(array('user' => Phpfox::getService('user')->getUserFields(true)), array(				
					'path' => 'core.url_user',
					'file' => Phpfox::getUserBy('user_image'),
					'suffix' => '_50_square',
					'max_width' => 50,
					'max_height' => 50
				)
			)
		);	
		
		$aGroup = Phpfox::getService('user.group')->getGroup(Phpfox::getUserBy('user_group_id'));

		// Assign template vars
		$this->template()->assign(array(
				'sUserProfileImage' => $sUserProfileImage,
				'sUserProfileUrl' => $this->url()->makeUrl('profile', Phpfox::getUserBy('user_name')), // Create the users profile URL
				'sCurrentUserName' => Phpfox::getLib('parse.output')->shorten(Phpfox::getLib('parse.output')->clean(Phpfox::getUserBy('full_name')), Phpfox::getParam('user.max_length_for_username'), '...'), // Get the users display name
				'sCurrentTimeStamp' => Phpfox::getTime(Phpfox::getParam('core.global_welcome_time_stamp'), PHPFOX_TIME), // Get the current time stamp
				'iTotalActivityPoints' => (int) Phpfox::getUserBy('activity_points'),
				'iTotalProfileViews' => (int) Phpfox::getUserBy('total_view'),
				'sUserGroupFullName' => Phpfox::getLib('locale')->convert($aGroup['title'])
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_controller_index_clean')) ? eval($sPlugin) : false);
		
		// Clean template vars from memory
		$this->template()->clean(array(
				'sUserProfileUrl'
			)
		);
	}
}

?>
