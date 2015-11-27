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
 * Phpfox_Database::instance()->query('SELECT * FROM user');
 * </code>
 * 
 * Example use to get multiple rows from a table:
 * <code>
 * $aRows = Phpfox_Database::instance()->select('*')
 * 		->from('user')
 * 		->where('user_name = \'foo\'')
 * 		->execute('getRows');
 * </code>
 * 
 * Example to insert data into the database:
 * <code>
 * Phpfox_Database::instance()->insert('user', array(
 * 			'email' => 'foo@bar.com',
 * 			'full_name' => 'Full Name'
 * 		)
 *	);
 * </code>
 * 
 * Example to update a record:
 * <code>
 * Phpfox_Database::instance()->update('user', array('email' => 'foo@bar.com'), 'user_id = 1');
 * </code>
 * 
 * Example to delete a record:
 * <code>
 * Phpfox_Database::instance()->delete('user', 'user_id = 1');
 * </code>
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: database.class.php 1666 2010-07-07 08:17:00Z Raymond_Benc $
 *
 * @method Phpfox_Database_Driver_Mysql select($select)
 * @method Phpfox_Database_Driver_Mysql update($table, $fields, $where)
 * @method Phpfox_Database_Driver_Mysql insert($table, $fields)
 * @method Phpfox_Database_Driver_Mysql delete($table, $where)
 */
class Phpfox_Database
{
	/**
	 * Holds the drivers object
	 *
	 * @var Phpfox_Database_Driver_Mysql
	 */
	private static $_oObject = null;

	/**
	 * Loads and initiates the SQL driver that we need to use.
	 *
	 */
	public function __construct()
	{
		if (!self::$_oObject)
		{
			$sDriver = 'phpfox.database.driver.mysqli';

			self::$_oObject = Phpfox::getLib($sDriver);
			self::$_oObject->connect(Phpfox::getParam(array('db', 'host')), Phpfox::getParam(array('db', 'user')), Phpfox::getParam(array('db', 'pass')), Phpfox::getParam(array('db', 'name')));
		}
	}	
	
	/**
	 * Return the object of the storage object.
	 *
	 * @return object Object provided by the storage class we loaded earlier.
	 */	
	public function &getInstance()
	{
		return self::$_oObject;
	}

	/**
	 * @return Phpfox_Database_Driver_Mysql
	 */
	public static function instance() {
		if (!self::$_oObject) {
			new self();
		}

		return self::$_oObject;
	}

	public function __call($method, $args) {
		return call_user_func_array([self::$_oObject, $method], $args);
	}
}