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
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Video_Component_Controller_Profile extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->setParam('bIsProfile', true);
		
		$aUser = $this->getParam('aUser');		
		
		if (!Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'video.display_on_profile'))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('video.videos_for_this_profile_is_set_to_private'));
		}			
		
		if ($sPlugin = Phpfox_Plugin::get('video.component_controller_profile_1')){eval($sPlugin);if (isset($mReturnFromPlugin)){return $mReturnFromPlugin;}}
		Phpfox::getComponent('video.index', array('bNoTemplate' => true), 'controller');
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('video.component_controller_profile_clean')) ? eval($sPlugin) : false);
	}
}

?>