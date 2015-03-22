<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Handle archive with tar.gz file extensions.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: tar.class.php 1666 2010-07-07 08:17:00Z Raymond_Benc $
 */
class Phpfox_Archive_Extension_Tar
{
	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{	
	}
	
	/**
	 * Test if the server has support for working with tar.gz files
	 *
	 * @return bool True if support is there | False if no support for tar.gz files
	 */
	public function test()
	{		
		return (!PHPFOX_SAFE_MODE ? true : false);
	}
	
	/**
	 * Extracts data from the archive
	 *
	 * @param string $sFile Full path to the archive
	 * @param string $sLocation Final location of where to place the extracted content
	 */
	public function extract($sFile, $sLocation)
	{
		shell_exec(Phpfox::getParam('core.tar_path') . ' -xzf ' . escapeshellarg($sFile) . ' -C ' . PHPFOX_DIR_CACHE);
	}
	
	/**
	 * Compress data into the archive
	 *
	 * @param string $sFile File or full path to folder we should compress
	 * @return mixed Return bool false if we where unable to create the archive | Return the Archive name if we were able to create it.
	 */
	public function compress($sFile)
	{
		chdir(PHPFOX_DIR_CACHE);		
		
		if (!file_exists($sFile))
		{
			return false;
		}
		
		$sArchive = substr_replace($sFile, '', -3) . 'tar.gz';
		
		shell_exec(Phpfox::getParam('core.tar_path') . ' -czf ' . escapeshellarg($sArchive) . ' ' . escapeshellarg($sFile));
		
		if (file_exists($sArchive))
		{
			return $sArchive;
		}
		
		return false;
	}	
}

?>