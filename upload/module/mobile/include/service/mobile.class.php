<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Service
 * @version 		$Id: mobile.class.php 4031 2012-03-20 15:08:25Z Raymond_Benc $
 */
class Mobile_Service_Mobile extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	public function getMenu()
	{
		$aMenus = array();
		/*
		$aCallback = Phpfox::massCallback('mobileMenu');
		
		foreach ($aCallback as $sModule => $aReturn)
		{
			$aMenus[] = $aReturn;
		}
		 * 
		 */
		$aMenus = Phpfox::getLib('template')->getMenu('mobile');
		foreach ($aMenus as $iKey => $aMenu)
		{
			$aMenus[$iKey]['phrase'] = Phpfox::getPhrase($aMenu['module'] . '.' . $aMenu['var_name']);
			$aMenus[$iKey]['link'] = Phpfox::getLib('url')->makeUrl($aMenu['url']);
			$aMenus[$iKey]['icon'] = Phpfox::getLib('template')->getStyle('image', 'mobile/' . $aMenu['mobile_icon']);
		}		
		
		return $aMenus;
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
		if ($sPlugin = Phpfox_Plugin::get('mobile.service_mobile__call'))
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