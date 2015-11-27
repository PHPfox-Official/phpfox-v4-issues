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
 * @package  		Module_Error
 * @version 		$Id: display.class.php 225 2009-02-13 13:24:59Z Raymond_Benc $
 */
class Error_Component_Controller_Display extends Phpfox_Component 
{
	public function process()
	{
		$this->template()->clearBreadCrumb();
	}
}

?>