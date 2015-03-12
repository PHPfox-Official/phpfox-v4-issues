<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

Phpfox::getLibClass('phpfox.database.dba');

/**
 * Database layer for phpFox. All interactions with a database is done via this class.
 * It connects to a specific driver such as MySQL or MySQLi or Oracle based on the
 * site owners needs.
 * 
 * Example use of an SQL query:
 * <code>
 * Phpfox::getLib('database')->query('SELECT * FROM user');
 * </code>
 * 
 * Example use to get multiple rows from a table:
 * <code>
 * $aRows = Phpfox::getLib('database')->select('*')
 * 		->from('user')
 * 		->where('user_name = \'foo\'')
 * 		->execute('getRows');
 * </code>
 * 
 * Example to insert data into the database:
 * <code>
 * Phpfox::getLib('database')->insert('user', array(
 * 			'email' => 'foo@bar.com',
 * 			'full_name' => 'Full Name'
 * 		)
 *	);
 * </code>
 * 
 * Example to update a record:
 * <code>
 * Phpfox::getLib('database')->update('user', array('email' => 'foo@bar.com'), 'user_id = 1');
 * </code>
 * 
 * Example to delete a record:
 * <code>
 * Phpfox::getLib('database')->delete('user', 'user_id = 1');
 * </code>
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: database.class.php 1666 2010-07-07 08:17:00Z Raymond_Benc $
 */
class Phpfox_Database
{
	/**
	 * Holds the drivers object
	 *
	 * @var object
	 */
	private $_oObject = null;

	/**
	 * Loads and initiates the SQL driver that we need to use.
	 *
	 */
	public function __construct()
	{
		if (!$this->_oObject)
		{			
			switch(Phpfox::getParam(array('db', 'driver')))
			{
				case 'mysqli':
					$sDriver = 'phpfox.database.driver.mysqli';
					break;
				case 'postgres':
					$sDriver = 'phpfox.database.driver.postgres';
				break;	
				case 'mssql':
					$sDriver = 'phpfox.database.driver.mssql';
					break;
				case 'oracle':
					$sDriver = 'phpfox.database.driver.oracle';
					break;		
				case 'sqlite':
					$sDriver = 'phpfox.database.driver.sqlite';
					break;
				default:
					$sDriver = 'phpfox.database.driver.mysql';
					break;
			}		

			$this->_oObject = Phpfox::getLib($sDriver);
			$this->_oObject->connect(Phpfox::getParam(array('db', 'host')), Phpfox::getParam(array('db', 'user')), Phpfox::getParam(array('db', 'pass')), Phpfox::getParam(array('db', 'name')));
		}
	}	
	
	/**
	 * Return the object of the storage object.
	 *
	 * @return object Object provided by the storage class we loaded earlier.
	 */	
	public function &getInstance()
	{
		return $this->_oObject;
	}
}

?>