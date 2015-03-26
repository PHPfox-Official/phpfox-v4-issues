<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Storage Handler Loader
 * Loads storage handler found: include/library/phpfox/session/storage/
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: session.class.php 1668 2010-07-12 08:54:32Z Raymond_Benc $
 *
 * @method get($key)
 * @method set($key, $value)
 * @method remove($key)
 */
class Phpfox_Session
{
	/**
	 * Session object.
	 *
	 * @var object
	 */	
	private static $_oObject = null;

	/**
	 * Class constructor which loads the session handler we should use.
	 *
	 * @return object
	 */	
	public function __construct()
	{
		if (!self::$_oObject)
		{
			$sStorage = 'phpfox.session.storage.session';
			
			self::$_oObject = Phpfox::getLib($sStorage);
		}
		return self::$_oObject;
	}

	public function &getInstance()
	{
		return self::$_oObject;
	}

	public function __call($method, $args) {
		return call_user_func_array([self::$_oObject, $method], $args);
	}
}