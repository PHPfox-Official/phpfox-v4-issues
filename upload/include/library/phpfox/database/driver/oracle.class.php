<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Oracle Database Driver
 * NOTE: This driver is not in use and is still being tested thus no documentation was done for it just yet.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: oracle.class.php 1666 2010-07-07 08:17:00Z Raymond_Benc $
 */
class Database_Driver_Oracle
{	
	public $sSlaveServer;
	private $_hMaster = null;
	private $_hSlave = null;
	private $_sIsSlave = '';	
	private $_sLastQuery;
	
	public function connect($sHost, $sUser, $sPass, $sName, $sPort = false, $sPersistent = false)
	{		
		// Connect to master db
		$this->_hMaster = $this->_connect($sHost, $sUser, $sPass);		

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
			$this->_hSlave = $this->_connect($aServers[$iSlave][0], $aServers[$iSlave][1], $aServers[$iSlave][2]);		
		}
		
		// If unable to connect to a slave or if no slave is called lets copy the master 
		if (!$this->_hSlave)
		{
			$this->_hSlave =& $this->_hMaster;
		}

		return true;
	}
	
	public function getVersion()
	{
		return @ociserverversion($this->_hMaster);
	}
	
	public function getServerInfo()
	{
		return $this->getVersion();
	}
	
    public function getResource()
    {
    	return $this->_hMaster;
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
    	
    	$this->_sLastQuery = $sSql;
    	
    	$hRes = @ociparse($hLink, $sSql);    	
        
        if (!$hRes)
        {
        	Phpfox_Error::trigger('Query Error:' . $this->_sqlError(), (PHPFOX_DEBUG ? E_USER_ERROR : E_USER_WARNING));
        }        
     
        ociexecute($hRes);
        
        (PHPFOX_DEBUG ? Phpfox_Debug::end('sql', array('sql' => $sSql, 'slave' => $this->_sIsSlave, 'rows' => (is_bool($hRes) ? '-' : ocirowcount($hRes)))) : '');
        
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
    	foreach ($aValues as $mValue)
    	{
    		$aInserts = array();
	    	for ($i = 0; $i < count($mValue); $i++)
	    	{
	    		$aInserts[$aFields[$i]] = (is_null($mValue[$i]) ? null : $mValue[$i]);    		
	    	}  
	    	$this->insert($sTable, $aInserts);
    	}
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
		static $aSeq = array();
    	
    	if (!empty($this->_sLastQuery))
    	{
			if (preg_match('#^INSERT[\t\n ]+INTO[\t\n ]+([a-z0-9\_\-]+)#is', $this->_sLastQuery, $aTable))
			{			
				$sTable = substr_replace($aTable[1], '', 0, strlen(Phpfox::getParam(array('db', 'prefix'))));				
				$sSeq = Phpfox::getParam(array('db', 'prefix')) . $sTable . '_seq';
				$query = 'SELECT ' . $sSeq . '.currval FROM DUAL';		
							
				if (!$aSeq)
				{
					$aRows = $this->getRows("
						SELECT SEQUENCE_NAME 
						FROM all_sequences		
						WHERE SEQUENCE_OWNER = '" . strtoupper($this->escape(Phpfox::getParam(array('db', 'user')))) . "'
					");			
					foreach ($aRows as $aRow)
					{
						$aSeq[] = $aRow['sequence_name'];
					}
				}

				if (!in_array(strtoupper($sSeq), $aSeq))
				{
					return false;
				}			
				
				$stmt = @ociparse($this->_hMaster, $query);
				@ociexecute($stmt, OCI_DEFAULT);

				$temp_result = @ocifetchinto($stmt, $temp_array, OCI_ASSOC + OCI_RETURN_NULLS);
				@ocifreestatement($stmt);

				if ($temp_result)
				{
					return $temp_array['CURRVAL'];
				}
				else
				{
					return false;
				}
			}
			
			$this->_sLastQuery = '';
		}

		return false;
    }

    public function freeResult()
	{
		if (is_resource($this->rQuery))
		{
			@ocifreestatement($this->rQuery);
		}
	}
	
	public function affectedRows()
	{
		return ocirowcount($this->_hMaster);
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
		$this->_aQuery['table'] = 'FROM ' . $sTable . ($sAlias ? ' ' . $sAlias : '');		
		
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
			$this->_aQuery['limit'] = $sLimit;
			
			return $this;
		}
		
		$iOffset = Phpfox::getLib('pager')->getOffset($iPage, $sLimit, $iCnt);		
		
		$this->_aQuery['limit'] = array($iOffset,  ($iOffset + $sLimit));
		
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
		
		if (isset($this->_aQuery['limit']))
		{
			if (!is_array($this->_aQuery['limit']))
			{
				$this->_aQuery['limit'] = array(0, $this->_aQuery['limit']);
			}
			$sSql = 'SELECT * FROM (SELECT /*+ FIRST_ROWS */ rownum AS xrownum, a.* FROM (' . $sSql . ') a WHERE rownum <= ' . $this->_aQuery['limit'][1] . ') WHERE xrownum > ' . $this->_aQuery['limit'][0];
		}
	
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
	
	public function sqlReport($query)
	{	
		$sHtml = '';				
				$html_table = false;

				// Grab a plan table, any will do
				$sql = "SELECT table_name
					FROM USER_TABLES
					WHERE table_name LIKE '%PLAN_TABLE%'";
				$stmt = ociparse($this->_hMaster, $sql);
				ociexecute($stmt);
				$result = array();

				if (ocifetchinto($stmt, $result, OCI_ASSOC + OCI_RETURN_NULLS))
				{
					$table = $result['TABLE_NAME'];

					// This is the statement_id that will allow us to track the plan
					$statement_id = substr(md5($query), 0, 30);

					// Remove any stale plans
					$stmt2 = ociparse($this->_hMaster, "DELETE FROM $table WHERE statement_id='$statement_id'");
					ociexecute($stmt2);
					ocifreestatement($stmt2);

					// Explain the plan
					$sql = "EXPLAIN PLAN
						SET STATEMENT_ID = '$statement_id'
						FOR $query";
					$stmt2 = ociparse($this->_hMaster, $sql);
					ociexecute($stmt2);
					ocifreestatement($stmt2);

					// Get the data from the plan
					$sql = "SELECT operation, options, object_name, object_type, cardinality, cost
						FROM plan_table
						START WITH id = 0 AND statement_id = '$statement_id'
						CONNECT BY PRIOR id = parent_id
							AND statement_id = '$statement_id'";
					$stmt2 = ociparse($this->_hMaster, $sql);
					ociexecute($stmt2);

					$row = array();
					while (ocifetchinto($stmt2, $row, OCI_ASSOC + OCI_RETURN_NULLS))
					{						
						list($html_table, $sData) = Phpfox_Debug::addRow($html_table, $row);
						
						$sHtml .= $sData;						
					}

					ocifreestatement($stmt2);

					// Remove the plan we just made, we delete them on request anyway
					$stmt2 = ociparse($this->_hMaster, "DELETE FROM $table WHERE statement_id='$statement_id'");
					ociexecute($stmt2);
					ocifreestatement($stmt2);
				}

				ocifreestatement($stmt);

				if ($html_table)
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
		
		$aSeqs = $this->getRows("
			SELECT SEQUENCE_NAME 
			FROM all_sequences		
			WHERE SEQUENCE_OWNER = '" . strtoupper($this->escape($aVals['user_name'])) . "'
		");		
								
		foreach ($aSeqs as $sSeq)
		{
			$this->query("DROP SEQUENCE {$sSeq['sequence_name']}");
		}		
	}	
	
	private function _join($sType, $sTable, $sAlias, $mParam = null)
	{
		if (!isset($this->_aQuery['join']))
		{
			$this->_aQuery['join'] = '';
		}
		$this->_aQuery['join'] .= $sType . " " . $sTable . " " . $sAlias;
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
			if (preg_match("/(AND|OR|=)/", $mParam))
			{
				$this->_aQuery['join'] .= "\n\tON({$mParam}";
			}
			else 
			{
				$this->_aQuery['join'] .= "\n\tUSING({$mParam}";
			}
		}
		$this->_aQuery['join'] = preg_replace("/^(AND|OR)(.*?)/i", "", trim($this->_aQuery['join'])) . ")\n";		
	}
	
	private function _sqlError()
	{
		return ocierror();
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
        $aRes = oci_fetch_array($hRes, ($bAssoc ? OCI_ASSOC : OCI_NUM) + OCI_RETURN_NULLS);    
        
        $aRow = array();
        
        if (!$aRes)
        {
        	return array();	
        }        
        
        foreach ($aRes as $mKey => $mValue)
        {
        	if (is_null($mValue))
			{
				$mValue = '';
			}

			if (is_object($mValue))
			{
				$mValue = $mValue->load();
			}        		
        		
        	$aRow[strtolower($mKey)] = $mValue;
        }     

        return $aRow;
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
        $bAssoc = ($bAssoc ? OCI_ASSOC : OCI_NUM);

		// Run the query
        $this->rQuery = $this->query($sSql, $hLink);

        // Put it into a while look
        while($aRow = oci_fetch_array($this->rQuery, $bAssoc + OCI_RETURN_NULLS))
        {
        	$aRow2 = array();
        	foreach ($aRow as $mKey => $mValue)
        	{
				if (is_null($mValue))
				{
					$mValue = '';
				}

				if (is_object($mValue))
				{
					$mValue = $mValue->load();
				}        		
        		
        		$aRow2[strtolower($mKey)] = $mValue;
        	}
            $aRows[] = $aRow2;
        }
        
        return $aRows; //empty array on error
    }	
    
	private function _connect($sHost, $sUser, $sPass, $sPort = false, $sPersistent = false)
	{
		if ($sPort)
		{
			$sHost = $sHost . ':' . $sPort;	
		}
		
		if ($hLink = ($sPersistent ? @ociplogon($sUser, $sPass, $sHost) : @ocinlogon($sUser, $sPass, $sHost)))
		{
			return $hLink;
		}
		
		return false;
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
    
	protected function _insert($sTable, $sFields, $sValues)
	{
		$sFields = implode(', ', array_map('strtoupper', explode(',', $sFields)));
		
		$sSql = 'INSERT INTO ' . $sTable . ' '.
        	'        (' . $sFields . ')'.
            ' VALUES (' . $sValues . ')';
            
		return $sSql;
	}

	protected function _update($sTable, $sSets, $sCond)
	{
		$sSql = 'UPDATE ' . $sTable . ' SET ' . $sSets . ' WHERE ' . $sCond;	
		
		preg_match_all('/^(UPDATE [\\w_]++\\s+SET )([\\w_]++\\s*=\\s*(?:\'(?:[^\']++|\'\')*+\'|[\d-.]+)(?:,\\s*[\\w_]++\\s*=\\s*(?:\'(?:[^\']++|\'\')*+\'|[\d-.]+))*+)\\s+(WHERE.*)$/s', $sSql, $data, PREG_SET_ORDER);

		$update = $data[0][1];
		$where = $data[0][3];
		preg_match_all('/([\\w_]++)\\s*=\\s*(\'(?:[^\']++|\'\')*+\'|[\d-.]++)/', $data[0][2], $temp, PREG_SET_ORDER);
		unset($data);

		$cols = array();
		foreach ($temp as $value)
		{								
			$cols[] = strtoupper($value[1]) . ' = ' . strtoupper($value[2]);
		}
		$query = $update . implode(', ', $cols) . ' ' . $where;
		unset($cols);		
		
		return $query;
	}	
}

?>