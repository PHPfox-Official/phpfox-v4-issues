<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * phpFox API
 * Class is used to interact with our API server.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: api.class.php 6599 2013-09-06 08:18:37Z Miguel_Espinoza $
 */
class Phpfox_Api
{	
	/**
	 * Error message.
	 *
	 * @var string
	 */
	private $_sError = '';
	
	/**
	 * Send a request to our API server.
	 *
	 * @param string $sCmd Command.
	 * @param array $aVals POST values.
	 * @return string Returns what our API server has returned for us.
	 */
	public function send($sCmd, $aVals = array())
	{		
		$aVals['domain'] = $this->_getDomain();
		$mReturn = Phpfox::getLib('request')->send(PHPFOX::PHPFOX_API, array('request' => base64_encode(serialize(array_merge(array('cmd' => $sCmd), $aVals)))), 'POST');				

		$mReturn = unserialize($mReturn);	

		$this->_sError = ($mReturn['error'] == 'fatal' ? $mReturn['error_message'] : $mReturn['error']);	
		
		if ($mReturn['error'] === 'fatal')
		{
			Phpfox_Error::set($mReturn['error_message']);
		}
		
		return $mReturn['return'];
	}
	
	/**
	 * Return any errors we may have found.
	 *
	 * @return string
	 */
	public function getError()
	{
		return $this->_sError;
	}
	
	/**
	 * Echo a public message. Used when the site is being upgraded or hasn't been installed.
	 *
	 * @param string $sStr Message to echo.
	 */
	public function message($sStr)
	{		
		if (file_exists(PHPFOX_DIR . 'include' . PHPFOX_DS . 'settings' . PHPFOX_DS . 'server.sett.php'))
		{
			$sMessage = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
			$sMessage .= '<html xmlns="http://www.w3.org/1999/xhtml" lang="en">';
			$sMessage .= '<head><title>Upgrade Taking Place</title><meta http-equiv="Content-Type" content="text/html;charset=utf-8" /><style type="text/css">body{font-family:verdana; color:#000; font-size:9pt; margin:5px; background:#fff;} img{border:0px;}</style></head><body>';
			$sMessage .= file_get_contents(PHPFOX_DIR . 'static' . PHPFOX_DS . 'upgrade.html');
			$sMessage .= '</body></html>';					
				
			echo $sMessage;
				
			exit;
		}
		
		$sMessage = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
		$sMessage .= '<html xmlns="http://www.w3.org/1999/xhtml" lang="en">';
		$sMessage .= '<head><title>Social Networking Community</title><meta http-equiv="Content-Type" content="text/html;charset=utf-8" /><style type="text/css">body{font-family:verdana; color:#000; font-size:11px; margin:5px; background:#fff;} img{border:0px;}</style></head><body>';
		$sMessage .= '</div>';
		$sMessage .= '<div style="padding:4px; font-size:11pt;">' . $sStr . '</div>';
		$sMessage .= '</body></html>';		
		
		echo $sMessage;
		
		exit;
	}
	
	/**
	 * Get the current domain name being used.
	 *
	 * @return string Full path to where phpFox is being installed.
	 */
	private function _getDomain()
	{
    	$sScriptPath = $_SERVER['PHP_SELF'];
        $sSubfolder = (defined('PHPFOX_INSTALLER') ? dirname(substr($sScriptPath, 0, strrpos($sScriptPath, '/'))) : substr($sScriptPath, 0, strrpos($sScriptPath, '/'))) . '/';
        if ($sSubfolder == '//' || $sSubfolder == '\/')
        {
        	$sSubfolder = '/';
		}		
		if (php_sapi_name() == 'litespeed')
		{
			$sSubfolder = str_replace('/admincp','',$sSubfolder);
		}
		return 'http://' . $_SERVER['HTTP_HOST'] . $sSubfolder;		
	}
}

?>