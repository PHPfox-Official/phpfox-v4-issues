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
 * @version 		$Id: contact.class.php 6968 2013-12-03 16:29:01Z Fern $
 */
class Contact_Service_Contact extends Phpfox_Service
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('contact_category');
	}

	public function getCategories()
	{		
		$sCacheId = $this->cache()->set('contact_category');
		
		if (!($aRows = $this->cache()->get($sCacheId)))
		{
			$aRows = $this->database()->select('*')
				->from($this->_sTable, 'cc')
				->order('cc.ordering ASC')
				->execute('getSlaveRows');
			
			$this->cache()->save($sCacheId, $aRows);			
		}		
		
		return $aRows;
	}

	/**
	 * Cleans the values and calls the sending function
	 *
	 * @param array $aValues
	 * @return unknown
	 */
	public function sendContactMessage($aValues)
	{
		$sSiteEmail = Phpfox::getParam('contact.contact_staff_emails');
		
		if (empty($sSiteEmail))
		{
			$sSiteEmail = Phpfox::getParam('core.email_from_email');
		}

		if (empty($sSiteEmail)) 
		{	
			return false;
		}
		
		// its better if we instantiate here instead of dynamic calling the lib every time
		$oParser = Phpfox::getLib('parse.input');
		
		// Remove all tags to make it plain text
		$sText = '';
		if (Phpfox::getUserId())
		{
			$sText .= Phpfox::getPhrase('contact.full_name') . ': ' . Phpfox::getUserBy('full_name') . '<br />';
			$sText .= Phpfox::getPhrase('contact.user_id') . ': ' . Phpfox::getUserId() . '<br />';
			$sText .= Phpfox::getPhrase('contact.profile') . ': ' . Phpfox::getLib('url')->makeUrl(Phpfox::getUserBy('user_name')) . '<br />';
		}
		
		$sText .= Phpfox::getPhrase('contact.email') . ': ' . $aValues['email'] . '<br />';
		$sText .= '------------------------------------------------------------<br />';
		
		if (!empty($aValues['category_id']) && $aValues['category_id'] == 'phpfox_sales_ticket')
		{
			$sText = $oParser->clean($aValues['text']);
		}
		else 
		{
			$sText .= (Phpfox::getParam('contact.allow_html_in_contact') == true ? $oParser->prepare($aValues['text']) : $oParser->clean($aValues['text']));		
		}

        // check if the user is logged in to include
        if (Phpfox::getUserId() > 0)
        {
		    $aValues['full_name'] .= ' (user id:'.Phpfox::getUserId() .')';
		}
		// send the mail 
		$aMails = explode(',', $sSiteEmail);
		
		if (!empty($aValues['category_id']) && $aValues['category_id'] == 'phpfox_sales_ticket')
		{
			$aValues['category_id'] = '';	
		}
		
		$bResult = true;		
		foreach ($aMails as $sMail)
		{
			$sMail = trim($sMail);
			$bSend = Phpfox::getLib('mail')->to($sMail)
				->messageHeader(false)
				->subject((!empty($aValues['category_id']) ? Phpfox::getLib('locale')->convert($aValues['category_id']) . ': ' : '') . $aValues['subject'])
				->message($sText)
				->fromName($aValues['full_name'])
				// Relay error SMTP http://www.phpfox.com/tracker/view/14866/
				// ->fromEmail($aValues['email'])
				->fromEmail(Phpfox::getParam('core.email_from_email'))
				->send();

			$bResult = $bResult && $bSend;
		}
		
		if (isset($aValues['copy']))
		{
			Phpfox::getLib('mail')->to($aValues['email'])
				->messageHeader(false)
				->subject((!empty($aValues['category_id']) ? Phpfox::getLib('locale')->convert($aValues['category_id']) . ': ' : '') . $aValues['subject'])
				->message($sText)
				->fromName(Phpfox::getParam('core.mail_from_name'))
				->fromEmail(Phpfox::getParam('core.email_from_email'))
				->send();		
		}

		if (Phpfox::getParam('contact.enable_auto_responder'))
		{
			Phpfox::getLib('mail')->to($aValues['email'])
					->messageHeader(false)
					->subject(Phpfox::getParam('contact.auto_responder_subject'))
					->message(Phpfox::getParam('contact.auto_responder_message'))
					->fromEmail(Phpfox::getParam('core.email_from_email'))
					->fromName(Phpfox::getParam('core.site_title'))
					->send();
		}
		return $bResult;
		
	}

	/**
	 * If a call is made to an unknown method attempt to connect
	 * it to a specific plug-in with the same name thus allowing
	 * plug-in developers the ability to extend classes.
	 *
	 * @param string $sMethod is the name of the method
	 * @param array $aArguments is the array of arguments of being passed
	 */
	public function __call($sMethod, $aArguments)
	{
		/**
		 * Check if such a plug-in exists and if it does call it.
		 */
		if ($sPlugin = Phpfox_Plugin::get('contact.service_contact__call'))
		{
			return eval($sPlugin);
		}

		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}
}

?>
