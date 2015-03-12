<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

Phpfox::getLibClass('phpfox.image.abstract');

/**
 * Image Manipulation Library Loader
 * Loads the specified image manipulation library to be used based on admin settings.
 * Classes can be found: include/library/phpfox/image/library/
 * By default we use: GD
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: image.class.php 1666 2010-07-07 08:17:00Z Raymond_Benc $
 */
class Phpfox_Image
{
	/**
	 * Object for the image library
	 *
	 * @var object
	 */
	private $_oObject = null;

	/**
	 * Class constructor. We load the image library the admin decided to use on their site.
	 *
	 */
	public function __construct()
	{
		if (!$this->_oObject)
		{			
			$sDriver = 'phpfox.image.library.gd';

			$this->_oObject = Phpfox::getLib($sDriver);
		}
	}	
	
	/**
	 * Returns the object of the image library we are using
	 *
	 * @return unknown
	 */
	public function &getInstance()
	{
		return $this->_oObject;
	}
}

?>