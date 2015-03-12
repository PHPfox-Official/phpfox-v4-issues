<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

Phpfox::getLibClass('phpfox.database.driver.mysql');

/**
 * Database driver for MySQLi. This class extends the MySQL driver
 * we provide since both function in the same way there was no need to make
 * an extra class for MySQLi.
 * 
 * @see Phpfox_Database_Driver_Mysql
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: mysqli.class.php 2016 2010-11-01 13:47:08Z Raymond_Benc $
 */
class Phpfox_Database_Driver_Mysqli extends Phpfox_Database_Driver_Mysql
{
	/**
	 * Array of all the MySQLi functions we use. This 
	 * variable overwrites the parent MySQL variable.
	 *
	 * @see parent::$_aCmd
	 * @var array
	 */
	protected $_aCmd = array(
		'mysql_query' => 'mysqli_query',
		'mysql_connect' => 'mysqli_connect',
		'mysql_pconnect' => 'mysqli_pconnect',
		'mysql_select_db' => 'mysqli_select_db',
		'mysql_num_rows' => 'mysqli_num_rows',
		'mysql_fetch_array' => 'mysqli_fetch_array',
		'mysql_real_escape_string' => 'mysqli_real_escape_string',
		'mysql_insert_id' => 'mysqli_insert_id',
		'mysql_fetch_assoc' => 'mysqli_fetch_assoc',
		'mysql_free_result' => 'mysqli_free_result',
		'mysql_error' => 'mysqli_error',
		'mysql_affected_rows' => 'mysqli_affected_rows',
		'mysql_get_server_info' => 'mysqli_get_server_info',
		'mysql_close' => 'mysqli_close'
	);
}

?>