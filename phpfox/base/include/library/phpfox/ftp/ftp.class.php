<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Handles FTP (File Transfer Protocol).
 * We mainly use this in the AdminCP to make things easier on Admins to upload new
 * plug-ins or themes without the need to open an FTP client and instead upload a archive
 * and with the access details provided we can use FTP commands to do tasks which normally
 * cant be done via HTTP.
 *
 * Example:
 * <code>
 * // Connect to the FTP server
 * Phpfox::getLib('ftp')->connect('192.168.0.2', 'user', 'pass');
 * 
 * // Upload a file tot he server
 * Phpfox::getLib('ftp')->put('/var/www/sample.jpg', '/home/site/public_html/sample.jpg');
 * </code>
 * 
 * @link http://php.net/manual/en/book.ftp.php
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: $
 */
class Phpfox_Ftp
{
	/**
	 * Holds FTP resource
	 *
	 * @see ftp_connect()
	 * @see self::__construct()
	 * @var resource
	 */
	private $_oFtp = null;
	
	/**
	 * Class constructor. Connects to FTP server.
	 *
	 * @return mixed Returns TRUE on success, FALSE on failure and NULL if we are to skip the login.
	 */
	public function __construct()
	{
		if (defined('PHPFOX_FTP_LOGIN_PASS'))
		{
			return;	
		}
		
		// Connect to FTP host
		if (!($this->_oFtp = ftp_connect(Phpfox::getParam('core.ftp_host'))))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('core.unable_to_connect_to_ftp_host'));
		}
		
		// Get FTP password, hash and password with the hash
		$sPassword = Phpfox::getParam('core.ftp_password');		
		$sHash = substr(base64_decode(base64_decode($sPassword)), -32);
		$sPassword = substr_replace(base64_decode(base64_decode($sPassword)), '', -32);
		
		// Make sure the password has match the server hash
		if (md5(Phpfox::getParam('core.salt')) != $sHash)
		{
			return Phpfox_Error::set(Phpfox::getPhrase('core.ftp_password_hash_does_not_match_with_server_hash'));
		}		
		
		// Login with FTP credentials
		if (!ftp_login($this->_oFtp, Phpfox::getParam('core.ftp_username'), $sPassword))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('core.unable_to_login_to_ftp_server'));
		}		
	}
	
	/**
	 * Performs a connection to a FTP server
	 *
	 * @see ftp_connect()
	 * @see ftp_login()
	 * @param string $sHost Host to connect to
	 * @param string $sUsername User name to use to log into the server
	 * @param string $sPassword Password to use to log into the server
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function connect($sHost, $sUsername, $sPassword)
	{
		Phpfox_Error::skip(true);
		if (!($this->_oFtp = ftp_connect($sHost)))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('core.unable_to_connect_to_ftp_host'));
		}		
		
		if (!ftp_login($this->_oFtp, $sUsername, $sPassword))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('core.unable_to_login_to_ftp_server'));
		}	
		Phpfox_Error::skip(false);	
		
		return true;
	}
	
	/**
	 * Tests the current directory if this is where phpFox is installed.
	 *
	 * @param mixed $sPage NULL is passed by default and we then find the base directory, however if you know where phpFox is installed you can pass the full path here.
	 * @return bool TRUE if we found phpFox, and FALSE if we didn't
	 */
	public function test($sPage = null)
	{
		Phpfox_Error::skip(true);
		$aList = ftp_nlist($this->_oFtp, ($sPage === null ? $this->getPath() : $sPage) . 'include' . PHPFOX_DS . 'library' . PHPFOX_DS . 'phpfox');
		Phpfox_Error::skip(false);
		
		if ((!is_array($aList)) || (is_array($aList) && !count($aList)))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('core.unable_to_connect_to_ftp_base_directory_make_sure_the_setting_for_ftp_directory_path_has_the_correct_path'));
		}
		
		return true;
	}	
	
	/**
	 * Uploads a file from your computer to the server.
	 *
	 * @see ftp_put()
	 * @param string $sOld Full path to the file on your computer
	 * @param string $sNew Full path to where to place the file on the server
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function put($sOld, $sNew)
	{		
		$cType = FTP_ASCII;
		if (preg_match('/^(.*?)\.(gif|jpg|jpeg|png)$/i', $sNew))
		{
			$cType = FTP_BINARY;
		}		
		
		$sNew = ltrim(str_replace(PHPFOX_DIR, Phpfox::getParam('core.ftp_dir_path'), $sNew), '/upload');

		if (!ftp_put($this->_oFtp, $sNew, $sOld, $cType))
		{
			return Phpfox_Error::trigger('Unable to move file ' . str_replace(PHPFOX_DIR, Phpfox::getParam('core.ftp_dir_path'), $sNew) . ' to ' . str_replace(PHPFOX_DIR, Phpfox::getParam('core.ftp_dir_path'), $sOld) . '.', E_USER_ERROR);
		}
		
		if (strtolower(PHP_OS) == 'linux')
		{
			ftp_chmod($this->_oFtp, 0644, $sNew);
		}		
		
		return true;
	}
	
	/**
	 * Moves a file from one location to another on the FTP server.
	 *
	 * @see ftp_rename()
	 * @param string $sOld Full path to the file we are going to move
	 * @param string $sNew Full path to where we are going to place the file
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function move($sOld, $sNew)
	{		
		// Use ftp_rename to move the item
		if (!ftp_rename($this->_oFtp, str_replace(PHPFOX_DIR, Phpfox::getParam('core.ftp_dir_path'), $sOld), str_replace(PHPFOX_DIR, Phpfox::getParam('core.ftp_dir_path'), $sNew)))
		{			
			return Phpfox_Error::trigger('Unable to move file ' . str_replace(PHPFOX_DIR, Phpfox::getParam('core.ftp_dir_path'), $sOld) . ' to ' . str_replace(PHPFOX_DIR, Phpfox::getParam('core.ftp_dir_path'), $sNew) . '.', E_USER_ERROR);
		}
		
		return true;
	}
	
	/**
	 * Changes permission on a file/folder
	 *
	 * @see ftp_chmod()
	 * @param string $sFile Full path to the file we are working with
	 * @param string $iPerm Permission to change the file to
	 */
	public function chmod($sFile, $iPerm)
	{
		ftp_chmod($this->_oFtp, $iPerm, str_replace(PHPFOX_DIR, Phpfox::getParam('core.ftp_dir_path'), $sFile));
	}
	
	/**
	 * Makes a directory on the server. There is also support to make directories recursively.
	 *
	 * @see ftp_mkdir()
	 * @param string $sDir Full path to the directory to create
	 * @param bool $bRecurse TRUE will recursively create directories based on the full path and FALSE will not
	 */
	public function mkdir($sDir, $bRecurse = false)
	{		
		if ($bRecurse === true)
		{			
			$aParts = explode(PHPFOX_DS, trim($sDir, PHPFOX_DS));
			$sParentDirectory = PHPFOX_DS;
			foreach ($aParts as $sDir)
			{
				if (!is_dir($sParentDirectory . $sDir))
				{
					ftp_mkdir($this->_oFtp, str_replace(PHPFOX_DIR, Phpfox::getParam('core.ftp_dir_path'), $sParentDirectory) . $sDir);
                    if (strtolower(PHP_OS) == 'linux')
                    {
                        ftp_chmod($this->_oFtp, 0755, str_replace(PHPFOX_DIR, Phpfox::getParam('core.ftp_dir_path'), $sParentDirectory) . $sDir);
                    }
				}				
				
				$sParentDirectory .= $sDir . PHPFOX_DS;
			}			
		}
		else 
		{			
			$sDir = str_replace(PHPFOX_DIR, Phpfox::getParam('core.ftp_dir_path'), $sDir);
			ftp_mkdir($this->_oFtp, $sDir);
            if (strtolower(PHP_OS) == 'linux')
            {
                ftp_chmod($this->_oFtp, 0755, $sDir);
            }
		}
	}
	
	/**
	 * Deletes a file on the FTP server
	 *
	 * @see ftp_delete()
	 * @param string $sFile Full path of the file to delete.
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function unlink($sFile)
	{
		return ftp_delete($this->_oFtp, str_replace(PHPFOX_DIR, Phpfox::getParam('core.ftp_dir_path'), $sFile));
	}
	
	/**
	 * Removes a directory from the FTP server
	 *
	 * @param string $sPath Full path to the directory we should remove
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function rmdir($sPath)
	{		
		if (!file_exists($sPath))
		{
			return true;
		}
		
		if (is_file($sPath))
		{
			return ftp_delete($this->_oFtp, str_replace(PHPFOX_DIR, Phpfox::getParam('core.ftp_dir_path'), $sPath));
		}
		
		foreach (scandir($sPath) as $sItem)
		{			
			if ($sItem == '.' || $sItem == '..')
			{
				continue;
			}
			
			if (is_dir($sPath . PHPFOX_DS . $sItem))
			{			
				$this->rmdir($sPath . PHPFOX_DS . $sItem);				
			}
			else
			{		
				if (is_dir($sPath . PHPFOX_DS . $sItem))
				{
					ftp_rmdir($this->_oFtp, str_replace(PHPFOX_DIR, Phpfox::getParam('core.ftp_dir_path'), $sPath) . PHPFOX_DS . $sItem);
				}
				else 
				{
					ftp_delete($this->_oFtp, str_replace(PHPFOX_DIR, Phpfox::getParam('core.ftp_dir_path'), $sPath) . PHPFOX_DS . $sItem);
				}
			}
		}
		
		return ftp_rmdir($this->_oFtp, str_replace(PHPFOX_DIR, Phpfox::getParam('core.ftp_dir_path'), $sPath));
	}

	/**
	 * Try to find the full path of where we are currently located based on the relative position
	 * we are allowed to access on the FTP server.
	 *
	 * @return mixed FALSE if we cannot find where we are, STRING if we can; which is the full path to where we are
	 */
	public function getPath()
	{
		Phpfox_Error::skip(true);
		if (ftp_chdir($this->_oFtp, PHPFOX_DIR))
		{
			return '';
		}
		Phpfox_Error::skip(false);
		
		$sCurrentDirectory = ftp_pwd($this->_oFtp);
		
		$aCache = array();
		$aParts = explode(PHPFOX_DS, PHPFOX_DIR);
		foreach ($aParts as $sPart)
		{
			if (empty($sPart))
			{
				continue;
			}
			
			$aCache[$sPart] = true;
		}		
		
		$sBase = '';
		$aList = ftp_nlist($this->_oFtp, '.');
		foreach ($aList as $sList)
		{
			if ($sList == '.' || $sList == '..')
			{
				continue;
			}

            $sList = trim($sList, '.');
            $sList = trim($sList, '/');
            $sList = trim($sList, '\/');
			
			if (isset($aCache[$sList]))
			{
				$sBase = $sList;
				break;
			}
		}		
		
		if (!empty($sBase))
		{
			$aBaseParts = explode($sBase, PHPFOX_DIR);			
			
			return PHPFOX_DS . $sBase . $aBaseParts[1];
		}
		
		return false;
	}
}

?>