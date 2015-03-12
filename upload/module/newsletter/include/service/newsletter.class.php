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
 * @package 		Phpfox_Service
 * @version 		$Id: newsletter.class.php 1496 2010-03-05 17:15:05Z Raymond_Benc $
 */
class Newsletter_Service_Newsletter extends Phpfox_Service
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('newsletter');
	}

	/**
	 * Sanity check, this function checks for users pending their newsletter and newsletters still incomplete (in process)
	 * sets Phpfox_Error
	 */
	public function checkPending()
	{
		$aUsers = $this->database()->select('user_id')
			->from(Phpfox::getT('user_field'))
			->where('newsletter_state != 0')
			->execute('getSlaveRows');
		
		if (!empty($aUsers))
		{
			Phpfox_Error::set(Phpfox::getPhrase('newsletter.there_are_users_still_missing_their_newsletter_total', array('total' => count($aUsers))));
			return Phpfox::getLib('url')->makeUrl('admincp.newsletter.manage', array('task' => 'pending-users'));
		}

		$aNewsletters = $this->database()->select('newsletter_id')
			->from($this->_sTable)
			->where('state = 1')
			->execute('getSlaveRows');
		if (!empty($aNewsletters))
		{
			Phpfox_Error::set(Phpfox::getPhrase('newsletter.there_are_newsletters_in_process_total', array('total' => count($aNewsletters))));
			return Phpfox::getLib('url')->makeUrl('admincp.newsletter.manage', array('task' => 'pending-tasks'));
		}
	}	

	/**
	 *
	 */
	public function get($iId = null)
	{
		if (is_int($iId))
		{
			$this->database()->where('n.newsletter_id = ' . (int)$iId);
		}
		$aNewsletters = $this->database()->select('n.*, nt.*, ' . Phpfox::getUserField())
			->from($this->_sTable, 'n')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = n.user_id')
			->join(Phpfox::getT('newsletter_text'), 'nt', 'nt.newsletter_id = n.newsletter_id')
			->order('time_stamp DESC')
			->execute('getSlaveRows');
		if ($iId !== null && !empty($aNewsletters))
		{
			return reset($aNewsletters);
		}
		return $aNewsletters;
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
		if ($sPlugin = Phpfox_Plugin::get('notification.service_notification__call'))
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