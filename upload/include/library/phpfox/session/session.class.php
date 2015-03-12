<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Storage Hanlder Loader
 * Loads storage hanlders found: include/library/phpfox/session/storage/
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: session.class.php 1668 2010-07-12 08:54:32Z Raymond_Benc $
 */
class Phpfox_Session
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
			$sStorage = 'phpfox.session.storage.session';
			
			/**
			 * Using Cookie handler here because of problems with session_set_save_handler()
			 * when using option 3 (sub-domains)
			 * 
			 * @link http://se2.php.net/manual/en/function.session-set-save-handler.php
			 * @todo Find a work around for this problem
			 */
			if (Phpfox::getParam('core.url_rewrite') == 3)
			{
				$sStorage = 'phpfox.session.storage.cookie';
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