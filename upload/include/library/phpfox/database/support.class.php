<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Works with all the supported database drivers we support and what the actual
 * server can handle as well. It can also perform certain tasks on all the database
 * drivers without the need to seperate the command. This is mainly used during
 * and install or upgrade or our product to find the supported database drivers and
 * perform and modifications on the queries based on the driver being used.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: support.class.php 6394 2013-07-31 13:13:37Z Raymond_Benc $
 */
class Phpfox_Database_Support
{
	/**
	 * Array of all the drivers we are testing but also the ones we just support at the moment.
	 *
	 * @var array
	 */
	private $_aDbs = array(
		'mysqli'	=> array(
			'label'			=> 'MySQL with MySQLi Extension',
			'schema'		=> 'mysql',
			'module'		=> 'mysqli',
			'delim'			=> ';',
			'comments'		=> 'remove_remarks',
			'driver'		=> 'mysqli',
			'available'		=> true
		),
		'mysql'		=> array(
			'label'			=> 'MySQL',
			'schema'		=> 'mysql',
			'module'		=> 'mysql',
			'delim'			=> ';',
			'comments'		=> 'remove_remarks',
			'driver'		=> 'mysql',
			'available'		=> true
		),
		'mssql'		=> array(
			'label'			=> 'MS SQL Server 2000+',
			'schema'		=> 'mssql',
			'module'		=> 'mssql',
			'delim'			=> 'GO',
			'comments'		=> 'remove_comments',
			'driver'		=> 'mssql',
			'available'		=> false
		),		
		'postgres' => array(
			'label'			=> 'PostgreSQL 7.x/8.x',
			'schema'		=> 'postgres',
			'module'		=> 'pgsql',
			'delim'			=> ';',
			'comments'		=> 'remove_comments',
			'driver'		=> 'postgres',
			'available'		=> false
		),
		'sqlite'		=> array(
			'label'			=> 'SQLite',
			'schema'		=> 'sqlite',
			'module'		=> 'sqlite',
			'delim'			=> ';',
			'comments'		=> 'remove_remarks',
			'driver'		=> 'sqlite',
			'available'		=> false
		),
		'oracle'	=>	array(
			'label'			=> 'Oracle',
			'schema'		=> 'oracle',
			'module'		=> 'oci8',
			'delim'			=> '/',
			'comments'		=> 'remove_comments',
			'driver'		=> 'oracle',
			'available'		=> false
		),		
	);
	
	/**
	 * Class constructor
	 *
	 */
	public function __construct()
	{
	}
	
	/**
	 * Gets all the supported drivers by making sure the driver class exists and if the
	 * actual server has support for it.
	 *
	 * @param bool $bReturnAll If set to TRUE it will return all the drivers even if they are not supported by the server.
	 * @return array Array of database drivers the server can handle
	 */
	public function getSupported($bReturnAll = false)
	{
		foreach ($this->_aDbs as $sKey => $aDbs)
		{	
			// Make sure extension is loaded in php.ini and that the driver exists for this specific license
			if (!@extension_loaded($aDbs['module']) 
				|| !file_exists(PHPFOX_DIR_LIB_CORE . 'database' . PHPFOX_DS . 'driver' . PHPFOX_DS . $aDbs['driver'] . '.class.php')
				|| $this->_aDbs[$sKey]['available'] === false)
			{			
				if (!$bReturnAll)
				{
					$this->_aDbs[$sKey]['available'] = false;
				}
				else 
				{
					unset($this->_aDbs[$sKey]);	
				}				
			}
		}
		
		return $this->_aDbs;
	}
	
	/**
	 * Gets a specific driver and returns all the information about it.
	 *
	 * @param string $sLabel Drivers name
	 * @return mixed Array if we can find the driver or FALSE if we cannot.
	 */
	public function getDriver($sLabel)
	{
		return (isset($this->_aDbs[$sLabel]) ? $this->_aDbs[$sLabel] : false);
	}
	
	/**
	 * Returns an SQL schema for a specific driver. Only used in development mode
	 * when exporting our database before a release.
	 *
	 * @param string $sName Name of the SQL driver
	 * @param string $sPrefix Optional string for the prefix of the table names
	 * @return array Array of SQL logic we transformed from the SQL schema which is a string of information
	 */
	public function getSchema($sName, $sPrefix = null)
	{
		$aDriver = $this->getDriver($sName);	
		
		$sSchema = PHPFOX_DIR_DEV . 'schema/' . $aDriver['schema'] . '.sql';
		
		if (!file_exists($sSchema))
		{
			return Phpfox_Error::set('Unable to load schema: ' . $sSchema);
		}
		
		$sContent = file_get_contents($sSchema);
		
		if ($sPrefix !== null)
		{
			$sContent = preg_replace('#phpfox_#i', $sPrefix, $sContent);
		}
		
		if ($aDriver['comments'] == 'remove_comments')
		{
			$this->removeComments($sContent);
		}
		else 
		{
			$this->removeRemarks($sContent);
		}
		
		$aSql = $this->splitSqlFile($sContent, $aDriver['delim']);		
		
		return $aSql;				
	}
	
	/**
	 * Split an SQL schema or string based on the delimiter used by the specific database driver.
	 *
	 * @param string $sql SQL code to parse
	 * @param string $delimiter Delimiter used to split the SQL code
	 * @return array Array of SQL lines of the string schema
	 */
	public function splitSqlFile($sql, $delimiter)
	{
		$sql = str_replace("\r" , '', $sql);
		$data = preg_split('/' . preg_quote($delimiter, '/') . '$/m', $sql);
	
		$data = array_map('trim', $data);
	
		// The empty case
		$end_data = end($data);
	
		if (empty($end_data))
		{
			unset($data[key($data)]);
		}
	
		return $data;
	}	
	
	/**
	 * Remove any SQL remarks from the output
	 *
	 * @param string $sContent SQL code to parse and remove remarks from
	 */
	public function removeRemarks(&$sContent)
	{
		$sContent = preg_replace('/\n{2,}/', "\n", preg_replace('/^#.*$/m', "\n", $sContent));
	}	
	
	/**
	 * Remove any SQL comments from the output
	 *
	 * @param string $sContent SQL code to parse and remove comments from
	 */	
	public function removeComments(&$sContent)
	{
		$lines = explode("\n", $sContent);
		$sContent = '';	
		$linecount = sizeof($lines);
	
		$in_comment = false;
		for ($i = 0; $i < $linecount; $i++)
		{
			if (trim($lines[$i]) == '/*')
			{
				$in_comment = true;
			}
	
			if (!$in_comment)
			{
				$sContent .= $lines[$i] . "\n";
			}
	
			if (trim($lines[$i]) == '*/')
			{
				$in_comment = false;
			}
		}
	
		unset($lines);		
	}
	
	/**
	 * Gets all the columns for a specific database table.
	 *
	 * @param string $sTable Database table to work with
	 * @param string $sDriver Optional command to identify what SQL driver we are working with
	 * @param mixed $oDb This can be an object or resource based on the SQL driver being used.
	 * @return array Returns an array of columns from a specific table.
	 */
	public function getColumns($sTable, $sDriver = null, &$oDb = null)
	{
		static $aColumns = array();
		
		if (isset($aColumns[$sTable]))
		{
			return $aColumns[$sTable];
		}		
		
		if ($oDb === null)
		{
			$oDb = Phpfox::getLib('database');
		}
		
		if (!in_array($sTable, $this->getTables($sDriver, $oDb)))
		{
			$aColumns[$sTable] = array();
			return $aColumns[$sTable];
		}		
		
		$aRows = $oDb->getRows("SHOW COLUMNS FROM {$sTable}");
		$oDb->freeResult();
		foreach ($aRows as $aRow)
		{
			$aColumns[$sTable][$aRow['Field']] = $aRow;
		}
		
		return $aColumns[$sTable];
	}
	
	/**
	 * Gets all the indexes for a specific database table.
	 *
	 * @param string $sTable Database table to work with
	 * @param string $sDriver Optional command to identify what SQL driver we are working with
	 * @param mixed $oDb This can be an object or resource based on the SQL driver being used.
	 * @return array Returns an array of indexes from a specific table.
	 */	
	public function getIndexes($sTable, $sDriver = null, &$oDb = null, $bReturnFull = false)
	{
		static $aKeys = array();
		
		if (isset($aKeys[$sTable]))
		{
			return $aKeys[$sTable];
		}
		
		if ($oDb === null)
		{
			$oDb = Phpfox::getLib('database');
		}
		
		if (!in_array($sTable, $this->getTables($sDriver, $oDb)))
		{
			$aColumns[$sTable] = array();
			return $aColumns[$sTable];
		}
		
		$aIndexes = $oDb->getRows("SHOW INDEX FROM {$sTable}");
		$oDb->freeResult();
		foreach ($aIndexes as $aIndex)
		{
			$aKeys[$sTable][] = ($bReturnFull ? $aIndex : $aIndex['Key_name']);
		}
		
		return $aKeys[$sTable];
	}
	
	/**
	 * Gets all the tables from the database.
	 *
	 * @param string $sDriver Optional command to identify what SQL driver we are working with
	 * @param mixed $oDb This can be an object or resource based on the SQL driver being used.
	 * @return array Returns an array of all the tables.
	 */
	public function getTables($sDriver = null, &$oDb = null)
	{
		static $aTables = array();
		
		if ($sDriver === null)
		{
			$sDriver = Phpfox::getParam(array('db', 'driver'));
		}
		
		if ($oDb === null)
		{
			$oDb = Phpfox::getLib('database');
		}
		
		if ($aTables)
		{			
			return $aTables;
		}		
		
		switch ($sDriver)
		{
			case 'mysql':
			case 'mysqli':
				
				$aRows = $oDb->getRows("SHOW TABLE STATUS");
				$oDb->freeResult();
				$aTables = array();
				foreach ($aRows as $aRow)
				{
					$aTables[] = $aRow['Name'];
				}		
				
				break;
			case 'mssql':
				
				$aRows = $oDb->getRows("
					SELECT *
					FROM INFORMATION_SCHEMA.TABLES
					WHERE TABLE_TYPE = 'BASE TABLE'
				");
				$oDb->freeResult();
				$aTables = array();
				foreach ($aRows as $aRow)
				{
					$aTables[] = $aRow['TABLE_NAME'];
				}				
				
				break;
			case 'postgres':
				
				$aRows = $oDb->getRows("
					SELECT * FROM information_schema.tables 
					WHERE table_schema = 'public' and table_type = 'BASE TABLE'
				");
				$oDb->freeResult();
				$aTables = array();
				foreach ($aRows as $aRow)
				{
					$aTables[] = $aRow['table_name'];
				}				
				
				break;				
			case 'oracle':
				
				$aRows = $oDb->getRows("
					SELECT * 
					FROM user_objects 
					WHERE object_type = 'TABLE'			
				");
				$oDb->freeResult();
				$aTables = array();
				foreach ($aRows as $aRow)
				{
					$aTables[] = strtolower($aRow['object_name']);
				}		
				
				break;				
			case 'sqlite':
			
				$aRows = $oDb->getRows("
					SELECT * 
					FROM SQLITE_MASTER 
					WHERE type='table'		
				");		
				$oDb->freeResult();
				$aTables = array();
				foreach ($aRows as $aRow)
				{
					$aTables[] = $aRow['tbl_name'];
				}			
				
				break;	
		}
		
		return $aTables;
	}
	
	/**
	 * Prepares SQL code to be transformed into PHP logic to later be used during an upgrade of the script.
	 *
	 * @param array $aTables Array of tables to export.
	 * @param mixed $oDb This can be an object or resource based on the SQL driver being used.
	 * @return array Returns an array of PHP logic to store and use at a later time.
	 */
	public function prepareSchema($aTables = array(), &$oDb = null)
	{
		if ($oDb === null)
		{
			$oDb = Phpfox::getLib('database');
		}		
		
		if ($aTables && is_array($aTables))
		{
			$aRows = array();
			foreach ($aTables as $iKey => $sTable)
			{
				$aRows[$iKey]['Name'] = Phpfox::getT($sTable);
			}
		}
		else 
		{
			$aRows = $oDb->getRows("SHOW TABLE STATUS");
		}
		
		$aSchema = array();
		$aMissed = array();
		foreach ($aRows as $aRow)
		{
			$aColumns = array();
			$aInfos = $oDb->getRows("SHOW COLUMNS FROM {$aRow['Name']}");
			foreach ($aInfos as $aInfo)
			{
				$sType = $aInfo['Type'];		
		
				$sType = preg_replace("/^int\((.*?)\)(.*)/i", "UINT:$1", $sType);
				$sType = preg_replace("/^smallint\((.*?)\)(.*)/i", "USINT", $sType);
				$sType = preg_replace("/^tinyint\((.*?)\)(.*)/i", "TINT:$1", $sType);
				$sType = preg_replace("/^mediumint\((.*?)\)(.*)/i", "UINT", $sType);
				$sType = preg_replace("/^varchar\((.*?)\)(.*)/i", "VCHAR:$1", $sType);
				$sType = preg_replace("/^char\((.*?)\)(.*)/i", "CHAR:$1", $sType);
				$sType = preg_replace("/^text$/i", "TEXT", $sType);
				$sType = preg_replace("/^mediumtext$/i", "MTEXT", $sType);
				$sType = preg_replace("/^decimal\(30,27\)(.*)/i", "MDECIMAL:", $sType);
				$sType = preg_replace("/^decimal\((.*?),2\)(.*)/i", "DECIMAL:$1", $sType);
				$sType = preg_replace("/^bigint\((.*?)\)(.*)/i", "BINT", $sType);
				
				if ($sType === $aInfo['Type'])
				{
					$aMissed[] = array_merge(array('Table' => $aRow['Name']), $aInfo);
				}
				
				$aColumns[$aInfo['Field']] = array(trim($sType), $aInfo['Default']);
				$aColumns[$aInfo['Field']][] = $aInfo['Extra'];
				$aColumns[$aInfo['Field']][] = $aInfo['Null'];
			}
			
			$aIndexes = $oDb->getRows("SHOW INDEX FROM {$aRow['Name']}");	
		
			$sPrimary = null;
			$aKeys = array();	
			foreach ($aIndexes as $aIndex)
			{		
				if ($aIndex['Key_name'] == 'PRIMARY')
				{
					$sPrimary = $aIndex['Column_name'];
				}
				else 
				{		
					$sKeyType = ($aIndex['Non_unique'] == 1 ? 'INDEX' : 'UNIQUE');
		
					if (!isset($aKeys[$aIndex['Key_name']]))
					{
						$aKeys[$aIndex['Key_name']] = $sKeyType . ',';
					}
					$aKeys[$aIndex['Key_name']] .= '' . $aIndex['Column_name'] . ',';
				}
			}	
			
			$aRow['Name'] = str_replace(Phpfox::getParam(array('db', 'prefix')), 'phpfox_', $aRow['Name']);
			
			$aSchema[$aRow['Name']]['COLUMNS'] = $aColumns;
			if ($sPrimary !== null)
			{
				$aSchema[$aRow['Name']]['PRIMARY_KEY'] = $sPrimary;
			}
			
			if (count($aKeys))
			{		
				foreach ($aKeys as $mKey => $mValue)
				{			
					$aParts = explode(',', rtrim(trim($mValue), ','));
					$iTotalKeys = count($aParts);
					$sIndexType = $aParts[0];
					
					$sFinalKey = "array('{$sIndexType}', ";
					if ($iTotalKeys == 2)
					{
						$sFinalKey .= "'{$aParts[1]}'";
					}
					else 
					{
						$sFinalKey .= "array(";
						for ($i = 1; $i < $iTotalKeys; $i++)
						{
							$sFinalKey .= "'{$aParts[$i]}',";
						}
						$sFinalKey = rtrim(trim($sFinalKey), ',') . ")";
					}			
					$sFinalKey .= ");";		
					
					eval('$aEval = ' . $sFinalKey . '');	
					
					$aSchema[$aRow['Name']]['KEYS'][$mKey] = $aEval;
				}
			}
		}	
		
		return $aSchema;	
	}
}

?>