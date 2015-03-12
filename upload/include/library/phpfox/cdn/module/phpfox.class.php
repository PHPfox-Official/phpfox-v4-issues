<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Class to work with phpFox CDN
 *  
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: phpfox.class.php 6995 2013-12-16 18:38:28Z Fern $
 */
class Phpfox_Cdn_Module_Phpfox extends Phpfox_Cdn_Abstract
{	
	private $_iServerId = 0;
	private $_aServers = array();
	
	/**
	 * Loads the amazons3 library developed by another group.
	 *
	 */
	public function __construct()
	{
		if (!file_exists(PHPFOX_DIR_SETTING . 'cdn.sett.php'))
		{
			Phpfox_Error::trigger('CDN setting file is missing.', E_USER_DEPRECATED);
		}
		
		require_once(PHPFOX_DIR_SETTING . 'cdn.sett.php');
		
		foreach ($aServers as $iKey => $aServer)
		{
			$iKey++;
			$iKey++;
			$this->_aServers[$iKey] = $aServer;
		}							
		
		$this->_iServerId = array_rand($this->_aServers);//rand(2, (count($this->_aServers) + 1));        
	}
	
	public function setServerId($iServerId)
	{
		$this->_iServerId = $iServerId;
	}
	
	/**
	 * Uploads the file to amazons server.
	 *
	 * @param string $sFile Full path to where the file is located.
	 * @param string $sName Optional name of the file once it is uploaded. By default we just use the original file name.
	 * @return bool We only return a bool false if we were not able to upload the item.
	 */
	public function put($sFile, $sName = null)
	{
		static $bServerIdIsSet = null;
		
		if (empty($sName))
		{
			$sName = str_replace("\\", '/', str_replace(PHPFOX_DIR, '', $sFile));
		}		
		
		if ($bServerIdIsSet === null)
		{
			// $this->_iServerId = rand(2, (count($this->_aServers) + 1));
			// $bServerIdIsSet = false;
		}
        
		$aPost = array(
			'file_name' => $sName,
			'upload' => '@' . $sFile . '',
			'action' => 'upload',
			'cdn_key' => $this->_aServers[$this->_iServerId]['key']
		);
		
		$mReturn = $this->_send($aPost);
					
		/*
		if (function_exists('json_last_error') && json_last_error() != JSON_ERROR_NONE)
		{
			Phpfox_Error::set('Unable to connect to CDN server.');
			
			return false;
		}
		 * 
		 */
		
		$mReturn = (array) $mReturn;	
		if (Phpfox::getParam('core.keep_files_in_server') == false)
		{
			$oSess = Phpfox::getLib('session');
			$aFiles = $oSess->get('deleteFiles');
			if (is_array($aFiles))
			{
				$aFiles[] = $sFile;
			}
			else
			{
				$aFiles = array($sFile);
			}
			$oSess->set('deleteFiles',$aFiles);
		}
		
		if (isset($mReturn['pass']) && !$mReturn['pass'])
		{
			return false;
		}
		
		return true;		
	}
	
	public function remove($sFile)
	{
		$sName = str_replace("\\", '/', str_replace(PHPFOX_DIR, '', $sFile));

		$aPost = array(
			'file_name' => $sName,
			'action' => 'remove',
			'cdn_key' => $this->_aServers[$this->_iServerId]['key']
		);
		
		$mReturn = $this->_send($aPost, true);
		$mReturn = (array) $mReturn;
		
		if (isset($mReturn['pass']) && !$mReturn['pass'])
		{
			return false;
		}
		
		return true;
	}	
	
	/**
	 * Returns a server ID. We always run "1" (int) if the file was uploaded to the amazon server, if not return "0" (int) so we display the local file instead.
	 *
	 * @return string
	 */
	public function getServerId()
	{
		return $this->_iServerId;		
	}
	
	/**
	 * Get the full URL to the amazon bucket with support to load a CDN CNAME URL.
	 *
	 * @param string $sPath Path to the file we are going to display.
	 * @return string Full path to the file on amazons server.
	 */
	public function getUrl($sPath, $iServerId = null, $bBass = false)
	{		
		$sPath = str_replace(Phpfox::getParam('core.path'), '', $sPath);
		$sPath = str_replace("\\", '/', $sPath);
		
		$aParts = explode('.', $sPath);
		if ($iServerId == null)
        {
            $iServerId = $this->getServerId();
        }
		if (!isset($this->_aServers[$iServerId]))
		{
			return '';
		}
		
		return $this->_aServers[$iServerId]['file'] . ($bBass ? '' : md5($aParts[0]) . '.' . $aParts[1]);
	}
	
	private function _send($aPost, $bIsDelete = false)
	{
		$hCurl = curl_init();

		curl_setopt($hCurl, CURLOPT_URL, rtrim($this->_aServers[$this->_iServerId]['upload'], '/') . '/phpfox-cdn.php');
		curl_setopt($hCurl, CURLOPT_HEADER, false);
		curl_setopt($hCurl, CURLOPT_RETURNTRANSFER, true);			

		curl_setopt($hCurl, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($hCurl, CURLOPT_POST, true);
		
		// https://github.com/sendgrid/sendgrid-php/issues/38
		if(!$bIsDelete && defined('PHP_VERSION_ID') && PHP_VERSION_ID > 50500)
		{
			$sMIME = null;
			$sFileName = substr($aPost['upload'], 1);
			
			if(function_exists('mime_content_type'))
			{
				$sMIME = mime_content_type($sFileName);
			}
			else
			{
				$hFileInfo = finfo_open(FILEINFO_MIME_TYPE);
				$sMIME = finfo_file($hFileInfo, $sFileName);
				finfo_close($hFileInfo);
			}
			$aPost['upload'] = new CurlFile($sFileName, $sMIME, $sFileName);
		}
		
		curl_setopt($hCurl, CURLOPT_POSTFIELDS, $aPost);

		$mReturn = curl_exec($hCurl);
				
		$mReturn = json_decode($mReturn);			
		
		curl_close($hCurl);		
		
		return $mReturn;
	}
}

?>
