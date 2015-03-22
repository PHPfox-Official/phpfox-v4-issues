<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

require(PHPFOX_DIR_LIB . 'foxporter' . PHPFOX_DS . 'interface.class.php');
require(PHPFOX_DIR_LIB . 'foxporter' . PHPFOX_DS . 'abstract.class.php');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: foxporter.class.php 2633 2011-05-30 13:57:44Z Raymond_Benc $
 */
class Foxporter
{	
	public function __construct()
	{
		
	}
	
	public function processStep($sModule, $sStep)
	{
		$sDir = PHPFOX_DIR_LIB . 'foxporter' . PHPFOX_DS . 'module' . PHPFOX_DS . $sModule . PHPFOX_DS;
		
		require_once($sDir . 'foxporter.class.php');
			
		eval('$oObject = new FoxporterModule_' . $sModule . '();');		
		
		if (empty($sStep))
		{
			$sStep = 'setup';
		}

		foreach ((array) $oObject->getSteps() as $sKey => $mValue)
		{
			if ($sKey == $sStep)
			{
				$mReturnData = $oObject->$mValue['method']();
				break;
			}
		}
		
		if (isset($mReturnData))
		{
			return $mReturnData;
		}
	}
	
	public function getModules()
	{
		$aModules = array();
		$sDir = PHPFOX_DIR_LIB . 'foxporter' . PHPFOX_DS . 'module' . PHPFOX_DS;
		$hDir = opendir($sDir);
		while ($sFolder = readdir($hDir))
		{
			if ($sFolder == '.' || $sFolder == '..')
			{
				continue;
			}
			
			if (!file_exists($sDir . $sFolder . PHPFOX_DS . 'foxporter.class.php'))
			{
				continue;
			}
			
			require_once($sDir . $sFolder . PHPFOX_DS . 'foxporter.class.php');
			
			eval('$oObject = new FoxporterModule_' . $sFolder . '();');
			
			$aModules[$sFolder] = $oObject->getDetails();
		}
		closedir($hDir);
		
		return $aModules;
	}
}

?>