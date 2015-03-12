<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * To create a mass reminder to verify their email address should be just a matter of getting all the hashes and looping
 * through $this->verify(sHash)
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_User
 * @version 		$Id: process.class.php 679 2009-06-15 19:45:45Z Miguel_Espinoza $
 */
class User_Service_Verify_Process extends Phpfox_Service
{	
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('user_verify');
	}

	/**
	 * Direct verify of a user, only admins should be allowed to trigger this function.
	 * @param Int $iUser
	 * @return $this->verify(sHash, false)
	 */
	public function adminVerify($iUser)
	{
		// Is this user allowed to verify others?
		if (!Phpfox::getUserParam('user.can_verify_others_emails')) return false;
		$sNewmail = $this->database()->select('email')->from($this->_sTable)->where('user_id = ' . (int)$iUser)->execute('getSlaveField');
		$aUpdate = array('status_id' => 0);
		if (isset($sNewmail) && $sNewmail != '') $aUpdate['email'] = $sNewmail;

		$this->database()->update(Phpfox::getT('user'), $aUpdate, 'user_id = ' . (int)$iUser);
		$this->database()->delete($this->_sTable, 'user_id = ' . (int)$iUser);
		$this->database()->update(Phpfox::getT('photo'), array('view_id' => '0'), 'view_id = 3 AND user_id = ' . (int)$iUser);
		
		// update the friends count when "on signup new friend is enabled
		if(Phpfox::getParam('user.on_signup_new_friend'))
		{
			Phpfox::getService('friend.process')->updateFriendCount($iUser, Phpfox::getParam('user.on_signup_new_friend'));
			Phpfox::getService('friend.process')->updateFriendCount(Phpfox::getParam('user.on_signup_new_friend'), $iUser);
		}
		
		return true;
	}

	/**
	 * Changes a user's email addres, checks if user is allowed and if he should be made verify their email address
	 * afterwards and if it should be logged out immediately after changing it.
	 * @param <type> $aUser
	 * @param <type> $sMail
	 * @return <type>
	 */
	public function changeEmail($aUser, $sMail)
	{
		// check if user has enough permissions and the mails dont match if they have to verify the new email upon signup it		
		if (Phpfox::getUserGroupParam($aUser['user_group_id'], 'user.can_change_email'))
		{			
			Phpfox::getService('user.validate')->email($sMail);

			if (!Phpfox_Error::isPassed())
			{
				return false;
			}			
			
			// check that the new email is not in use.
			$sEmail = Phpfox::getLib('parse.input')->prepare($sMail);
			$inUse = $this->database()
				->select('email')
				->where('email = \'' .$sEmail .'\'')
				->from(Phpfox::getT('user'))
				->execute('getSlaveField');
			
			if ($inUse != '')
			{
				return 'Email address already in use';
			}
			//die(d(Phpfox::getParam('user.verify_email_at_signup'), true));
			// set the status to need to be verified only if they are required at signup
			if (Phpfox::getParam('user.verify_email_at_signup'))
			{
				$mUser = array('user_id' => $aUser['user_id'], 
								'email' => Phpfox::getLib('parse.input')->prepare($sMail),
								'password' => $aUser['password']);
				$this->database()->update(Phpfox::getT('user'), array('status_id' => 1), 'user_id = ' . (int)$aUser['user_id']);
				$this->sendMail($mUser);				
			}
			else
			{
				// just change the email
				$this->database()->update(Phpfox::getT('user'),
						array('email' => Phpfox::getLib('parse.input')->prepare($sMail)),
					'user_id = ' . (int)$aUser['user_id']
				);
			}
			//Phpfox::getParam('user.logout_after_change_email_if_verify') && Phpfox::getParam('user.verify_email_at_signup')
			// check if they should be logged out immediately after changing it. Only then should their status_id be changed
			if (Phpfox::getParam('user.verify_email_at_signup') && Phpfox::getParam('user.logout_after_change_email_if_verify') == true)
			{				
				Phpfox::getService('user.auth')->logout();
			}
			return true;
		}
		
		return false;
	}

	/**
	 * This function checks if the hash submitted is valid.
	 * In every case it deletes the hash from the database, if the hash expired it creates a new one and sends an email to the user.
	 * @param String $sHash
	 * @param Boolean $bStrict tells if we should check if the password has expired, added to complement the adminVerify
	 * @return boolean false if the hash is not found on the db or if it has expired | true if the hash matches
	 */
	public function verify($sHash, $bStrict = true)
	{		
		$aVerify = $this->database()
			->select('uv.user_id, uv.email as newMail, u.password, uv.time_stamp')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = uv.user_id')
			->from($this->_sTable, 'uv')
			->where('uv.hash_code = \'' . Phpfox::getLib('parse.input')->clean($sHash) . '\'')
			->execute('getSlaveRow');

		if (empty($aVerify))
		{
			return false;
		}
		/**
		 *  @ToDo what do we do if the entry is not found? do we allow the user to log in? */
		// Delete the entry from the user_verify table
		$this->database()->delete($this->_sTable, 'user_id = ' . $aVerify['user_id']);
		
		if ((Phpfox::getParam('user.verify_email_timeout') == 0 ||
			($aVerify['time_stamp'] + (Phpfox::getParam('user.verify_email_timeout') * 60)) >= Phpfox::getTime())) 
		{
			$bValid = true;
			// Update the user table where user_id = aVerify[user_id]
			
			// (Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->allowGuest()->add('user_joined', $aVerify['user_id'], null, $aVerify['user_id']) : null);
			
			(($sPlugin = Phpfox_Plugin::get('user.service_verify_process_verify_pass')) ? eval($sPlugin) : false);
			
			$this->database()->update(Phpfox::getT('user'), array(
				'status_id' => 0,
				'email' => $aVerify['newMail']
				), 'user_id = ' . $aVerify['user_id']);
			
			$this->database()->update(Phpfox::getT('photo'), array('view_id' => '0'), 'view_id = 3 AND user_id = ' . $aVerify['user_id']);
			
			// update the friends count when "on signup new friend is enabled
			if(Phpfox::getParam('user.on_signup_new_friend'))
			{
				Phpfox::getService('friend.process')->updateFriendCount($aVerify['user_id'], Phpfox::getParam('user.on_signup_new_friend'));
				Phpfox::getService('friend.process')->updateFriendCount(Phpfox::getParam('user.on_signup_new_friend'), $aVerify['user_id']);
			}
			
			// Send the welcome email
			 Phpfox::getLib('mail')
				->to($aVerify['user_id'])
				->subject(array('core.welcome_email_subject', array('site' => Phpfox::getParam('core.site_title'))))
				->message(array('core.welcome_email_content'))
				->send();
			return true;
		}
		else
		{
			$bValid = false;
		}

		if ($bStrict === false) return true;
		// Its invalid (timeout) so add the entry to the error log table
		$aError = array(
			'ip_address' => Phpfox::getIp(),
			'hash_code' => Phpfox::getLib('parse.input')->prepare($sHash),
			'email' => $aVerify['newMail'], // should we add also the email address here ?
			'time_stamp' => Phpfox::getTime()
		);
		$this->database()->insert(Phpfox::getT('user_verify_error'), $aError);

		return false;
	}

	/**
	 * Sends an email with the verification link. Accepts an integer, an array() or an array(array())
	 * @param int|array[]|array[][] $mUser If int its taken as user_id, if array we save a query, if array[][] we mass mail their verification links
	 * @return boolean
	 */
	public function sendMail($mUser)
	{
	// this function to be flexible, allows receiving an integer or an array, if its an array then we
	// dont query the database looking for the info needed.
	// Info needed: email in the user_verify table if exists.
	// when we add the new email to the user_verify table then when they log in using their old email,
	// until they verify the new one

		if (is_numeric($mUser) || (!isset($mUser['email']) && !isset($mUser[0]['email'])) ) 
		{
			// check if the user exists:
			$aUser = $this->database()
					->select('user_id, email, password')
					->from(Phpfox::getT('user'))
					->where('user_id = ' . (int)$mUser)
					->execute('getSlaveRow');
			if (!$aUser)
			{
				return false;
			}

			$aUserV = $this->database()
				->select('uv.email') // select the new email
				->from($this->_sTable, 'uv')
				->where('uv.user_id = ' . (int)$mUser)
				->limit(1)
				->execute('getSlaveRow');

			if (!$aUserV)
			{
				// we know the user exists, so we generate a new hash and send that instead
				$this->database()->insert(Phpfox::getT('user_verify'), array(
					'user_id' => $aUser['user_id'],
					'hash_code' => Phpfox::getService('user.verify')->getVerifyHash($aUser),
					'time_stamp' => Phpfox::getTime(),
					'email' => $aUser['email']));
				$aUserV = array('email' => $aUser['email']);
			}
			$mUser = array('user_id' => $mUser, 'email' => $aUserV['email'], 'password' => $aUser['password']);

		}

		// Check if we're mass mailing
		if (isset($mUser[0]['email']))
		{
			// its an array of users
			foreach ($mUser as $aUser)
			{
				$this->sendMail($aUser);
			}
			return true;
		}

		// Set the hash code
		if (!isset($sHash))
		{
			$sHash = Phpfox::getService('user.verify')->getVerifyHash($aUser);//Phpfox::getLib('hash')->setRandomHash($mUser['user_id'] . $mUser['email'] . $mUser['password'] . Phpfox::getParam('core.salt') . uniqid()); // + email & password & $_CONF[core.salt]
		}
		// There may already be an entry so to avoid duplicates and not risk an update on a missing entry we delete:
		$this->database()->delete($this->_sTable, 'user_id = ' . (int)$mUser['user_id']);

		$this->database()->insert($this->_sTable, array(
			'user_id' => $mUser['user_id'],
			'hash_code' => $sHash,
			'time_stamp' => Phpfox::getTime(),
			'email' => $mUser['email']
		));

		// send email
		$sLink = Phpfox::getLib('url')->makeUrl('user.verify', array('link' => $sHash));
		Phpfox::getLib('mail')
			->to($mUser['email'])
			->subject(array('user.email_verification_on_site_title', array('site_title' => Phpfox::getParam('core.site_title'))))
			->message(array('user.you_registered_an_account_on_site_title_before', array(
						'site_title' => Phpfox::getParam('core.site_title'),
						'link' => $sLink
					)
				)
			)
			->send();
			
		return true;
	}

}

?>
