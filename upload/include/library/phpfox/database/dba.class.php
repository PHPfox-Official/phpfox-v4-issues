<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

Phpfox::getLibClass('phpfox.database.interface');

/**
 * Parent class for all SQL drivers. Each driver needs to interact
 * with this class in case any modifications need to be done to a query.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: dba.class.php 6809 2013-10-21 09:16:37Z Miguel_Espinoza $
 */
abstract class Phpfox_Database_Dba implements Phpfox_Database_Interface
{
	/**
	 * Array of all the parts of a query we are going to execute
	 *
	 * @see self::execute()
	 * @var array
	 */
	protected $_aQuery = array();
	
	/**
	 * Array of all the words that cannot be used
	 * when creating a database table or field. This is only 
	 * used in development mode.
	 *
	 * @var array
	 */
	protected $_aWords = array();
	
	/**
	 * Holds all the data that has been filtered when inserting or updating
	 * information directly from a from posted by an end user.
	 *
	 * @var array
	 */
	private $_aData = array();
	
	/**
	 * Array of all the SQL unions.
	 *
	 * @var array
	 */
	private $_aUnions = array();
	
	/**
	 * Class constructor. If we are in development mode we store
	 * all the words that cannot be used when creating tables or fields.
	 *
	 */
	public function __construct()
	{
		if (PHPFOX_DEBUG && !defined('PHPFOX_INSTALLER') && !PHPFOX_OPEN_BASE_DIR)
		{
			if (file_exists(PHPFOX_DIR_DEV . 'include/sql-list'))
			{
				$oCache = Phpfox::getLib('cache');
				$sCacheId = $oCache->set('sql_reserved_list');
				if (!($this->_aWords = $oCache->get($sCacheId)))
				{
					$aFile = file(PHPFOX_DIR_DEV . 'include/sql-list');
					foreach ($aFile as $sLine)
					{
						$sLine = trim($sLine);
						$aParts = explode('=>', $sLine);
						$sWord = trim($aParts[0]);
						
						if (empty($sWord) || (is_array($this->_aWords) && in_array($sWord, $this->_aWords)))
						{
							continue;
						}
					
						$this->_aWords[] = $sWord;
					}
					$oCache->save($sCacheId, $this->_aWords);
				}
			}
		}		
	}
	
    /** 
     * Returns one field from a row using a slave connection
     * 
     * @param string $sSql SQL query
     * @return resource SQL resource
     */
    public function getSlaveField($sSql)
    {
		$this->_bIsSlave = true;
		
    	return $this->_getField($sSql, $this->_hSlave);
    }     
    
    /**
     * Returns one row using a slave connection
     *
     * @param string $sSql SQL query
     * @param bool $bAssoc True to return an associative array
     * @return resource SQL resource
     */
    public function getSlaveRow($sSql, $bAssoc = true)
    {
    	$this->_bIsSlave = true;
    	
    	return $this->_getRow($sSql, $bAssoc, $this->_hSlave);
    }
    
    /**
     * Returns several rows using a slave connection
     *
     * @param string $sSql SQL query
     * @param bool $bAssoc True to return an associative array
     * @return resource SQL resource
     */
    public function getSlaveRows($sSql, $bAssoc = true)
    {
    	$this->_bIsSlave = true;
    	
    	return $this->_getRows($sSql, $bAssoc, $this->_hSlave);
    }    
    
    /**
     * Returns one row
     *
     * @param string $sSql SQL query
     * @param bool $bAssoc True to return an associative array
     * @return resource SQL resource
     */    
    public function getRow($sSql, $bAssoc = true)
    {
    	return $this->_getRow($sSql, $bAssoc, $this->_hMaster);
    }
    
    /**
     * Returns several rows
     *
     * @param string $sSql SQL query
     * @param bool $bAssoc True to return an associative array
     * @return resource SQL resource
     */    
    public function getRows($sSql, $bAssoc = true)
    {
    	return $this->_getRows($sSql, $bAssoc, $this->_hMaster);
    } 
    
    /** 
     * Returns one field from a row
     * 
     * @param string $sSql SQL query
     * @return resource SQL resource
     */
    public function getField($sSql)
    {
		return $this->_getField($sSql, $this->_hMaster);
    }	
    
    /**
     * Stores the SELECT part of a query
     *
     * @see self::execute()
     * @param string $sSelect Select part of an SQL query
     * @return object Returns own object
     */
	public function select($sSelect)
	{
		/*
		if ($sSelect == 'dob_setting')
		{
			echo $a;
		}
		*/
		if (!isset($this->_aQuery['select']))
		{
			$this->_aQuery['select'] = 'SELECT ';
		}
		
		$this->_aQuery['select'] .= $sSelect;	
		
		return $this;
	}
	
    /**
     * Stores the WHERE part of a query
     * Example using a string method:
     * <code>
     * ->where('user_id = 1')
     * </code>
     * Example using an array method:
     * <code>
     * $aCond = array();
     * $aCond[] = 'AND user_id = 1';
     * $aCond[] = 'AND email = \'foo@bar.com\'';
     * ->where($aCond)
     * </code>
     * 
     * @see self::execute()
     * @param mixed $aConds Can be a string of the WHERE part of an SQL query or an array or all the parts of an SQL query.
     * @return object Returns own object
     */	
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
	
    /**
     * Stores the FROM part of a query
     *
     * @see self::execute()
     * @param string $sTable Table to query
     * @param string $sAlias Optional usage of alias can be passed here
     * @return object Returns own object
     */	
	public function from($sTable, $sAlias = '')
	{
		/*
		if ($sTable == 'phpfox_custom_relation_data')
		{
			ob_clean();
			echo $a;
			exit;
		}
		*/
		if (PHPFOX_DEBUG && in_array(strtoupper($sAlias), $this->_aWords))
		{
			Phpfox_Error::trigger('The alias "' . $sAlias . '" is a reserved SQL word. Use another alias to resolve this problem.', E_USER_ERROR);
		}
		
		$this->_aQuery['table'] = 'FROM ' . $sTable . ($sAlias ? ' AS ' . $sAlias : '');		
		
		return $this;
	}
	
    /**
     * Stores the ORDER part of a query
     *
     * @see self::execute()
     * @param string $sOrder SQL ORDER BY command
     * @return object Returns own object
     */		
	public function order($sOrder)
	{
		if (!empty($sOrder))
		{		
			$this->_aQuery['order'] = 'ORDER BY ' . $sOrder;
		}
		
		return $this;
	}
	
    /**
     * Stores the GROUP BY part of a query
     *
     * @see self::execute()
     * @param string $sGroup SQL GROUP BY command
     * @return object Returns own object
     */		
	public function group($sGroup)
	{
		$this->_aQuery['group'] = 'GROUP BY ' . $sGroup;
		
		return $this;
	}

    /**
     * Stores the HAVING part of a query
     *
     * @see self::execute()
     * @param string $sHaving SQL HAVING command
     * @return object Returns own object
     */		
	public function having($sHaving)
	{
		$this->_aQuery['having'] = 'HAVING ' . $sHaving;
		
		return $this;
	}
	
	/**
	 * Creates a LEFT JOIN for an SQL query.
	 * Example of left joining tables:
	 * <code>
	 * Phpfox::getLib('database')->select('*')
	 * 		->from('user', 'u')
	 * 		->leftJoin('user_info', 'ui', 'ui.user_id = u.user_id')
	 * 		->execute('getRows');
	 * </code>
	 *
	 * @see self::_join()
	 * @param string $sTable Table to join
	 * @param string $sAlias Alias to use to identify the table and make it unique
	 * @param mixed $mParam Can be a string or an array of how to link the tables. This is usually a string that contains the part found with an SQL ON(__STRING__)
	 * @return object Returns own object
	 */
	public function leftJoin($sTable, $sAlias, $mParam = null)
	{
		$this->_join('LEFT JOIN', $sTable, $sAlias, $mParam);
		
		return $this;
	}
	
	/**
	 * Creates a INNER JOIN for an SQL query.
	 * Example of left joining tables:
	 * <code>
	 * Phpfox::getLib('database')->select('*')
	 * 		->from('user', 'u')
	 * 		->innerJoin('user_info', 'ui', 'ui.user_id = u.user_id')
	 * 		->execute('getRows');
	 * </code>
	 *
	 * @see self::_join()
	 * @param string $sTable Table to join
	 * @param string $sAlias Alias to use to identify the table and make it unique
	 * @param mixed $mParam Can be a string or an array of how to link the tables. This is usually a string that contains the part found with an SQL ON(__STRING__)
	 * @return object Returns own object
	 */	
	public function innerJoin($sTable, $sAlias, $mParam = null)
	{
		$this->_join('INNER JOIN', $sTable, $sAlias, $mParam);
		
		return $this;
	}	
	
	/**
	 * Creates a JOIN for an SQL query.
	 * Example of left joining tables:
	 * <code>
	 * Phpfox::getLib('database')->select('*')
	 * 		->from('user', 'u')
	 * 		->join('user_info', 'ui', 'ui.user_id = u.user_id')
	 * 		->execute('getRows');
	 * </code>
	 *
	 * @see self::_join()
	 * @param string $sTable Table to join
	 * @param string $sAlias Alias to use to identify the table and make it unique
	 * @param mixed $mParam Can be a string or an array of how to link the tables. This is usually a string that contains the part found with an SQL ON(__STRING__)
	 * @return object Returns own object
	 */		
	public function join($sTable, $sAlias, $mParam = null)
	{
		$this->_join('JOIN', $sTable, $sAlias, $mParam);
		
		return $this;
	}	
	
    /**
     * Stores the LIMIT/OFFSET part of a query. It can also be used
     * to create a pagination if params 2 and 3 and filled otherwise
     * it bahaves just as a limit on the SQL query.
     *
     * @see self::execute()
     * @param int $iPage If $sLimit and $iCnt are NULL then this value is the LIMIT on the SQL query. However if $sLimit and $iCnt are not NULL then this value is the current page we are on.
     * @param string $sLimit Is how many to limit per query
     * @param int $iCnt Is how many rows there are in this query
     * @param bool $bCorrectMax Should we limit searches to valid pages
     * @return object Returns own object
     */		
	public function limit($iPage, $sLimit = null, $iCnt = null, $bReturn = false, $bCorrectMax = true)
	{
		if ($sLimit === null && $iCnt === null && $iPage !== null)
		{
			$this->_aQuery['limit'] = 'LIMIT ' . $iPage;	
			
			return $this;
		}
		
		if ($bCorrectMax == true)
		{
			$iOffset = ($iCnt === null ? $iPage : Phpfox::getLib('pager')->getOffset($iPage, $sLimit, $iCnt));
			$this->_aQuery['limit'] = ($sLimit ? 'LIMIT ' . $sLimit : '') . ($iOffset ? ' OFFSET ' . $iOffset : '');
		}
		else
		{
			$this->_aQuery['limit'] = ($sLimit ? 'LIMIT ' . $sLimit : '') . ($sLimit != null && $iPage > 0 ? ' OFFSET ' . (($iPage-1)* ($sLimit)) : '');
		}
		
		if ($bReturn === true)
		{
			return $this->_aQuery['limit'];	
		}
		
		return $this;
	}
	
	/**
	 * Build a UNION call.
	 *
	 * @return object Return self.
	 */
	public function union()
	{
		$this->_aUnions[] = $this->execute(null, array('union_no_check' => true));
		
		return $this;
	}
	
	/**
	 * Build a UNION FROM call.
	 *
	 * @param string $sAlias FROM alias name.
	 * @return object Return self.
	 */
	public function unionFrom($sAlias)
	{
		$this->_aQuery['union_from'] = $sAlias;
		
		return $this;	
	}
	
	/**
	 * Define that this is a joined count
	 *
	 * @return object Return self.
	 */
	public function joinCount()
	{
		$this->_aQuery['join_count'] = true;
		
		return $this;	
	}
	
	/**
	 * Performs the final SQL query with all the information we have gathered from various
	 * other methods in this class. Via this method you can perform all tasks from getting
	 * a single field from a row, to just one row or a list of rows.
	 *
	 * @see self::getRow()
	 * @see self::getRows()
	 * @see self::getField()
	 * @param string $sType The command we plan to execute. It can also be NULL or empty and will simply return the SQL query itself without executing it.
	 * @param array $aParams Any special commands that we need to run can be passed here. Mainly used if we were to cache the actual query.
	 * @return mixed Depending on the command you ran this can return various things, usually an array but it all depends on what you executed.
	 */
	public function execute($sType = null, $aParams = array())
	{		
        if (($sType == 'getField' || $sType == 'getSlaveField') && (!isset($this->_aQuery['limit']) || empty($this->_aQuery['limit'])))
        {
            $this->_aQuery['limit'] = ' LIMIT 1';
        }
		$sSql = '';
		if (isset($this->_aQuery['select']))
		{
			$sSql .= $this->_aQuery['select'] . "\n";
		}
		
		if (isset($this->_aQuery['join_count']))
		{
			$sSql .= 'SELECT (';
		}
		
		if (isset($this->_aQuery['table']))
		{
			$sSql .= $this->_aQuery['table'] . "\n";
		}
        
		if (isset($this->_aQuery['forceIndex']) && !empty($this->_aQuery['forceIndex']))
        {
            $sSql .= 'FORCE INDEX (' . $this->_aQuery['forceIndex'] .') ' . "\n";
        }
        
		if (isset($this->_aQuery['union_from']))
		{
			$sSql .= "FROM(\n";
		}
		
		if (!isset($aParams['union_no_check']) && count($this->_aUnions))
		{
			$iUnionCnt = 0;
			foreach ($this->_aUnions as $sUnion)
			{
				$iUnionCnt++;	
				if ($iUnionCnt != 1)
				{
					$sSql .= (isset($this->_aQuery['join_count']) ? ' + ' : ' UNION ');
				}
				
				$sSql .= '(' . $sUnion . ')';
			}
		}
		
		if (isset($this->_aQuery['join_count']))
		{
			$sSql .= ') AS total_count';
		}
		
		if (isset($this->_aQuery['union_from']))
		{
			$sSql .= ") AS " . $this->_aQuery['union_from'] . "\n";
		}		
		
		$sSql .= (isset($this->_aQuery['join']) ? $this->_aQuery['join'] . "\n" : '');
		$sSql .= (isset($this->_aQuery['where']) ? $this->_aQuery['where'] . "\n" : '');
		$sSql .= (isset($this->_aQuery['group']) ? $this->_aQuery['group'] . "\n" : '');
		$sSql .= (isset($this->_aQuery['having']) ? $this->_aQuery['having'] . "\n" : '');
		$sSql .= (isset($this->_aQuery['order']) ? $this->_aQuery['order'] . "\n" : '');
		$sSql .= (isset($this->_aQuery['limit']) ? $this->_aQuery['limit'] . "\n" : '');
		$sSql .= '/* OO Query */';		
	
		if (method_exists($this, '_execute'))
		{
			$sSql = $this->_execute();
		}
		
		$this->_aQuery = array();
		if (!isset($aParams['union_no_check']))
		{
			$this->_aUnions = array();
		}
		
		$bDoCache = false;
		if (isset($aParams['cache']) && !empty($aParams))
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
		
		$sType = strtolower($sType);		
		switch($sType)
		{
			case 'getslaverows':
				$aRows = $this->getSlaveRows($sSql);
				break;
			case 'getslaverow':
				$aRows = $this->getSlaveRow($sSql);
				break;				
			case 'getrow':
				$aRows = $this->getRow($sSql);
				break;	
			case 'getrows':
				$aRows = $this->getRows($sSql);
				break;	
			case 'getfield':
				$aRows = $this->getField($sSql);
				break;				
			case 'getslavefield':
				$aRows = $this->getSlaveField($sSql);
				break;
			default:
				return $sSql;
				break;
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
	
	/**
	 * We clean out the query we just ran so another query can be built
	 *
	 */
	public function clean()
	{
		$this->_aQuery = array();		
	}
	
	/**
	 * Process data from a form a end-user posted and prepare it to be used when inserting/updating records
	 *
	 * @param array $aFields Array of rules of the fields that are allowed and the type it must be
	 * @param array $aVals  $_POST fields from a form
	 * @return object Returns own object
	 */
	public function process($aFields, $aVals)
	{
		foreach ($aFields as $mKey => $mVal)
		{
			if (is_numeric($mKey))
			{
				unset($aFields[$mKey]);
				
				$mKey = $mVal;
				$mVal = 'string';
			}
			
			if (empty($aVals[$mKey]))
			{
				$aVals[$mKey] = ($mVal == 'int' ? 0 : null);
			}			
			
			$aFields[$mKey] = $mVal;
		}
	
		foreach ($aVals as $mKey => $mVal)
		{
			if (!isset($aFields[$mKey]))
			{
				continue;
			}			
			
			$this->_aData[$mKey] = ($aFields[$mKey] == 'int' ? (int) $mVal : $mVal);
		}		
		
		return $this;
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
    public function insert($sTable, $aValues = array(), $bEscape = true, $bReturnQuery = false)
    {    	
    	if (!$aValues)
    	{
    		$aValues = $this->_aData;
    	}
    	
    	$sValues = '';
    	foreach ($aValues as $mValue)
    	{
    		if (is_null($mValue))
    		{
    			$sValues .= "NULL, ";
    		}
    		else 
    		{
    			$sValues .= "'" . ($bEscape ? $this->escape($mValue) : $mValue) . "', ";
    		}
    	}
    	$sValues = rtrim(trim($sValues), ',');
    	
    	if ($this->_aData)
    	{
    		$this->_aData = array();
    	}

        $sSql = $this->_insert($sTable, implode(', ', array_keys($aValues)), $sValues);
 
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
     * Runs an SQL query to run one SQL query and insert multiple rows. The 2nd and 3rd
     * params much match in order to inser the data correctly.
     *
     * @param string $sTable Table to insert the data
     * @param array $aFields Array of table fields
     * @param array $aValues Array of values to insert that matches the table fields
     * @return int Returns the last ID of the insert. Usually the auto_increment.
     */
    public function multiInsert($sTable, $aFields, $aValues)
    {
    	$sSql = "INSERT INTO {$sTable} (" . implode(', ', array_values($aFields)) . ") ";
    	$sSql .= " VALUES\n";
    	foreach ($aValues as $aValue)
    	{
    		$sSql .= "\n(";
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
    		$sSql = rtrim(trim($sSql), ',');
    		$sSql .= "),";
    	}
    	$sSql = rtrim($sSql, ',');  
    	
        if ($hRes = $this->query($sSql))
        {
            return $this->getLastId();
		}
    	
    	return 0;
    }
    
    /**
     * Performs update of rows.
     * 
     * @param string $sTable  table name
     * @param array  $aValues array of column=>new_value
     * @param string $sCond   condition (without WHERE)
     * @param boolean $bEscape true - method escapes values (with "), false - not escapes
     * @return boolean true - update successfule, false - error
     */
    public function update($sTable, $aValues = array(), $sCond = null, $bEscape = true)
    {
        if (!is_array($aValues) && count($this->_aData))
        {
            $sCond = $aValues;
        	$aValues = $this->_aData;            
        	$this->_aData = array();
		}

        $sSets = '';
        foreach ($aValues as $sCol => $sValue)
        {
            $sCmd = "=";
            if (is_array($sValue))
            {
            	$sCmd = $sValue[0];
            	$sValue = $sValue[1];    
            }
        	
        	$sSets .= "{$sCol} {$sCmd} " . (is_null($sValue) ? 'NULL' : ($bEscape ? "'" . $this->escape($sValue) . "'" : $sValue)) . ", ";
        }
        $sSets[strlen($sSets)-2] = '  ';        
		
        return $this->query($this->_update($sTable, $sSets, $sCond));
    } 
    
    /**
     * Delete entry from the database
     * 
     * @param string $sTable is the table name
     * @param string $sQuery is the query we will run
     * @return boolean true - update successfule, false - error
     */
    public function delete($sTable, $sQuery, $iLimit = null)
    {
    	if ($iLimit !== null)
    	{
    		$sQuery .= ' LIMIT ' . (int) $iLimit;
    	}
    	
    	return $this->query("DELETE FROM {$sTable} WHERE ". $sQuery);    	
    }   
    
    /**
     * Drops tables from the database
     *
     * @param string $aDrops Array of tables to drop
     * @param array $aVals Not being used at the moment.
     */
	public function dropTables($aDrops, $aVals = array())
	{
		if (!is_array($aDrops))
		{
			$aDrops = array($aDrops);
		}
		foreach ($aDrops as $sDrop)
		{
			$this->query("DROP TABLE IF EXISTS {$sDrop}");		
		}			
	}
	
	/**
	 * Updates a int field in the database to increase or decrease its count.
	 * We usually use this to cache information about a user. Lets take for example
	 * a user has 10 friends and instead of running a query to the database to check
	 * how many friends they have we just store a static count in the database. So when
	 * they add or remove a friend we then either increase or decrease the static record.
	 * 
	 * Example:
	 * <code>
	 * Phpfox::getLib('database')->updateCounter('user_count', 'total_friend', 'user_id', 1);
	 * </code>
	 *
	 * @param string $sTable Table to update
	 * @param string $sCounter Field we are going to be updating. This is where the static value is
	 * @param string $sField Field we need to identify the record we are going to be updating
	 * @param int $iId ID of the field we are going to be updating
	 * @param bool $bMinus False by default as we usually increase a count, if we decrease a count set this to true
	 */
	public function updateCounter($sTable, $sCounter, $sField, $iId, $bMinus = false)
	{		
		$iCount = $this->select($sCounter)->from(Phpfox::getT($sTable))->where($sField . ' = ' . (int) $iId)->execute('getSlaveField');
		
		$this->update(Phpfox::getT($sTable), array($sCounter => ($bMinus === true ? (($iCount <= 0 ? 0 : $iCount - 1)) : ($iCount + 1))), $sField . ' = ' . (int) $iId);
	}	
	
	/**
	 * This in practice works similar to our previous method self::updateCounter(), however
	 * instead of increasing or decreasing a field it checks the table to see how many 
	 * rows there are and updates the static field with that count. This is usually only used
	 * in the AdminCP to fix broken counters.
	 *
	 * @param string $sCountTable Table to check how many rows there are
	 * @param array $aCountCond SQL conditional statement for the table we are checking
	 * @param string $sCounter Field name of the table we are updating the static count
	 * @param string $sUpdateTable Table we are going to be updating with the new count number
	 * @param array $aUpdateCond SQL conditional statment for the table we are updating
	 */
	public function updateCount($sCountTable, $aCountCond, $sCounter, $sUpdateTable, $aUpdateCond)
	{
		$iCount = $this->select('COUNT(*)')
			->from(Phpfox::getT($sCountTable))
			->where($aCountCond)
			->execute('getSlaveField');
			
		$this->update(Phpfox::getT($sUpdateTable), array($sCounter => $iCount), $aUpdateCond);
	}

	/**
	 * Gets all the joins made for the query.
	 *
     * @return string Returns SQL joins
	 */
	public function getJoins()
	{
		return $this->_aQuery['join'];
	}	
	
	/**
	 * Build search params for keywords.
	 * 
	 * @param string $sField Field to search
	 * @param string $sStr Keywords to use
	 * @return string Returns an SQL ready search statement
	 */
	public function searchKeywords($sField, $sStr)
	{
		if (is_array($sField))
		{
			$sQuery = '';
			$iIteration = 0;
			foreach ($sField as $sNewField)
			{
				$iIteration++;
				if ($iIteration != 1)
				{
					$sQuery .= ' OR ';
				}
				$sQuery .= $this->searchKeywords($sNewField, $sStr);
			}
			
			return $sQuery;
		}
		
		$aWords = explode(' ', $sStr);
		
		$sQuery = ' (';
		if (count($aWords))
		{
			$iIteration = 0;
			foreach ($aWords as $sWord)
			{
				$sWord = trim($sWord);
				if (strlen($sWord) < 4)
				{
					continue;
				}
				$iIteration++;
				if ($iIteration != 1)
				{
					$sQuery .= ' OR ';
				}
				
				$sQuery .= $sField . ' LIKE \'%' . Phpfox::getLib('database')->escape($sWord) . '%\' ';
				
				$aLikeWords = $this->getLikeWords($sWord);
				
				foreach ($aLikeWords as $sLikeWord)
				{
					if (strpos($sQuery, $sLikeWord) === false)
					{
						$sQuery .= ' OR ' . $sField . ' LIKE \'%' . Phpfox::getLib('database')->escape($sLikeWord) . '%\'' ;
					}
				}
				
				$sQuery = rtrim($sQuery, ' OR ');				
			}
		}
		
		if (!$iIteration)
		{
			return $sField . ' LIKE \'%' . Phpfox::getLib('database')->escape($sStr) . '%\' ';
		}
		
		$sQuery .= ') ';
		
		return $sQuery;
	}
	
	/**
	*	Takes into account html entities to return the ucwords and strtolower in an array.
	*	Mysql treats LIKE "%Something%" as => column LIKE "%Something" OR column LIKE "%something" but this doesnt work with non-english characters
	*	@return array
	*	@param $sWord string
	*/
	private function getLikeWords($sWord)
	{
		if (preg_match('/(&#[0-9]+;)(.*)/', $sWord, $aMatch) < 1)
		{
			return array();
		}
		else if (isset($aMatch[2]))
		{
			$sFirstChar = $aMatch[1];
			$sFirstCharInChar = mb_decode_numericentity($sFirstChar, array(0x0, 0xffff, 0, 0x2ffff), 'UTF-8');
			$sRest = $aMatch[2];
			
			// Check its an html entity
			return array(
				(mb_encode_numericentity (mb_strtoupper($sFirstCharInChar, 'UTF-8'), array (0x0, 0xffff, 0, 0xffff), 'UTF-8')) . $sRest,
				(mb_encode_numericentity (mb_strtolower($sFirstCharInChar, 'UTF-8'), array (0x0, 0xffff, 0, 0xffff), 'UTF-8')) . $sRest,
			);
		}
	}

	/**
	 * Performs all the joins based on information passed from JOIN methods within this class.
	 *
	 * @see self::join()
	 * @see self::leftJoin()
	 * @see self::innerJoin()
	 * @param string $sType The type of join we are going to use (LEFT JOIN, JOIN, INNER JOIM)
	 * @param string $sTable Table to join
	 * @param string $sAlias Alias to use to identify the table and make it unique
	 * @param mixed $mParam Can be a string or an array of how to link the tables. This is usually a string that contains the part found with an SQL ON(__STRING__)
	 */
	protected function _join($sType, $sTable, $sAlias, $mParam = null)
	{
		if (PHPFOX_DEBUG && in_array(strtoupper($sAlias), $this->_aWords))
		{
			Phpfox_Error::trigger('The alias "' . $sAlias . '" is a reserved SQL word. Use another alias to resolve this problem.', E_USER_ERROR);
		}		
		
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
			if (preg_match("/(AND|OR|=|LIKE)/", $mParam))
			{
				$this->_aQuery['join'] .= "\n\tON({$mParam}";
			}
			else 
			{
				// Not supported with other drivers so we don't use this anymore
				Phpfox_Error::trigger('Not allowed to use "USING()" in SQL queries any longer.', E_USER_ERROR);
			}
		}
		$this->_aQuery['join'] = preg_replace("/^(AND|OR)(.*?)/i", "", trim($this->_aQuery['join'])) . ")\n";
	} 
	
	/**
	 * Insert data into the database
	 *
	 * @param string $sTable Database table
	 * @param string $sFields List of fields
	 * @param string $sValues List of values
	 * @return string Returns the actual SQL query to perform
	 */
	protected function _insert($sTable, $sFields, $sValues)
	{
		return 'INSERT INTO ' . $sTable . ' '.
        	'        (' . $sFields . ')'.
            ' VALUES (' . $sValues . ')';            
	}
	
	/**
	 * Updates data in a specific table
	 *
	 * @param string $sTable Table we are updating
	 * @param string $sSets SQL SET command
	 * @param string $sCond SQL WHERE command
	 * @return string Returns the actual SQL query to perform
	 */
	protected function _update($sTable, $sSets, $sCond)
	{
		return 'UPDATE ' . $sTable . ' SET ' . $sSets . ' WHERE ' . $sCond;
	}

    /** 
     * Returns one field from a row
     * 
     * @param string $sSql SQL query
     * @param resource $hLink SQL resource
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
	
	public function createTable($sName, $aFields)
	{
		$sSql = 'CREATE TABLE ' . $sName . "\n";
		$sSql .= '(' ."\n";
		$bHasPK = false;
		foreach ($aFields as $aField)
		{			
			$sSql .= $aField['name'] .' ' . $aField['type'] . (isset($aField['extra']) ? ' ' .$aField['extra'] : '' ) . ",\n";
			if (isset($aField['primary_key']) && $aField['primary_key'] == true)
			{
				$bHasPK = $aField['name'];
			}
		}
		
		if ($bHasPK !== false)
		{
			$sSql .= 'PRIMARY KEY (`' . $bHasPK . '`)' . "\n";
		}
		
		$sSql .= ')';
		
		$this->query($sSql);		
	}
    
    /**
     * Tells which index to use by issuing a Force Index ($sName)
     * @param type String
     */
    public function forceIndex($sName)
    {
        if (preg_match('/([a-zA-Z0-9_]+)/', $sName, $aMatches) > 0)
        {
            $this->_aQuery['forceIndex'] = $aMatches[1];
        }
        return $this;
    }
}

?>