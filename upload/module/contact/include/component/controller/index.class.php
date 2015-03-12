<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_Contact
 * @version 		$Id: index.class.php 1449 2010-01-27 19:06:39Z Raymond_Benc $
 */
class Contact_Component_Controller_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		// assign the categories
		$this->template()->assign(array(
				'aCategories' => Phpfox::getService('contact.contact')->getCategories()
			)
		);

		// create the captcha check JS
		// they need to input some text always
		$aValidation = array(
			'text' => Phpfox::getPhrase('contact.fill_in_some_text_for_your_message'),
			'category_id' => Phpfox::getPhrase('contact.you_need_to_choose_a_category'), // they should always specify a category,
			'subject' => Phpfox::getPhrase('contact.provide_a_subject'),
			'full_name' => Phpfox::getPhrase('contact.provide_your_full_name')
		);

		// do they need to complete a captcha challenge?
		if (Phpfox::isModule('captcha') && Phpfox::getParam('contact.contact_enable_captcha'))
		{
			$aValidation['image_verification'] = Phpfox::getPhrase('captcha.complete_captcha_challenge');
		}

		// They always need to input their email address
		$aValidation['email'] = array(
			'def' => 'email',
			'title' => Phpfox::getPhrase('contact.provide_a_valid_email')
		);

		$oValid = Phpfox::getLib('validator')->set(array(
				'sFormName' => 'js_contact_form', 
				'aParams' => $aValidation
			)
		);

		// check if we're getting a request:
		if ($aVals = $this->request()->getArray('val'))
		{
			// check the fields are valid
			if ($oValid->isValid($aVals))
			{
				if (Phpfox::getService('contact.contact')->sendContactMessage($aVals))
				{
					if (!empty($aVals['category_id']) && $aVals['category_id'] == 'phpfox_sales_ticket')
					{
						$this->url()->send('contact', array('sent' => 'true'));	
					}
					else 
					{
						$this->url()->send('contact', null, Phpfox::getPhrase('contact.your_message_was_successfully_sent'));		
					}
				}
				else
				{
					$this->template()->assign(array('aContactErrors' => Phpfox_Error::set(Phpfox::getPhrase('error.site_email_not_set'))));
				}
			}			
		}
		
		if (Phpfox::isUser())
		{
			$this->template()->assign(array(
					'sFullName' => Phpfox::getUserBy('full_name'),
					'sEmail' => Phpfox::getUserBy('email')
				)
			);
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('contact.contact_us'))
			->setBreadcrumb(Phpfox::getPhrase('contact.contact_us'))
			->assign(array(
					'sCreateJs' => $oValid->createJs(),
					'sGetJsForm' => $oValid->getJsForm(),
					'bIsSent' => $this->request()->get('sent')
				)
			)
			->setFullSite();
	}

	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('contact.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>