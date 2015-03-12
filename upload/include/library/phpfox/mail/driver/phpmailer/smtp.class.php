<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * PHPMailer SMTP
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: smtp.class.php 1666 2010-07-07 08:17:00Z Raymond_Benc $
 */
class Phpfox_Mail_Driver_Phpmailer_Smtp implements Phpfox_Mail_Interface
{	
	/**
	 * PHPMailer Object
	 *
	 * @var unknown_type
	 */	
	private $_oMail = null;
	
	/**
	 * Class constructor that loads PHPMailer class and sets all the needed variables.
	 *
	 * @return mixed FALSE if we cannot load PHPMailer, or NULL if we were.
	 */	
	public function __construct()
    {
	    if (!file_exists(PHPFOX_DIR_LIB . 'phpmailer' . PHPFOX_DS . 'class.phpmailer.php'))
	    {
	    	return Phpfox_Error::trigger('Unable to load lib: ' . PHPFOX_DIR_LIB . 'phpmailer' . PHPFOX_DS . 'class.phpmailer.php', E_USER_ERROR);
	    }
    	
	   	require_once(PHPFOX_DIR_LIB . 'phpmailer' . PHPFOX_DS . 'class.phpmailer.php');
    	
	    $this->_oMail = new PHPMailer;
	    $this->_oMail->From = (Phpfox::getParam('core.email_from_email') ? Phpfox::getParam('core.email_from_email') : 'server@localhost');
	    $this->_oMail->FromName = (Phpfox::getParam('core.mail_from_name') ? Phpfox::getParam('core.mail_from_name') : Phpfox::getParam('core.site_title'));
	    if (Phpfox::getParam('core.mail_smtp_authentication'))
	    {
    		$this->_oMail->SMTPAuth = true;
	    	$this->_oMail->Username = Phpfox::getParam('core.mail_smtp_username');
	    	$this->_oMail->Password = Phpfox::getParam('core.mail_smtp_password');		
	    }

	    $this->_oMail->Port = Phpfox::getParam('core.mail_smtp_port');
	    $this->_oMail->Host = Phpfox::getParam('core.mailsmtphost');
	    $this->_oMail->Mailer = "smtp";
	    $this->_oMail->WordWrap = 75;
	    $this->_oMail->CharSet = 'utf-8';
	    
    }
    
    /**
     * Run a test to make sure the admin provides the correct SMTP information.
     *
     * @param array $aVals ARRAY of values to connect to an SMTP server.
     */
    public function test($aVals)
    {
	    $this->_oMail = new PHPMailer;
	    $this->_oMail->From = $aVals['email_from_email'];
	    $this->_oMail->FromName = $aVals['mail_from_name'];
	    if ($aVals['mail_smtp_authentication'])
	    {
    		$this->_oMail->SMTPAuth = true;
	    	$this->_oMail->Username = $aVals['mail_smtp_username'];
	    	$this->_oMail->Password = $aVals['mail_smtp_password'];		
	    }

	    $this->_oMail->Port = $aVals['mail_smtp_port'];
	    $this->_oMail->Host = $aVals['mailsmtphost'];
	    $this->_oMail->Mailer = "smtp";
	    $this->_oMail->WordWrap = 75;
	    $this->_oMail->CharSet = 'utf-8';  
	    $this->_oMail->SMTPDebug = 2;  	
    }
    
    /**
     * Sends out an email.
     *
     * @param mixed $mTo Can either be a persons email (STRING) or an ARRAY of emails.
     * @param string $sSubject Subject message of the email.
     * @param string $sTextPlain Plain text of the message.
     * @param string $sTextHtml HTML version of the message.
     * @param string $sFromName Name the email is from.
     * @param string $sFromEmail Email the email is from.
     * @return bool TRUE on success, FALSE on failure.
     */    
    public function send($mTo, $sSubject, $sTextPlain, $sTextHtml, $sFromName = null, $sFromEmail = null)
    {    	
    	$this->_oMail->AddAddress($mTo);
		$this->_oMail->Subject = $sSubject;
		$this->_oMail->Body = $sTextHtml;
		$this->_oMail->AltBody = $sTextPlain;
		
		if ($sFromName !== null)
		{
			$this->_oMail->FromName = $sFromName;
		}
		
		if ($sFromEmail !== null)
		{		
			$this->_oMail->From = $sFromEmail;
		}
		
		if(!$this->_oMail->Send())
		{
			$this->_oMail->ClearAddresses();
			return Phpfox_Error::set($this->_oMail->ErrorInfo);
		}    	
		
		$this->_oMail->ClearAddresses();
		
		return true;
    }
}

?>