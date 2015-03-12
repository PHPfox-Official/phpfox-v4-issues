<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * File Cache Layer - This class handles the cache routine for phpFox
 * and can store arrays, strings and objects. All the data is stored in a
 * flat file which has a unique id. Data is also serilazed before its stored
 * in the flat file.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: file.class.php 6363 2013-07-25 09:14:30Z Raymond_Benc $
 */
class Phpfox_Cache_Storage_File extends Phpfox_Cache_Abstract
{
	/**
	 * Array of all the cache files we have saved.
	 *
	 * @var array
	 */
	private $_aName = array();	
	
	/**
	 * Name of the current cache file we are saving
	 *
	 * @var string
	 */
	private $_sName;
	
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
	private $_bSkipClose = false;
	
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
			if (PHPFOX_SAFE_MODE || PHPFOX_OPEN_BASE_DIR)
			{
				$sName = str_replace(array('/', PHPFOX_DS), '_', $sName[0]) . '_' . $sName[1];
			}
			else
			{
				if ($sName[0] == 'feeds')
				{
					$sName[0] = $sName[0] . Phpfox::getLib('locale')->getLangId();
				}
				$sNewDirectory = PHPFOX_DIR_CACHE . $sName[0];
				if (!is_dir($sNewDirectory))
				{
					Phpfox::getLib('file')->mkdir($sNewDirectory, true, 0777);				
				}
				$sName = rtrim($sName[0], '/') . PHPFOX_DS . $sName[1];
			}
		}
		
		$sId = $sName;
		
		$this->_aName[$sId] = $sName;
		$this->_sName = $sName;
		
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

		if (!$this->isCached($sId, $iTime))
		{
			return false;
		}
		
		require($this->_getName($this->_aName[$sId]));

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
		if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
		{		
			return;	
		}
		
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

		if ($this->_getParam('free'))
		{
			$sContent = $mContent;
		}
		else 
		{
			$sContent = '<?php defined(\'PHPFOX\') or exit(\'NO DICE!\'); ?>' . "\n";
			$sContent .= '<?php $aContent = ' . var_export($mContent, true) . '; ?>';
		}
		
		if ($rOpen = @fopen($this->_getName($this->_aName[$sId]), 'w+'))
		{			
			fwrite($rOpen, $sContent);
			fclose($rOpen);			
			
			// $this->saveInfo($this->_getName($this->_aName[$sId]), 'file', var_export($mContent, true), filesize($this->_getName($this->_aName[$sId])));			
		}
		else 
		{
			/**
			 * @todo Add error message
			 */
		}
	}

	/**
	 * Close the cache connection.
	 *
	 * @param string $sId ID of the cache file we plan on closing the connection with.
	 */
	public function close($sId)
	{
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
		
		switch($sType)
		{
			case 'substr':
				$sDir = PHPFOX_DIR_CACHE . (is_array($sName) ? rtrim($sName[0], '/') . PHPFOX_DS : '');
				if (!PHPFOX_SAFE_MODE && !PHPFOX_OPEN_BASE_DIR && !is_dir($sDir))
				{
					Phpfox::getLib('file')->mkdir($sDir, true, 0777);
				}
				$aFiles = Phpfox::getLib('file')->getFiles($sDir);
				$iCount = strlen((is_array($sName) ? $sName[1]: $sName));				
				foreach ($aFiles as $sFile)
				{
					if (substr($sFile, 0, $iCount) != (is_array($sName) ? $sName[1]: $sName))
					{
						continue;
					}
					
					if (is_dir($sDir . $sFile))
					{
						Phpfox::getLib('file')->delete_directory($sDir . $sFile);
					}
					else 
					{
						@unlink($sDir . $sFile);
					}
					
					$this->removeInfo($sDir . $sFile);
				}
				break;
			case 'path':
				if (file_exists($sName))
				{					
					@unlink($sName);
					
					$this->removeInfo($sName);
				}				
				break;
			default:
				if (is_array($sName))
				{
					$sName[0] = rtrim($sName[0], '/');
					if ($sName[0] == 'feeds')
					{
						$sName[0] = $sName[0] . Phpfox::getLib('locale')->getLangId();
					}
					$sName = $sName[0] . PHPFOX_DS . $sName[1];
				}				
				$sName = $this->_getName($sName);
				if (file_exists($sName))
				{					
					@unlink($sName);
					
					$this->removeInfo($sName);
				}
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
	
		if (isset($this->_aName[$sId]) && file_exists($this->_getName($this->_aName[$sId])))
		{
			if ($iTime && (PHPFOX_TIME - $iTime * 60) > (filemtime($this->_getName($this->_aName[$sId]))))
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
		$iCnt = 0;
		$aRows = array();
		$iSize = 0;
		$aFiles = Phpfox::getLib('file')->getAllFiles(PHPFOX_DIR_CACHE);
		$iLastFile = 0;
		foreach ($aFiles as $sFile)
		{
			$iSize += filesize($sFile);
			$iCnt++;
			
			if (filemtime($sFile) > $iLastFile)
			{
				$iLastFile = filemtime($sFile);
			}
		}
		
		$this->_aStats = array(
			'total' => $iCnt,
			'size' => $iSize,
			'last' => $iLastFile
		);
					
		return array($iCnt, $aRows);
	}	
	
	/**
	 * Returns the full path to the cache file.
	 *
	 * @param string $sFile File name of the cache
	 * @return string Full path to the cache file.
	 */
	private function _getName($sFile)
	{
		if ($this->_getParam('free'))
		{
			return $sFile;
		}
		elseif ($this->_getParam('path'))
		{
			return $sFile;
		}
		return PHPFOX_DIR_CACHE . (Phpfox::getParam('core.cache_add_salt') ? md5(Phpfox::getParam('core.salt') . $sFile) : $sFile) . Phpfox::getParam('core.cache_suffix');
	}	
}

?>