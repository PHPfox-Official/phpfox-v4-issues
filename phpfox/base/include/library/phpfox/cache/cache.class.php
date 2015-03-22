<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

Phpfox::getLibClass('phpfox.cache.abstract');

/**
 * Class is used to cache any sort of data that is passed via PHP. 
 * Currenlty there is support for file based caching and memcached. 
 * It is perfect to store output from SQL queries that do not need to be executed
 * each time a user visits a specific page.
 * 
 * Example of using the cache system:
 * <code>
 * $oCache = Phpfox::getLib('cache');
 * // Create a name for your cache file
 * $sCacheId = $oCache->set('cache_file_name');
 * // Check if the file is already cached
 * if (!($aData = $oCache->get($sCacheId)))
 * {
 * 		// Run SQL query here...
 * 		$aData = array(1, 2, 3, 4);
 * 		// Store data in the the cache file (eg. strings, arrays, bools, objects etc...)
 * 		$oCache->save($sCacheId, $aData);
 * }
 * print_r($aData); 
 * </code>
 * 
 * If you want to remove a cache file:
 * <code>
 * Phpfox::getLib('cache')->remove('cache_file_name');
 * </code>
 * 
 * If you want to get all the files that have been cached:
 * <code>
 * // Array of files.
 * $aFiles = Phpfox::getLib('cache')->getCachedFiles();
 * </code>
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: cache.class.php 1666 2010-07-07 08:17:00Z Raymond_Benc $
 */
class Phpfox_Cache
{
	/**
	 * Object of the storage class.
	 *
	 * @var object
	 */
	private $_oObject = null;	
	
	/**
	 * Based on what storage system is set within the global settings this is where we load the file.
	 * You can also pass any params to the storge object.
	 *
	 * @param array $aParams Any extra params you may want to pass to the storage object.
	 */
	public function __construct($aParams = array())
	{		
		if (!$this->_oObject)
		{
			$sStorage = (isset($aParams['storage']) ? $aParams['storage'] : Phpfox::getParam('core.cache_storage'));
			
			switch($sStorage)
			{
				case 'memcache':
					$sStorage = 'phpfox.cache.storage.memcache';
					break;
				default:		
					$sStorage = 'phpfox.cache.storage.file';
			}						
			
			$this->_oObject = Phpfox::getLib($sStorage, $aParams);
		}
	}

	/**
	 * Return the object of the storage object.
	 *
	 * @return object Object provided by the storage class we loaded earlier.
	 */	
	public function &getInstance()
	{
		return $this->_oObject;
	}	
}

?>