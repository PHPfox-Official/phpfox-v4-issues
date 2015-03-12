<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Template for cache storage classes.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: interface.class.php 1666 2010-07-07 08:17:00Z Raymond_Benc $
 */
interface Phpfox_Cache_Interface
{
	/**
	 * Sets the name of the cache.
	 *
	 * @param string $sName Unique fill name of the cache.
	 * @param string $sGroup Optional param to identify what group the cache file belongs to
	 * @return string Returns the unique ID of the file name
	 */	
	public function set($sName, $sGroup = '');
	
	/**
	 * Gets all the cache files and returns information about the cache file to stats.
	 *
	 * @param array $aConds SQL conditions (not used anymore)
	 * @param string $sSort Sorting the cache files
	 * @param int $iPage Current page we are on
	 * @param string $sLimit Limit of how many files to display
	 * @return array First array is how many cache files there are and the 2nd array holds all the cache files.
	 */		
	public function getCachedFiles($aConds = array(), $sSort, $iPage, $sLimit);
}

?>