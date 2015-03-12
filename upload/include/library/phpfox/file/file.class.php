<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Handles anything related to files and/or folders on the server.
 * 
 * Handles:
 * - checking meta data
 * - loading a file that was recently uploaded
 * - upload and move files
 * - get a list of files from a given directory
 * - delete directories
 * - copy files
 * - force a download of a file
 * - check if file/folder is writable
 * - make a new directory
 * - write to a file / create a new file
 * - write to a cache file
 * - get the servers temporary directory
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: file.class.php 6862 2013-11-07 11:00:19Z Miguel_Espinoza $
 */
class Phpfox_File
{
	/**
	 * Holds the final path of a file that was uploaded
	 *
	 * @var string
	 */
	private $_sDestination;
	
	/**
	 * Holds meta information about a file that was uploaded. Information includes $_FORM
	 *
	 * @var array
	 */
	private $_aFile = array();
	
	/**
	 * Holds the file extension of the file that was uploaded.
	 *
	 * @var string
	 */
	private $_sExt;
	
	/**
	 * Holds an ARRAY of all the supported file types identified by the routine
	 *
	 * @var array
	 */
	private $_aSupported = array();
	
	/**
	 * Holds the max size of what is allowed by the routine in bytes. Note that this
	 * is also checked by the system to make sure it can handle such a size.
	 *
	 * @var int
	 */
	private $_iMaxSize = null;
	
	/**
	 * Foruce a special file check on meta data. This feature is not being used
	 * at the moment as it was designed for MP3s
	 *
	 * @var array
	 */
	private $_aFileCheck = array(
		// 'mp3' => 
	);
	
	/**
	 * Class constructor
	 *
	 */
	public function __construct()
	{		
	}
	
	/**
	 * Get meta information about a file using the getID3 library.
	 * Library is located at: include/library/getid3/
	 *
	 * Example:
	 * <code>
	 * $aMeta = Phpfox::getLib('file')->getMeta('/var/www/sample.jpg');	 
	 * </code>
	 * @param string $sFileName Full path to the file we need to check
	 * @return array Returns an ARRAY of meta information about the file
	 */
	public function getMeta($sFileName)
	{
		// Temp. disable error reporting
		Phpfox_Error::skip(true);	
			
		require_once(PHPFOX_DIR_LIB . 'getid3' . PHPFOX_DS . 'getid3' . PHPFOX_DS . 'getid3.php');
			
		$oGetId3 = new getID3;
			
		$aMeta = $oGetId3->analyze($sFileName);				
		
		Phpfox_Error::skip(false);	
		
		return $aMeta;
	}
	
	/**
	 * Loads an uploaded file and performs checks to make sure it was allowed
	 * to be uploaded bassed on the supported file extensions passed by the 2nd
	 * argument. As well as check if the filesize is allowed bassed on the 3rd argument
	 * that is passed plus to also make sure the server can handle uploading such
	 * a size on the file.
	 *
	 * @param string $sFormItem Name of the <input> used when submitting the form.
	 * @param array $aSupported An ARRAY of allowed file extensions
	 * @param int $iMaxSize Max filesize in bytes for the file being uploaded
	 * @return mixed If a file was not allowed to be uploaded we return a FALSE, however if it is allowed we return an ARRAY with meta information about the uploaded file.
	 */
	public function load($sFormItem, $aSupported = array(), $iMaxSize = null)
	{				
		if (is_string($aSupported))
		{
			$aSupported = array($aSupported);			
		}
		
		$aSupported = array_map('strtolower', $aSupported);
		
		if (in_array('jpg', $aSupported))
		{
			array_push($aSupported, 'jpeg');
		}
	
		if (in_array('mpg', $aSupported))
		{
			array_push($aSupported, 'mpeg');
		}		
		
		$this->_aSupported = $aSupported;
		
		$this->_buildFile($sFormItem);
		
		if ($iMaxSize !== null)
		{
			$this->_iMaxSize = $iMaxSize;
		}
		
		if (Phpfox::isUser())
		{
			if (!Phpfox::getService('user.space')->isAllowedToUpload(Phpfox::getUserId(), filesize($this->_aFile['tmp_name'])))
			{
				return false;
			}
		}		
		
		if (count($aSupported) && !in_array(strtolower($this->_aFile['ext']), $aSupported))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('core.not_a_valid_file_extension_we_only_accept_support', array('support' => implode(', ', $aSupported))));
		}		
		
		if (!($bReturn = $this->_verify($this->_aFile['tmp_name'])))
		{
			return $bReturn;
		}
		
		if (Phpfox::getLib('image')->isImageExtension($this->_aFile['ext']) && !Phpfox::getLib('image')->isImage($this->_aFile['tmp_name']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('core.not_a_valid_image_we_only_accept_the_following_file_extensions_support', array('support' => implode(', ', $aSupported))));
		}	
		
		if (!$this->_passLimit())
		{
			return false;
		}		

		return $this->_aFile;
	}	
   
	/**
	 * Method is named "upload", however due to how PHP works the file has already been
	 * uploaded and this simply moves the uploaded file to the final location
	 * since it passed all the tests done by the load() method.
	 *
	 * @param string $sFormItem Name of the <input> used when submitting the form.
	 * @param string $sDestination Full path to where the final location of the file will be
	 * @param string $sFileName File name of the uploaded file once we have moved it to its final destination
	 * @param bool $bModifyFileName By default we modify the actual file name with a unique MD5 hash to make it harder to find, however setting this to FALSE will keep the original name of the file.
	 * @param int $iPerm UNIX file permissions on the file. Default is 0644 (read only).
	 * @param bool $buildDir We place files in folders based on the current month/year by default. Set this to FALSE to not create such directories and place it in the specificed destination folder.
	 * @param bool $bCdn If CDN support is enabled we will copy the file to the CDN server. Set this to FALSE to force the script to not copy the file to CDN even if support is enabled for CDN.
	 * @return mixed Returns a FALSE if we cannot move the file or a STRING on the full path of where the file is located as well as the files new name and extension.
	 */
    public function upload($sFormItem, $sDestination, $sFileName, $bModifyFileName = true, $iPerm = 0644, $buildDir = true, $bCdn = true)
    {
        (($sPlugin = Phpfox_Plugin::get('file_upload_start')) ? eval($sPlugin) : false);
        
		if ($buildDir)
		{
			$this->_buildDir($sDestination);
		}
		else
		{
			$this->_sDestination = $sDestination;
		}
	
        if ($sPlugin = Phpfox_Plugin::get('library_phpfox_file_file_upload_1')){eval($sPlugin);if (isset($mReturnFromPlugin)){return $mReturnFromPlugin;}}
    	if (!defined('PHPFOX_APP_USER_ID') && !is_uploaded_file($this->_aFile['tmp_name']) && !defined('PHPFOX_HTML5_PHOTO_UPLOAD'))
        {
            return Phpfox_Error::set(Phpfox::getPhrase('core.unable_to_upload_the_image'));
        }    	
        
        if ($bModifyFileName === true)
        {
        	$sFileName = md5($sFileName . PHPFOX_TIME . uniqid());
        }        
        
        if (Phpfox::getParam(array('balancer', 'enabled')))
        {
	        if (Phpfox::getLib('image')->isImageExtension($this->_aFile['ext']))
	        {
				list($iWidth, $iHeight) = getimagesize($this->_aFile['tmp_name']);
				$sFileName = $iWidth . '-' . $iHeight . '-' . Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID') . '_' . $sFileName;
			}
			else
			{
				$sFileName = Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID') . '_' . $sFileName;
			}
        }
        
        $sDest = $this->_sDestination . $sFileName . '.' . $this->_sExt;
		
	if ($sPlugin = Phpfox_Plugin::get('library_phpfox_file_file_upload_2')){eval($sPlugin);if (isset($mReturnFromPlugin)){return $mReturnFromPlugin;}}
		if (defined('PHPFOX_APP_USER_ID') || defined('PHPFOX_HTML5_PHOTO_UPLOAD'))
		{
			 @copy($this->_aFile['tmp_name'], $sDest);
			 @unlink($this->_aFile['tmp_name']);
		}
        else if (!@move_uploaded_file($this->_aFile['tmp_name'], $sDest))
        {
            return Phpfox_Error::set(Phpfox::getPhrase('core.unable_to_move_the_file'));
        }    
        if ($sPlugin = Phpfox_Plugin::get('library_phpfox_file_file_upload_3')){eval($sPlugin);if (isset($mReturnFromPlugin)){return $mReturnFromPlugin;}}
        // Windows permission problem???
        if (stristr(PHP_OS, "win"))
        {        
        	@copy($sDest, $sDest . '.cache');
        	@unlink($sDest);
        	@copy($sDest . '.cache', $sDest);
        	@unlink($sDest . '.cache');
        }
        else 
        {        
			@chmod($sDest, $iPerm);
        }

		if (Phpfox::getParam('core.allow_cdn') && $bCdn === true)
		{
			$bReturn = Phpfox::getLib('cdn')->put($sDestination . str_replace('\\', '/', str_replace($sDestination, '', $this->_sDestination) . $sFileName . '.' . $this->_sExt));
			
			if ($bReturn === false)
			{
				return false;
			}
		}		

        return str_replace('\\', '/', str_replace($sDestination, '', $this->_sDestination) . $sFileName . (($bModifyFileName === true || is_array($bModifyFileName)) ? '%s.' : '.') . $this->_sExt);
    }
    
    /**
     * Gets all the files/folders in a specified directory.
     *
     * @param string $sDir Full path to the directory.
     * @return mixed Returns an ARRAY of files if we found any or FALSE if we were not able to open the directory.
     */
	public function getFiles($sDir)
	{		
		$aFiles = array();
        if ($hDir = @opendir($sDir))
        {
			while (false !== ($sFile = readdir($hDir)))
           	{
            	if ($sFile == '.' || $sFile == '..' || $sFile == '.svn' || $sFile == '.svn-ignore' || $sFile == 'index.html')
               	{
					continue;
               	}
               	$aFiles[] = $sFile;
           	}
           	closedir($hDir);
           	return $aFiles;
        }
		return false;		
	}   
	
	/**
	 * Gets all files/folders in a give directory recursively.
	 *
	 * @param string $sDir Full path to the directory
	 * @param bool $bRecurse TRUE if we are in a recursive check or FALSE if we are not.
	 * @return array List of all the files/folders in a folder.
	 */
	public function getAllFiles($sDir, $bRecurse = false)
	{
		static $aFiles = array();
		
		if ($bRecurse === false)
		{
			$aFiles = array();
		}
		
		$hDir = opendir($sDir);
		while ($sFile = readdir($hDir))
		{
			if ($sFile == '.' || $sFile == '..' || $sFile == '.svn')
			{
				continue;
			}
			
			$sNewDir = rtrim($sDir, PHPFOX_DS) . PHPFOX_DS . $sFile;
			
			if (is_dir($sNewDir))
			{
				$this->getAllFiles($sNewDir, true);
			}
			else 
			{
				$aFiles[] = $sNewDir;
			}	
		}
		closedir($hDir);
		
		return $aFiles;	
	}
    
	/**
	 * Gets the filesize of a file and returns the best human readable output.
	 *
	 * @param int $iSize Size of the file
	 * @param int $iPrecision Precision on the output
	 * @return string Returns a human readable output on the file size of a file
	 */
	public static function filesize($iSize, $iPrecision = 2)
	{
	    if (!is_numeric($iSize))
	    {
	        return $iSize;
	    }

	    if (!is_numeric($iPrecision))
	    {
	        $iPrecision = 2;
	    }

	    $sSize   = '';
	    $fSize   = 0;
	    $sSuffix = '';

	    if ($iSize >= 1073741824)
	    {
	        $fSize = $iSize / 1073741824;
	        $sSuffix = 'Gb';
	    }
	    elseif (($iSize >= 1048576) && ($iSize < 1073741824))
	    {
	        $fSize = $iSize / 1048576;
	        $sSuffix = 'Mb';
	    }
	    elseif (($iSize >= 1024) && ($iSize < 1048576))
	    {
	        $fSize = $iSize / 1024;
	        $sSuffix = 'kb';
	    }
    	else
    	{
    	    $fSize = $iSize;
    	    $sSuffix = 'b';
    	}
    	$sSize = round($fSize, $iPrecision);
    	$sSize .= ' '.$sSuffix;
    	
    	return $sSize;
	}
	
	/**
	 * Writes to a cache file. Overwrites old files and if it does not exist
	 * it creates a new one.
	 *
	 * @param string $sFile Fill name of the file to write to.
	 * @param string $sData Data to add into the file.
	 * @return object Returns the classes own object.
	 */
	public function writeToCache($sFile, $sData)
	{		
		if ($hFile = @fopen(PHPFOX_DIR_CACHE . $sFile, 'w+'))
		{			
			fwrite($hFile, $sData);
			fclose($hFile);		
		}
		
		return $this;	
	}
	
	/**
	 * Writes to a file on the server. Always removes files if it exists.
	 *
	 * @see fopen()
	 * @see fwrite()
	 * @param string $sFile Full path to the file
	 * @param string $sData Data to put in the file
	 * @param string $sMode Mode to take when opening the file. Default is "w"
	 * @return bool Returns TRUE if we were able to write to the file and FALSE if not.
	 */
	public function write($sFile, $sData, $sMode = 'w')
	{
		if (file_exists($sFile))
		{
			unlink($sFile);
		}		
		
		if ($hFile = @fopen($sFile, $sMode))
		{
			if (!is_string($sData))
			{
				$sData = (string)$sData;
			}
			fwrite($hFile, trim($sData));
			fclose($hFile);		
			
			return true;
		}		
		
		return false;
	}
	
	/**
	 * Forces a file to be downloaded by the end-user and at the same time
	 * try to hide the location of the file.
	 *
	 * @param string $sFile Full path to a file
	 * @param string $sName Name of the file when the user trys to download it
	 * @param string $sMimeType MIME type of the file in case we can't find it.
	 * @param string $sFileSize File size of the file in case we can't find it.
	 * @param string $iServerId Optional if the site has more then one server you need to specify the original location of the file with the servers ID#
	 */
	public function forceDownload($sFile, $sName, $sMimeType = '', $sFileSize = '', $iServerId = 0) 
	{	    
		// required for IE  
		if(ini_get('zlib.output_compression')) 
		{
			ini_set('zlib.output_compression', 'Off'); 
		}	
		
		if (!$sMimeType)
		{
	     	if (function_exists('mime_content_type'))
	     	{
	     		$sMimeType = mime_content_type($sFile);
	     	}
	     	else 
	     	{	     	
				if (strtolower(PHP_OS) == 'linux')
				{
					$sMimeType = trim(exec('file -bi ' . escapeshellarg($sFile)));
				}
	     		else
	     		{
		     		// get the file mime type using the file extension  
			     	switch(strtolower(substr(strrchr($sFile,'.'), 1)))  
			     	{  
			        	case 'pdf': 
			        		$sMimeType = 'application/pdf'; 
			        		break;  
			        	case 'zip': 
			        		$sMimeType = 'application/zip'; 
			        		break;  
			        	case 'jpeg':  
			        	case 'jpg': 
			        		$sMimeType = 'image/jpg'; 
			        		break;  
			        	default: 
			        		$sMimeType = 'application/force-download';  
			        		// $sMimeType = 'application/octet-stream';
			     	}
	     		}
	     	}
		}		
		
		if (Phpfox::getParam('core.allow_cdn') && $iServerId > 0)
		{
			//$sFile = Phpfox::getLib('cdn')->getUrl(str_replace(PHPFOX_DIR, Phpfox::getParam('core.path'), $sFile), $iServerId);					
			$sFileSize = $sFileSize ? $sFileSize : filesize($sFile);
			$sFile = Phpfox::getLib('cdn')->getUrl(str_replace(PHPFOX_DIR, Phpfox::getParam('core.path'), $sFile), $iServerId); 
		}		

	    // Make sure there's not anything else left
	    ob_clean();
	    /*
	    if ($iServerId && !file_exists($sFile))
	    {
	    	$sServer = Phpfox::getLib('request')->getServerUrl($iServerId);
	    	$sFileServer = $sServer . '/' .str_replace(PHPFOX_DIR, '', $sFile);
	    	$this->copy($sFileServer, $sFile);
	    	
	    }
		*/
	    // Start sending headers
	    header("Pragma: public"); // required
	    header("Expires: 0");
	    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	    header("Cache-Control: private", false); // required for certain browsers
	    header("Content-Transfer-Encoding: binary");
	    header("Content-Type: " . $sMimeType);
	    header("Content-Length: " . ($sFileSize ? $sFileSize : filesize($sFile)));
	    header("Content-Disposition: attachment; filename=\"" . $sName . "\";" );
	    	
	    // Send data
	    readfile($sFile);
	    
	    // If its stored in the cache folder delete it
	    if (preg_match('/cache\/(.*?)\.(.*?)/', $sFile))
	    {
	    	unlink($sFile);
	    }
	    
	    exit;
	}			
	
	/**
	 * Copy a file from one location to another.
	 *
	 * @see copy()
	 * @param string $sSrc Full path to the orginal file
	 * @param string $sDest Full path to where the orignal file will be copied to
	 * @return bool If copy was successful we return TRUE, otherwise we return FALSE
	 */
	public function copy($sSrc, $sDest)
	{
		if (@copy($sSrc, $sDest))
		{
			return true;
		}
		
		return false;
	}
	
	/**
	 * Renames a file
	 *
	 * @see rename()
	 * @param string $sSrc Full path to the orginal file
	 * @param string $sDest Full path to where the new file will be located with its new name
	 * @return bool If rename was successful we return TRUE, otherwise we return FALSE
	 */	
	public function rename($sSrc, $sDest)
	{
		if (@rename($sSrc, $sDest))
		{
			return true;
		}
		
		return false;
	}
	
	/**
	 * Delete a file from the server.
	 *
	 * @see unlink()
	 * @param string $sSrc Full path to the file
	 * @return bool If we were able to delete the file we return TRUE otherwise we return FALSE
	 */
	public function unlink($sSrc)
	{
		if (Phpfox::getParam('core.allow_cdn'))
		{
			try 
		    { 
		        Phpfox::getLib('cdn')->remove($sSrc); 
		    } 
	    	catch(Exception $e){}	    	
		}		
		
		if (@unlink($sSrc))
		{
			return true;
		}
		
		return false;
	}	
	
    /**
     * Checks if path is writable
     *
     * @param string $sPath Path to file or directory
     * @param bool $bForce If set to TRUE we will disable error reporting and force a check on the file/folder
     * @return boolean If file/folder is writable we return TRUE otherwise we return FALSE
     */
    public function isWritable($sPath, $bForce = false)
    {    	
    	clearstatcache();

    	if ($bForce === false)
    	{
	        if (!is_writable($sPath))
	        {
	            if (!stristr(PHP_OS, "win"))
	            {
	                return false;
	            }
	        }
    	}
    	
    	if ($bForce === true)
    	{
    		Phpfox_Error::skip(true);
    	}

        /**
         * Checking if writable on windows OS
         */
        if (stristr(PHP_OS, "win") || $bForce === true)
        {
            /**
             * need to check whether we can really create files in this directory or not
             */
            if (is_dir($sPath))
            {
                /**
                 * Trying to create a new file
                 */
                $fp = @fopen($sPath . PHPFOX_DS . 'win-test.txt', 'w');                
                if (!$fp)
                {
                    if ($bForce === true)
    				{
    					Phpfox_Error::skip(false);	
    				}
                	return false;
                }
                if (!@fwrite($fp, 'test'))
                {
                    if ($bForce === true)
    				{
    					Phpfox_Error::skip(false);	
    				}
                	return false;
                }
                fclose($fp);
                /**
                 * clean up after ourselves
                 */
				if (file_exists($sPath . 'win-test.txt'))
				{
					unlink($sPath . 'win-test.txt');
				}
            } 
            else
            {
                if (!file_exists($sPath))
                {
                    if ($bForce === true)
    				{
    					Phpfox_Error::skip(false);	
    				}                	
                	return false;
                }

                $sContent = @file_get_contents($sPath);
                if (!$fp = @fopen($sPath, 'w'))
                {
                    if ($bForce === true)
    				{
    					Phpfox_Error::skip(false);	
    				}                    
                	return false;
                }
                
                if (!@fwrite($fp, $sContent))
                {
                    if ($bForce === true)
    				{
    					Phpfox_Error::skip(false);	
    				}                	
                	return false;
                }
                
                fclose($fp);
            }
        }
        
        if ($bForce === true)
    	{
    		Phpfox_Error::skip(false);	
		}        
        
        return true;
    }
    
    /**
     * Get the temporary directory of the server based on the servers enviroment variables.
     * Note: Use with caution some servers can be tricky.
     *
     * @return string Returns the best temporary directory we can find.
     */
    public function getTempDir()
    {		
    	if (!empty($_ENV['TMP'])) 
		{
			$sTempDir = $_ENV['TMP'];
		} 
		elseif (!empty($_ENV['TMPDIR'])) 
		{
			$sTempDir = $_ENV['TMPDIR'];
		} 
		elseif (!empty($_ENV['TEMP'])) 
		{
			$sTempDir = $_ENV['TEMP'];
		} 
		else 
		{
			if (function_exists('sys_get_temp_dir'))
			{
				$sTempDir = sys_get_temp_dir();
			}
			else 
			{
	            $sTempFile = tempnam(md5(uniqid(rand(), true)), '');
	            if ($sTempFile)
	            {
	                $sTempDir = realpath(dirname($sTempFile));
	                
	                unlink($sTempFile);                
	            }
	            else
	            {
	                return false;
	            }				
			}
		}    

		return rtrim($sTempDir, PHPFOX_DS) . PHPFOX_DS;	
    }
    
    /**
     * Gets the servers limit on uploading files.
     *
     * @param int $iMaxSize You can define what you want as a limit.
     * @return string Returns the actual limit the server has and if your limit passes the test it will just return your limit.
     */
    public function getLimit($iMaxSize)
    {
    	$iUploadMaxFileSize = (ini_get('upload_max_filesize') * 1048576);
    	$iPostMaxSize = (ini_get('post_max_size') * 1048576);
    	
    	if ( $iUploadMaxFileSize > 0 && $iUploadMaxFileSize < ($iMaxSize * 1048576))
    	{
    		return ini_get('upload_max_filesize');
    	}
    	
    	if ($iPostMaxSize > 0 && $iPostMaxSize < ($iMaxSize * 1048576))
    	{
    		return ini_get('post_max_size');
    	}
    	
    	return $iMaxSize . 'MB';
    }
    
    /**
     * Gets the directory we just built to place an uploaded file.
     *
     * @param string $sDestination Full path to where we should place the uploaded file.
     * @return string Returns the new full path of where the file will be placed.
     */
    public function getBuiltDir($sDestination)
    {
        $this->_buildDir($sDestination);	
    	
    	return $this->_sDestination;	
    }
    
	/**
	 * Deletes a directory and all the files and folders in it (recursive)
	 * 
	 * @param string $sPath Absolute path to the folder
	 */
	public function delete_directory($dir)
	{
        if(is_dir($dir)) 
        {
        	if($dh = opendir($dir)) 
        	{
            	while(($file = readdir($dh)) !== false) 
            	{
                	if($file != '.' && $file != '..') 
                	{
                    	if(is_dir($dir . '/' . $file)) 
                    	{
                        	$this->delete_directory($dir . '/' . $file);
						} 
						else
						{
                        	unlink($dir . '/' . $file);
                         }
                	}
				}
        	}
        	closedir($dh);
        	@rmdir($dir);
        }
	}

	/**
	 * Creates a directory. Unlike mkdir() it can also create recursive directories based
	 * on the full path that is being passed.
	 *
	 * @param string $sDir Full path of the directory to create
	 * @param bool $bRecurse FALSE by default, however if set to TRUE we will create a recursive run on mkdir.
	 */
	public function mkdir($sDir, $bRecurse = false, $mChmod = null)
	{		
		if ($bRecurse === true)
		{			
			$aParts = explode(PHPFOX_DS, trim($sDir, PHPFOX_DS));
			$sParentDirectory = (Phpfox::getLib('server')->isWindows() ? '' : PHPFOX_DS);
			
			foreach ($aParts as $sDir)
			{			
				if (!is_dir($sParentDirectory . $sDir))
				{
					mkdir($sParentDirectory . $sDir);    
					if ($mChmod !== null)
					{
						chmod($sParentDirectory . $sDir, 0777);
					}          
				}		
				
				$sParentDirectory .= $sDir . PHPFOX_DS;
			}			
		}
		else 
		{			
			mkdir($sDir);
			if ($mChmod !== null)
			{
				chmod($sDir, 0777);
			}
		}
	}	
    
	public function getFileDetails()
	{
		return $this->_aFile;
	}
	
	public function getFileExt($sFileName)
	{
		$sFilename = strtolower($sFileName);
		$aExts = preg_split("/[\/\\.]/", $sFileName);
		$iCnt = count($aExts)-1;
		
		return strtolower($aExts[$iCnt]);		
	}
	
	/**
	 * Runs a check to make sure the item being uploaded is allowed to be uploaded
	 * based on the server requirements.
	 *
	 * @return bool Returns TRUE if item is allowed to be uploaded and FALSE if not
	 */
    private function _passLimit()
    {
		
		$aImage = getimagesize($this->_aFile['tmp_name']);
		/*
			0 => width
			1 => height
			2 => IMAGETYPE_XXX
		*/
		if ($aImage[0] < 10 || $aImage[1] < 10)
		{
			//return Phpfox_Error::set('Image dimensions too small');
		}
    	switch ($this->_aFile['error'])
    	{
    		case 1:
    				return Phpfox_Error::set(Phpfox::getPhrase('core.upload_failed_server_cannot_handle_files_larger_then_file_size', array('file_size' => ini_get('upload_max_filesize'))));
    			break;
    		default:
	    			$iSize = filesize($this->_aFile['tmp_name']);
	    			$iPostMaxSize = ((int) ini_get('post_max_size') * 1048576);
	    			
			    	if ($iSize >= $iPostMaxSize)
			    	{
			    		return Phpfox_Error::set(Phpfox::getPhrase('core.upload_failed_server_cannot_handle_files_size_larger_then_file_size', array('size' => $this->filesize($iSize, 0), 'file_size' => $this->filesize($iUploadMaxFileSize))));
			    	}    
			    	
			    	if ($this->_iMaxSize !== null && $iSize >= ($this->_iMaxSize * 1048576))
			    	{
			    		return Phpfox_Error::set(Phpfox::getPhrase('core.upload_failed_your_file_size_is_larger_then_our_limit_file_size', array('size' => $this->filesize($iSize, 0), 'file_size' => $this->filesize(($this->_iMaxSize * 1048576)))));
			    	}
	    			
	    			return true;
    			break;
    	}
    }
	
    /**
     * Builds a directory structure for items being uploaded based on
     * by deafult the month/year we are in. This is a setting in the AdminCP
     * where admins can control how the structure is to be built. Note that if SAFE_MODE
     * is enabled this feature will do nothing as we are not allowed to create folders
     * in such an enviroment.
     *
     * @param string $sDestination Destination of the folder we are to create new folders in.
     * @return mixed Returns TRUE if we were able to create directories and returns NULL if we did nothing
     */
	private function _buildDir($sDestination)
	{
		if (!PHPFOX_SAFE_MODE && Phpfox::getParam('core.build_file_dir') && !defined('PHPFOX_IS_HOSTED_SCRIPT'))
		{
			$aParts = explode('/', Phpfox::getParam('core.build_format'));
			$this->_sDestination = $sDestination;
			foreach ($aParts as $sPart)
			{
				$sDate = date($sPart) . PHPFOX_DS;
				$this->_sDestination .=	$sDate;
				if (!is_dir($this->_sDestination))
				{
					@mkdir($this->_sDestination, 0777);
					@chmod($this->_sDestination, 0777);
				}
			}
			
			// Make sure the directory was actually created, if not we use the default dir we know is working
			if (is_dir($this->_sDestination))
			{
				return true;
			}	
		}
				
		$this->_sDestination = $sDestination;
	}
	
	/**
	 * We find out a files extension based on information passed along with $_FILE
	 *
	 * @see self::_buildFile()
	 */
    private function _getFileType()
    {
    	$sFilename = strtolower($this->_aFile['name']);
		$aExts = preg_split("/[\/\\.]/", $this->_aFile['name']);
		$iCnt = count($aExts)-1;
		$this->_sExt = strtolower($aExts[$iCnt]);
		$this->_aFile['ext'] = strtolower($aExts[$iCnt]);
    }    
    
    /**
     * We build an ARRAY of information about the file based on information passed by $_FORM
     * or $_FORM['FOO'][] with the latter being a multiple uploade routine.
     *
     * @param string $sFormItem The ID to connect with the $_FORM variable
     */
    private function _buildFile($sFormItem)
    { 	
    	if (strpos($sFormItem, ']') === false)
        {
            $this->_aFile = $_FILES[$sFormItem];
        }
        elseif (preg_match('/^(.+)\[(.+)\]$/', $sFormItem, $aM))
        {
        	$this->_aFile['name']     = $_FILES[$aM[1]]['name'][$aM[2]];
            $this->_aFile['type']     = $_FILES[$aM[1]]['type'][$aM[2]];
            $this->_aFile['tmp_name'] = $_FILES[$aM[1]]['tmp_name'][$aM[2]];
            $this->_aFile['error']    = $_FILES[$aM[1]]['error'][$aM[2]];
            $this->_aFile['size']     = $_FILES[$aM[1]]['size'][$aM[2]];
        }
        else
        {
            /**
             * @todo Add error message here...
             */
        }  	
        
		$this->_getFileType();
    }
    
    /**
     * If this feature is enabled we use getID3 to try to find the mime type by
     * trying to extract meta information. Note that since this is based off a 3rd
     * party library this method has been known to have it share of problems. We are not
     * using this by default until it is fully stable.
     *
     * @param string $sFileName Path to the file we are going to check
     * @return bool TRUE if mime type checked out and FALSE if there is no mime type
     */
	private function _verify($sFileName)
	{		
		if (Phpfox::getParam('core.enable_getid3_check'))
		{		
			$aMeta = $this->getMeta($this->_aFile['tmp_name']);
			
			if (!isset($aMeta['mime_type']))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('core.uploaded_file_is_not_valid'));
			}
		}		
		
		return true;
	}
}

?>
