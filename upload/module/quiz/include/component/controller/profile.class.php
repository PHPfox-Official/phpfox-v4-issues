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
 * @version 		$Id: profile.class.php 2512 2011-04-09 09:57:25Z Raymond_Benc $
 */
class Quiz_Component_Controller_Profile extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		(($sPlugin = Phpfox_Plugin::get('quiz.component_controller_profile_process_start')) ? eval($sPlugin) : false);

		$this->setParam('bIsProfile', true);		
		
		Phpfox::getComponent('quiz.index', array('bNoTemplate' => true), 'controller');			
		
		(($sPlugin = Phpfox_Plugin::get('quiz.component_controller_profile_process_end')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('quiz.component_controller_profile_clean')) ? eval($sPlugin) : false);
	}
}

?>