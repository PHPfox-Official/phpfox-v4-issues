<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Memcached Cache Layer - This class handles the cache routine for phpFox
 * and can store arrays, strings and objects. All the data is stored in 
 * memcached which has a unique id. Data is also serilazed before its stored.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: memcache.class.php 6363 2013-07-25 09:14:30Z Raymond_Benc $
 */
class Phpfox_Cache_Storage_Memcache extends Phpfox_Cache_Abstract
{
	/**
	 * Array of all the cache files we have saved.
	 *
	 * @var array
	 */	
	private $_aName = array();
	
	/**
	 * Memcached object
	 *
	 * @var object
	 */
	private $_oDb = null;
	
	/**
	 * Array of all the cache data we have saved.
	 *
	 * @var array
	 */	
	private $_aCached = array();
	
	/**
	 * Set this to true and we will force the system to get the information from
	 * a memory based caching system (eg. memcached)
	 *
	 * @var bool
	 */	
	private $_bFromMemory = false;
	
	/**
	 * By default we always close a cache call automatically, however at times
	 * you may need to close it at a later time and setting this to true will
	 * skip closing the closing of the cache reference.
	 *
	 * @var bool
	 */	
	private $_bSkipClose= false;	
	
	/**
	 * We open up a connection to each of the memcached servers.
	 *
	 */
	public function __construct()
	{			
		$this->_oDb = new Memcache;
		$aHosts = Phpfox::getParam('core.memcache_hosts');
		$bPersistent = Phpfox::getParam('core.memcache_persistent');
		foreach ($aHosts as $aHost)
		{
			$this->_oDb->addServer($aHost['host'], $aHost['port'], $bPersistent);
		}
	}
	
	public function memcache()
	{
		return $this->_oDb;
	}
	
	/**
	 * Sets the name of the cache.
	 *
	 * @param string $sName Unique fill name of the cache.
	 * @param string $sGroup Optional param to identify what group the cache file belongs to
	 * @return string Returns the unique ID of the file name
	 */	
	public function set($sName, $sGroup = '')
	{		
		if (is_array($sName))
		{
			if ($sName[0] == 'feeds')
			{
				$sName[0] = $sName[0] . Phpfox::getLib('locale')->getLangId();
			}
			$sName = $sName[0] . $sName[1];	
		}
		
		$sId = md5(time() . rand(100, 10000) . microtime());
		
		$this->_aName[$sId] = $sName;
		
		if ($sGroup == 'memory')
		{
			$this->_bFromMemory = true;	
		}			
		
		return $sId;
	}	
	
	/**
	 * By default we always close a cache call automatically, however at times
	 * you may need to close it at a later time and setting this to true will
	 * skip closing the closing of the cache reference.
	 *
	 * @param bool $bClose True to skip the closing of the connection
	 * @return object Returns the classes object.
	 */	
	public function skipClose($bClose)
	{
		$this->_bSkipClose = $bClose;		
		
		return $this;
	}	
	
	/**
	 * We attempt to get the cache file. Also used within an IF conditional statment
	 * to check if the file has already been cached.
	 *
	 * @see self::set()
	 * @param string $sId Unique ID of the file we need to get. This is what is returned from when you use the set() method.
	 * @param int $iTime By default this is left blank, however you can identify how long a file should be cached before it needs to be updated in minutes.
	 * @return mixed If the file is cached we return the data. If the file is cached but emptry we return a true (bool). if the file has not been cached we return false (bool).
	 */	
	public function get($sId, $iTime = 0)
	{
		// We don't allow caching during an install or upgrade.
		if (defined('PHPFOX_INSTALLER'))
		{
			return false;
		}		
		
		if ($this->_bFromMemory)
		{
			$this->_bFromMemory = false;
			
			return false;
		}		
	
		(PHPFOX_DEBUG ? Phpfox_Debug::start('cache') : false);
		/*
		if (!$this->isCached($sId, $iTime))
		{
			return false;
		}		
		*/
		if (Phpfox::getParam('core.cache_skip'))
		{
			return false;
		}		
		
		if (!($sContent = $this->_oDb->get($this->_getName($this->_aName[$sId]))))
		{			
			return false;
		}
		
		$aContent = unserialize($sContent);
		if (is_array($aContent) && isset($aContent['data']))
		{
			$aContent = $aContent['data'];
			if (isset($aContent['time_stamp']) && (int) $iTime > 0)
			{			
				if ((PHPFOX_TIME - $iTime * 60) > $aContent['time_stamp'])
				{
					$this->remove($this->_aName[$sId]);
					
					return false;
				}
			}
		}		
		
		(PHPFOX_DEBUG ? Phpfox_Debug::end('cache', array('namefile' => $this->_getName($this->_aName[$sId]))) : false);
		
		if (!isset($aContent))
		{
			return false;
		}		
		
		if ($this->_bSkipClose === false)
		{
			$this->_bSkipClose = false;
			$this->close($sId);		
		}

		/* 
			Incase the data is not an array and is empty make sure we return it as 'true' 
			since the data is already cached.		
		*/
		if (!is_array($aContent) && empty($aContent))
		{
			return true;
		}	
		
		if (is_array($aContent) && !count($aContent))
		{
			return true;
		}
				
		return $aContent;		
	}
	
	/**
	 * Save data to the cache.
	 *
	 * @see self::set()
	 * @param string $sId Unique ID connecting to the cache file based by the method set()
	 * @param string $mContent Content you plan on saving to cache. Can be bools, strings, ints, objects, arrays etc...
	 */	
	public function save($sId, $mContent)
	{
		// We don't allow caching during an install or upgrade.
		if (defined('PHPFOX_INSTALLER'))
		{
			return;
		}
		
		if ($this->_bFromMemory)
		{
			$this->_bFromMemory = false;
			$this->close($sId);
			return;
		}			
		
		$mContent = serialize(array('time_stamp' => PHPFOX_TIME, 'data' => $mContent));
		
		// Cache the data only for the first time, Memcache will take over after	
		$this->_aCached[$sId] = $mContent;		
		/*
		if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
		{
			$aCacheData = $this->_oDb->get(md5('grouplysite' . PHPFOX_IS_HOSTED_SCRIPT));
			$this->_oDb->set(md5('grouplysite' . PHPFOX_IS_HOSTED_SCRIPT), array_merge((array) $aCacheData , array($this->_getName($this->_aName[$sId]))));
		}		
		*/
		return $this->_oDb->set($this->_getName($this->_aName[$sId]), $mContent, MEMCACHE_COMPRESSED, 0);
	}
	
	/**
	 * Close the cache connection.
	 *
	 * @param string $sId ID of the cache file we plan on closing the connection with.
	 */	
	public function close($sId)
	{
		unset($this->_aCached[$sId]);
		unset($this->_aName[$sId]);
	}	
	
	/**
	 * Removes cache file(s). 
	 *
	 * @param string $sName Name of the cache file we need to remove.
	 * @param string $sType Pass an optional command to execute a specific routine.
	 * @return bool Returns true if we were able to remove the cache file and false if the system was locked.
	 */	
	public function remove($sName = null, $sType = '')
	{
		if (file_exists(PHPFOX_DIR_CACHE . 'cache.lock'))
		{
			return false;
		}		
		
		if ($sName === null)
		{
			if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
			{		
				$this->_oDb->delete(md5('oncloudsite' . PHPFOX_IS_HOSTED_SCRIPT));
				/*
				$aCacheData = $this->_oDb->get(md5('grouplysite' . PHPFOX_IS_HOSTED_SCRIPT));
				if (is_array($aCacheData))
				{
					foreach ($aCacheData as $sCacheId)
					{
						if (empty($sCacheId))
						{
							continue;
						}

						$this->_oDb->delete($sCacheId);
					}
				}
				*/
			}
			else
			{
				$this->_oDb->flush();
			}
			
			foreach ($this->getAll() as $aFile)
			{
				if (file_exists(PHPFOX_DIR_CACHE . $aFile['name']))
				{
					if (is_dir(PHPFOX_DIR_CACHE . $aFile['name']))
					{
						Phpfox::getLib('file')->delete_directory(PHPFOX_DIR_CACHE . $aFile['name']);
					}
					else 
					{
						unlink(PHPFOX_DIR_CACHE . $aFile['name']);
					
						$this->removeInfo(PHPFOX_DIR_CACHE . $aFile['name']);
					}
				}
			}						
			
			return true;
		}		
		else
		{			
			if (is_array($sName))
			{
				if ($sName[0] == 'feeds')
				{
					$sName[0] = $sName[0] . Phpfox::getLib('locale')->getLangId();
				}
				$sName = $sName[0] . $sName[1];
			}			
			$this->_oDb->delete($this->_getName($sName));
		}
		
		return true;
	}
	
	/**
	 * Checks if a file is cached or not.
	 *
	 * @param string $sId Unique ID of the cache file. 
	 * @param string $iTime By default no timestamp check is done, howver you can pass an int to check how many minutes a file can be cached before it must be recached.
	 * @return bool Returns true if the file is cached and false if the file hasn't been cached already.
	 */	
	public function isCached($sId, $iTime = 0)
	{
		if (Phpfox::getParam('core.cache_skip'))
		{
			return false;
		}		
	
		if (isset($this->_aName[$sId]) && file_exists(PHPFOX_DIR_CACHE . $this->_getName($this->_aName[$sId])))
		{
			if ($iTime && (PHPFOX_TIME - $iTime * 60) > (filemtime(PHPFOX_DIR_CACHE . $this->_getName($this->_aName[$sId]))))
			{
				$this->remove($this->_aName[$sId]);
				return false;
			}			
			
			return true;
		}
		
		return false;
	}		
	
	/**
	 * Gets all the cache files and returns information about the cache file to stats.
	 *
	 * @param array $aConds SQL conditions (not used anymore)
	 * @param string $sSort Sorting the cache files
	 * @param int $iPage Current page we are on
	 * @param string $sLimit Limit of how many files to display
	 * @return array First array is how many cache files there are and the 2nd array holds all the cache files.
	 */	
	public function getCachedFiles($aConds = array(), $sSort, $iPage, $sLimit)
	{
		$aStats = $this->_oDb->getExtendedStats();
		
		$iCnt = 0;
		$aRows = array();
		$iSize = 0;		
		foreach ($aStats as $aStat)
		{
			$iCnt += $aStat['total_items'];
			$iSize += $aStat['bytes'];
		}
		
		$this->_aStats = array(
			'total' => $iCnt,
			'size' => $iSize			
		);
					
		return array($iCnt, $aRows);
	}		
	
	/**
	 * Returns the name of the cache file. Memcached does nothing special here so we just return the file name.
	 *
	 * @param string $sFile File name of the cache
	 * @return string Return the file name. Nothing to do...
	 */	
	private function _getName($sFile)
	{
		if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
		{
			$sFile = md5($this->_getHashId() . $sFile);
		}		
		
		return $sFile;
	}

	private function _getHashId()
	{
		$sName = md5('oncloudsite' . PHPFOX_IS_HOSTED_SCRIPT);
		$sHashKey = $this->_oDb->get($sName);
		if (empty($sHashKey))
		{
			$sHashKey = PHPFOX_IS_HOSTED_SCRIPT . uniqid();
			$this->_oDb->set(md5('oncloudsite' . PHPFOX_IS_HOSTED_SCRIPT), $sHashKey);
		}

		return $sHashKey;
	}
}

?>