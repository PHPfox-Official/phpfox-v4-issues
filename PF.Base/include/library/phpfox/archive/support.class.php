<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Runs a check on the server to fully check what extensions are supported by the server.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: support.class.php 1666 2010-07-07 08:17:00Z Raymond_Benc $
 */
class Phpfox_Archive_Support
{
	/**
	 * Array of all the supported file extensions.
	 *
	 * @var unknown_type
	 */
	private $_aSupported = array(
		'xml',
		'zip' => array(
			'class' => 'zip'
		),
		'tar.gz' => array(
			'class' => 'tar'
		)
	);
	
	/**
	 * Constructor
	 *
	 */		
	public function __construct()
	{	
	}
	
	/**
	 * Checks if a specific archive is supported by the phpFox class itself and by the server.
	 *
	 * @param string $sName Name of the file extension we want to work with.
	 * @return mixed If it is supported we return an array of information about the archive, however we return a false (bool) if it is not supported at all.
	 */
	public function get($sName)
	{
		return (isset($this->_aSupported[$sName]) ? $this->_aSupported[$sName] : false);
	}
}

?>