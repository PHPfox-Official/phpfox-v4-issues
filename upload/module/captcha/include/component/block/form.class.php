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
 * @version 		$Id: form.class.php 4348 2012-06-26 10:13:10Z Raymond_Benc $
 */
class Captcha_Component_Block_Form extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (Phpfox::getParam('captcha.recaptcha'))
		{
			require_once(PHPFOX_DIR_LIB . 'recaptcha' . PHPFOX_DS . 'recaptchalib.php');
		}		
		
		$bHttps = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? true : false);
		
		$this->template()->assign(array(
				'sImage' => $this->url()->makeUrl('captcha.image', array('id' => md5(rand(100, 1000)))),
				'sCaptchaData' => (Phpfox::getParam('captcha.recaptcha') ? recaptcha_get_html(Phpfox::getParam('captcha.recaptcha_public_key'), null, $bHttps, PHPFOX_IS_AJAX) : null),
				'sCatpchaType' => $this->getParam('captcha_type', null),
				'bCaptchaPopup' => $this->getParam('captcha_popup', false)
			)
		);
		
		(($sPlugin = Phpfox_Plugin::get('captcha.component_block_form_process')) ? eval($sPlugin) : false);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('captcha.component_block_form_clean')) ? eval($sPlugin) : false);
	}
}

?>