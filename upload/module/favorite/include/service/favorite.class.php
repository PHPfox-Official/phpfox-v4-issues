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
 * @version 		$Id: favorite.class.php 1495 2010-03-05 15:45:57Z Raymond_Benc $
 */
class Favorite_Service_Favorite extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('favorite');
	}
	
	public function get($iUserId)
	{
		$aFavorites = $this->database()->select('f.*')
			->from($this->_sTable, 'f')
			->where('f.user_id = ' . (int) $iUserId)
			->order('f.time_stamp DESC')
			->execute('getSlaveRows');
			
		if (!count($aFavorites))
		{
			return array(0, array());
		}
			
		$aGroups = array();
		$aCache = array();
		$aCacheFavorite = array();
		$iOwnerUserId = 0;
		foreach ($aFavorites as $aFavorite)
		{
			$aGroups[$aFavorite['type_id']][] = $aFavorite['item_id'];
			$aCacheFavorite[$aFavorite['type_id']][] = $aFavorite['favorite_id'];
			$iOwnerUserId = $aFavorite['user_id'];
		}
		unset($aFavorites, $aFavorite);		
		
		foreach ($aGroups as $sType => $aFavorites)
		{
			$sModule = $sType;
			if (strpos($sModule, '_'))
			{
				$aParts = explode('_', $sModule);
				$sModule = $aParts[0];
			}
			
			if (!Phpfox::isModule($sModule))
			{
				continue;
			}
			
			$aCallback = Phpfox::callback($sType . '.getFavorite', $aFavorites, $iUserId);
			
			foreach ($aCacheFavorite[$sType] as $iKey => $iCacheFavId)
			{
				if (isset($aCallback['items'][$iKey]))
				{
				    $aCallback['items'][$iKey]['favorite_id'] = $iCacheFavId;
				}
			}			
			
			foreach ($aCallback as $sKey => $aCallbackItem)
			{				
				if ($sKey != 'items')
				{
			 		continue;
				}
				
				foreach ($aCallbackItem as $iItemKey => $aSub)
				{
				    
				    $aCallback['items'][$iItemKey]['time_stamp_phrase'] = Phpfox::getTime(Phpfox::getParam('core.global_update_time'), $aSub['time_stamp']);
				    
				}
			}
						
			$aCache[] = $aCallback;
		}		
		
		return array($iOwnerUserId, $aCache);
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
		if ($sPlugin = Phpfox_Plugin::get('favorite.service_favorite__call'))
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