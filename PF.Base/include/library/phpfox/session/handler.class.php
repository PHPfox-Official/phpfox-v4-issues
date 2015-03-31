<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Session Handler Loader
 * Loads session handlers: include/library/phpfox/session/handler/
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: handler.class.php 5557 2013-03-26 10:48:01Z Raymond_Benc $
 */
class Phpfox_Session_Handler
{
	/**
	 * Session object.
	 *
	 * @var object
	 */
	private static $_oObject = null;

	/**
	 * Class constructor which loads the session hanlder we should use.
	 *
	 * @return object
	 */
	public function __construct()
	{
		if (!self::$_oObject)
		{
			$sStorage = 'phpfox.session.handler.default';
			/*
			if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
			{
				$sStorage = 'phpfox.session.handler.memcache';
			}
			else
			{
				if (defined('PHPFOX_IS_AJAX') && PHPFOX_IS_AJAX)
				{
					$sStorage = 'phpfox.session.handler.file';			
				}
				else
				{
					if (Phpfox::getParam(array('balancer', 'enabled')))
					{
						$sStorage = 'phpfox.session.handler.memcache';
					}
				}
			}
			*/
			
			self::$_oObject = Phpfox::getLib($sStorage);
		}
		// return self::$_oObject;
	}	
	
	/**
	 * Get session object.
	 *
	 * @return Phpfox_Session_Handler_Default
	 */
	public function &getInstance()
	{
		return self::$_oObject;
	}

	/**
	 * @return Phpfox_Session_Handler_Default
	 */
	public static function instance() {
		if (!self::$_oObject) {
			new self();
		}

		return self::$_oObject;
	}

	public function __call($method, $args) {
		return call_user_func_array([self::$_oObject, $method], $args);
	}
}
