<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * MSSQL Database Driver
 * NOTE: This driver is not in use and is still being tested thus no documentation was done for it just yet.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: mssql.class.php 1666 2010-07-07 08:17:00Z Raymond_Benc $
 */
class Database_Driver_Mssql
{	
	public $sSlaveServer;
	private $_hMaster = null;
	private $_hSlave = null;
	private $_sIsSlave = '';	
	
	public function connect($sHost, $sUser, $sPass, $sName, $sPort = false, $sPersistent = false)
	{		
		if ($sPort)
		{
			$sHost = $sHost . ':' . $sPort;
		}		
		
		// Connect to master db
		$this->_hMaster = ($sPersistent ? @mssql_pconnect($sHost, $sUser, $sPass) : @mssql_connect($sHost, $sUser, $sPass));

		// Unable to connect to master
		if (!$this->_hMaster)
		{
			// Cannot connect to the database
			return Phpfox_Error::set('Cannot connect to the database: ' . $this->_sqlError());
		}
		/*
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
			$this->_hSlave = $this->_connect($aServers[$iSlave][0], $aServers[$iSlave][1], $aServers[$iSlave][2]);
			
			// Check if we were able to connect to the slave
			if ($this->_hSlave)
			{
				if (!@mysql_select_db($sName, $this->_hSlave))
				{
					if (PHPFOX_DEBUG)
					{
						// Phpfox_Error::trigger('Cannot connect to slave database:' . $this->_sqlError(), E_USER_ERROR);
					}					
					$this->_hSlave = null;
				}
			}			
		}
		*/
		// If unable to connect to a slave or if no slave is called lets copy the master 
		if (!$this->_hSlave)
		{
			$this->_hSlave =& $this->_hMaster;
		}		
		
		// Attempt to connect to master table
		if (!@mssql_select_db($sName, $this->_hMaster))
		{
			return Phpfox_Error::set('Cannot connect to the database: ' . $this->_sqlError());
		}
		
		return true;
	}

	public function getVersion()
	{
		$hResult = @mssql_query("SELECT SERVERPROPERTY('productversion'), SERVERPROPERTY('productlevel'), SERVERPROPERTY('edition')", $this->_hMaster);

		$aRow = false;
		if ($hResult)
		{
			$aRow = @mssql_fetch_assoc($hResult);
			@mssql_free_result($hResult);
		}

		if ($aRow)
		{
			return implode(' ', $aRow);
		}

		return '';		
	}
	
	public function getServerInfo()
	{
		return 'MSSQL ' . $this->getVersion();
	}	
	
    /**
     * Performs sql query with error reporting and logging.
     * 
     * @todo Debug debug backtrace
     * @access public
     * @param  string $sSql query string
     * @return int query result handle
     */
	public function query($sSql, &$hLink = '')
    {
		if (!$hLink)
		{
			$hLink =& $this->_hMaster;	
		}
		
    	(PHPFOX_DEBUG  ? Phpfox_Debug::start('sql') : '');
    	
    	$hRes = mssql_query($sSql, $hLink);
        
        if (!$hRes)
        {
        	Phpfox_Error::trigger('Query Error:' . $this->_sqlError(), (PHPFOX_DEBUG ? E_USER_ERROR : E_USER_WARNING));
        }        
     
        (PHPFOX_DEBUG ? Phpfox_Debug::end('sql', array('sql' => $sSql, 'slave' => $this->_sIsSlave, 'rows' => (is_bool($hRes) ? '-' : mssql_num_rows($hRes)))) : '');
        
        $this->_sIsSlave = '';
        
        return $hRes;
    }    
    
    /** 
     * Returns one field from a row
     * 
     * @param string $sSql SQL query
     * @return mixed field value
     */
    public function getSlaveField($sSql)
    {
		$this->_sIsSlave = true;
		
    	return $this->_getField($sSql, $this->_hSlave);
    }     
    
    public function getSlaveRow($sSql, $bAssoc = true)
    {
    	$this->_sIsSlave = true;
    	
    	return $this->_getRow($sSql, $bAssoc, $this->_hSlave);
    }
    
    public function getSlaveRows($sSql, $bAssoc = true)
    {
    	$this->_sIsSlave = true;
    	
    	return $this->_getRows($sSql, $bAssoc, $this->_hSlave);
    }    
    
    public function getRow($sSql, $bAssoc = true)
    {
    	return $this->_getRow($sSql, $bAssoc, $this->_hMaster);
    }
    
    public function getRows($sSql, $bAssoc = true)
    {
    	return $this->_getRows($sSql, $bAssoc, $this->_hMaster);
    }    
    
    /** 
     * Returns one field from a row
     * 
     * @param string $sSql SQL query
     * @return mixed field value
     */
    public function getField($sSql)
    {
		return $this->_getField($sSql, $this->_hMaster);
    }    
    
    /**
     * Prepares string to store in db (performs  addslashes() )
     * 
     * @access	public
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

        $mParam = str_replace("'", "''", $mParam);

        return $mParam;
    }
    
    public function multiInsert($sTable, $aFields, $aValues)
    {
    	if (!isset($aValues[1]))
    	{
    		$aInserts = array();
    		for ($i = 0; $i < count($aFields); $i++)
    		{
    			$aInserts[$aFields[$i]] = $aValues[0][$i];
    		}
    		return $this->insert($sTable, $aInserts);
    	}
    	
    	$sSql = "INSERT INTO {$sTable} (" . implode(', ', array_values($aFields)) . ") ";
    	$sSql .= "\n";
    	foreach ($aValues as $aValue)
    	{
    		$sSql .= "\n SELECT ";
    		foreach ($aValue as $mValue)
    		{
    			if (is_null($mValue))
    			{
    				$sSql .= "NULL, ";
    			}
    			else 
    			{
    				$sSql .= "'" . $this->escape($mValue) . "', ";
    			}
    		}
    		$sSql = rtrim(trim($sSql), ',') . "\nUNION ALL";
    	}
    	$sSql = rtrim($sSql, 'UNION ALL');
    	
        if ($hRes = $this->query($sSql))
        {
            return $this->getLastId();
		}
    	
    	return 0;
    }
    
    /**
     * Performs insert of one row. Accepts values to insert as an array:
     *    'column1' => 'value1'
     *    'column2' => 'value2'
     * 
     * @access	public
     * @param string  $sTable    table name
     * @param array   $aValues   column and values to insert
     * @param boolean $bEscape true - method escapes values (with "), false - not escapes
     * @return int last ID (or 0 on error)
     */
    public function insert($sTable, $aValues, $bEscape = true, $bReturnQuery = false)
    {    	
    	$sCols = '' . implode(', ', array_keys($aValues)) . '';
        
        if ($bEscape)
        {
            $aValues = $this->escape($aValues);
            $sVals = "'".implode("', '", array_values($aValues))."'";
        }
        else
        {
            $sVals = implode(',', array_values($aValues));
        }

        $sSql = 'INSERT INTO '. $sTable .' '.
                '        ('. str_replace('`', '', $sCols).')'.
                ' VALUES ('.$sVals.')';
        if ($hRes = $this->query($sSql))
        {
        	if ($bReturnQuery)
        	{
        		return $sSql;
        	}

            return $this->getLastId();
		}

        return 0;
    }
    
    /**
     * Performs update of rows.
     * 
     * @access public
     * @param string $sTable  table name
     * @param array  $aValues array of column=>new_value
     * @param string $sCond   condition (without WHERE)
     * @param boolean $bEscape true - method escapes values (with "), false - not escapes
     * @return boolean true - update successfule, false - error
     */
    public function update($sTable, $aValues, $sCond, $bEscape = true)
    {
        if (!is_array($aValues))
        {
            return false;
		}

        $sSets = '';
        foreach ($aValues as $sCol=>$sValue)
        {
            if ($bEscape)
            {
                $sSets .= "" . $sCol . " = '" . $this->escape($sValue) . "', ";
            }
            else
            {
                $sSets .= ''.$sCol.' = '.$sValue.', ';
            }
        }
        $sSets[strlen($sSets)-2]='  ';
        $sSql = 'UPDATE '. $sTable .' SET '.$sSets.' WHERE '.$sCond;

        return $this->query($sSql);
    } 
    
    /**
     * Delete entry from the database
     * 
     * @access public
     * @param string $sTable is the table name
     * @param string $sQuery is the query we will run
     */
    public function delete($sTable, $sQuery)
    {
    	$this->query("DELETE FROM ". $sTable ." WHERE ". $sQuery);
    }    
    
    /**
     * Returns row id from last executed query
     * 
     * @access	public
     * @return int id of last INSERT operation
     */
    public function getLastId()
    {
		$result_id = @mssql_query('SELECT SCOPE_IDENTITY()', $this->_hMaster);
		if ($result_id)
		{
			if ($row = @mssql_fetch_assoc($result_id))
			{
				@mssql_free_result($result_id);
				return $row['computed'];
			}
			@mssql_free_result($result_id);
		}

		return false;        
    }

    public function freeResult()
	{
		if (is_resource($this->rQuery))
		{
			mssql_free_result($this->rQuery);
		}
	}
	
	public function affectedRows()
	{
		return mssql_rows_affected($this->_hMaster);
	}

	public function search($sType, $mFields, $sSearch)
	{
		$sSql = '';
		foreach ($mFields as $sField)
		{
			$sSql .= "OR ". $sField . " LIKE '%" . $this->escape($sSearch) . "%' ";	
		}
		return 'AND (' . trim(ltrim(trim($sSql), 'OR')) . ')';	
	} 
	
	public function select($sSelect)
	{
		if (!isset($this->_aQuery['select']))
		{
			$this->_aQuery['select'] = 'SELECT ';
		}
		
		$this->_aQuery['select'] .= $sSelect;
		
		return $this;
	}
	
	public function where($aConds)
	{
		$this->_aQuery['where'] = '';
		if (is_array($aConds) && count($aConds))
		{
			foreach ($aConds as $sValue)
			{
				$this->_aQuery['where'] .= $sValue . ' ';
			}
			$this->_aQuery['where'] = "WHERE " . trim(preg_replace("/^(AND|OR)(.*?)/i", "", trim($this->_aQuery['where'])));
		}
		else 
		{
			if (!empty($aConds))
			{
				$this->_aQuery['where'] .= 'WHERE ' . $aConds;	
			}
		}
		
		return $this;
	}
	
	public function from($sTable, $sAlias = '')
	{
		$this->_aQuery['table'] = 'FROM ' . $sTable . ($sAlias ? ' AS ' . $sAlias : '');		
		
		return $this;
	}
	
	public function order($sOrder)
	{
		if (!empty($sOrder))
		{		
			$this->_aQuery['order'] = 'ORDER BY ' . $sOrder;
		}
		
		return $this;
	}
	
	public function group($sGroup)
	{
		$this->_aQuery['group'] = 'GROUP BY ' . $sGroup;
		
		return $this;
	}

	public function having($sHaving)
	{
		$this->_aQuery['having'] = 'HAVING ' . $sHaving;
		
		return $this;
	}	
	
	public function leftJoin($sTable, $sAlias, $mParam = null)
	{
		$this->_join('LEFT JOIN', $sTable, $sAlias, $mParam);
		
		return $this;
	}
	
	public function innerJoin($sTable, $sAlias, $mParam = null)
	{
		$this->_join('INNER JOIN', $sTable, $sAlias, $mParam);
		
		return $this;
	}	
	
	public function join($sTable, $sAlias, $mParam = null)
	{
		$this->_join('JOIN', $sTable, $sAlias, $mParam);
		
		return $this;
	}	
	
	public function limit($iPage, $sLimit = null, $iCnt = null)
	{		
		if ($sLimit === null && $iCnt === null)
		{			
			$this->_aQuery['select'] = 'SELECT TOP ' . $iPage . ' ' . substr($this->_aQuery['select'], 6);			
			
			return $this;
		}
		
		$iOffset = Phpfox::getLib('pager')->getOffset($iPage, $sLimit, $iCnt);
		
		$this->_aQuery['select'] = 'SELECT TOP ' . ($iOffset + $sLimit) . ' ' . substr($this->_aQuery['select'], 6);	
		
		return $this;
	}
	
	public function execute($sType, $aParams = array())
	{
		$sSql = $this->_aQuery['select'] . "\n";
		$sSql .= $this->_aQuery['table'] . "\n";
		$sSql .= (isset($this->_aQuery['join']) ? $this->_aQuery['join'] . "\n" : '');
		$sSql .= (isset($this->_aQuery['where']) ? $this->_aQuery['where'] . "\n" : '');
		$sSql .= (isset($this->_aQuery['group']) ? $this->_aQuery['group'] . "\n" : '');
		$sSql .= (isset($this->_aQuery['having']) ? $this->_aQuery['having'] . "\n" : '');
		$sSql .= (isset($this->_aQuery['order']) ? $this->_aQuery['order'] . "\n" : '');
		$sSql .= (isset($this->_aQuery['limit']) ? $this->_aQuery['limit'] . "\n" : '');
		$sSql .= "/* OO Query */";		
	
		$this->_aQuery = array();
		
		$bDoCache = false;
		if (isset($aParams['cache']) && $aParams)
		{
			$bDoCache = true;	
			$oCache = Phpfox::getLib('cache');
		}
		
		if ($bDoCache)
		{
			$sCacheId = $oCache->set($aParams['cache_name']);
			if ((isset($aParams['cache_limit']) && ($aRows = $oCache->get($sCacheId, $aParams['cache_limit']))) || ($aRows = $oCache->get($sCacheId)))
			{
				return $aRows;
			}
		}
		
		if (isset($aParams['count']))
		{

		}
		
		switch($sType)
		{
			case 'getSlaveRows':
				$aRows = $this->getSlaveRows($sSql);
				break;
			case 'getSlaveRow':
				$aRows = $this->getSlaveRow($sSql);
				break;				
			case 'getRow':
				$aRows = $this->getRow($sSql);
				break;	
			case 'getRows':
				$aRows = $this->getRows($sSql);
				break;	
			case 'getField':
				$aRows = $this->getField($sSql);
				break;				
			case 'getSlaveField':
				$aRows = $this->getSlaveField($sSql);
				break;
			default:
				Phpfox_Error::trigger('Invalid execute on SQL query.', E_USER_ERROR);
		}

		if ($bDoCache)
		{
			$oCache->save($sCacheId, $aRows);
		}
		
		if (isset($aParams['free_result']))
		{
			$this->freeResult();
		}
		
		return $aRows;		
	}
	
	public function sqlReport($sQuery)
	{	
		if (!preg_match('/^SELECT/', $sQuery))
		{
			return '';
		}
		
		$bTable = false;
		$sHtml = '';
		@mssql_query('SET SHOWPLAN_TEXT ON;', $this->_hMaster);
		if ($hResult = @mssql_query($sQuery, $this->_hMaster))
		{
			@mssql_next_result($hResult);
			while ($aRow = @mssql_fetch_row($hResult))
			{
				list($bTable, $sData) = Phpfox_Debug::addRow($bTable, $aRow);
					
				$sHtml .= $sData;
			}
		}
		@mssql_query('SET SHOWPLAN_TEXT OFF;', $this->_hMaster);
		@mssql_free_result($hResult);

		if ($bTable)
		{
			$sHtml .= '</table>';
		}		

		return $sHtml;
	}	
	
	public function dropTables($aDrops, $aVals = array())
	{
		foreach ($aDrops as $sDrop)
		{
			$this->query("DROP TABLE {$sDrop}");		
		}			
	}	
	
	private function _join($sType, $sTable, $sAlias, $mParam = null)
	{
		if (!isset($this->_aQuery['join']))
		{
			$this->_aQuery['join'] = '';
		}
		$this->_aQuery['join'] .= $sType . " " . $sTable . " AS " . $sAlias;
		if (is_array($mParam))
		{
			$this->_aQuery['join'] .= "\n\tON(";
			foreach ($mParam as $sValue)
			{
				$this->_aQuery['join'] .= $sValue . " ";
			}
		}
		else 
		{
			$this->_aQuery['join'] .= "\n\tON({$mParam}";
		}
		$this->_aQuery['join'] = preg_replace("/^(AND|OR)(.*?)/i", "", trim($this->_aQuery['join'])) . ")\n";		
	}
	
	/**
	 * @todo Fix this
	 *
	 * @return unknown
	 */
	private function _sqlError()
	{
		return mysql_error();
	}

    /**
     * Returns exactly one row as array. If there is number of rows
     * satisfying the condition then the first one will be returned.
     * 
     * @access	public
     * @param string $sSql   select query
     * @param string $bAssoc  type of returned rows array
     * @return array exact one row (first if multiply row selected): or false on error
     */
	private function _getRow($sSql, $bAssoc, &$hLink)
    {
		// Run the query
        $hRes = $this->query($sSql, $hLink);

        // Get the array
        $aRes =  mssql_fetch_array($hRes, ($bAssoc ? MSSQL_ASSOC : MSSQL_NUM));

        return $aRes ? $aRes : array();
    } 
    
    /**
     * Gets data returned by sql query
     * 
     * @access	public
     * @param string $sSql    select query
     * @param string $bAssoc  type of returned rows array
     * @return array selected rows (each row is array of specified type) or emprt array on error
     */
    private function _getRows($sSql, $bAssoc = true, &$hLink)
    {
        $aRows = array();
        $bAssoc = ($bAssoc ? MSSQL_ASSOC : MSSQL_NUM);

		// Run the query
        $this->rQuery = $this->query($sSql, $hLink);

        // Put it into a while look
        while($aRow = mssql_fetch_array($this->rQuery, $bAssoc))
        {
        	// Create an array for the data
            $aRows[] = $aRow;
        }

        return $aRows; //empty array on error
    }	
    	
    /** 
     * Returns one field from a row
     * 
     * @param string $sSql SQL query
     * @return mixed field value
     */
    private function _getField($sSql, &$hLink)
    {
        $sRes = '';
        $aRow = $this->getRow($sSql, false, $hLink);
        if ($aRow)
        {
            $sRes = $aRow[0];
        }
        return $sRes;
    }     
}

?>