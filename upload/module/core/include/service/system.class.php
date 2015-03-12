<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox_Service
 * @version 		$Id: system.class.php 5456 2013-02-28 14:24:45Z Miguel_Espinoza $
 */
class Core_Service_System extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{
	
	}
	
	public function get()
	{
		$oFile = Phpfox::getLib('file');
		$bSlaveEnabled = Phpfox::getParam(array('db', 'slave'));
		$sDriver = Phpfox::getParam(array('db', 'driver'));
		
	    $aStats = array
	    (
	    	Phpfox::getPhrase('admincp.phpfox_version') => PhpFox::getVersion() . '<i>(build ' . Phpfox::getBuild() . ')</i>',
			Phpfox::getPhrase('admincp.php_version') => '<a href="' . Phpfox::getLib('url')->makeUrl('admincp.core.phpinfo') . '">' . PHP_VERSION . '</a>',
	    	Phpfox::getPhrase('admincp.php_sapi') => php_sapi_name(),
	    	Phpfox::getPhrase('admincp.php_safe_mode') => (PHPFOX_SAFE_MODE ? Phpfox::getPhrase('admincp.true') : Phpfox::getPhrase('admincp.false')),
	    	Phpfox::getPhrase('admincp.php_open_basedir') => (PHPFOX_OPEN_BASE_DIR ? Phpfox::getPhrase('admincp.true') : Phpfox::getPhrase('admincp.false')),
	    	Phpfox::getPhrase('admincp.php_disabled_functions') =>  (@ini_get('disable_functions') ? str_replace( ",", ", ", @ini_get('disable_functions') ) : Phpfox::getPhrase('admincp.none')),
	    	Phpfox::getPhrase('admincp.php_loaded_extensions') => implode(' ', get_loaded_extensions()),
	    	Phpfox::getPhrase('admincp.operating_system') => PHP_OS,
	    	Phpfox::getPhrase('admincp.server_time_stamp') => date('F j, Y, g:i a', PHPFOX_TIME) . ' (GMT)',	    		
	    	Phpfox::getPhrase('admincp.gzip') => (Phpfox::getParam('core.use_gzip') ? Phpfox::getPhrase('admincp.enabled') : Phpfox::getPhrase('admincp.disabled')),
	    	Phpfox::getPhrase('admincp.sql_driver_version') =>  ($sDriver == 'DATABASE_DRIVER' ? Phpfox::getPhrase('admincp.n_a') : Phpfox::getLib('database')->getServerInfo()),
	    	Phpfox::getPhrase('admincp.sql_slave_enabled') => ($bSlaveEnabled ? Phpfox::getPhrase('admincp.yes') : Phpfox::getPhrase('admincp.no')),
	    	Phpfox::getPhrase('admincp.sql_total_slaves') => ($bSlaveEnabled ? count(Phpfox::getParam(array('db', 'slave_servers'))) : Phpfox::getPhrase('admincp.n_a')),
	    	Phpfox::getPhrase('admincp.sql_slave_server') => ($bSlaveEnabled ? Phpfox::getLib('database')->sSlaveServer : Phpfox::getPhrase('admincp.n_a')),    		
	    	Phpfox::getPhrase('admincp.memory_limit') => $oFile->filesize($this->_getUsableMemory()) . ' (' . @ini_get('memory_limit') . ')',
	    	Phpfox::getPhrase('admincp.load_balancing_enabled') => (Phpfox::getParam(array('balancer', 'enabled')) ? Phpfox::getPhrase('admincp.yes') : Phpfox::getPhrase('admincp.no'))			
	    );
	    
	    if(strpos(strtolower(PHP_OS), 'win') === 0 || PHPFOX_SAFE_MODE || PHPFOX_OPEN_BASE_DIR)
		{
			
		}
		else 
		{
			if (function_exists('shell_exec'))
			{
				$sMemory = @shell_exec("free -m");
				$aMemory = explode("\n", str_replace( "\r", "", $sMemory));
				if (is_array($aMemory))
				{
					$aMemory = array_slice($aMemory, 1, 1);
					if (isset($aMemory[0]))
					{
						$aMemory = preg_split("#\s+#", $aMemory[0]);

						$aStats[Phpfox::getPhrase('admincp.total_server_memory')]	= (isset($aMemory[1]) ? $aMemory[1] . ' MB' : '--');
						$aStats[Phpfox::getPhrase('admincp.available_server_memory')]	= (isset($aMemory[3]) ? $aMemory[3] . ' MB' : '--');
					}
				}
			}
            else if (stristr(PHP_OS, "win") === false)
            {
                $sMemory = file_get_contents('/proc/meminfo'); 
                $aMemoryStats = explode("n", $sMemory); // escape the "new line" 
                $aMem = null; 
                foreach($aMemoryStats as $iKey => $sMemoryStat) 
                { 
                    $aMemoryStats[$iKey] = preg_replace('/s+/', ' ', $sMemoryStat); 
                    if(preg_match('/[0-9]+/', $sMemoryStat, $aMem)) 
                    { 
                        $aMemoryStats[$iKey] = ($aMem[0]/1024); 
                    } 
                } 
                $aStats[Phpfox::getPhrase('admincp.total_server_memory')] = (int)$aMemoryStats[0] . ' MB';
                $aStats[Phpfox::getPhrase('admincp.available_server_memory')] = (int)$aMemoryStats[1] . ' MB';
            }
		}
		
		if (!PHPFOX_OPEN_BASE_DIR && ($sLoad = Phpfox::getService('core.load')->get()) !== null)
		{
			$aStats[Phpfox::getPhrase('admincp.current_server_load')] = $sLoad;	
		}
	    
	    return $aStats;
	}
	
	/**
	 * If a call is made to an unknown method attempt to connect
	 * it to a specific plug-in with the same name thus allowing 
	 * plug-in developers the ability to extend classes.
	 *
	 * @param string $sMethod is the name of the method
	 * @param array $aArguments is the array of arguments of being passed
	 */
	public function __call($sMethod, $aArguments)
	{
		/**
		 * Check if such a plug-in exists and if it does call it.
		 */
		if ($sPlugin = Phpfox_Plugin::get('core.service_system__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}

	private static function _getUsableMemory()
	{
		$sVal = trim(@ini_get('memory_limit'));
	
		if (preg_match('/(\\d+)([mkg]?)/i', $sVal, $aRegs))
		{
			$sMemoryLimit = (int) $aRegs[1];
			switch ($aRegs[2])
			{	
				case 'k':
				case 'K':
					$sMemoryLimit *= 1024;
					break;	
				case 'm':
				case 'M':
					$sMemoryLimit *= 1048576;
					break;	
				case 'g':
				case 'G':
					$sMemoryLimit *= 1073741824;
					break;
			}
			
			$sMemoryLimit /= 2;
		}
		else
		{
			$sMemoryLimit = 1048576;
		}
	
		return $sMemoryLimit;
	}		
}

?>