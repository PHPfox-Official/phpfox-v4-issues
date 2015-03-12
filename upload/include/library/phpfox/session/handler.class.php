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
	private $_oObject = null;

	/**
	 * Class constructor which loads the session hanlder we should use.
	 *
	 * @return object
	 */
	public function __construct()
	{
		if (!$this->_oObject)
		{
			$sStorage = 'phpfox.session.handler.default';		
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
			
			$this->_oObject = Phpfox::getLib($sStorage);
		}
		return $this->_oObject;
	}	
	
	/**
	 * Get session object.
	 *
	 * @return Returns the session object we loaded with the class constructor.
	 */
	public function &getInstance()
	{
		return $this->_oObject;
	}	
}

?>
