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
	 * Extends the database object.
	 *
	 * @see Phpfox_Database
	 * @return object
	 */
    protected function database()
    {
    	return Phpfox::getLib('database');
    }
    
    /**
     * Extends the cache object
     *
     * @see Phpfox_Cache
     * @return object
     */
    protected function cache()
    {
    	return Phpfox::getLib('cache');
    }
    
    /**
     * Extends the pre-parsing object.
     *
     * @see Phpfox_Parse_Input
     * @return object
     */
    protected function preParse()
    {
    	return Phpfox::getLib('parse.input');
    }
    
    /**
     * Extends the validation/sanity check object.
     *
     * @see Phpfox_Validator
     * @return object
     */
    protected function validator()
    {
    	return Phpfox::getLib('validator');
    }
    
    /**
     * Extends the search check object.
     *
     * @see Phpfox_Search
     * @return object
     */    
    protected function search()
    {
    	return Phpfox::getLib('search');
    }
    
	/**
	 * Extends the request class and returns its class object.
	 *
	 * @see Phpfox_Request
	 * @return object
	 */
	protected function request()
	{
		return Phpfox::getLib('request');	
	}	    
}

?>