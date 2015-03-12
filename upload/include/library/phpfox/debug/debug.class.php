<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Handles the debugging of the script when in development mode. Mainly used
 * by developers when testing the product itself or their own product.
 * 
 * When testing a part of your code or maybe the entire execution of your code
 * you can add a timer to check how long the code it took to execute the code
 * and how much memory was used.
 * Example:
 * <code>
 * Phpfox_Debug::start('my_custom_code');
 * // execute all your code here
 * Phpfox_Debug::end('my_custom_code');
 * </code>
 * To retrieve the information run:
 * <code>
 * $aData = Phpfxo_Debug::getHistory('my_custom_code');
 * print_r($aData);
 * </code>
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: debug.class.php 6627 2013-09-12 08:35:04Z Miguel_Espinoza $
 */
class Phpfox_Debug
{
	/**
	 * Holds a history of all the debug tests being executed
	 *
	 * @see self::start()
	 * @var array
	 * @static 
	 */
	public static $_aDebug = array();
	
	/**
	 * Holds a history of all the completed debug tests that were ran
	 *
	 * @see self::end()
	 * @var array
	 * @static 
	 */
	public static $_aDebugHistory = array();
	
	/**
	 * Starts a debug test on a specific routine
	 *
	 * @param string $sName Unique identifier of the test
	 * @static 
	 */
	public static function start($sName)
	{
		self::$_aDebug[$sName] = array(
        	'name' => $sName,
        	'memory_before' => memory_get_usage(),
        	'start' => array_sum(explode(' ', microtime()))
        );     
	}
	
	/**
	 * Store any debug messages that will later be outputed in the global debug table
	 *
	 * @see self::getDetails()
	 * @param string $sMsg Message you want to save in the debug history
	 * @static 
	 */
	public static function message($sMsg)
	{
		self::$_aDebugHistory['messages'][] = $sMsg;
	}
	
	/**
	 * Reset a debug test for a specific routine
	 *
	 * @param string $sName Unique identifier of the test. If left blank it will reset all tests.
	 * @static 
	 */
	public static function reset($sName = null)
	{
		if ($sName === null)
		{
			self::$_aDebug = array();
			return;	
		}
		
		unset(self::$_aDebug[$sName]);
	}
	
	/**
	 * Ends a debug test and stores it into memory so it can be disabled in our debug table or picked
	 * up at a later time for debug purposes.
	 *
	 * @param string $sName Unique identifier of the test.
	 * @param unknown_type $aExtra Any extra information you want to pass about the test
	 * @param unknown_type $bBackTrace Not used at the moment.
	 * @static 
	 */
	public static function end($sName, $aExtra = array(), $bBackTrace = false)
	{
		if (isset(self::$_aDebug[$sName]['name']) && $sName == self::$_aDebug[$sName]['name'])
		{
			$iEndTime = sprintf('%0.7f', (array_sum(explode(' ', microtime()))-self::$_aDebug[$sName]['start']));
			$iEndMemory = memory_get_usage();

			self::$_aDebugHistory[$sName][] = array_merge(
				$aExtra,
				array(
					'time' => $iEndTime,
					'memory_before' => self::$_aDebug[$sName]['memory_before'],
					'memory_after' => $iEndMemory
				)
			);
			self::reset($sName);
		}
	}	
	
	/**
	 * Gets history on a specific debug test that was executed earlier
	 *
	 * @static 
	 * @param string $sName Unique identifier of the test.	 
	 * @return array Returns an ARRAY of the history of the test. If the test was not found it will return an empty ARRAY
	 */
	public static function getHistory($sName)
	{		
		return (isset(self::$_aDebugHistory[$sName]) ? self::$_aDebugHistory[$sName] : array());
	}
	
	/**
	 * Used to create a table based on content being passed.
	 *
	 * @see self::getDetails()
	 * @static 
	 * @param bool $html_table FALSE will start a new table and TRUE will not create a new table
	 * @param array $row ARRAY of content to put in the table
	 * @return array 1st arg. returns if we created a new table and the 2nd arg returns the table HTML content.
	 */
	public static function addRow($html_table, $row)
	{
		$html_hold = '';	
		if (!$html_table && sizeof($row))
		{
			$html_table = true;
			$html_hold .= '<table class="nDebugExplainShell"><tr>';								
			foreach (array_keys($row) as $val)
			{
				$html_hold .= '<th class="nDebugExplainHead">' . (($val) ? ucwords(str_replace('_', ' ', $val)) : '&nbsp;') . '</th>';
			}
			$html_hold .= '</tr>';
		}
		$html_hold .= '<tr>';

		$class = 'row1';
		$iCnt = 0;
		foreach (array_values($row) as $val)
		{
			$iCnt++;
			$class = ($class == 'row1') ? 'nDebugExplain' : 'nDebugExplain';
			$val = htmlspecialchars($val);
			$html_hold .= '<td class="' . $class . '">' . (($iCnt == 6 && empty($val)) ? '<span style="color:red; font-weight:bold;">MISSING KEY</span>' : '') . (($val) ? $val : '&nbsp;') . '</td>';
		}
		$html_hold .= '</tr>';				
				
		return array($html_table, $html_hold);		
	}
	
	/**
	 * Debug output found at the bottom of the site when debug mode is enabled.
	 *
	 * @static 
	 * @return mixed Only returns something if the installer is being used and in that case it returns FALSE
	 */
	public static function getDetails()
	{		
		if (defined('PHPFOX_INSTALLER'))
		{
			return false;
		}
		
		// SQL
    	$iSqlCount = 0;
    	$fSum = 0.0;
    	$fLimit = 0.05 * 128;
    	$iSqlMemory = 0;
    	$aKeywords = array('SELECT', 'SELECT ', 'FROM', 'FROM ', 'WHERE ', 'UPDATE ', 'OFFSET', ' AS ', 'UNION ALL', 'INNER JOIN ', 'LEFT JOIN ', 'INSERT INTO ', 'SHOW COLUMNS ', 'ON', 'SET', 'USING', 'USE INDEX', 'JOIN ', 'ORDER BY', 'DESC', 'LIMIT', 'DELETE');
    	$oRequest = Phpfox::getLib('request');
    	$oFile = Phpfox::getLib('file');
    	$aReplaces = array_map(array('self', '_addKeywordSyntax'), $aKeywords);
    	$sDriver = Phpfox::getParam(array('db', 'driver'));
    	$sSql = '';
    	$bIsCmd = ((PHP_SAPI == 'cli' || (defined('PHPFOX_IS_AJAX') && PHPFOX_IS_AJAX)));
    	
    	if (!isset(self::$_aDebugHistory['sql']))
    	{
    		self::$_aDebugHistory['sql'] = array();
    	}
    	
    	// Fresh install, no need to display sql debug
    	if ($sDriver == 'DATABASE_DRIVER')
    	{
    		self::$_aDebugHistory['sql'] = array();
    	}    	
    	
    	foreach(self::$_aDebugHistory['sql'] as $aLine)
    	{
    		if ( !isset($aLine['sql']) )
    		{
    			continue;
    		}
    		
    		$iSqlCount++;
    		$sExtra = Phpfox::getLib('database')->sqlReport($aLine['sql']);

    	    if ($bIsCmd)
    	    {
    	    	$sSql .= "\n ----------------- \n Rows: " . $aLine['rows'] . " Slave: " . ($aLine['slave'] ? 'Yes' : 'No') . " \n " . $aLine['sql'] . " \n\n";
    	    }
    	    else 
    	    {
	    		if ($aLine['time'] == '0.0000000')
	    		{
	    			$aLine['time'] = '0.0000001';
	    		}
    	    	$sColor = sprintf('%02X', min(255, $fLimit/$aLine['time']));
	    	    $aLine['sql'] = str_replace($aKeywords, $aReplaces, htmlspecialchars($aLine['sql']));	    	    
    	    	
    	    	$sSql .= '<div class="nDebugInfo">
				<span style="background-color: #FF'.$sColor.$sColor.'; color:#000; padding:2px;">'. $aLine['time'] .'</span>
				| <b>Memory Before:</b> '. $oFile->filesize($aLine['memory_before']) .'
				| <b>Memory After:</b> '. $oFile->filesize($aLine['memory_after']) .'
				| <b>Memory Used:</b> '. $oFile->filesize($aLine['memory_after'] - $aLine['memory_before']) .'
				| <b>Rows:</b> '.$aLine['rows'].'
				| <b>Slave:</b> ' . ($aLine['slave'] ? 'Yes' : 'No') . '
				</div>';
	    	    $sSql .= '<div class="nDebugItems">'. self::_parseSQL($aLine['sql']).''. $sExtra .'</div>';
    	    }

    	    $fSum += $aLine['time'];
    	    $iSqlMemory += ($aLine['memory_after'] - $aLine['memory_before']);
    	}    	

    	// General Stats
    	$iTotalTime = sprintf('%0.7f', (array_sum(explode(' ', microtime()))-PHPFOX_TIME_START));
    	$iTotalSqlTime = sprintf('%0.7f', $fSum);
    	
    	$sDebugReturn = '<div id="js_main_debug_holder">';
    	if (!defined('PHPFOX_MEM_END'))
		{
			define('PHPFOX_MEM_END', memory_get_usage());
		}
    	
    	if (PHPFOX_DEBUG_LEVEL === 1)
    	{    	
    		$sDebugReturn .= '<div style="font-size:9pt; text-align:center; padding-bottom:50px;">Page generated in ' . round($iTotalTime, 4) . ' seconds with ' . $iSqlCount . ' queries and GZIP ' . (Phpfox::getParam('core.use_gzip') ? 'enabled' : 'disabled') . ' on ' . $_SERVER['SERVER_ADDR'] . '.</div>';
    	}    	
    	elseif (PHPFOX_DEBUG_LEVEL === 2 || PHPFOX_DEBUG_LEVEL === 3)
    	{
	    	$bSlaveEnabled = Phpfox::getParam(array('db', 'slave'));
	    	$aStats = array
	    	(
	    		// phpFox
	    		'Version' => PhpFox::getVersion(),
	    		'Product Code Name' => PhpFox::getCodeName(),
	    		'1' => '',
	    		// Total Time
	    		'Total Time' => $iTotalTime,
	    		'PHP General Time' => ($iTotalTime - $iTotalSqlTime),
	    		'GZIP' => (Phpfox::getParam('core.use_gzip') ? 'enabled' : 'disabled'),
	    		'2' => '',
	    		// SQL
	    		'Driver Version' =>  ($sDriver == 'DATABASE_DRIVER' ? 'N/A' : Phpfox::getLib('database')->getServerInfo()),
	    		'SQL Time' =>  $iTotalSqlTime,
	    		'SQL Queries' => $iSqlCount,    		
	    		'SQL Memory Usage' => $oFile->filesize($iSqlMemory),
	    		'SQL Slave Enabled' => ($bSlaveEnabled ? 'Yes' : 'No'),
	    		'SQL Total Slaves' => ($bSlaveEnabled ? count(Phpfox::getParam(array('db', 'slave_servers'))) : 'N/A'),
	    		'SQL Slave Server' => ($bSlaveEnabled ? Phpfox::getLib('database')->sSlaveServer : 'N/A'),    		
	    		'3' => '',
	    		// Vars
	    		'Total Memory Usage' => $oFile->filesize(PHPFOX_MEM_END),
	    		'Total Memory Usage (Including Debug)' => $oFile->filesize(memory_get_usage()),
	    		'Memory Limit' => $oFile->filesize(self::_getUsableMemory()) . ' (' . @ini_get('memory_limit') . ')',
	    		'4' => '',
	    		'Load Balancing Enabled' => (Phpfox::getParam(array('balancer', 'enabled')) ? 'Yes' : 'No'),
	    		'Requests From' => $oRequest->getServer('SERVER_ADDR'),
	    		'Server ID#' => $oRequest->getServer('PHPFOX_SERVER_ID'),
	    		'5' => '',
	    		'Server Time Stamp' => date('F j, Y, g:i a', PHPFOX_TIME),
	    		'PHP Version' => PHP_VERSION,
	    		'PHP Sapi' => php_sapi_name(),
	    		'PHP safe_mode' => (PHPFOX_SAFE_MODE ? 'true' : 'false'),
	    		'PHP open_basedir' => (PHPFOX_OPEN_BASE_DIR ? 'true' : 'false'),
	    		'Operating System' => PHP_OS,
			'6' => '',
			'Cache'=> Phpfox::getParam('core.cache_storage')
	    	);
	
		    if (extension_loaded('xdebug'))
		    {
	    		$aXdebug = array(
	    			'4' => '', 
	    			'xDebug File Name' => xdebug_get_profiler_filename(),
	    			'xDebug Total Time' => xdebug_time_index()
	    		);
		    	$aStats = array_merge($aStats, $aXdebug);
		    }
	   	
	    	$sDebugStats = '';
	    	foreach( $aStats as $sStatTitle => $mStatValue )
	    	{
	    		if (!$mStatValue)
	    		{
	    			$sDebugStats .= ($bIsCmd ? "\n" : "<br />");
	    		}
	    		else
	    		{
	    			$sDebugStats .= ($bIsCmd ? "". $sStatTitle .": ". $mStatValue ."\n" : "<div class=\"nDebugLeft\">". $sStatTitle .":</div><div>". $mStatValue ."</div>\n<div class=\"nClear\"></div>\n");
	    		}
	    	}	
	    	
	    	$aCookies = array();
	    	$sCookiePrefix = Phpfox::getParam('core.session_prefix');
	    	$iPrefixLength = strlen($sCookiePrefix);
	    	foreach ($_COOKIE as $sKey => $sValue)
	    	{
	    		if (substr($sKey, 0, $iPrefixLength) != $sCookiePrefix)
	    		{
	    			continue;
	    		}
	    		$aCookies[$sKey] = $sValue;
	    	}
	    	    	
	    	if ($bIsCmd)
	    	{
	    		$sDebugReturn .= $sDebugStats;
	    		$sDebugReturn .= "##############################################";
	    	}
	    	else 
	    	{	    	
		    	$sDebugReturn .= '
				<div id="n_debug">
				<div id="n_debug_header">
					phpFox Developers Debug
					<a href="#" onclick="if (getCookie(\'js_console\')) { deleteCookie(\'js_console\'); $(\'#firebug_no_console\').remove(); } else { setCookie(\'js_console\', \'1\', 365); p(\'Enabled JavaScript Console\'); } return false;">Toggle JavaScript Console</a>
				</div>		
				<div class="nDebugItem"><a href="#" onclick="if (getCookie(\'phpfox_debug_detail\')) { deleteCookie(\'phpfox_debug_detail\'); $(\'#phpfox_debug_detail\').slideDown(); } else { $(\'#phpfox_debug_detail\').slideUp(); setCookie(\'phpfox_debug_detail\', \'1\', 365); } return false;">Debug Details</a></div>
				<div class="nDebugContent nDebugContentShell" id="phpfox_debug_detail"' . (Phpfox::getCookie('phpfox_debug_detail') ? ' style="display:none;"' : '') . '>
					<div class="nDebugContentShell">
						'.$sDebugStats .'
					</div>
				</div>
				';
	    	}	
		    
	    	if (PHPFOX_DEBUG_LEVEL === 3)
	    	{
		    	if ($bIsCmd)
		    	{
		    		$sDebugReturn .= $sSql;
		    		$sDebugReturn .= "##############################################";
		    	}
		    	else 
		    	{
		    		$sDebugReturn .= '
					<div class="nDebugItem">SQL Queries</div>
					<div class="nDebugContent nDebugContentShell" style="height:400px;">
						'. $sSql .'
					</div>	
					';
		    	}
	    	}
	    	/*
			<div class="nDebugItem">Debug History</div>
			<div class="nDebugContent nDebugContentShell" style="height:200px;">
				<pre>'. self::_loadData(self::$_aDebugHistory) .'</pre>
			</div>
			*/
	    	if (!$bIsCmd)
	    	{
		    	$sDebugReturn .= '
				<div class="nDebugItem"><a href="#" onclick="if (getCookie(\'phpfox_debug_session\')) { deleteCookie(\'phpfox_debug_session\'); $(\'#phpfox_debug_session\').slideDown(); } else { $(\'#phpfox_debug_session\').slideUp(); setCookie(\'phpfox_debug_session\', \'1\', 365); } return false;">Session</a></div>
				<div class="nDebugContent nDebugContentShell" id="phpfox_debug_session"' . (Phpfox::getCookie('phpfox_debug_session') ? ' style="display:none;"' : '') . '>
					<pre>'. self::_loadData($_SESSION[Phpfox::getParam('core.session_prefix')]) .'</pre>
				</div>
		
				<div class="nDebugItem"><a href="#" onclick="if (getCookie(\'phpfox_debug_cookie\')) { deleteCookie(\'phpfox_debug_cookie\'); $(\'#phpfox_debug_cookie\').slideDown(); } else { $(\'#phpfox_debug_cookie\').slideUp(); setCookie(\'phpfox_debug_cookie\', \'1\', 365); } return false;">Cookie</a></div>
				<div class="nDebugContent nDebugContentShell" id="phpfox_debug_cookie"' . (Phpfox::getCookie('phpfox_debug_cookie') ? ' style="display:none;"' : '') . '>
					<pre>'. self::_loadData($aCookies) .'</pre>
				</div>		
				
				</div>
				';
	    	}
    	}
    	
    	$sDebugReturn .= '</div>';
    	
    	if (defined('PHPFOX_DEBUG_SHOW_FIXED'))
    	{
    		$sDebugReturn .= '<div style="position:fixed; bottom:0px; right:5px; background:#fff; border:1px #dfdfdf solid; width:200px; padding:5px; font-size:16px;">
    				Generated in: ' . round($iTotalTime, 4) . ' <br />
    				SQL: ' . $iSqlCount . ' (' . $iTotalSqlTime . ') <br />
    				Server:  ' . $_SERVER['SERVER_ADDR'] . '
    		</div>';
    	}
    	
    	return $sDebugReturn;
	}	
	
	/**
	 * Parses ARRAYS and makes it readable for browsers.
	 *
	 * @static 
	 * @example self::_loadData($_COOKIE)
	 * @param mixed $mType ARRAY we want to display.
	 * @return string Returns ARRAY as a string that can be outputed to the browser.
	 */
	private static function _loadData(&$mType)
	{
    	$sContent = htmlspecialchars(print_r($mType, true));
	 	return $sContent;
	}	

	/**
	 * Parse SQL code so when outputed to the browser it is easier to read and understand.
	 *
	 * @param string $sStr SQL Code to parse
	 * @return string Updated SQL code making it easier to read
	 */
	private static function _parseSQL($sStr)
	{
		$sStr = str_replace("\n", "<br />\n", trim($sStr));		
		$sStr = str_replace('UNIO_N ALL', "PHPFOX_UNIO_N_ALL", $sStr);
		$sStr = str_replace('LEFT JOIN', "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PHPFOX_LEFT", $sStr);
		$sStr = str_replace('LEFT JOIN', "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PHPFOX_INNER", $sStr);
		$sStr = str_replace('JOIN', "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;JOIN", $sStr);
		$sStr = str_replace('PHPFOX_LEFT', "LEFT JOIN", $sStr);
		$sStr = str_replace('PHPFOX_INNER', "INNERT JOIN", $sStr);
		$sStr = str_replace('ON', "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ON", $sStr);
		$sStr = str_replace('PHPFOX_UNIO_N_ALL', "<br />UNION ALL<br />", $sStr);
		$sStr = trim($sStr);
		return $sStr;
	}
	
	/**
	 * We want to identify special SQL functions like ON() or USING()
	 *
	 * @param string $sVal SQL Code to parse
	 * @return string Returns updated code with bolding on special functions
	 */
	private static function _addKeywordSyntax($sVal)
	{
	    if (trim($sVal) == 'UNION ALL')
	    {
	    	$sVal = 'UNIO_N ALL';	
	    }
		
		$sReturn = ' <span style="color:#54A4DE;"><b>' . trim($sVal) . '</b></span> ';
	    
	    if ($sVal == 'ON' || $sVal == 'USING')
	    {
	    	$sReturn = rtrim($sReturn);
	    }
	    
	    return $sReturn;
	}	
	
	/**
	 * Gets the total memory that can be used by the script based on what the server has.
	 *
	 * @return string Total memory allowed by the server
	 */
	private static function _getUsableMemory()
	{
		$sVal = trim(@ini_get('memory_limit'));
	
		if (preg_match('/(\\d+)([mkg]?)/i', $sVal, $aRegs))
		{
			$sMemoryLimit = (int) $aRegs[1];
			switch ($aRegs[2])
			{	
				case 'k':
				case 'K':
					$sMemoryLimit *= 1024;
					break;	
				case 'm':
				case 'M':
					$sMemoryLimit *= 1048576;
					break;	
				case 'g':
				case 'G':
					$sMemoryLimit *= 1073741824;
					break;
			}
			
			$sMemoryLimit /= 2;
		}
		else
		{
			$sMemoryLimit = 1048576;
		}
	
		return $sMemoryLimit;
	}	
}

?>