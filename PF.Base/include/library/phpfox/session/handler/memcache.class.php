<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Memcached Session Handler
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: memcache.class.php 1668 2010-07-12 08:54:32Z Raymond_Benc $
 */
class Phpfox_Session_Handler_Memcache
{
	/**
	 * Path to save a session.
	 *
	 * @var string
	 */	
	private $_sSavePath = '';
	
	/**
	 * Session prefix.
	 *
	 * @var string
	 */	
	private $_sPrefix = 'php_sess_';
	
	/**
	 * Memcached object.
	 *
	 * @var object
	 */
	private $_oDb = null;
	
	/**
	 * Start the session.
	 *
	 * @return mixed NULL if no errors, however FALSE if session cannot start.
	 */	
	public function init()
	{		
		session_set_save_handler(
				array($this, 'open'),
				array($this, 'close'),
				array($this, 'read'),
				array($this, 'write'),
				array($this, 'destroy'),
				array($this, 'gc')			
		);		
		
		$this->_oDb = new Memcache;
		$aHosts = Phpfox::getParam('core.memcache_hosts');
		$bPersistent = Phpfox::getParam('core.memcache_persistent');
		foreach ($aHosts as $aHost)
		{
			$this->_oDb->addServer($aHost['host'], $aHost['port'], $bPersistent);
		}	
		
		if(!isset($_SESSION))
		{
			session_start();	
		}
	}
	
	/**
	 * Open a session file.
	 *
	 * @return bool Always TRUE.
	 */	
	public function open()
	{	  
		return true;
	}

	/**
	 * Close a session file.
	 *
	 * @return bool Always TRUE.
	 */	
	public function close()
	{
		return true;
	}
	
	/**
	 * Read a session file.
	 *
	 * @param int $iId File ID.
	 * @return mixed FALSE if not exists, STRING if file exists.
	 */	
	public function read($iId)
	{
		if (!($sContent = $this->_oDb->get($this->_sPrefix . $iId)))
		{
			return false;
		}
		
		return (string) $sContent;
	}
	
	/**
	 * Write to session file.
	 *
	 * @param int $iId Session ID.
	 * @param string $mData Session Data.
	 * @return bool TRUE if success, FALSE on failure.
	 */	
	public function write($iId, $mData)
	{	  	
	  	return $this->_oDb->set($this->_sPrefix . $iId, $mData, MEMCACHE_COMPRESSED, 0);
	}
	
	/**
	 * Remove session file.
	 *
	 * @param int $iId Session ID.
	 * @return bool TRUE on success, FALSE on failure.
	 */	
	public function destroy($iId)
	{
		return $this->_oDb->delete($this->_sPrefix . $iId);
	}
	
	/**
	 * Garbage collecting.
	 *
	 * @param int $iMaxLifetime Define how long a session can exist on the server.
	 * @return bool Always TRUE.
	 */	
	public function gc($iMaxLifetime)
	{		
	  	return true;
	}	
}

?>
