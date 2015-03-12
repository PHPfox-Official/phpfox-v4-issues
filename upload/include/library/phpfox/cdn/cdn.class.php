<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

Phpfox::getLibClass('phpfox.cdn.abstract');

/**
 * We use this class to store data on CDN services like Amazon S3. This can be items from
 * photos, videos, songs, CSS files etc...
 * 
 * Example of storing a file:
 * <code>
 * Phpfox::getLib('cdn')->put('/var/www/file/sample.jpg');
 * </code>
 * 
 * Displaying an uploaded file:
 * <code>
 * <img src="<?php echo Phpfox::getLib('cdn')->getUrl('/var/www/file/sample.jpg'); ?>" />
 * </code>
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: cdn.class.php 3956 2012-03-01 12:28:26Z Raymond_Benc $
 */
class Phpfox_Cdn
{
	/**
	 * Object of the CDN module.
	 *
	 * @var object
	 */
	private $_oObject = null;
	
	/**
	 * Based on what CDN module is selected here is where we load the CDN class and initiat the object.
	 *
	 * @param array $aParams Array of any special params to pass to the module CDN class
	 */
	public function __construct($aParams = array())
	{
		if (!$this->_oObject)
		{
			$sCdn = (Phpfox::getParam('core.cdn_service') == '' ? 's3' : Phpfox::getParam('core.cdn_service'));
			
			$this->_oObject = Phpfox::getLib('phpfox.cdn.module.' . $sCdn, $aParams);
		}
	}
	
	/**
	 * Return the object of the CDN module object.
	 *
	 * @return object Object provided by the module class we loaded earlier.
	 */		
	public function &getInstance()
	{
		return $this->_oObject;
	}		
}

?>