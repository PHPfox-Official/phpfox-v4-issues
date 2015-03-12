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
 * @package  		Module_Invite
 * @version 		$Id: invite.class.php 6880 2013-11-12 13:56:55Z Miguel_Espinoza $
 */
class Invite_Service_Invite extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('invite');
	}

	/**
	 *	Checks every mail to see if its valid and filters the one that have already been invited if set in adminpanel
	 * @param array $aMails
	 * @return array with uninvited and valid emails
	 */
	public function getValid($aMails, $iUser)
	{
		if (empty($aMails))
		{
			return array();
		}
		
		$oMail = Phpfox::getLib('mail');
		$aValid = array();
		$aInvalid = array();
		$aMembers = array();

		$sDbCheck = '';
		foreach($aMails as $sMail)
		{
			$sMail = trim($sMail);
			$sDbCheck .= '\'' . $this->database()->escape($sMail) . '\',';
			if ($oMail->checkEmail($sMail, Phpfox::getParam('core.use_dnscheck')) == true)
			{
				array_push($aValid, $sMail);
			}
			else
			{
				array_push($aInvalid, $sMail . ' - ' . Phpfox::getPhrase('invite.not_a_valid_email'));
			}
		}
		$sDbCheck = rtrim($sDbCheck, ',');
		
		$aCacheUsers = array();

		if(Phpfox::isModule('friend'))
		{
			$aUsers = $this->database()->select(Phpfox::getUserField() . ', u.email, f.friend_id')
				->from(Phpfox::getT('user'), 'u')
				->leftJoin(Phpfox::getT('friend'), 'f', 'f.user_id = ' . Phpfox::getUserId() . ' AND f.friend_user_id = u.user_id')
				->where('u.email IN(' . $sDbCheck . ')')
				->execute('getSlaveRows');
		}
		else
		{
			$aUsers = $this->database()->select(Phpfox::getUserField() . ', u.email')
				->from(Phpfox::getT('user'), 'u')
				->where('u.email IN(' . $sDbCheck . ')')
				->execute('getSlaveRows');
		}
		
		foreach ($aUsers as $aUser)
		{
			$aCacheUsers[strtolower($aUser['email'])] = $aUser;
		}	
		
		foreach ($aValid as $iKey => $sEmail)
		{
			if (isset($aCacheUsers[strtolower($sEmail)]))
			{				
				unset($aValid[$iKey]);
			}
		}
					
		// should we check for duplicate invites by this user
		if (Phpfox::getParam('invite.check_duplicate_invites') && !empty($sDbCheck))
		{			
			$aDuplicate = array();
			if (!empty($sDbCheck))
			{
				// get the invites that he is trying to resend
				$aDuplicate = $this->database()->select('email')
					->from($this->_sTable)
					->where('user_id = ' . (int) $iUser . ' AND email IN(' . $sDbCheck . ')')
					->execute('getSlaveRows');
					
				// Check invited users
				$aInvited = $this->database()->select('user_id, email')
					->from(Phpfox::getT('invite'))
					->where('email IN(' . $sDbCheck . ')')
					->execute('getSlaveRows');
				foreach ($aInvited as $aInvite)
				{
					$aDuplicate = array_merge($aDuplicate, $aInvited);
				}
			}	
				
			if (empty($aDuplicate))
			{
				return array($aValid, $aInvalid, $aCacheUsers);
			}

			// go through the elements
			foreach ($aDuplicate as $aDupl)
			{
				// in both arrays
				foreach ($aValid as $iKey => $sIndex)
				{
					// and compare if one of the valid ones has been sent already
					if ($aDupl['email'] == $sIndex)
					{						
						// if it has, add to the invalid
						array_push($aInvalid, $aDupl['email'] . ' - ' . (isset($aDupl['user_id']) && $aDupl['user_id'] != $iUser ? 'Already invited' : Phpfox::getPhrase('invite.you_have_already_invited')));
						// and remove from the valid ones
						unset($aValid[$iKey]);
					}
				}				
			}			
		}			
		
		return array($aValid, $aInvalid, $aCacheUsers);
	}

	/**
	 *	Gets a set of invites to display in the pending invitation section
	 * @param <type> $iUser
	 * @param <type> $iPage
	 * @param <type> $iPageSize
	 * @return <type>
	 */
	public function get($iUser, $iPage, $iPageSize)
	{
		$iCnt = $this->database()->select("COUNT(*)")
			->from($this->_sTable, 'i')
			->where('i.user_id = ' . (int) $iUser)
			->execute('getSlaveField');

		$aInvites = $this->database()->select('*')
			->from($this->_sTable)
			->where('user_id = ' . (int) $iUser)
			->limit($iPage, $iPageSize, $iCnt)
			->execute('getSlaveRows');

		$iTotal = ($iPage > 1 ? (($iPageSize * $iPage) - $iPageSize) : 0);
		foreach ($aInvites as $iKey => $aPost)
		{
			$iTotal++;
			$aInvites[$iKey]['count'] = $iTotal;
		}
		
		return array($iCnt, $aInvites);
	}
	
	public function isValidInvite($sEmail)
	{
		$aInvite = $this->database()->select('invite_id')
			->from($this->_sTable)
			->where('email = \'' . $this->database()->escape($sEmail) . '\'')
			->execute('getSlaveRow');
			
		if (!isset($aInvite['invite_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('invite.unable_to_find_your_invitation'));
		}
		
		$aUser = $this->database()->select('user_id')
			->from(Phpfox::getT('user'))
			->where('email = \'' . $this->database()->escape($sEmail) . '\'')
			->execute('getSlaveRow');
			
		if (isset($aUser['user_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('invite.this_email_is_already_registered_within_our_community'));
		}
		
		return true;
	}
	
	public function isInviteOnly()
	{
		if (Phpfox::getCookie('invite_only_pass') != '')
		{
			return false;
		}
		
		if (Phpfox::getParam('user.invite_only_community'))
		{
			return true;
		}
		
		return false;
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
		if ($sPlugin = Phpfox_Plugin::get('invite.service_invite__call'))
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
