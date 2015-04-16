<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Module Service Parent
 * This class is the parent class for all module services. Services handle all database
 * interactions and any PHP logic outside the scope of a component (block/controller).
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: service.class.php 2323 2011-03-03 18:24:00Z Raymond_Benc $
 */
class Phpfox_Service
{	
	/**
	 * Holds the default database table we are working with in this service.
	 *
	 * @var string
	 */
	protected $_sTable;

	/**
	 * @return $this
	 */
	public static function instance() {
		$name = get_called_class();
		$name = strtolower($name);
		$name = str_replace('service_', '', $name);
		// $name = str_replace('.', '_', $name);
		$parts = explode('_', $name);
		if (count($parts) > 2) {
			if ($parts[1] == $parts[2]) {
				unset($parts[2]);
			}
		}
		$className = implode('.', $parts);

		return Phpfox::getService($className);
	}
	    
	/**
	 * Extends the database object.
	 *
	 * @see Phpfox_Database
	 * @return Phpfox_Database_Driver_Mysql
	 */
    protected function database()
    {
    	return Phpfox_Database::instance();
    }
    
    /**
     * Extends the cache object
     *
     * @see Phpfox_Cache
     * @return Phpfox_Cache_Storage_File
     */
    protected function cache()
    {
    	return Phpfox::getLib('cache');
    }
    
    /**
     * Extends the pre-parsing object.
     *
     * @see Phpfox_Parse_Input
     * @return Phpfox_Parse_Input
     */
    protected function preParse()
    {
    	return Phpfox::getLib('parse.input');
    }
    
    /**
     * Extends the validation/sanity check object.
     *
     * @see Phpfox_Validator
     * @return Phpfox_Validator
     */
    protected function validator()
    {
    	return Phpfox_Validator::instance();
    }
    
    /**
     * Extends the search check object.
     *
     * @see Phpfox_Search
     * @return Phpfox_Search
     */    
    protected function search()
    {
    	return Phpfox_Search::instance();
    }
    
	/**
	 * Extends the request class and returns its class object.
	 *
	 * @see Phpfox_Request
	 * @return Phpfox_Request
	 */
	protected function request()
	{
		return Phpfox_Request::instance();
	}	    
}

?>