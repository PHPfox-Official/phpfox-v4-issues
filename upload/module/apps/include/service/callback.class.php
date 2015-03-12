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
class Apps_Service_Callback extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	public function getReportRedirect($iId)
	{
		$aApp = Phpfox::getService('apps')->getAppById($iId);
		if (empty($aApp))
		{
			Phpfox_Error::add(Phpfox::getPhrase('apps.app_not_found'));
		}
		return Phpfox::permalink('apps', $iId, $aApp['app_title']);
	}
	
	public function mobileMenu()
	{
		return array(
			'phrase' => Phpfox::getPhrase('apps.apps'),
			'link' => Phpfox::getLib('url')->makeUrl('apps'),
			'icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'mobile/small_apps.png'))
		);
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
		if ($sPlugin = Phpfox_Plugin::get('apps.service_callback__call'))
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