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
 * @version 		$Id: process.class.php 5612 2013-04-05 07:46:26Z Miguel_Espinoza $
 */
class Profile_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	/*
	public function updateDesign($aVals)
	{
		Phpfox::isUser(true);
		
		if (isset($aVals['order']))
		{
			$this->database()->delete(Phpfox::getT('user_design_order'), 'user_id = ' . Phpfox::getUserId() . ' AND is_hidden = 0');
			foreach ($aVals['order'] as $sCacheId => $aOrder)
			{				
				$aKey = array_keys($aOrder);
				$aValue = array_values($aOrder);				
				$this->database()->insert(Phpfox::getT('user_design_order'), array('user_id' => Phpfox::getUserId(), 'cache_id' => $sCacheId, 'block_id' => $aKey[0], 'ordering' => $aValue[0]));
			}
		}
		
		if (isset($aVals['cache_id']))
		{
			$this->hideBlock($aVals['cache_id'], ($aVals['is_installed'] ? 1 : 0));
		}		
		
		if (isset($aVals['style_id']))
		{
			$this->database()->update(Phpfox::getT('user_field'), array('designer_style_id' => (int) $aVals['style_id']), 'user_id = ' . Phpfox::getUserId());
		}
		
		return true;
	}
	
	public function hideBlock($sBlockId, $iHidden = 1)
	{
		$iHasEntry = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('user_design_order'))
			->where('user_id = ' . Phpfox::getUserId() . ' AND cache_id = \'js_block_border_' . $this->database()->escape($sBlockId) . '\'')
			->execute('getSlaveField');
			
		if ($iHasEntry)
		{
			$this->database()->update(Phpfox::getT('user_design_order'), array('is_hidden' => $iHidden), 'user_id = ' . Phpfox::getUserId() . ' AND cache_id = \'js_block_border_' . $this->database()->escape($sBlockId) . '\'');
		}
		else 
		{
			$this->database()->insert(Phpfox::getT('user_design_order'), array('user_id' => Phpfox::getUserId(), 'cache_id' => 'js_block_border_' . $sBlockId, 'block_id' => null, 'ordering' => 0, 'is_hidden' => $iHidden));
		}
	}
	*/
	
	
	public function clearProfileCache($mUser)
	{
		if (Phpfox::getParam('core.super_cache_system'))
		{
			$this->cache()->remove(array('profile', 'user_id_' . (int)$mUser));
		}
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
		if ($sPlugin = Phpfox_Plugin::get('profile.service_process__call'))
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