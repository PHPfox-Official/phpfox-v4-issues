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
 * @package  		Module_User
 * @version 		$Id: group.class.php 5612 2013-04-05 07:46:26Z Miguel_Espinoza $
 */
class User_Service_Group_Group extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('user_group');
	}
	
	public function getUserGroupId()
	{
		return (int) Phpfox::getService('user.auth')->getUserBy('user_group_id');
	}
	
	public function get($aConds = array())
	{
		$aCache = array(
			'cache' => true,
			'cache_name' => 'user_group'
		);
		if (empty($aConds))
        {
            $aConds[] = 'user_group.user_group_id > 0';
        }
		$aGroups = $this->database()->select('user_group.*')
			->from($this->_sTable, 'user_group')
			->where($aConds)
			->order('user_group.user_group_id ASC')
			->execute('getRows', ($aConds ? null : $aCache));
		
		
		return $aGroups;
	}
	
	public function getAll()
	{
		if (Phpfox::getParam('user.cache_user_groups'))
		{
			if ( ($aGroups = $this->cache()->get('user_groups')) );
			{
				if (!is_array($aGroups))
				{
					$aGroups = array();
				} 
				return $aGroups;
			}
		}
		
		$aGroups = $this->database()->select('user_group.*')
			->from($this->_sTable, 'user_group')
			->order('user_group.user_group_id ASC')
			->execute('getSlaveRows');
			
		if (Phpfox::getParam('user.cache_user_groups'))
		{
			$this->cache()->save('user_groups', $aGroups);
		}
		
		return $aGroups;
	}
	
	public function getForEdit()
	{
		$aRows = $this->database()->select('user_group.user_group_id, user_group.title, user_group.is_special, COUNT(user_id) AS total_users')
			->from($this->_sTable, 'user_group')
			->leftJoin(Phpfox::getT('user'), 'u', 'u.user_group_id = user_group.user_group_id AND u.profile_page_id = 0')
			->group('user_group.user_group_id, user_group.title, user_group.is_special')
			->order('user_group.user_group_id ASC')
			->execute('getRows');
			
		$aGroups = array();
		foreach ($aRows as $aRow)
		{			
			if ($aRow['is_special'])
			{
				$aGroups['special'][] = $aRow;	
			}
			else 
			{
				$aGroups['custom'][] = $aRow;
			}
		}	
			
		return $aGroups;	
	}

	/**
	 * @todo Cache ME
	 *
	 * @param unknown_type $iId
	 * @return unknown
	 */
	public function getGroup($iId)
	{
		static $aCache = array();
		
		if (!isset($aCache[$iId]))
		{
			$aCache[$iId] = $this->database()->select('user_group.*')
				->from($this->_sTable, 'user_group')
				->where('user_group_id = ' . (int) $iId)
				->execute('getRow');
		}
		
		$sPhraseVar = 'user.' . str_replace(' ', '_', strtolower($aCache[$iId]['title']));
		
		if (Phpfox::getLib('locale')->isPhrase($sPhraseVar))
		{
			$aCache[$iId]['title'] = Phpfox::getPhrase($sPhraseVar);
		}
		return $aCache[$iId];
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
		if ($sPlugin = Phpfox_Plugin::get('user.service_group_group__call'))
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