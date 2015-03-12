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
 * @package 		Phpfox_Service
 * @version 		$Id: service.class.php 67 2009-01-20 11:32:45Z Raymond_Benc $
 */
class Poke_Service_Poke extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('poke_data');
	}
	
	/**
	 * This function does the normal permissions checks and also checks the database
	 * if the user has a pending poke it should not allow the current user to send
	 * a new poke
	 */
	public function canSendPoke($iUser)
	{
		/* If user cannot send pokes or can only send pokes to friends but $iUser is not a friend */
		if (!Phpfox::getUserParam('poke.can_poke') || 
			(Phpfox::getUserParam('poke.can_only_poke_friends') && !Phpfox::getService('friend')->isFriend(Phpfox::getUserId(), $iUser))
				)
		{
			return false;
		}

		/*
		if (Phpfox::getParam('core.super_cache_system'))
		{
			$sCacheId = $this->cache()->set(array('pokes', $iUser));
			if ( !($aCache = $this->cache()->get($sCacheId)) )
			{
				$aCache = $this->database()->select('p.*, u.user_name, u.full_name')
					->from($this->_sTable, 'p')
					->join(Phpfox::getT('user'), 'u', 'u.user_id = p.to_user_id')
					->where('p.user_id = ' . (int)$iUser)
					->execute('getSlaveRows');
				$iCnt = count($aCache);
				$aCache = array('cnt' => $iCnt, 'pokes' => $aCache);
				$this->cache()->save($sCacheId, $aCache);
			}
			
			if (!is_array($aCache))
			{
				return false;
			}
			
			if ($aCache['cnt'] < 1)
			{
				return true;
			}
			foreach ($aCache['pokes'] as $aPoke)
			{
				if ($aPoke['user_id'] == Phpfox::getUserId() && $aPoke['status_id'] == 1)
				{
					return true;
				}
			}
			return false;
		}
		*/

		/* if $iUser has a pending poke */
		$iExists = $this->database()->select('poke_id')
				->from($this->_sTable)
				->where('user_id = ' . Phpfox::getUserId() . ' AND to_user_id = ' . (int)$iUser . ' AND status_id = 1')
				->execute('getSlaveField');
		
		return empty($iExists);
	}
	
	
	public function getPokesForUser($iUserId, $bCache = false)
	{
		$bCache = false;
		if ($bCache)
		{
			$sCacheId = $this->cache()->set(array('pokes', $iUserId . (PHPFOX_IS_AJAX ? '_ajax' : '')));
			if (($aCache = $this->cache()->get($sCacheId)))
			{
				$aCache = $this->checkPokes($aCache);
				return array($aCache['cnt'], $aCache['pokes']);
			}
		}
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_sTable, 'p')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = p.user_id AND u.profile_page_id = 0')
			->where('to_user_id = ' . (int)$iUserId . ' AND p.status_id = 1')				
			->group('p.user_id')
			->execute('getSlaveField');		
		
		if (!PHPFOX_IS_AJAX)
		{
			$this->database()->limit(5);
		}
		
		$aPokes = $this->database()->select('p.*, u.user_name, u.user_id, u.full_name')
			->from($this->_sTable, 'p')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = p.user_id AND u.profile_page_id = 0')
			->where('p.to_user_id = ' . (int)$iUserId . ' AND p.status_id = 1')		
			->group('p.user_id')					
			->order('p.poke_id DESC')
			->execute('getSlaveRows');
		
		if ($bCache)
		{
			$this->cache()->save($sCacheId, array('cnt' => $iCnt, 'pokes' => $aPokes));
		}
				
		return array($iCnt, $aPokes);
	}
	
	
	/* Removes duplicates */
	private function checkPokes($aItem)
	{
		$aChecked = array();
		foreach ($aItem['pokes'] as $aPoke)
		{
			$sKey = $aPoke['user_id'] . '-' . $aPoke['to_user_id'];
			if (!isset($aChecked[$sKey]))
			{
				$aChecked[$sKey] = $aPoke;
				continue;
			}
			
			if (isset($aChecked[$sKey]) && $aChecked[$sKey]['poke_id'] < $aPoke['poke_id'])
			{
				$aChecked[$sKey] = $aPoke;
				$aItem['cnt'] = $aItem['cnt'] - 1;
			}
		}
		$aItem['pokes'] = $aChecked;
		return $aItem;
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
		if ($sPlugin = Phpfox_Plugin::get('poke.service_poke__call'))
		{
			eval($sPlugin);
			return;
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
}

?>