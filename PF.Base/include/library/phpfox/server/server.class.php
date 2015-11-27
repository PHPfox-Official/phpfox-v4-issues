<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Server
 * Class is used to check on server enviroment.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: setting.class.php 1189 2009-10-16 19:05:19Z Raymond_Benc $
 */
class Phpfox_Server
{
	/**
	 * Check to see if we are on a windows server.
	 *
	 * @return bool TRUE if windows, FALSE if not.
	 */
	public function isWindows()
	{
		return (PHP_OS == 'WINNT' || PHP_OS == 'WIN32' || PHP_OS == 'Windows');
	}		
	
	/**
	 * Return the server URL based on the server ID (load balancing).
	 *
	 * @param int $sId Server ID.
	 * @return string Server URL.
	 */
	public function getServerUrl($sId)
	{
		$aServers = Phpfox::getParam(array('balancer', 'servers'));
		foreach ($aServers as $iIp => $aServer)
		{
			if ($aServer['id'] == $sId)
			{
				return $aServer['url'];		
			}		
		}		
	}
}

?>
