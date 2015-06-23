<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Class we used to upload images within a hiddne iframe which gives the effect
 * that we are using AJAX to upload an image in the background.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: frame.class.php 4166 2012-05-15 06:44:59Z Raymond_Benc $
 */
class Photo_Component_Controller_Frame extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{	
		exit;
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_frame_clean')) ? eval($sPlugin) : false);
	}
}

?>