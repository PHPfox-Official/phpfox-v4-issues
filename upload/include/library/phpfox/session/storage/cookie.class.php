<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Cookie Storage
 * Store information about the user using $_COOKIE.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: cookie.class.php 1668 2010-07-12 08:54:32Z Raymond_Benc $
 */
class Phpfox_Session_Storage_Cookie
{
	/**
	 * Prefix of the session name.
	 *
	 * @var unknown_type
	 */
	private $_sPrefix = 'phpfox';
	
	/**
	 * Class constructor. Gets the new prefix from the global settings.
	 *
	 */
	public function __construct()
	{
		$this->_sPrefix = Phpfox::getParam('core.session_prefix');
	}

	/**
	 * Sets a session.
	 *
	 * @see Phpfox::setCookie()
	 * @param string $sName Name of the session.
	 * @param string $sValue Value of the session.
	 */
	public function set($sName, $sValue)
	{
		Phpfox::setCookie($sName, $sValue);
	}
	
	/**
	 * Gets a session.
	 *
	 * @param string $sName Name of the session.
	 * @return mixed Session exists we return its value, otherwise we return FALSE.
	 */
	public function get($sName)
	{
		$mCookie = Phpfox::getCookie($sName);
		
		return (empty($mCookie) ? false : $mCookie);
	}
	
	/**
	 * Removes a session.
	 *
	 * @param mixed $mName STRING name of session, ARRAY of sessions.
	 */
	public function remove($mName)
	{
		if (!is_array($mName))
		{
			$mName = array($mName);
		}
		
		foreach ($mName as $sName)
		{
			Phpfox::setCookie($sName, '', -1);
		}
	}
	
	/**
	 * Set an ARRAY session.
	 *
	 * @param string $sName Name of session.
	 * @param string $sValue Group of session.
	 * @param string $sActualValue Value of the session.
	 */
	public function setArray($sName, $sValue, $sActualValue)
	{		
		$this->set($sName . $sValue, $sActualValue);
	}
	
	/**
	 * Get a session ARRAY.
	 *
	 * @param string $sName Name of the session.
	 * @param string $sValue Name of the group session.
	 * @return mixed Session exists we return its value, otherwise we return FALSE.
	 */
	public function getArray($sName, $sValue)
	{		
		$mCookie = Phpfox::getCookie($sName . $sValue);					
		
		if (!empty($mCookie))
		{
			return $mCookie;
		}		
		
		return false;		
	}		
}

?>