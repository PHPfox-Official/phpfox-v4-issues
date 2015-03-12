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
 * @version 		$Id: process.class.php 2738 2011-07-15 10:28:44Z Miguel_Espinoza $
 */
class Ban_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('ban');
	}

	/**
	 * This function adds a ban filter, it was not renamed after 2.1 for compatibility
	 * @param array $aVals
	 * @param <type> $aBanFilter
	 * @return true
	 */
	public function add($aVals, &$aBanFilter = null)
	{
		Phpfox::isAdmin(true);
		
		$aForm = array(
			'type_id' => array(
				'type' => 'string:required'
			),
			'find_value' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('ban.filter_value_is_required')
			),
			'reason' => array(
				'type' => 'string'
			),
			'days_banned' => array(
				'type' => 'int'
			),
			'return_user_group' => array(
				'type' => 'int'
			),
			'bShow' => array(
				'type' => 'string'
				), // just to allow the input
			'user_groups_affected' => array(
				'type' => 'array'
			)
		);
		
		if ($aBanFilter !== null && isset($aBanFilter['replace']))
		{
			$aForm['replacement'] = array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('ban.filter_replacement_is_required')
			);
		}
		
		$aVals = $this->validator()->process($aForm, $aVals);
		
		if (!Phpfox_Error::isPassed())
		{			
			return false;
		}
		if ($aVals['find_value'] == Phpfox::getIp())
		{
			return Phpfox_Error::set('You cannot ban yourself.');
		}		
		
		$aVals['user_id'] = Phpfox::getUserId();
		$aVals['time_stamp'] = PHPFOX_TIME;
		$aVals['find_value'] = $this->preParse()->convert($aVals['find_value']);
		if ( (isset($aVals['bShow']) && $aVals['bShow'] == '0') || !isset($aVals['bShow']))
		{
			unset($aVals['reason']);
			unset($aVals['days_banned']);
			unset($aVals['return_user_group']);
		}
		else
		{
			$aVals['reason'] = !Phpfox::getLib('locale')->isPhrase($aVals['reason']) ? Phpfox::getLib('parse.input')->clean($aVals['reason']) : $aVals['reason'];
			$aVals['days_banned'] = (int)$aVals['days_banned'];
			$aVals['return_user_group'] = (int)$aVals['return_user_group'];
			if (!isset($aVals['user_groups_affected']))
			{
				$aVals['user_groups_affected'] = array();
			}
			$aVals['user_groups_affected'] = serialize($aVals['user_groups_affected']);
		}
		unset($aVals['bShow']);
		if (isset($aVals['replacement']))
		{
			$aVals['replacement'] = $this->preParse()->convert($aVals['replacement']);	
		}
		if (empty($aVals['user_groups_affected']))
		{
			$aVals['user_groups_affected'] = '';
		}
		$this->database()->insert($this->_sTable, $aVals);

		$this->cache()->remove('ban', 'substr');
		
		return true;
	}
	
	
	/**
	 * This function places a ban on a user, it is a new functionality introduced in v2.1
	 * It takes into account the number of the days the user will be banned, which user group
	 * will the user return to after the ban expires and provides a reason for it.
	 * This function reuses Phpfox::getService('user.process')->ban() as it already implements safety checks
	 *
	 * @param int $iUser user_id
	 * @param int $iBanId `phpfox_ban`.`ban_id`
	 * @param int $iDays
	 * @param int $iUserGroup User group to return after ban expires
	 * @param string $sReason can be a language phrase or plain text. Stored as mediumtext in DB, parsed if language phrase after
	 * @return boolean
	 */
	public function banUser($iUser, $iDays=0, $iUserGroup=null, $sReason=null, $iBanId = null)
	{
		// sanity checks
		$iUser = (int) $iUser;
		$iDays = (int) $iDays;
		$iUserGroup = (int) $iUserGroup;
		$sReason = Phpfox::getLib('parse.input')->clean($sReason);
		$iBanId = ($iBanId != null) ? (int) $iBanId : null;

		define('PHPFOX_SKIP_BAN_ADMIN_CHECK', true);

		if ($iUser > 0 && $iUserGroup > 0 && ( (is_int($iBanId) && $iBanId > 0) || $iBanId == null))
		{
			if ((Phpfox::getService('user.process')->ban($iUser, true) == true))
			{
				// always add a record
				$this->database()->insert(Phpfox::getT('ban_data'), array(
					'ban_id' => $iBanId,
					'user_id' => $iUser,
					'start_time_stamp' => PHPFOX_TIME,
					'end_time_stamp' => $iDays > 0 ? ($iDays * 86400) + PHPFOX_TIME : 0,
					'return_user_group' => $iUserGroup,
					'reason' => $sReason
				));
			}
			return true;
		}
		return false;
	}

	public function delete($iDeleteid)
	{
		Phpfox::isAdmin(true);
		
		$this->database()->delete($this->_sTable, 'ban_id = ' . (int) $iDeleteid);
		
		$this->cache()->remove('ban', 'substr');
		
		return true;
	}
	
	public function deleteByValue($sType, $sValue)
	{
		Phpfox::isAdmin(true);
		
		$this->database()->delete($this->_sTable, 'type_id = \'' . $this->database()->escape($sType) . '\' AND find_value = \'' . $this->database()->escape($sValue) . '\'');
		
		$this->cache()->remove('ban', 'substr');
		
		return true;		
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
		if ($sPlugin = Phpfox_Plugin::get('ban.service_process__call'))
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