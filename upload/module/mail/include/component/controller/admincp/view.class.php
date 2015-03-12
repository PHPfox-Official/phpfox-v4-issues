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
 * @version 		$Id: view.class.php 4857 2012-10-09 06:32:38Z Raymond_Benc $
 */
class Mail_Component_Controller_Admincp_View extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aMessage = Phpfox::getService('mail')->getMail($this->request()->getInt('id'));
		
		if ((!Phpfox::getParam('mail.threaded_mail_conversation') && !isset($aMessage['mail_id'])) || (Phpfox::getParam('mail.threaded_mail_conversation') && !count($aMessage)))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('mail.message_not_found'));
		}
		
		if (Phpfox::getParam('mail.threaded_mail_conversation'))
		{
			$this->template()->setHeader(array('mail.css' => 'style_css'));
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('mail.viewing_private_message'))
			->setBreadCrumb(Phpfox::getPhrase('mail.private_messages'), $this->url()->makeUrl('admincp.mail.private'))
			->setBreadcrumb(Phpfox::getPhrase('mail.viewing_private_message'), null, true)
			->assign(array(
					'aMessage' => $aMessage
			)
		);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('mail.component_controller_admincp_view_clean')) ? eval($sPlugin) : false);
	}
}

?>