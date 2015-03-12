<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Profile
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Blog
 * @version 		$Id: profile.class.php 4590 2012-08-10 08:52:23Z Raymond_Benc $
 */
class Pages_Component_Controller_Profile extends Phpfox_Component
{
	public function process()
	{
		$this->setParam('bIsProfile', true);
		
		Phpfox::getComponent('pages.index', array('bNoTemplate' => true), 'controller');
	}	
}

?>