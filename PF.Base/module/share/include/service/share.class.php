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
 * @package  		Module_Share
 * @version 		$Id: share.class.php 5269 2013-01-30 09:00:11Z Raymond_Benc $
 */
class Share_Service_Share extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('share_bookmark');	
	}
	
	public function canSendEmails()
	{
		if (Phpfox::getUserParam('share.emails_per_hour') === 0)
		{
			return true;
		}
		
		$iTotal = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('share_email'))
			->where('user_id = ' . Phpfox::getUserId() . ' AND time_stamp > \'' . (PHPFOX_TIME - 3600) . '\'')
			->execute('getSlaveField');
		
		return ($iTotal > Phpfox::getUserParam('share.emails_per_hour') ? false : true);
	}
	
	public function getForEdit($iId)
	{
		static $aCache = null;
		
		if ($aCache === null)
		{
			$aCache = $this->database()->select('*')
				->from($this->_sTable)
				->where('site_id = ' . (int) $iId)
				->execute('getRow');		
		}
		
		return $aCache;
	}
	
	public function get()
	{
		return $this->database()->select('*')
			->from($this->_sTable)
			->order('ordering ASC')
			->execute('getRows');
	}
	
	public function getType($sType = null)
	{
		if ($sType === null)
		{
			$sType = 'all';
		}
		
		$sCacheId = $this->cache()->set('share_' . $sType);
		
		if (!($aSites = $this->cache()->get($sCacheId)))
		{
			$aSites =$this->database()->select('*')
				->from($this->_sTable)
				->where(($sType != 'all' ? 'type_id = \'' . $this->database()->escape($sType) . '\' AND ' : '') . ' is_active = 1')
				->order('ordering ASC')
				->execute('getRows');		
				
			$this->cache()->save($sCacheId, $aSites);
		}
		
		return $aSites;
	}
	
	public function hasConnection($sType)
	{
		static $aConnections = null;
		
		if ($aConnections === null)
		{
			$aRows = $this->database()->select('*')
				->from(Phpfox::getT('share_connect'))
				->where('user_id = ' . (int) Phpfox::getUserId())
				->execute('getSlaveRows');
			foreach ($aRows as $aRow)
			{
				$aConnections[$aRow['connect_id']] = $aRow;
			}
		}
		
		return (isset($aConnections[$sType]) ? $aConnections[$sType] : false);
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
		if ($sPlugin = Phpfox_Plugin::get('share.service_share__call'))
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