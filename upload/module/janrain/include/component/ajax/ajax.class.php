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
 * @package 		Phpfox_Ajax
 * @version 		$Id: ajax.class.php 5840 2013-05-09 06:14:35Z Raymond_Benc $
 */
class Janrain_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function login()
	{
		$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('janrain.login') . '\';');	
	}
}

?>