<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Component
 * @version 		$Id: info.class.php 6058 2013-06-13 13:54:02Z Miguel_Espinoza $
 */
class Profile_Component_Controller_Info extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{		
		$aRow = $this->getParam('aUser');
		if (!isset($aRow['user_id']))
		{
			return false;
		}	
		if (!isset($aRow['has_rated']))
		{
			$aRow['has_rated'] = false;
		}

		$this->template()->setTitle(Profile_Service_Profile::instance()->getProfileTitle($aRow));
		$this->template()->setEditor();
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('profile.component_controller_info_clean')) ? eval($sPlugin) : false);
	}
}

?>