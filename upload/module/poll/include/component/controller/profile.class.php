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
 * @package  		Module_Poll
 * @version 		$Id: profile.class.php 2489 2011-03-31 14:28:59Z Raymond_Benc $
 */
class Poll_Component_Controller_Profile extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getUserParam('poll.can_access_polls', true);
	
		(($sPlugin = Phpfox_Plugin::get('poll.component_controller_profile_process_start')) ? eval($sPlugin) : false);
		
		$this->setParam('bIsProfile', true);		
		
		Phpfox::getComponent('poll.index', array('bNoTemplate' => true), 'controller');	
		
		(($sPlugin = Phpfox_Plugin::get('poll.component_controller_profile_process_end')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('poll.component_controller_profile_clean')) ? eval($sPlugin) : false);
	}
}

?>