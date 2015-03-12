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
 * @version 		$Id: janrain.class.php 6053 2013-06-11 14:09:37Z Raymond_Benc $
 */
class Janrain_Service_Janrain extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	public function getName()
	{
		$sDomain = Phpfox::getParam('janrain.janrain_application_domain');
		if (preg_match('/^https:\/\/(.*)\.rpxnow\.com\/$/i', $sDomain, $aMatches))
		{
			$sDomain = $aMatches[1];
		}
		
		return $sDomain;
	}
	
	public function getUrl()
	{
		return '#';

		$sDomain = Phpfox::getParam('janrain.janrain_application_domain');
		
		return rtrim($sDomain, '/') . '/openid/v2/signin?token_url=' . urlencode(Phpfox::getLib('url')->makeUrl('janrain.rpx'));
	}
	
	public function getUser($aUserInfo)
	{
		$sIdentifier = md5($aUserInfo['identifier']);
		
		$aRow = $this->database()->select('u.*')	
			->from(Phpfox::getT('janrain'), 'j')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = j.user_id')
			->where('j.identifier = \'' . $this->database()->escape($sIdentifier) . '\'')
			->execute('getSlaveRow');
			
		if (!isset($aRow['user_id']))
		{
			if (!empty($aUserInfo['email']))
			{
				$aRow = $this->database()->select('u.*')	
					->from(Phpfox::getT('user'), 'u')
					->where('u.email = \'' . $aUserInfo['email'] . '\'')
					->execute('getSlaveRow');			
					
				if (isset($aRow['user_id']))
				{
					return $aRow;
				}
			}
			
			return false;
		}
		
		return $aRow;
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
		if ($sPlugin = Phpfox_Plugin::get('janrain.service_janrain__call'))
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