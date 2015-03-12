<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Handle archive with zip file extensions.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: zip.class.php 1666 2010-07-07 08:17:00Z Raymond_Benc $
 */
class Phpfox_Archive_Extension_Zip
{
	/**
	 * Object of the PHP class ZipArchive
	 *
	 * @var object
	 */
	private $_oZip = null;
	
	/**
	 * Constructor
	 *
	 */	
	public function __construct()
	{			
		if (class_exists('ZipArchive'))
		{
			$this->_oZip = new ZipArchive;
		}		
	}
	
	/**
	 * Test if the server has support for working with tar.gz files
	 *
	 * @return bool True if support is there | False if no support for tar.gz files
	 */	
	public function test()
	{
		return (((is_object($this->_oZip)) || (!PHPFOX_SAFE_MODE)) ? true : false);
	}
	
	/**
	 * Extracts data from the archive
	 *
	 * @param string $sFile Full path to the archive
	 * @param string $sLocation Final location of where to place the extracted content
	 */	
	public function extract($sFile, $sLocation)
	{		
		if (is_object($this->_oZip))
		{
			if ($this->_oZip->open($sFile))
			{				
				$this->_oZip->extractTo($sLocation);
			    $this->_oZip->close();		
			    
			    return true;		
			}
		}
		else 
		{
			shell_exec(Phpfox::getParam('core.unzip_path') . ' -u ' . escapeshellarg($sFile) . ' -d ' . escapeshellarg($sLocation) . '');		
			
			return true;	
		}
		
		return false;
	}

	/**
	 * Compress data into the archive
	 *
	 * @param string $sFile Name of the ZIP file
	 * @param string $sFolder Name of the folder we are going to compress. Must be located within the "file/cache/" folder.
	 * @return mixed Returns the full path to the newly created ZIP file.
	 */	
	public function compress($sFile, $sFolder)
	{		
		// Create random ZIP
		$sArchive = PHPFOX_DIR_CACHE . md5((is_array($sFile) ? serialize($sFile) : $sFile) . Phpfox::getParam('core.salt') . PHPFOX_TIME) . '.zip';
		
		chdir(PHPFOX_DIR_CACHE . $sFolder . PHPFOX_DS);
		
		if (is_object($this->_oZip))
		{			
			if ($this->_oZip->open($sArchive, ZipArchive::CREATE))
			{
				$aFiles = Phpfox::getLib('file')->getAllFiles(PHPFOX_DIR_CACHE . $sFolder . PHPFOX_DS);							
				
				foreach ($aFiles as $sNewFile)
				{
					$sNewFile = str_replace(PHPFOX_DIR_CACHE . $sFolder . PHPFOX_DS, '', $sNewFile);

					$this->_oZip->addFile($sNewFile);	
				}				
				
	    		$this->_oZip->close();    			    	
			}		
		}
		else 
		{	
			shell_exec(Phpfox::getParam('core.zip_path') . ' -r ' . escapeshellarg($sArchive) . ' ./');			
		}	
		
		chdir(PHPFOX_DIR);
		
		return $sArchive;
	}
}

?>