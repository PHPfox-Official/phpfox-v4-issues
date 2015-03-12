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
 * @package  		Module_Captcha
 * @version 		$Id: ajax.class.php 6793 2013-10-16 10:51:50Z Miguel_Espinoza $
 */
class Captcha_Component_Ajax_Ajax extends Phpfox_Ajax
{	
	public function reload()
	{
		$sUrl = Phpfox::getLib('url')->makeUrl('captcha.image', array('id' => md5(rand(100, 1000))));
		$sId = htmlspecialchars($this->get('sId'));
		$sInput = htmlspecialchars($this->get('sInput'));
		$this->call('$("#' . $sId . '").attr("src", "' . $sUrl . '"); $("#' . $sInput . '").val(""); $("#' . $sInput . '").focus(); $("#js_captcha_process").html("");');
	}
}

?>