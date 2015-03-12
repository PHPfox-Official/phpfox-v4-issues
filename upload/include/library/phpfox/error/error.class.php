<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Error handling for phpFox.
 * 
 * Within a controller you can exit the script by using the display() method like:
 * <code>
 * return Phpfox_Error::display('Unable to view this page...');
 * </code>
 * 
 * If using PHP logic that requires triggering a fatal error it can be done with:
 * <code>
 * Phpfox_Error::trigger('Missing a variable...', E_USER_ERROR);
 * </code>
 * 
 * The entire script has a built in error system and automatically displays errors when set with:
 * <code>
 * Phpfox_Error::set('We have encountered an error');
 * </code>
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: error.class.php 7272 2014-04-15 13:25:27Z Fern $
 */
class Phpfox_Error
{
	/**
	 * Holds an ARRAY of all the error messages we set
	 *
	 * @static 
	 * @var array
	 */
	static private $aErrors = array();
	
	/**
	 * Holds a BOOL value if we should display the error messages or not
	 *
	 * @static 
	 * @var bool
	 */
	static private $_bDisplay = true;
	
	/**
	 * Holds a BOOL value if we should skip the error reporting or not
	 *
	 * @static 
	 * @var bool
	 */
	static private $_bSkipError = false;	
	
	/**
	 * Displays the error message and directly creates a variable for the template engine
	 *
	 * @static 
	 * @param string $sMsg Error message you want to display on the current page the user is on.
	 */
	public static function display($sMsg, $iErrCode = null)
	{
		if (PHPFOX_IS_AJAX)
		{
			echo $sMsg;
		}
		else 
		{
			Phpfox::getLib('module')->setController('error.display');
			Phpfox::getLib('template')->assign(array(
					'sErrorMessage' => $sMsg
				)
			);	
		}
		if ($iErrCode !== null)
		{
			$oUrl = Phpfox::getLib('url');
			header($oUrl->getHeaderCode($iErrCode));
		}
		return false;
	}
	
	/**
	 * Display a warning or error message
	 *
	 * @static 
	 * @param string $sMsg is the Error message
	 * @param constant $sErrorCode is the valid constant. (eg. E_USER_WARNING will be a warning message and E_USER_ERROR will be a fatal error message)
	 * @return bool If E_USER_ERROR is enabled we exit() the script, however if not we return FALSE
	 */
	public static function trigger($sMsg, $sErrorCode = E_USER_WARNING)
	{		
		trigger_error(strip_tags($sMsg), $sErrorCode);
		
		if ($sErrorCode == E_USER_ERROR)
		{
			exit;
		}
		
		return false;
	}
	
	/**
	 * Set an error message that can be displayed at a later time
	 *
	 * @static 
	 * @param string $sMsg Error message you want to display
	 * @return bool Always returns FALSE since we encountered an error
	 */
	public static function set($sMsg)
	{
		self::$aErrors[] = $sMsg;
		
		return false;
	}
	
	/**
	 * Get all the reported errors thus far set by the method set()
	 *
	 * @see self::set()
	 * @static 
	 * @return array Returns an ARRAY of error messages. If no errors it returns an empty ARRAY
	 */
	public static function get()
	{
		return self::$aErrors;
	}	
	
	/**
	 * Sets the display status of error reporting.
	 *
	 * @static 
	 * @param bool $bDisplay Sets the display status
	 */
	public static function setDisplay($bDisplay)
	{
		self::$_bDisplay = $bDisplay;
	}	
	
	/**
	 * Gets the current display status of error reporting
	 *
	 * @static 
	 * @return array
	 */
	public static function getDisplay()
	{
		return self::$_bDisplay;
	}
	
	/**
	 * Returns if an error has accured up to this point. This is bassed on anything
	 * set by the method set(). This is used with IF conditional statments to see if
	 * we can continue with a routine or if an error has occured.
	 * 
	 * Example usage:
	 * <code>
	 * if (Phpfox_Error::isPassed())
	 * {
	 * 		// Everything is okay do something here...
	 * }
	 * else
	 * {
	 * 		// Oh no there was an error. Display error messages here...
	 * }
	 * </code>
	 *
	 * @see self::set()
	 * @static 
	 * @return unknown
	 */
	public static function isPassed()
	{
		return (!count(self::$aErrors) ? true : false);
	}		
	
	/**
	 * Reset the error messages. We do this automatically at the end of the
	 * entire routine to display a page, however if you need to reset it earlier
	 * it can be done with this method.
	 * 
	 * @static 
	 *
	 */
	public static function reset()
	{
		self::$aErrors = array();
	}
	
	/**
	 * If debug mode is enabled and you want to make sure to skip error reporting
	 * you can use this method to force us to skip error reporting and then later
	 * turn it back on. We mainly use this when dealing with 3rd party libraries
	 * since we did not develop the code we are not fully aware of the coding standards
	 * applied.
	 *
	 * @static 
	 * @param bool $bSkipError TRUE to skip error reporting and FALSE to turn error reporting back on.
	 */
	public static function skip($bSkipError)
	{
		if ($bSkipError === true)
		{
			error_reporting(0);
		}
		else 
		{
			error_reporting((PHPFOX_DEBUG ? E_ALL | E_STRICT : 0));
		}
		self::$_bSkipError = $bSkipError;
	}
	
	/**
	 * This method handles the output of the error message PHP returns. We extend the PHP error
	 * reporting with providing more information on the error and where in the source code
	 * it can be found.
	 *
	 * @static 
	 * @see set_error_handler
	 * @param int $nErrNo The first parameter, errno, contains the level of the error raised, as an integer. 
	 * @param string $sErrMsg The second parameter, errstr, contains the error message, as a string. 
	 * @param string $sFileName The third parameter is optional, errfile, which contains the filename that the error was raised in, as a string. 
	 * @param int $nLinenum The fourth parameter is optional, errline, which contains the line number the error was raised at, as an integer. 
	 * @param array $aVars The fifth parameter is optional, errcontext, which is an array that points to the active symbol table at the point the error occurred. In other words, errcontext  will contain an array of every variable that existed in the scope the error was triggered in. User error handler must not modify error context. 
	 * @return bool We only return a BOOL FALSE if we need to skip error reporting, otherwise we echo the output.
	 */
	public static function errorHandler($nErrNo, $sErrMsg, $sFileName, $nLinenum, $aVars = array())
	{		
		/* @Todo Purefan fix all 65 preg_replace calls that use /e */
		if (strpos($sErrMsg, '/e modifier is deprecated') !== false)
		{
			return;
		}
		if (defined('PHPFOX_IS_API'))
		{
			echo serialize(array(
					'error' => 'fatal',
					'error_message' => $sErrMsg,
					'return' => false
				)
			);
			
			exit;
		}
		
		if (self::$_bSkipError)
		{
			return false;
		}
		
		if ((defined('PHPFOX_LOG_ERROR') && PHPFOX_LOG_ERROR) || defined('PHPFOX_INSTALLER'))
		{
			self::log($sErrMsg, $sFileName, $nLinenum);
		}
		
		if (!PHPFOX_DEBUG && !error_reporting())		
	    {
	    	return false;
	    }	    
		
		$aTypes = array(
	        1   =>  "Error",
	        2   =>  "Warning",
	        4   =>  "Parsing Error",
	        8   =>  "Notice",
	        16  =>  "Core Error",
	        32  =>  "Core Warning",
	        64  =>  "Compile Error",
	        128 =>  "Compile Warning",
	        256 =>  "User Error",
	        512 =>  "User Warning",
	        1024=>  "User Notice",
	        2048=>  "PHP 5"
	    );

    	$aColors = array(
    	    1   =>  "#FF9999",
    	    2   =>  "#00FFFF",
    	    4   =>  "#FF9999",
    	    8   =>  "#99FF99",
    	    16  =>  "#FF9999",
    	    32  =>  "#00FFFF",
    	    64  =>  "#FF9999",
    	    128 =>  "#00FFFF",
    	    256 =>  "#FF9999",
    	    512 =>  "#00FFFF",
    	    1024=>  "#FF9999",
    	    2048=>  "#FF9999"
    	);

    	if (substr(PHP_VERSION, 0, 1) < 5)
	    {
	        $iStart = 1;
	    }
	    else
	    {
	        $iStart = 0;
	    }    	
	    
	    $bNoHtml = false;
	    if ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') || (PHP_SAPI == 'cli'))
	    {
	    	$bNoHtml = true;	
	    }

    	$sErrMsg = str_replace(PHPFOX_DIR, '', $sErrMsg);
    	if ($bNoHtml)
    	{
    		$sErr = "\n{$aTypes[$nErrNo]}: {$sErrMsg}\n";
    	}
    	else 
    	{
			if (!isset($aColors[$nErrNo]) || !isset($aTypes[$nErrNo]))
			{
				$nErrNo = 1;
			}
			$sErr = '<!-- phpFox Error Message --><br />
			<table border="0" cellspacing="0" cellpadding="2" style="font-family:Verdana;font-size:12px; border-color: #000000; border: 1px solid black; background:#fff;">
	        <tr>
	        	<td colspan="10" align="left" valig="top" style="background-color: ' . $aColors[$nErrNo] . '"><b>' . $aTypes[$nErrNo] . ':&nbsp;' . $sErrMsg . ' - ' . str_replace(PHPFOX_DIR, '', $sFileName) . ' (' . $nLinenum . ')</b></td></tr>';  	
    	}    	
    	
   		$aFiles = debug_backtrace();
   		
   		if (preg_match('/mysql_connect\(\)/i', $sErrMsg) && !defined('PHPFOX_INSTALLER'))
   		{			
			exit($sErrMsg);
			// cant connect to database : too many connections
			// display the no DB error page
			$sFile = file_get_contents(PHPFOX_DIR . 'static' . PHPFOX_DS . 'nodb.html');
			ob_clean();
			die($sFile);
			
   			$aFiles = array();
   		}
   		
    	for ($i=$iStart, $n=sizeof($aFiles); $i<$n; ++$i)
    	{
        	if (!isset($aFiles[$i]['file']))
        	{
        		continue;
        	}

        	if ($aFiles[$i]['function'] == 'trigger_error' || $aFiles[$i]['function'] == 'trigger')
        	{
        		// continue;
        	}        	
        	
			if (isset($aFiles[$i]['class']) && $aFiles[$i]['class'] == 'Phpfox_Error')
			{
				// continue;
			}        	
			
			if (in_array(strip_tags(str_replace(PHPFOX_DIR, '', $aFiles[$i]['file'])), array(
						'include/library/phpfox/error/error.class.php',
						'include/library/phpfox/database/driver/mysql.class.php',
						'include/library/phpfox/database/dba.class.php'
					)
				)
			)
			{
				// continue;
			}

    		$sArgs = '';
        	if (isset($aFiles[$i]['args']))
        	{
            	$aArgs = array();
            	$aArgs = array_merge($aFiles[$i]['args'], array());
            	if ($aArgs and is_array($aArgs))
            	{
                	foreach ($aArgs as $k=>$v)
                	{
                    	if (is_numeric($v))
                    	{
                    	    $aArgs[$k] = '<span style="color:#7700AA">'.$v.'</span>';
                    	}
                    	elseif(is_bool($v))
                    	{
                    	    $aArgs[$k] = '<span style="color:#222288;">'.($v ? 'TRUE' : 'FALSE').'</span>';
                    	}
                    	elseif(is_null($v))
                    	{
                    	    $aArgs[$k] = '<span style="color:#222288;">NULL</span>';
                    	}
                    	elseif(is_array($v))
                    	{
                    	    $aArgs[$k] = 'Array('.count($v).')';
                    	}
    	                elseif (is_string($v) && ! (('"' == substr($v,0,1)) && ('"' == substr($v,-1))))
	                    {
	                        $aArgs[$k] = '<span style="color:#0000FF">"'.$v.'"</span>';
	                    }
	                    elseif(is_object($v))
	                    {
	                        unset($aArgs[$k]);
	                        $aArgs[$k] = '{' . ucfirst(get_class($v)) . '}';
	                    }
	                }
	            }
	            $sArgs = implode(', ', $aArgs);
	        }

        	$sFuncName = (isset($aFiles[$i]['class'])?$aFiles[$i]['class']:'').
                     (isset($aFiles[$i]['type'])?$aFiles[$i]['type']:'').
                     $aFiles[$i]['function'].'('.$sArgs.')';
        	if ($iStart == $i)
        	{
        	    $sFuncName = '<b>' . $sFuncName . '</b>';
        	}
        	$sFile = str_replace(PHPFOX_DIR, '', $aFiles[$i]['file']);
        	
        	if ($bNoHtml)
    		{
    			$sErr .= "{$i}\t{$sFile}\t" . (isset($aFiles[$i]['line']) ? $aFiles[$i]['line'] : '') . "\t" . strip_tags(str_replace(PHPFOX_DIR, '', $sFuncName)) . "\n";	
    		}
    		else 
    		{
        		$sErr .= '<tr><td bgcolor="#DDEEFF" align="right">'.$i.'&nbsp;</td>'.
                 '<td style="border-bottom:1px #000 solid;">' . $sFile . '&nbsp;:&nbsp;<b>'.(isset($aFiles[$i]['line']) ? $aFiles[$i]['line'] : '').'</b>&nbsp;&nbsp; </td>'.
                 '<td style="border-bottom:1px #000 solid; border-left:1px #000 solid;">' . str_replace(PHPFOX_DIR, '', $sFuncName) . '</td></tr>';
    		}
    	}  		
   		
    	if (!$bNoHtml)
    	{
	    	$sErr .= '</table>';
    	}  	

	    echo $sErr;	    
	    
	    if (PHPFOX_DEBUG && defined('PHPFOX_DEBUG_EXIT'))
	    {      	
	    	exit;
	    }
	}	
	
	/**
	 * Error messages can also be logged into a flat file on the server. The reason
	 * for this certain AJAX request or API callbacks may be hard to find error reports
	 * and by adding all error reports to a flat file it will help with debugging. This
	 * is automatically used with our error handler.
	 *
	 * @see self::errorHandler()
	 * @static 
	 * @param string $sMessage Error message to display
	 * @param string $sFile Full path to the file
	 * @param int $iLine Line number of where the error occured
	 */
	public static function log($sMessage, $sFile, $iLine)
	{
		$aCallbacks = debug_backtrace();
		$aBacktrace = array();
		foreach ($aCallbacks as $aCallback)
		{
			if (isset($aCallback['class']) && $aCallback['class'] == 'Phpfox_Error')
			{
				continue;
			}
			
			if (!isset($aCallback['file']) || !isset($aCallback['line']))
			{
				continue;
			}
			
			$aBacktrace[] = array(
				'file' => $aCallback['file'],
				'line' => $aCallback['line']
			);
		}	    
		
		$sErrorLog = serialize(array(
				'message' => self::_escapeCdata($sMessage),
				'backtrace' => var_export($aBacktrace, true),
				'request' => var_export($_REQUEST, true),
				'ip' => Phpfox::getLib('request')->getServer('REMOTE_ADDR') // $_SERVER['REMOTE_ADDR']
			)
		);
		
		$hFile = fopen(PHPFOX_DIR . 'file' . PHPFOX_DS . 'log' . PHPFOX_DS . 'phpfox_error_log_' . date('d_m_y', time()) . '_' . md5(Phpfox::getVersion()) . '.php', 'a');
    	fwrite($hFile, '<?php defined(\'PHPFOX\') or exit(\'NO DICE!\');  ?>' . "##\n{$sErrorLog}##\n");
    	fclose($hFile);		
	}
	
	/**
	 * Removes any CDATA from a string.
	 *
	 * @static 
	 * @param string $sXml XML code to parse
	 * @return string New string without CDATA
	 */
	private static function _escapeCdata($sXml)
	{
		$sXml = preg_replace('#[\\x00-\\x08\\x0B\\x0C\\x0E-\\x1F]#', '', $sXml);

		return str_replace(array('<![CDATA[', ']]>'), array('�![CDATA[', ']]�'), $sXml);	
	}
}

/**
 * PHP print_r Data so its readable
 * 
 * @see print_r()
 * @param mixed $mInfo Can be any sort of type that will be outputed by print_r()
 */
function d($mInfo, $bVarDump = false)
{
	$bCliOrAjax = (PHP_SAPI == 'cli');
	(!$bCliOrAjax ? print '<pre style="text-align:left; padding-left:15px;">' : false);
	($bVarDump ? var_dump($mInfo) : print_r($mInfo));
	(!$bCliOrAjax ? print '</pre>' : false);
}

/**
 * Print DATA
 */
function p()
{
	$aArgs = func_get_args();
	$bCliOrAjax = (PHP_SAPI == 'cli');
	foreach($aArgs as $sStr)
	{
		print ($bCliOrAjax ? '' : '<pre>') . "{$sStr}" . ($bCliOrAjax ? "\n" : '</pre><br />');
	}
}

/**
 * Prints error messages. Used with AJAX calls
 */
function e()
{
	$bCliOrAjax = ((PHP_SAPI == 'cli' || (defined('PHPFOX_IS_AJAX') && PHPFOX_IS_AJAX)));
	ob_clean();
	if (!$bCliOrAjax)
	{
		echo '<link rel="stylesheet" type="text/css" href="theme/adminpanel/default/style/default/css/debug.css?v=' . PHPFOX_TIME . '" />';
	}
	define('PHPFOX_MEM_END', memory_get_usage());
	echo Phpfox_Debug::getDetails();
	exit;
}

?>
