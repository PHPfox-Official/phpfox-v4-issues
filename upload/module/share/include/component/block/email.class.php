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
 * @version 		$Id: email.class.php 2026 2010-11-01 16:24:15Z Miguel_Espinoza $
 */
class Share_Component_Block_Email extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('share.can_send_emails', true);
		$sText = Phpfox::getPhrase('share.hi_check_this_out_url', array(
			'url' => $this->request()->get('url'),
			'full_name' => Phpfox::getUserBy('full_name'),
			'user_name' => Phpfox::getUserBy('user_name'),
			'email' => Phpfox::getUserBy('email'),
			'user_id' => Phpfox::getUserBy('user_id')
				));
		$this->template()->assign(array(
				'sTitle' => $this->request()->get('title'),
				'sMessage' => str_replace("\n", "", $sText),
				'iEmailLimit' => Phpfox::getUserParam('share.total_emails_per_round'),
				'bCanSendEmails' => Phpfox::getService('share')->canSendEmails()				
			)
		);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('share.component_block_email_clean')) ? eval($sPlugin) : false);
	}
}

?>