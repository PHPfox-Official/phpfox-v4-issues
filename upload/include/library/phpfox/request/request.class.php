<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Creates a special request method which is used in the script
 * instead of calling the default $_REQUEST methods. All requests are
 * parsed and trimmed.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: request.class.php 7230 2014-03-26 21:14:12Z Fern $
 */
class Phpfox_Request
{	
	/**
	 * Variable is deprecated.
	 * 
	 * @deprecated 2.0.6
	 * @var array
	 */
	private $_aMethod = array();
	
	/**
	 * List of all the requests ($_GET, $_POST, $_FILES etc...)
	 *
	 * @var array
	 */
	private $_aArgs = array();
	
	/**
	 * List of requests being checked.
	 *
	 * @var array
	 */
	private $_aName = array();
	
	/**
	 * Last name being checked.
	 *
	 * @var string
	 */
	private $_sName;
	
	/**
	 * Check to see if we are using a mobile device.
	 *
	 * @var bool
	 */
	private $_bIsMobile = false;
	
	/**
	 * List of browsers.
	 *
	 * @var array
	 */
	private static $_aBrowser = array();
	
	private $_xIp6 = "/^\s*((([0-9A-Fa-f]{1,4}:){7}(([0-9A-Fa-f]{1,4})|:))|(([0-9A-Fa-f]{1,4}:){6}(:|((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})|(:[0-9A-Fa-f]{1,4})))|(([0-9A-Fa-f]{1,4}:){5}((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})?)|((:[0-9A-Fa-f]{1,4}){1,2})))|(([0-9A-Fa-f]{1,4}:){4}(:[0-9A-Fa-f]{1,4}){0,1}((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})?)|((:[0-9A-Fa-f]{1,4}){1,2})))|(([0-9A-Fa-f]{1,4}:){3}(:[0-9A-Fa-f]{1,4}){0,2}((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})?)|((:[0-9A-Fa-f]{1,4}){1,2})))|(([0-9A-Fa-f]{1,4}:){2}(:[0-9A-Fa-f]{1,4}){0,3}((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})?)|((:[0-9A-Fa-f]{1,4}){1,2})))|(([0-9A-Fa-f]{1,4}:)(:[0-9A-Fa-f]{1,4}){0,4}((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})?)|((:[0-9A-Fa-f]{1,4}){1,2})))|(:(:[0-9A-Fa-f]{1,4}){0,5}((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})?)|((:[0-9A-Fa-f]{1,4}){1,2})))|(((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})))(%.+)?\s*$/";
	
	/**
	 * Class Constructor used to build the variable $this->_aArgs.
	 * 
	 */
	public function __construct()
	{
		$this->_aArgs = $this->_trimData(array_merge($_GET, $_POST, $_FILES, Phpfox::getLib('url')->getParams()));				
	}
	
	/**
	 * Checks to see if a request exists.
	 *
	 * @param string $sName Name of the request.
	 * @return object Returns self object.
	 */
	public function is($sName)
	{
		if (isset($this->_aArgs[$sName]))
		{
			$this->_aName[$sName] = true;
			$this->_sName = $sName;
		}
		return $this;
	}

    /** 
     * Retrieve parameter value from request.
     * 
     * @param string $sName name of argument
     * @param string $sCommand is any extra commands we need to execute
     * @return string parameter value
     */
    public function get($sName = '', $mDef = '')
    {
    	if ($this->_sName)
    	{
    		$sName = $this->_sName;
    	}
    	
    	(($sPlugin = Phpfox_Plugin::get('request_get')) ? eval($sPlugin) : false);
    	
    	return (isset($this->_aArgs[$sName]) ? ((empty($this->_aArgs[$sName]) && isset($this->_aName[$sName])) ? true : $this->_aArgs[$sName]) : $mDef);
    }
    
    /**
     * Set a request manually.
     *
     * @param mixed $mName ARRAY include a name and value, STRING just the request name.
     * @param string $sValue If the 1st argument is a string this must be the request value.
     */
    public function set($mName, $sValue = null)
    {
    	if (!is_array($mName) && $sValue !== null)
    	{
    		$mName = array($mName => $sValue);
    	}
    	
    	foreach ($mName as $sKey => $sValue)
    	{
    		$this->_aArgs[$sKey] = $sValue;
    	}
    }
    
    /**
     * Get a request and convert it into an INT.
     *
     * @param string $sName Name of the request.
     * @param string $mDef Default value in case the request does not exist.
     * @return int INT value of the request.
     */
    public function getInt($sName, $mDef = '')
    {
		return (int)$this->get($sName, $mDef);
    }    
    
    /**
     * Get a request and make sure it is an ARRAY.
     *
     * @param string $sName Name of the request.
     * @param array $mDef ARRAY of default values in case the request does not exist.
     * @return array Returns an ARRAY value.
     */
    public function getArray($sName, $mDef = array())
    {		
    	return (array)(isset($this->_aArgs[$sName]) ? $this->_aArgs[$sName] : $mDef);
    }       
    
    /**
     * Get all the requests.
     *
     * @return array
     */
    public function getRequests()
    {
    	return (array)$this->_aArgs;
    }
    
    /**
     * Get specific server value. ($_SERVER)·
     *
     * @param string $sVar Param name.
     * @return string $_SERVER value.
     */
    public function getServer($sVar)
    {
    	switch($sVar)
    	{
    		case 'SERVER_NAME':
    			$sVar = (isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? 'HTTP_X_FORWARDED_HOST' : $sVar);
    			break;
    		case 'HTTP_HOST':
    			$sVar = (isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? 'HTTP_X_FORWARDED_HOST' : $sVar);
    			break;
    		case 'REMOTE_ADDR':
    			return $this->getIp();
    			break;
    		case 'PHPFOX_SERVER_ID':
    			if (!Phpfox::getParam(array('balancer', 'enabled')))
    			{
					if (Phpfox::getParam('core.allow_cdn'))
					{
						return Phpfox::getLib('cdn')->getServerId();
					}
    				
    				return 0;
    			}
    			$aServers = Phpfox::getParam(array('balancer', 'servers'));
    			$iServerIp = $this->getServer('SERVER_ADDR');
    			if (isset($aServers[$iServerIp]['id']))
    			{
    				return $aServers[$iServerIp]['id'];
    			}
    			return 0;
    			break;
    	}
    	return (isset($_SERVER[$sVar]) ? $_SERVER[$sVar] : '');
    }
    
	public function isIOS()
	{
		$sAgent = strtolower($this->getBrowser());		
		$bIsIphone = stripos($sAgent, 'iphone') !== false;
		$bIsIpad = stripos($sAgent, 'ipad') !== false || (stripos($sAgent, 'safari') !== false && stripos($sAgent, 'mobile') !== false);
		$bIsIpod = stripos($sAgent, 'ipod') !== false;
		
		return (($bIsIphone || $bIsIpad || $bIsIpod));
	}
	
    /**
     * Get the name of the browser being used.
     *
     * @return string
     */
    public function getBrowser()
    {
    	static $sAgent;
    	
    	if ($sAgent)
    	{
    		return $sAgent;
    	}
    	
    	$sAgent = $this->getServer('HTTP_USER_AGENT');   	
		
    	if (preg_match("/Firefox\/(.*)/i", $sAgent, $aMatches) && isset($aMatches[1]))
    	{
    		$sAgent = 'Firefox ' . $aMatches[1];
    	}
    	elseif (preg_match("/MSIE (.*);/i", $sAgent, $aMatches))
    	{
			if(preg_match("/Phone\s?O?S?\s?(.*)/i", $aMatches[1]))
			{
				$this->_bIsMobile = true;
    			$aParts = explode(' ', trim($aMatches[1]));
    			$sAgent = 'MSIE Windows Phone ' . $aParts[0];
			}
			else
			{
				$aParts = explode(';', $aMatches[1]);
				$sAgent = 'IE ' . $aParts[0];
				self::$_aBrowser['ie'][substr($aParts[0], 0, 1)] = true;
			}
    	}
    	elseif (preg_match("/Opera\/(.*)/i", $sAgent, $aMatches))
    	{
			if(preg_match("/mini/i", $aMatches[1]))
			{
				$this->_bIsMobile = true;
    			$aParts = explode(' ', trim($aMatches[1]));
    			$sAgent = 'Opera Mini ' . $aParts[0];
			}
			else
			{
				$aParts = explode(' ', trim($aMatches[1]));
				$sAgent = 'Opera ' . $aParts[0];
			}
    	}
    	elseif (preg_match('/\s+?chrome\/([0-9.]{1,10})/i', $sAgent, $aMatches))
    	{
    		if (preg_match('/android/i', $sAgent))
    		{
    			$this->_bIsMobile = true;
    			$sAgent = 'Android';
    		}
    		else
    		{
	    		$aParts = explode(' ', trim($aMatches[1]));
	    		$sAgent = 'Chrome ' . $aParts[0];
    		}
    	}
    	elseif (preg_match('/android/i', $sAgent))
    	{
			$this->_bIsMobile = true;
			$sAgent = 'Android';			
    	}    
    	elseif (preg_match('/opera mini/i', $sAgent))
    	{
			$this->_bIsMobile = true;
			$sAgent = 'Opera Mini';			
    	}   
    	elseif (preg_match('/(pre\/|palm os|palm|hiptop|avantgo|fennec|plucker|xiino|blazer|elaine)/i', $sAgent))
    	{
			$this->_bIsMobile = true;
    		$sAgent = 'Palm';			
    	}      	
    	elseif (preg_match('/blackberry/i', $sAgent))
    	{
			$this->_bIsMobile = true;
			$sAgent = 'Blackberry';
    	}     	
    	elseif (preg_match('/(iris|3g_t|windows ce|opera mobi|windows ce; smartphone;|windows ce; iemobile|windows phone)/i', $sAgent))
    	{
			$this->_bIsMobile = true;
			$sAgent = 'Windows Smartphone';
    	}    	
		elseif (preg_match("/Version\/(.*) Safari\/(.*)/i", $sAgent, $aMatches) && isset($aMatches[1]))
    	{
    		if (preg_match("/iPhone/i", $sAgent) || preg_match("/ipod/i", $sAgent))
    		{
    			$aParts = explode(' ', trim($aMatches[1]));
    			$sAgent = 'Safari iPhone ' . $aParts[0];	
    			$this->_bIsMobile = true;
    		}
    		else 
    		{
    			$sAgent = 'Safari ' . $aMatches[1];
    		}
    	}
    	elseif (preg_match('/(mini 9.5|vx1000|lge |m800|e860|u940|ux840|compal|wireless| mobi|ahong|lg380|lgku|lgu900|lg210|lg47|lg920|lg840|lg370|sam-r|mg50|s55|g83|t66|vx400|mk99|d615|d763|el370|sl900|mp500|samu3|samu4|vx10|xda_|samu5|samu6|samu7|samu9|a615|b832|m881|s920|n210|s700|c-810|_h797|mob-x|sk16d|848b|mowser|s580|r800|471x|v120|rim8|c500foma:|160x|x160|480x|x640|t503|w839|i250|sprint|w398samr810|m5252|c7100|mt126|x225|s5330|s820|htil-g1|fly v71|s302|-x113|novarra|k610i|-three|8325rc|8352rc|sanyo|vx54|c888|nx250|n120|mtk |c5588|s710|t880|c5005|i;458x|p404i|s210|c5100|teleca|s940|c500|s590|foma|samsu|vx8|vx9|a1000|_mms|myx|a700|gu1100|bc831|e300|ems100|me701|me702m-three|sd588|s800|8325rc|ac831|mw200|brew |d88|htc\/|htc_touch|355x|m50|km100|d736|p-9521|telco|sl74|ktouch|m4u\/|me702|8325rc|kddi|phone|lg |sonyericsson|samsung|240x|x320vx10|nokia|sony cmd|motorola|up.browser|up.link|mmp|symbian|smartphone|midp|wap|vodafone|o2|pocket|kindle|mobile|psp|treo)/i', $sAgent))
    	{
    		$this->_bIsMobile = true;
    	}
    	
    	return $sAgent;
    }
    
    /**
     * Check to see if we are using a mobile device.
     *
     * @return bool TRUE yes, FALSE no.
     */
    public function isMobile($bRedirect = true)
    {    	
    	static $bFirstCheck = false;

		if (defined('PHPFOX_NO_MOBILE_CHECK'))
		{
			return false;
		}

    	if (!Phpfox::isModule('mobile'))
    	{
    		return false;
    	}
    	
    	if ($bFirstCheck === false && !Phpfox::getLib('url')->isMobile() && !Phpfox::getLib('session')->get('mobilestatus'))
    	{
    		$bFirstCheck = true;
    		
    		$this->getBrowser();
    		
    		if ($this->_bIsMobile === true && !PHPFOX_IS_AJAX)
    		{
    			if ($this->get('req1') == 'apps' && $this->get('req2') == 'install')
    			{
    				Phpfox::getLib('url')->send('mobile.apps.install.' . $this->get('req3'));
    			}
    			elseif ($this->get('req1') == 'user' && $this->get('req2') == 'verify' && $this->get('link'))
    			{
    				Phpfox::getLib('url')->send('mobile.user.verify', array('link' => $this->get('link')));
    			}
    			
    			$sSendWhere = 'mobile';
    			
    			// http://www.phpfox.com/tracker/view/15041/
    			if(Phpfox::getParam('core.redirect_guest_on_same_page'))
    			{
					$sSendWhere = Phpfox::getLib('url')->getFullUrl(true);
					$sSendWhere = 'mobile.' . str_replace('/', '.', $sSendWhere);
				}
				
    			(($sPlugin = Phpfox_Plugin::get('request_is_mobile')) ? eval($sPlugin) : false);
    			
    			if ($bRedirect && !empty($sSendWhere))
    			{
					Phpfox::getLib('url')->send($sSendWhere);
				}
				else
				{
					return true;
				}
    			
    		}
    	}
    	
    	return Phpfox::getLib('url')->isMobile();    	
    }
    
    /**
     * Check if the user is using a specific browser and browser version.
     *
     * @param string $sName Browser name.
     * @param int $iVersion Browser version.
     * @return bool TRUE on success, FALSE on failure.
     */
    public static function isBrowser($sName, $iVersion)
    {
    	return (isset(self::$_aBrowser[strtolower($sName)][$iVersion]) ? true : false);
    }
    
    /**
     * Get the servers URL based on the server ID you pass.
     *
     * @param int $iId Server ID.
     * @return string Full server URL.
     */
    public function getServerUrl($iId = '')
    {
		if (!$iId)
		{
			$iId = $this->getServer('PHPFOX_SERVER_ID');
		}
    	
    	$aServers = Phpfox::getParam(array('balancer', 'servers'));
		$sServer = '';
		foreach ($aServers as $iServerKey => $aServerValue)
		{
			if ($aServerValue['id'] == $iId)
			{
				$sServer .= $aServerValue['url'];
				break;
			}
		} 

		return $sServer;	
    }
    
 	/**
 	* Fetches an alternate IP address of the current visitor, attempting to detect proxies etc.
 	*
 	* @param boolean $bReturnNum Return numerical value on TRUE.
 	* @return string
 	*/
 	public function getIp($bReturnNum = false)
 	{
 		if (PHP_SAPI == 'cli')
		{
			return 0;
		}
 		
 		$sAltIP = $_SERVER['REMOTE_ADDR'];
 
 		if (isset($_SERVER['HTTP_CLIENT_IP']))
 		{
 			$sAltIP = $_SERVER['HTTP_CLIENT_IP'];
 		}
 		elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $aMatches))
 		{
 			foreach ($aMatches[0] AS $sIP)
 			{
 				if (!preg_match("#^(10|172\.16|192\.168)\.#", $sIP))
 				{
 					$sAltIP = $sIP;
 					break;
 				}
 			}
 		}
 		elseif (isset($_SERVER['HTTP_FROM']))
 		{
 			$sAltIP = $_SERVER['HTTP_FROM'];
 		}
 		
 		if ($bReturnNum === true)
 		{
 			$sAltIP = str_replace('.', '', $sAltIP);
 		}
 
 		return $sAltIP;
 	}    
 	
 	/**
 	 * Check to see if an IP is really an IP.
 	 *
 	 * @param string $iIp IP to check.
 	 * @return bool TRUE is a valid IP, FALSE is not a valid IP.
 	 */
	public function isIP($iIp)
	{
		if(preg_match('/(\d+)\.(\d+)\.(\d+)\.(\d+)/', $iIp, $aMatches))
		{
			for($i=1;$i<=4;$i++)
			{
				if (($aMatches[$i] > 255) || ($aMatches[$i] < 0))
				{
					return false;
				}
			}
		}
        else
		{
			if (preg_match($this->_xIp6, $iIp, $aMatches) && isset($aMatches[1]) && !empty($aMatches[1]))
			{
				return true;
			}
			return false;
		}

        return true;
	} 	
 	
	/**
 	* Returns the IP address with the specified number of octets removed
 	*
 	* @param string IP address
 	* @return string Truncated IP address
 	*/
 	public function getSubstrIp($sIP, $iLength = null)
 	{
 		if ($iLength === null || $iLength > 3)
 		{
 			$iLength = Phpfox::getParam('core.ip_check');
 		}

 		return implode('.', array_slice(explode('.', $sIP), 0, 4 - $iLength));
 	}	
 	
 	/**
 	 * Get the unique ID of a user based on their browser and IP substirng.
 	 *
 	 * @return string MD5 string.
 	 */
 	public function getIdHash()
 	{
 		return md5((isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null) . Phpfox::getParam('core.id_hash_salt') . (Phpfox::getParam('core.include_ip_sub_id_hash') ? $this->getSubstrIp($this->getIp()) : ''));
 	}
	
	/**
	* Fetches a valid sessionhash value, not necessarily the one tied to this session.
	*
	* @return string 32-character sessionhash
	*/
	public function getSessionHash()
	{
		return md5(PHPFOX_TIME . Phpfox::getParam('core.path') . $this->getIdHash() . Phpfox::getParam('core.path') . rand(1, 1000000));
	}

	/**
	 * Send a request to another server. Usually using CURL.
	 *
	 * @param string $sUrl URL of the server.
	 * @param array $aPost $_POST data to send.
	 * @param string $sMethod Method of request (GET or POST).
	 * @param string $sUserAgent Useragent to send.
	 * @param string $aCookies ARRAY of any cookies to pass.
	 * @return mixed FALSE if failed to connect, STRING if anything was returned from the server.
	 */
	public function send($sUrl, $aPost = array(), $sMethod = 'POST', $sUserAgent = null, $aCookies = null, $bFollow = false)
	{
		$aHost = parse_url($sUrl);
		$sPost = '';
		foreach ($aPost as $sKey => $sValue)
		{
			$sPost .= '&' . $sKey . '=' . $sValue;
		}

		// Curl
		if (extension_loaded('curl') && function_exists('curl_init'))
		{
			$hCurl = curl_init();		
			
			curl_setopt($hCurl, CURLOPT_URL, (($sMethod == 'GET' && !empty($sPost)) ? $sUrl . '?' . ltrim($sPost, '&') : $sUrl));
			curl_setopt($hCurl, CURLOPT_HEADER, false);
			curl_setopt($hCurl, CURLOPT_FOLLOWLOCATION, $bFollow);
			curl_setopt($hCurl, CURLOPT_RETURNTRANSFER, true);
			
			// Testing this out at the moment...
			curl_setopt($hCurl, CURLOPT_SSL_VERIFYPEER, false);
			
			// Run if this is a POST request method
			if ($sMethod != 'GET')
			{
				curl_setopt($hCurl, CURLOPT_POST, true);
				curl_setopt($hCurl, CURLOPT_POSTFIELDS, $sPost);	
			}
			
			// Add the browser agent
			curl_setopt($hCurl, CURLOPT_USERAGENT, ($sUserAgent === null ? "" . PHPFOX::BROWSER_AGENT . " (" . PhpFox::getVersion() . ")" : $sUserAgent));
			
			// Check if we need to set some cookies
			if ($aCookies !== null)
			{				
				$sLine = "\n";				
				// Loop thru all the cookies we currently have set
				foreach ($aCookies as $sKey => $sValue)
				{
					// Make sure we don't see the session ID or the browser will crash
					if ($sKey == 'PHPSESSID')
					{
						continue;
					}
						
					// Add the cookies
					$sLine .= '' . $sKey . '=' . $sValue . '; ';		
				}
				// Trim the cookie
				$sLine = trim(rtrim($sLine, ';'));
					
				// Set the cookie
				curl_setopt($hCurl, CURLOPT_COOKIE, $sLine);
			}
			
			// Run the exec
			$sData = curl_exec($hCurl);
			
			// Close the curl connection
			curl_close($hCurl);	

			// Return whatever we can from the curl request
			return trim($sData);	
		}		
		
		// file_get_contents()
		if ($sMethod == 'GET' && ini_get('allow_url_fopen') && function_exists('file_get_contents'))
		{
			$sData = file_get_contents($sUrl . "?" . ltrim($sPost, '&'));
			
			return trim($sData);			
		}
		
		// fsockopen
		if (!isset($sData))
		{
			$hConnection = fsockopen($aHost['host'], 80, $errno, $errstr, 30);
	        if (!$hConnection)
	        {
				return false;
	        }
	        else
	        {
				if ($sMethod == 'GET')
				{
	        		$sUrl = $sUrl . '?' . ltrim($sPost, '&');
				}
	        	
	        	$sSend = "{$sMethod} {$sUrl}  HTTP/1.1\r\n";
	            $sSend .= "Host: {$aHost['host']}\r\n";
	            $sSend .= "User-Agent: " . PHPFOX::BROWSER_AGENT . " (" . PhpFox::getVersion() . ")\r\n";
	            $sSend .= "Content-Type: application/x-www-form-urlencoded\r\n";
	            $sSend .= "Content-Length: " . strlen($sPost) . "\r\n";
	            $sSend .= "Connection: close\r\n\r\n";
	           	$sSend .= $sPost;
	            fwrite($hConnection, $sSend);            
	            $sData = '';
				while (!feof($hConnection))
				{
					$sData .= fgets($hConnection, 128);
				}
				
				$aResponse = preg_split("/\r\n\r\n/", $sData);
				$sHeader = $aResponse[0];
				$sData = $aResponse[1];
				
				if(!(strpos($sHeader,"Transfer-Encoding: chunked")===false))
				{
	                $aAux = split("\r\n", $sData);
	                for($i=0; $i<count($aAux); $i++)
	                {
	                    if($i==0 || ($i%2==0))
	                    {
	                        $aAux[$i] = '';
	                    }
	                	$sData = implode("",$aAux);
	                }
				}				
				
				return chop($sData);
	        }
		}
		
		return false;
	}	
    
    /** 
     * Trims params and strip slashes if magic_quotes_gpc is set.
     *
     * @param mixed $mParam request params
     * @return mixed trimmed params.
     */
    private function _trimData($mParam)
    {		
    	if (is_array($mParam))
		{
			return array_map(array(&$this, '_trimData'), $mParam);
		}

		if (get_magic_quotes_gpc())
		{
			$mParam = stripslashes($mParam);
		}
		
		$mParam = trim($mParam);

		return $mParam;
    }    
}

?>
