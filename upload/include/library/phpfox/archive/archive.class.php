<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Handles archives such as zip and tar.gz.
 * 
 * Example to compress a ZIP archive:
 * <code>
 * Phpfox::getLib('archive', 'zip')->compress('foo', 'bar');
 * </code>
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: archive.class.php 1666 2010-07-07 08:17:00Z Raymond_Benc $
 */
class Phpfox_Archive
{
	/**
	 * Holds the object of the extension class depending on what sort of archive
	 * we are working with.
	 *
	 * @var object
	 */
	private $_oObject = null;
	
	/**
	 * Constructor
	 *
	 */	
	public function __construct($sExt = null)
	{
		if ($sExt)
		{
			switch ($sExt)
			{
				case 'zip':
					$sObject = 'phpfox.archive.extension.zip';
					break;
				case 'tar.gz':
					$sObject = 'phpfox.archive.extension.tar';
					break;		
				case 'xml':
					$sObject = 'phpfox.archive.extension.xml';
					break;	
				default:
					if (substr($sExt, -4) == '.zip')
					{
						$sObject = 'phpfox.archive.extension.zip';
					}
			}			
			
			(($sPlugin = Phpfox_Plugin::get('archive__construct')) ? eval($sPlugin) : false);
		
			$this->_oObject = Phpfox::getLib($sObject);
		}
	}
	
	/**
	 * Return the object of the extension class.
	 *
	 * @return object Object provided by the extension class we loaded earlier.
	 */
	public function &getInstance()
	{
		return $this->_oObject;
	}
}

?>