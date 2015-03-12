<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Database driver for MySQL.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: mysql.class.php 3160 2011-09-21 10:46:04Z Miguel_Espinoza $
 */
class Phpfox_Database_Driver_Mysql extends Phpfox_Database_Dba
{	
	/**
	 * IP/Host of the slave server we are currently using.
	 *
	 * @var unknown_type
	 */
	public $sSlaveServer;
	
	/**
	 * Resource for the MySQL master server
	 *
	 * @var resource
	 */
	protected $_hMaster = null;
	
	/**
	 * Resource for the MySQL salve server
	 *
	 * @var resource
	 */
	protected $_hSlave = null;	
	
	/**
	 * Check to see if we are using slave servers
	 *
	 * @var bool
	 */
	protected $_bIsSlave = false;	
	
	/**
	 * Holds an array of all the MySQL functions we use. We store
	 * it here because we also provide support for MySQLi, which extends
	 * this class when it use.
	 *
	 * @var array
	 */
	protected $_aCmd = array(
		'mysql_query' => 'mysql_query',
		'mysql_connect' => 'mysql_connect',
		'mysql_pconnect' => 'mysql_pconnect',
		'mysql_select_db' => 'mysql_select_db',
		'mysql_num_rows' => 'mysql_num_rows',
		'mysql_fetch_array' => 'mysql_fetch_array',
		'mysql_real_escape_string' => 'mysql_real_escape_string',
		'mysql_insert_id' => 'mysql_insert_id',
		'mysql_fetch_assoc' => 'mysql_fetch_assoc',
		'mysql_free_result' => 'mysql_free_result',
		'mysql_error' => 'mysql_error',
		'mysql_affected_rows' => 'mysql_affected_rows',
		'mysql_get_server_info' => 'mysql_get_server_info',
		'mysql_close' => 'mysql_close'
	);
	
	/**
	 * Makes a connection to the MySQL database
	 *
	 * @param string $sHost Hostname or IP
	 * @param string $sUser User used to log into MySQL server
	 * @param string $sPass Password used to log into MySQL server. This can be blank.
	 * @param string $sName Name of the database.
	 * @param mixed $sPort Port number (int) or false by default since we do not need to define a port.
	 * @param bool $sPersistent False by default but if you need a persistent connection set this to true.
	 * @return bool If we were able to connect we return true, however if it failed we return false and a error message why.
	 */
	public function connect($sHost, $sUser, $sPass, $sName, $sPort = false, $sPersistent = false)
	{
		// Connect to master db
		$this->_hMaster = $this->_connect($sHost, $sUser, $sPass, $sPort, $sPersistent);		

		// Unable to connect to master
		if (!$this->_hMaster)
		{
			// Cannot connect to the database
			return Phpfox_Error::set('Cannot connect to the database: ' . $this->_sqlError());
		}
		
		// Check if we have any slave servers
		if (Phpfox::getParam(array('db', 'slave')))
		{
			// Get the slave array
			$aServers = Phpfox::getParam(array('db', 'slave_servers'));
			
			// Get a random slave to use if there is more then one slave
			$iSlave = (count($aServers) > 1 ? rand(0, (count($aServers) - 1)) : 0);
			
			if (PHPFOX_DEBUG)
			{
				$this->sSlaveServer = $aServers[$iSlave][0];
			}

			// Connect to slave
			$this->_hSlave = $this->_connect($aServers[$iSlave][0], $aServers[$iSlave][1], $aServers[$iSlave][2], $aServers[$iSlave][3], $aServers[$iSlave][4]);
			
			// Check if we were able to connect to the slave
			if ($this->_hSlave)
			{
				if (!@($this->_aCmd['mysql_select_db'] == 'mysqli_select_db' ? $this->_aCmd['mysql_select_db']($this->_hSlave, $sName) : $this->_aCmd['mysql_select_db']($sName, $this->_hSlave)))
				{
					if (PHPFOX_DEBUG)
					{
						// Phpfox_Error::trigger('Cannot connect to slave database:' . $this->_sqlError(), E_USER_ERROR);
					}					
					$this->_hSlave = null;
				}
			}			
		}
		
		// If unable to connect to a slave or if no slave is called lets copy the master 
		if (!$this->_hSlave)
		{
			$this->_hSlave =& $this->_hMaster;
		}		
		
		// Attempt to connect to master table
		if (!@($this->_aCmd['mysql_select_db'] == 'mysqli_select_db' ? $this->_aCmd['mysql_select_db']($this->_hMaster, $sName) : $this->_aCmd['mysql_select_db']($sName, $this->_hMaster)))
		{
			return Phpfox_Error::set('Cannot connect to the database: ' . $this->_sqlError());
		}

		return true;
	}

	/**
	 * Returns the MySQL version
	 *
	 * @return string
	 */
	public function getVersion()
	{
		return @$this->_aCmd['mysql_get_server_info']($this->_hMaster);	
	}
	
	/**
	 * Returns MySQL server information. Here we only identify that it is MySQL and the version being used.
	 *
	 * @return string
	 */
	public function getServerInfo()
	{
		return 'MySQL ' . $this->getVersion();
	}	
	
    /**
     * Performs sql query with error reporting and logging.
     * 
     * @see mysql_query()
     * @param  string $sSql MySQL query to perform
     * @param resource $hLink MySQL resource. If nothing is passed we load the default master server.
     * @return resource Returns the MYSQL resource from the function mysql_query()
     */
	public function query($sSql, &$hLink = '')
    {
		if (!$hLink)
		{
			$hLink =& $this->_hMaster;	
		}
		
    	(PHPFOX_DEBUG  ? Phpfox_Debug::start('sql') : '');

    	$hRes = @($this->_aCmd['mysql_query'] == 'mysqli_query' ? $this->_aCmd['mysql_query']($hLink, $sSql) : $this->_aCmd['mysql_query']($sSql, $hLink));
		
    	if (defined('PHPFOX_LOG_SQL') && Phpfox::getLib('file')->isWritable(PHPFOX_DIR_FILE . 'log' . PHPFOX_DS))
    	{    		
    		$hFile = fopen(PHPFOX_DIR_FILE . 'log' . PHPFOX_DS . 'phpfox_query_' . date('d.m.y', PHPFOX_TIME) . '_' . md5(Phpfox::getVersion()) . '.php', 'a');
    		fwrite($hFile, '<?php defined(\'PHPFOX\') or exit(\'NO DICE!\');  ?>' . "##\n{$sSql}##\n");
    		fclose($hFile);
    	}    	
		
        if (!$hRes)
        {
        	Phpfox_Error::trigger('Query Error:' . $this->_sqlError(), (PHPFOX_DEBUG ? E_USER_ERROR : E_USER_WARNING));
        }        
     
        (PHPFOX_DEBUG ? Phpfox_Debug::end('sql', array('sql' => $sSql, 'slave' => $this->_bIsSlave, 'rows' => (is_bool($hRes) ? '-' : @$this->_aCmd['mysql_num_rows']($hRes)))) : '');
        
        $this->_bIsSlave = false;        
        
        return $hRes;
    }  
    
    /**
     * Prepares string to store in db (performs  addslashes() )
     * 
     * @param mixed $mParam string or array of string need to be escaped
     * @return mixed escaped string or array of escaped strings
     */
    public function escape($mParam)
    {
        if (is_array($mParam))
        {
            return array_map(array(&$this, 'escape'), $mParam);
		}

        if (get_magic_quotes_gpc())
        {
            $mParam = stripslashes($mParam);
        }

        $mParam = @($this->_aCmd['mysql_real_escape_string'] == 'mysqli_real_escape_string' ? $this->_aCmd['mysql_real_escape_string']($this->_hMaster, $mParam) : $this->_aCmd['mysql_real_escape_string']($mParam));

        return $mParam;
    }   
    
    /**
     * Returns row id from last executed query
     * 
     * @return int id of last INSERT operation
     */
    public function getLastId()
    {
        return @$this->_aCmd['mysql_insert_id']($this->_hMaster);
    }

    /**
     * Frees the MySQL results
     *
     */
    public function freeResult()
	{
		if (is_resource($this->rQuery))
		{
			@$this->_aCmd['mysql_free_result']($this->rQuery);
		}
	}
	
	/**
	 * Returns the affected rows.
	 *
	 * @return array
	 */
	public function affectedRows()
	{
		return @$this->_aCmd['mysql_affected_rows']($this->_hMaster);
	}

	/**
	 * MySQL has special search functions, so we try to use that here.
	 *
	 * @param string $sType Type of search we plan on doing.
	 * @param mixed $mFields Array of fields to search
	 * @param string $sSearch Value to search for.
	 * @return string MySQL query to use when performing the search
	 */
	public function search($sType, $mFields, $sSearch)
	{
		switch ($sType)
		{
			case 'full':
				return "AND MATCH(" . implode(',', $mFields) . ") AGAINST ('+" . $this->escape($sSearch) . "' IN BOOLEAN MODE)";
				break;
			case 'like%':
				$sSql = '';
				foreach ($mFields as $sField)
				{
					$sSql .= "OR ". $sField . " LIKE '%" . $this->escape($sSearch) . "%' ";	
				}
				return 'AND (' . trim(ltrim(trim($sSql), 'OR')) . ')';
				break;
		}		
	}
	
	/**
	 * During development you may need to check how your queries are being executed and how long they are taking. This
	 * routine uses MySQL's EXPLAIN to return useful information.
	 *
	 * @param string $sQuery MySQL query to check.
	 * @return string HTML output of the information we have found about the query.
	 */
	public function sqlReport($sQuery)
	{	
		$sHtml = '';
		$sExplainQuery = $sQuery;
		if (preg_match('/UPDATE ([a-z0-9_]+).*?WHERE(.*)/s', $sQuery, $m))
		{
			$sExplainQuery = 'SELECT * FROM ' . $m[1] . ' WHERE ' . $m[2];
		}
		elseif (preg_match('/DELETE FROM ([a-z0-9_]+).*?WHERE(.*)/s', $sQuery, $m))
		{
			$sExplainQuery = 'SELECT * FROM ' . $m[1] . ' WHERE ' . $m[2];
		}

		$sExplainQuery = trim($sExplainQuery);		
		
		if (preg_match('/SELECT/se', $sExplainQuery) || preg_match('/^\(SELECT/', $sExplainQuery))
		{
			$bTable = false;			

			if ($hResult = @($this->_aCmd['mysql_query'] == 'mysqli_query' ? $this->_aCmd['mysql_query']($this->_hMaster, "EXPLAIN $sExplainQuery") : $this->_aCmd['mysql_query']("EXPLAIN $sExplainQuery", $this->_hMaster)))
			{
				while ($aRow = @$this->_aCmd['mysql_fetch_assoc']($hResult))
				{					
					list($bTable, $sData) = Phpfox_Debug::addRow($bTable, $aRow);
					
					$sHtml .= $sData;
				}
			}
			@$this->_aCmd['mysql_free_result']($hResult);

			if ($bTable)
			{
				$sHtml .= '</table>';
			}
		}
				
		return $sHtml;
	}

	/**
	 * Check if a field in the database is set to null
	 *
	 * @param string $sField The field we plan to check
	 * @return string Returns MySQL IS NULL usage
	 */
	public function isNull($sField)
	{
		return '' . $sField . ' IS NULL';
	}
	
	/**
	 * Check if a field in the database is set not null
	 *
	 * @param string $sField The field we plan to check
	 * @return string Returns MySQL IS NOT NULL usage
	 */	
	public function isNotNull($sField)
	{
		return '' . $sField . ' IS NOT NULL';
	}	
	
	/**
	 * Adds an index to a table.
	 *
	 * @param string $sTable Database table.
	 * @param string $sField List of indexes to add.
	 * @return resource Returns the MySQL resource from mysql_query()
	 */
	public function addIndex($sTable, $sField)
	{
		$sSql = 'ALTER TABLE ' . $sTable . ' ADD INDEX (' . $sField . ')';
		
		return $this->query($sSql);
	}
	
	/**
	 * Adds fields to a database table.
	 *
	 * @param array $aParams Array of fields and what type each field is.
	 * @return resource Returns the MySQL resource from mysql_query()
	 */
	public function addField($aParams)
	{
		$sSql = 'ALTER TABLE ' . $aParams['table'] . ' ADD ' . $aParams['field'] . ' ' . $aParams['type'] . '';
		if (isset($aParams['attribute']))
		{
			$sSql .= ' ' . $aParams['attribute'] . ' ';
		}		
		if (isset($aParams['null']))
		{
			$sSql .= ' ' . ($aParams['null'] ? 'NULL' : 'NOT NULL') . ' ';
		}		
		if (isset($aParams['default']))
		{
			$sSql .= ' ' . $aParams['default'] . ' ';
		}
		
		return $this->query($sSql);
	}
	
	/**
	 * Drops a specific field from a table.
	 *
	 * @param string $sTable Database table
	 * @param string $sField Name of the field to drop
	 * @return resource Returns the MySQL resource from mysql_query()
	 */
	public function dropField($sTable, $sField)
	{
		return $this->query('ALTER TABLE ' . $sTable . ' DROP ' . $sField. '');
	}
	
	/**
	 * Checks if a field already exists or not.
	 *
	 * @param string $sTable Database table to check
	 * @param string $sField Name of the field to check
	 * @return bool If the field exists we return true, if not we return false.
	 */
	public function isField($sTable, $sField)
	{
		$aRows = $this->getRows("SHOW COLUMNS FROM {$sTable}");
		foreach ($aRows as $aRow)
		{
			if (strtolower($aRow['Field']) == strtolower($sField))
			{
				return true;
			}
		}

		return false;
	}
	
		/**
	 * Checks if a field already exists or not.
	 *
	 * @param string $sTable Database table to check
	 * @param string $sField Name of the field to check
	 * @return bool If the field exists we return true, if not we return false.
	 */
	public function isIndex($sTable, $sField)
	{
		$aRows = $this->getRows("SHOW INDEX FROM {$sTable}");
		foreach ($aRows as $aRow)
		{
			if (strtolower($aRow['Key_name']) == strtolower($sField))
			{
				return true;
			}
		}

		return false;
	}
	
	/**
	 * Returns the status of the table.
	 *
	 * @return array Returns information about the table in an array.
	 */
	public function getTableStatus()
	{
		return $this->_getRows('SHOW TABLE STATUS', true, $this->_hMaster);
	}
	
	/**
	 * Checks if a database table exists.
	 *
	 * @param string $sTable Table we are looking for.
	 * @return bool If the table exists we return true, if not we return false.
	 */
	public function tableExists($sTable)
	{
		$aTables = $this->getTableStatus();
		
		foreach ($aTables as $aTable)
		{
			if ($aTable['Name'] == $sTable)
			{
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * Optimizes a table
	 *
	 * @param string $sTable Table to optimize
	 * @return resource Returns the MySQL resource from mysql_query()
	 */
	public function optimizeTable($sTable)
	{
		return $this->query('OPTIMIZE TABLE ' . $this->escape($sTable));
	}
	
	/**
	 * Repairs a table
	 *
	 * @param string $sTable Table to repair
	 * @return resource Returns the MySQL resource from mysql_query()
	 */	
	public function repairTable($sTable)
	{
		return $this->query('REPAIR TABLE ' . $this->escape($sTable));
	}	
	
	/**
	 * Checks if we can backup the database or not. This depends on the server itself.
	 * We currently only support unix based servers.
	 *
	 * @return bool Returns true if we can backup or false if we can't
	 */
	public function canBackup()
	{
		return ((function_exists("exec") AND $checkDump = @str_replace("mysqldump:","",exec("whereis mysqldump")) AND !empty($checkDump)) ? true : false);
	}
	
	/**
	 * Performs a backup of the database and places the backup in a specific area on the server
	 * based on what the admins decide.
	 *
	 * @param string $sPath Full path to where to place the backup.
	 * @return string Full path to where the backup is located including the file name.
	 */
	public function backup($sPath)
	{
		if (!is_dir($sPath))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.the_path_you_provided_is_not_a_valid_directory'));
		}
		
		if (!Phpfox::getLib('file')->isWritable($sPath, true))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.the_path_you_provided_is_not_a_valid_directory'));
		}
		
		$sPath = rtrim($sPath, PHPFOX_DS) . PHPFOX_DS;
		$sFileName = uniqid() . '.sql';
		$sZipName = 'sql-backup-' . date('Y-d-m', PHPFOX_TIME) . '-' . uniqid() . '.tar.gz';
		
		shell_exec("mysqldump --skip-add-locks --disable-keys --skip-comments -h". Phpfox::getParam(array('db','host')) ." -u". Phpfox::getParam(array('db','user')) ." -p". Phpfox::getParam(array('db','pass')) ." ". Phpfox::getParam(array('db','name')) ." > " . $sPath . $sFileName ."");
		chdir($sPath);
		shell_exec("tar -czf ". $sZipName ." " . $sFileName ."");
		chdir(PHPFOX_DIR);
		unlink($sPath . $sFileName);
		
		return $sPath . $sZipName;
	}
	
    /**
     * Close the SQL connection
     * 
     * @return bool TRUE on success, FALSE on failure
     */
    public function close()
    {
        return @$this->_aCmd['mysql_close']($this->_hMaster);
    }	

    /**
     * Returns exactly one row as array. If there is number of rows
     * satisfying the condition then the first one will be returned.
     * 
     * @param string $sSql   select query
     * @param string $bAssoc  type of returned rows array
     * @return array exact one row (first if multiply row selected): or false on error
     */
	protected function _getRow($sSql, $bAssoc, &$hLink)
    {
		// Run the query
        $hRes = $this->query($sSql, $hLink);

        // Get the array
        $aRes =  $this->_aCmd['mysql_fetch_array']($hRes, ($bAssoc ? MYSQL_ASSOC : MYSQL_NUM));

        return $aRes ? $aRes : array();
    } 
    
    /**
     * Gets data returned by sql query
     * 
     * @param string $sSql    select query
     * @param string $bAssoc  type of returned rows array
     * @return array selected rows (each row is array of specified type) or emprt array on error
     */
    protected function _getRows($sSql, $bAssoc = true, &$hLink)
    {
        $aRows = array();
        $bAssoc = ($bAssoc ? MYSQL_ASSOC : MYSQL_NUM);

		// Run the query
        $this->rQuery = $this->query($sSql, $hLink);

        // Put it into a while look
        while($aRow = $this->_aCmd['mysql_fetch_array']($this->rQuery, $bAssoc))
        {
        	// Create an array for the data
            $aRows[] = $aRow;
        }

        return $aRows; //empty array on error
    }
    
	/**
	 * Makes a connection to the MySQL database
	 *
	 * @param string $sHost Hostname or IP
	 * @param string $sUser User used to log into MySQL server
	 * @param string $sPass Password used to log into MySQL server. This can be blank.
	 * @param string $sName Name of the database.
	 * @param mixed $sPort Port number (int) or false by default since we do not need to define a port.
	 * @param bool $sPersistent False by default but if you need a persistent connection set this to true.
	 * @return bool If we were able to connect we return true, however if it failed we return false and a error message why.
	 */
	private function _connect($sHost, $sUser, $sPass, $sPort = false, $sPersistent = false)
	{		
		if ($sPort)
		{
			$sHost = $sHost . ':' . $sPort;
		}
		
		if ($hLink = ($sPersistent ?  @$this->_aCmd['mysql_pconnect']($sHost, $sUser, $sPass) : @$this->_aCmd['mysql_connect']($sHost, $sUser, $sPass)))
		{
			return $hLink;
		}
		
		return false;
	}
	
	/**
	 * Returns any SQL errors.
	 *
	 * @return string String of error message in case something failed.
	 */
	private function _sqlError()
	{
		return ($this->_aCmd['mysql_error'] == 'mysqli_error' ? @$this->_aCmd['mysql_error']($this->_hMaster) : @$this->_aCmd['mysql_error']());
	}	
}

?>
