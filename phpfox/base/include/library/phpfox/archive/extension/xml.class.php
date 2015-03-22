<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Handle XML data in instead of storing data in conventional archives. Note that 
 * this class is not in use so no further documenation was done to further explain
 * this class. We reserved this file in case we plan on using it in the future.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: xml.class.php 1666 2010-07-07 08:17:00Z Raymond_Benc $
 */
class Phpfox_Archive_Extension_Xml
{	
	public function __construct()
	{			

	}
	
	public function test()
	{
		return true;
	}
	
	public function extract($sFile, $sLocation)
	{		

	}

	public function compress($sFile, $sFolder)
	{		
		return PHPFOX_DIR_CACHE . $sFolder;
	}
}

?>