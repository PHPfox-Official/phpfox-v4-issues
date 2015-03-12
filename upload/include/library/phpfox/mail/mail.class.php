<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

Phpfox::getLibClass('phpfox.mail.interface');

/**
 * Email Driver Layer
 * Our email loads a 3rd party email class that usually has support for both sendmail and smtp.
 * 
 * Example:
 * <code>
 * Phpfox::getLib('mail')->to('foo@bar.com')
 * 		->subject('Test Subject')
 * 		->message('Test Message')
 * 		->send();
 * </code>
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: mail.class.php 7079 2014-01-29 17:27:22Z Fern $
 */
class Phpfox_Mail
{
	/**
	 * Object of the 3rd party library we are using to send the actual image.
	 *
	 * @var object
	 */
	private $_oMail = null;
	
	/**
	 * STRING or ARRAY of emails or users to send the emai to.
	 *
	 * @var mixed
	 */
	private $_mTo = null;
	
	/**
	 * ARRAY if loading a phrase or STRING if we are passing a subject.
	 *
	 * @var mixed
	 */
	private $_aSubject = null;
	
	/**
	 * The name of the person sending the email.
	 *
	 * @var string
	 */
	private $_sFromName = null;
	
	/**
	 * The email of the person sending the email.
	 *
	 * @var string
	 */
	private $_sFromEmail = null;
	
	/**
	 * Notification ID to be used to check if a user has privacy settings on receiving an email.
	 *
	 * @var string
	 */
	private $_sNotification = null;
	
	/**
	 * ARRAY of users to email and their information.
	 *
	 * @var array
	 */
	private $_aUsers = null;
	
	/**
	 * ARRAY of loading a phrase or STRING of we are passing the message directly.
	 *
	 * @var mixed
	 */
	private $_aMessagePlain = null;
	
	/**
	 * TRUE to send the message to ourself and FALSE to not.
	 *
	 * @var bool
	 */
	private $_bSendToSelf = false;
	
	/**
	 * Controlls if we should include the default header in the message. Default is TRUE.
	 *
	 * @var bool
	 */
	private $_bMessageHeader = true;
	
	/**
	 * ARRAY of loading a phrase or STRING of we are passing the message directly.
	 *
	 * @var mixed
	 */
	private $_aMessage = null;
	
	/**
	 * Used for global replacements like site_name and site_email
	 * @var String 
	 */
	private $_sArray = 'array()';
	/**
	 * Class constructor that loads a specific method of sending emails (sendmail or smtp)
	 *
	 * @param string $sMethod Method to send an email (sendmail or smtp)
	 */
	public function __construct($sMethod = null)
    {    	
    	$this->_oMail = Phpfox::getLib('mail.driver.phpmailer.' . ($sMethod === null ? Phpfox::getParam('core.method') : $sMethod));
		$this->_sArray = 'array("site_name" => "'.str_replace('"', '&quot;',Phpfox::getParam('core.site_title')).'","site_email" => "'.Phpfox::getParam('core.email_from_email').'")';
    }    
    
    /**
     * Run a test if we are able to send out an email using the default method being loaded.
     *
     * @param array $aVals ARRAY of values to test.
     * @return object Returns this class.
     */
    public function test($aVals)
    {
    	$this->_oMail->test($aVals);
    	
    	return $this;
    }
    
    /**
     * Identify who this email will be sent to. Can be an actual email or a user ID or an array of 
     * emails or user IDs.
     *
     * @param mixed $mTo ARRAY of emails/users or STRING of email/user
     * @return object Returns this class.
     */
    public function to($mTo)
    {    	
    	$this->_mTo = $mTo;
    	
    	return $this;
    }
    
    /**
     * Subject of the email.
     *
     * @param mixed $aSubject ARRAY if loading a phrase or STRING if we are passing a subject.
     * @return object Returns this class.
     */
    public function subject($aSubject)
    {
		$this->_aSubject = $aSubject;
		
		return $this;
    }
    
    /**
     * The name of the person sending out the email.
     *
     * @param string $sFromName Persons name.
     * @return object Returns this class.
     */
    public function fromName($sFromName)
    {
    	$this->_sFromName = $sFromName;
    	
    	return $this;
    }
    
    /**
     * Send a copy to our own email.
     *
     * @param bool $bSendToSelf TRUE will send a copy and FALSE will not.
     * @return object Returns this class.
     */
    public function sendToSelf($bSendToSelf)
    {
    	$this->_bSendToSelf = $bSendToSelf;
    	
    	return $this;
    }
    
    /**
     * Email of the person sending out this email.
     *
     * @param string $sFromEmail Email.
     * @return object Returns this class.
     */
    public function fromEmail($sFromEmail)
    {
    	$this->_sFromEmail = $sFromEmail;
    	
    	return $this;
    }
    
    /**
     * Notification param for this specific email to check a users privacy settings.
     *
     * @param string $sNotification Param of the notification.
     * @return object Returns this class.
     */
    public function notification($sNotification)
    {
    	$this->_sNotification = $sNotification;
    	
    	return $this;
    }
    
    /**
     * Message of the email.
     *
     * @param mixed $aMessage ARRAY of loading a phrase or STRING of we are passing the message directly.
     * @return object Returns this class.
     */
    public function message($aMessage)
    {
		if (is_array($aMessage))
		{
			if (!isset($aMessage[1]['site_name']))
			{
				$aMessage[1]['site_name'] = Phpfox::getParam('core.site_title');
			}
			if (!isset($aMessage[1]['site_url']))
			{
				$aMessage[1]['site_url'] = Phpfox::getLib('url')->getDomain();
			}
		}
		$this->_aMessage = $aMessage;

    	return $this;    	
    }
    
    /**
     * Identify if we should load the message header we include by default.
     *
     * @param bool $bMessageHeader Controlls if we should include the default header in the message. Default is TRUE.
     * @return object Returns this class.
     */
    public function messageHeader($bMessageHeader)
    {
    	$this->_bMessageHeader = $bMessageHeader;
    	
    	return $this;
    }

    /**
     * Message of the email (Plain Text).
     *
     * @param mixed $aMessage ARRAY of loading a phrase or STRING of we are passing the message directly.
     * @return object Returns this class.
     */    
	public function messagePlain($aMessage)
	{		
		$this->_aMessagePlain = $aMessage;

		return $this;
	}

	/**
	 * We load users information in our send() method, however you can also load users by passing
	 * an array of their information with this method.
	 *
	 * @param array $aUser ARRAY of users information.
	 * @return object Returns this class.
	 */
	public function aUser($aUser)
	{
		if (!isset($aUser['user_id']) || !isset($aUser['full_name']) || !isset($aUser['email']))
		{
			// Phpfox_Error::set('aUser incomplete');
		}
		$this->_aUsers[] = ($aUser);

		return $this;
	}
	
	/**
	 * Email address validator based on http://www.linuxjournal.com/article/9585 and RFC 2821
	 * Uses recursion for arrays
	 * 
	 * @param mixed $mEmail array|string
	 * @return boolean true if all valid
	 */
	public function checkEmail($mEmail)
	{
		if (is_array($mEmail))
		{			
			foreach($mEmail as $sEmail)
			{
				if (!$this->_checkEmail($sEmail, Phpfox::getParam('core.use_dnscheck')))
				{
					// return here before keep going					
					return false;
				}
			}
			return true;
		}
		return $this->_checkEmail($mEmail);		
	}

    /**
     * Method to send out the email.
     * Checks: 
     * 		(message || to) === null -> return false;
     * 		(sFromName || sFromEmail) === null -> getParam(core.
     * 		(Notification) assumes to is an array of integers, otherwise return false
	 *
	 * @example Phpfox::getLib('mail')->to('user@email.com')->subject('Test Subject')->message('This is a test message')->send();
     * @example Phpfox::getLib('mail')->to(array('user1@email.com', 'user2@email.com', 'user3@email.com')->subject('Test Subject')->message('This is a test message')->send()
     * @return boolean
     */
    public function send($bDoCheck = false)
    {		
		if (defined('PHPFOX_SKIP_MAIL'))
		{
			return true;
		}
    	
    	// turn into an array
    	if (!is_array($this->_mTo))
    	{
    		$this->_mTo = array($this->_mTo);
    	}

		// check if the mail(s) are valid
		if ($bDoCheck && $this->checkEmail($this->_mTo) == false)
		{			
			return false;
		}

    	if ($this->_aMessage === null || $this->_mTo === null)
    	{
    		return false;
    	}
    	
    	if ($this->_sFromName === null)
		{
			$this->_sFromName = Phpfox::getParam('core.mail_from_name');
		}
		
		if ($this->_sFromEmail === null)
		{
			$this->_sFromEmail = Phpfox::getParam('core.email_from_email');
		}
		
		$this->_sFromName = html_entity_decode($this->_sFromName, null, 'UTF-8');
		
		$sIds = '';
		$sEmails = '';

		if (!empty($this->_aUsers))
		{
			foreach ($this->_aUsers as $aUser)
			{
				if (isset($aUser['user_id']) && !empty($aUser['user_id']))
				{
					$sIds .= (int) $aUser['user_id'] . ',';
				}
			}
		}
		else
		{
			foreach ($this->_mTo as $mTo)
			{
				if (strpos($mTo, '@'))
				{
					$sEmails .= $mTo . ',';
				}
				else
				{
					$sIds .= (int) $mTo . ',';
				}
			}			
		}
		$sIds = rtrim($sIds, ',');
		$sEmails = rtrim($sEmails, ',');
		
		$bIsSent = true;		

		if (!empty($sIds))
		{
			if ($this->_sNotification !== null)
			{
				Phpfox::getLib('database')->select('un.user_notification, ')->leftJoin(Phpfox::getT('user_notification'), 'un', "un.user_id = u.user_id AND un.user_notification = '" . Phpfox::getLib('database')->escape($this->_sNotification) . "'");
			}		
			
			(($sPlugin = Phpfox_Plugin::get('mail_send_query')) ? eval($sPlugin) : false);
			
			if ($this->_aUsers === null)
		    {
				$aUsers = Phpfox::getLib('database')->select('u.user_id, u.email, u.language_id, u.full_name, u.user_group_id')
					->from(Phpfox::getT('user'), 'u')
					->where('u.user_id IN(' . $sIds . ')')
					->execute('getSlaveRows');
			}
			else
			{
				$aUsers = $this->_aUsers;
			}
		    if (!empty($aUsers) && count($aUsers) > 0)
			{			    
				foreach ($aUsers as $aUser)
				{
					// User is banned, lets not send them any emails
					if (isset($aUser['user_group_id']) && Phpfox::getService('user.group.setting')->getGroupParam($aUser['user_group_id'], 'core.user_is_banned'))
					{
						continue;
					}
					
					// Lets not send out an email to myself					
					if ($this->_bSendToSelf === false && $aUser['user_id'] == Phpfox::getUserId())
					{
						continue;
					}
					
					$bCanSend = true;
					if ($this->_sNotification !== null && $aUser['user_notification'])
					{						
						$bCanSend = false;
					}
					
					if ($bCanSend === true)
					{						
						// load the messages in their language						
						$aUser['language_id'] = ($aUser['language_id'] == null || empty($aUser['language_id'])) ?  Phpfox::getParam('core.default_lang_id') : $aUser['language_id'];
		
						if (is_array($this->_aMessage))
						{
							$sMessage = Phpfox::getPhrase($this->_aMessage[0], isset($this->_aMessage[1]) ? array_merge($aUser, $this->_aMessage[1]) : $aUser, false, null, $aUser['language_id']);
						}
						else
						{
							$sMessage = Phpfox::getLib('locale')->getPhraseHistory($this->_aMessage, $aUser['language_id']);
						} 
						
						if (is_array($this->_aMessagePlain))
						{
							$sMessagePlain = Phpfox::getPhrase($this->_aMessagePlain[0], isset($this->_aMessagePlain[1]) ? array_merge($aUser, $this->_aMessagePlain[1]) : $aUser, false, null, $aUser['language_id']);
						}
						else
						{
							$sMessagePlain = Phpfox::getLib('locale')->getPhraseHistory($this->_aMessagePlain, $aUser['language_id']);
						}

						$sMessage = preg_replace('/' . preg_quote(Phpfox::getLib('url')->makeUrl(''), '/') . '/is', str_replace('mobile/', '', Phpfox::getLib('url')->makeUrl('')), $sMessage);
						$sMessagePlain = preg_replace('/' . preg_quote(Phpfox::getLib('url')->makeUrl(''), '/') . '/is', str_replace('mobile/', '', Phpfox::getLib('url')->makeUrl('')), $sMessagePlain);
						
						if (is_array($this->_aSubject))
						{
							$sSubject = Phpfox::getPhrase($this->_aSubject[0], isset($this->_aSubject[1]) ? array_merge($aUser,$this->_aSubject[1]) : $aUser, false, null, $aUser['language_id']);
						}
						else
						{
							$sSubject = Phpfox::getLib('locale')->getPhraseHistory($this->_aSubject, $aUser['language_id']);
						}

						$sMessage = preg_replace('/\{setting var=\'(.*)\'\}/ise', "'' . Phpfox::getParam('\\1') . ''", $sMessage);
						$sMessage = preg_replace('/\{phrase var=\'(.*)\'\}/ise', "'' . Phpfox::getPhrase('\\1',{$this->_sArray}, false, null, '".$aUser['language_id']."') . ''", $sMessage);
						$sMessagePlain = preg_replace('/\{phrase var=\'(.*)\'\}/ise', "'' . Phpfox::getPhrase('\\1',{$this->_sArray}, false, null, '".$aUser['language_id']."') . ''", $sMessagePlain);
						$sMessagePlain = preg_replace('/\{setting var=\'(.*)\'\}/ise', "'' . Phpfox::getParam('\\1') . ''", $sMessagePlain);
						$sSubject = preg_replace('/\{setting var=\'(.*)\'\}/ise', "'' . Phpfox::getParam('\\1') . ''", $sSubject);
						$sSubject = preg_replace('/\{phrase var=\'(.*)\'\}/ise', "'' . Phpfox::getPhrase('\\1',{$this->_sArray}, false, null, '".$aUser['language_id']."') . ''", $sSubject);
						$sSubject = html_entity_decode($sSubject, null, 'UTF-8'); // http://www.phpfox.com/tracker/view/10392/
						$sSubject = str_replace(array('&#039;', '&#0039;'), "'", $sSubject); // http://www.phpfox.com/tracker/view/15051/
						$sEmailSig = preg_replace('/\{phrase var=\'(.*)\'\}/ise', "'' . Phpfox::getPhrase('\\1',{$this->_sArray}, false, null, '".$aUser['language_id']."') . ''", Phpfox::getParam('core.mail_signature'));
				
						// Load plain text template
						$sTextPlain = Phpfox::getLib('template')->assign(array(
									'sName' => $aUser['full_name'],
									'bHtml' => false,
									'sMessage' => $this->_aMessagePlain !== null ? $sMessagePlain : $sMessage,
									'sEmailSig' => $sEmailSig,
									'bMessageHeader' => $this->_bMessageHeader,
									'sMessageHello' => Phpfox::getPhrase('core.hello_name', array('name' => $aUser['full_name']), false, null, $aUser['language_id'])
								)
							)->getLayout('email', true);

						// Load HTML text template
						$sTextHtml = Phpfox::getLib('template')->assign(array(
									'sName' => $aUser['full_name'],
									'bHtml' => true,
									'sMessage' => str_replace("\n", "<br />", $sMessage),
									'sEmailSig' => str_replace("\n", "<br />", $sEmailSig),
									'bMessageHeader' => $this->_bMessageHeader,
									'sMessageHello' => Phpfox::getPhrase('core.hello_name', array('name' => $aUser['full_name']), false, null, $aUser['language_id'])
								)
							)->getLayout('email', true);
						
						if (defined('PHPFOX_DEFAULT_OUT_EMAIL'))
						{
							$aUser['email'] = PHPFOX_DEFAULT_OUT_EMAIL;
						}
						
						(($sPlugin = Phpfox_Plugin::get('mail_send_call')) ? eval($sPlugin) : false);
						
						if (empty($aUser['email']))
						{
							continue;
						}
						
						if (!isset($bSkipMailSend))
						{
							$bIsSent = (defined('PHPFOX_CACHE_MAIL') ? $this->_cache($aUser['email'], $sSubject, $sTextPlain, $sTextHtml, $this->_sFromName, $this->_sFromEmail) : $this->_oMail->send($aUser['email'], $sSubject, $sTextPlain, $sTextHtml, $this->_sFromName, $this->_sFromEmail));
						}
					}					
				}
			}	
		}
		
		
		if ($sPlugin = Phpfox_Plugin::get('mail_send_call_2'))
		{
			eval($sPlugin);
		}
		
		if (!empty($sEmails))
		{			
			$aEmails = explode(',', $sEmails);
			foreach ($aEmails as $sEmail)
			{
				$sEmail = trim($sEmail);

				if (is_array($this->_aMessage))
				{
					$sMessage = Phpfox::getPhrase($this->_aMessage[0], $this->_aMessage[1], false, null, Phpfox::getParam('core.default_lang_id'));
				}
				else
				{
					$sMessage = $this->_aMessage;
				}
				if (is_array($this->_aMessagePlain))
				{
					$sMessagePlain = Phpfox::getPhrase($this->_aMessagePlain[0], $this->_aMessagePlain[1], false, null, Phpfox::getParam('core.default_lang_id'));
				}
				else
				{
					$sMessagePlain  = $this->_aMessagePlain;
				}
				if (is_array($this->_aSubject))
				{
					$sSubject = Phpfox::getPhrase($this->_aSubject[0], $this->_aSubject[1], false, null, Phpfox::getParam('core.default_lang_id'));
				}
				else
				{
					$sSubject = $this->_aSubject;
				}
				$sEmailSig = preg_replace('/\{phrase var=\'(.*)\'\}/ise', "'' . Phpfox::getPhrase('\\1', {$this->_sArray}, false, null, '". Phpfox::getParam('core.default_lang_id')."') . ''", Phpfox::getParam('core.mail_signature'));
				$sMessagePlain = preg_replace('/\{phrase var=\'(.*)\'\}/ise', "'' . Phpfox::getPhrase('\\1', {$this->_sArray}, false, null, '". Phpfox::getParam('core.default_lang_id')."') . ''", $sMessagePlain);
				$sMessage = preg_replace('/\{phrase var=\'(.*)\'\}/ise', "'' . Phpfox::getPhrase('\\1', {$this->_sArray}, false, null, '". Phpfox::getParam('core.default_lang_id')."') . ''", $sMessage);
				$sSubject = preg_replace('/\{phrase var=\'(.*)\'\}/ise', "'' . Phpfox::getPhrase('\\1', {$this->_sArray}, false, null, '". Phpfox::getParam('core.default_lang_id')."') . ''", $sSubject);
				$sSubject = html_entity_decode($sSubject, null, 'UTF-8');
				
				// Load plain text template
				$sTextPlain = Phpfox::getLib('template')->assign(array(				
						'bHtml' => false,
						'sMessage' => $this->_aMessagePlain !== null ? $sMessagePlain : $sMessage,
						'sEmailSig' => $sEmailSig,
						'bMessageHeader' => $this->_bMessageHeader
					)
				)->getLayout('email', true);
						
				// Load HTML text template
				$sTextHtml = Phpfox::getLib('template')->assign(array(
						'bHtml' => true,
						'sMessage' => str_replace("\n", "<br />", $sMessage),
						'sEmailSig' => str_replace("\n", "<br />", $sEmailSig),
						'bMessageHeader' => $this->_bMessageHeader
					)
				)->getLayout('email', true);	
				
				if ($sPlugin = Phpfox_Plugin::get('mail_send_call_3'))
				{
					eval($sPlugin);
				}
		
				if (empty($sEmail))
				{
					continue;
				}
				
				$bIsSent = (defined('PHPFOX_CACHE_MAIL') ? $this->_cache($sEmail, $sSubject, $sTextPlain, $sTextHtml, $this->_sFromName, $this->_sFromEmail) : $this->_oMail->send($sEmail, $sSubject, $sTextPlain, $sTextHtml, $this->_sFromName, $this->_sFromEmail));
			}
		}
		$this->_aUsers = null;
		
		if ($sPlugin = Phpfox_Plugin::get('mail_send_call_4'))
		{
			eval($sPlugin);
		}
		
		return $bIsSent;
    }
    
    private function _cache($sEmail, $sSubject, $sTexPlain, $sTextHtml, $sFromName, $sFromEmail)
    {    	
    	Phpfox::getLib('file')->write(PHPFOX_DIR_FILE . 'log' . PHPFOX_DS . 'email_' . md5(str_replace(' ', '_', $sSubject) . PHPFOX_TIME . uniqid()) . '.html', "<b>Email:</b> {$sEmail}<br />\n<b>Subject:</b> {$sSubject}\n<br /><b>Text Plan:</b>{$sTexPlain}\n<br /><b>Text HTML:</b> {$sTextHtml}\n<br /><b>From Name:</b> {$sFromName}\n<br /><b>From Email:</b> {$sFromEmail}");
    	
    	return true;
    }
    
	/**
	 * Checks to validate an email.
	 * 
	 * @param string $sEmail email to check
	 * @param boolean $bDoDnsCheck http://php.net/checkdnsrr check for domain name, this could slow down the function so use wisely
	 * @return boolean
	 */
	private function _checkEmail($sEmail, $bDoDnsCheck = false)
	{		
		$iAtIndex = strrpos($sEmail, "@");
		
		if ($iAtIndex === false)
		{ // there is no @ symbol
		   return false;
		}

		$sDomain = substr($sEmail, $iAtIndex+1);
		$sLocal = substr($sEmail, 0, $iAtIndex);

		$iDomainLen = strlen($sDomain);
		$iLocalLen = strlen($sLocal);

		
		if ( ($iLocalLen < 1) || ($iLocalLen > 64) || ($iDomainLen < 1) || ($iDomainLen > 255))
		{ // either the user or the domain are not within valid values
			return false;
		}
		
		if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$sLocal)))
		{
		   // character not valid in local part unless
		   // local part is quoted
		   if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$sLocal)))
		   {
			  return false;
		   }
		}

		// check for dots according to RFC 2822 3.2.4
		if ($sLocal[0] == '.' || $sLocal[$iLocalLen-1] == '.' || preg_match('/\\.\\./', $sLocal))
		{
		   // local starts or ends with a dot or has 2 consecutive dots
		   return false;
		}
		// validate domain
		if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $sDomain) || (preg_match('/\\.\\./', $sDomain)))
		{
		   // Domain has 2 consecutive dots or invalid characters
		   return false;
		}
		elseif ($bDoDnsCheck == true && function_exists('checkdnsrr')
			&& !(checkdnsrr($sDomain,"MX") || checkdnsrr($sDomain, "A")))
		{
		   // domain not found in DNS
		   return false;
		}

		return true;
	}   
}

?>
