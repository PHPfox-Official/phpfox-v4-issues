<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Used to import data from a archive like a ZIP or tar.gz. This class however
 * is not being used and is currently on hold to be removed or replaced by a new routine.
 * Thus no further documentation was created for this specific class.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: import.class.php 4906 2012-10-22 04:52:14Z Raymond_Benc $
 */
class Phpfox_Archive_Import
{
	private $_aArchives = array();
	
	private $_aSupported = array(
		'xml',
		'zip',
		'tar.gz'
	);
	
	private $_aTypes = array(
		'application/x-gzip' => 'tar.gz',
		'application/x-zip' => 'zip',
		'application/zip' => 'zip',
		'application/x-zip-compressed' => 'zip',
		'text/xml' => 'xml'
	);
	
	public function __construct()
	{	
	}
	
	public function set($aArchives)
	{		
        foreach ($aArchives as $sArchive)
		{
			if (!in_array($sArchive, $this->_aSupported))
			{
				continue;
			}
			
			if (!class_exists('ZipArchive') && ($sArchive == 'zip' || $sArchive == 'tar.gz') && strtolower(PHP_OS) != 'linux')
			{
				continue;
			}
			
			$this->_aArchives[] = $sArchive;
		}
		
		return $this;
	}
	
	public function getSupported()
	{
		$iTotal = count($this->_aArchives);
		$sSupported = '';
		
		$iCnt = 0;
		foreach ($this->_aArchives as $sArchive)
		{
			$iCnt++;
			$sSupported .= (count($this->_aArchives) > 1 ? ($iCnt == $iTotal ? ' ' . Phpfox::getPhrase('admincp.or') . ' ' : ', ') : '') . $sArchive;
		}
		
		return $sSupported;
	}	
	
	public function process($aFile)
	{
		if (!Phpfox::getParam('core.is_auto_hosted'))
		{
			return Phpfox_Error::set('Unable to import data using the current routine. Use the manual method of importing data.');
		}
		
		if (!preg_match('/^(.*?)\.zip$/i', $aFile['name']))
		{
			return Phpfox_Error::set('Not a valid ZIP package.');
		}
		
		$sExt = 'zip';

		$sLocationId = md5(PHPFOX_TIME . uniqid() . $aFile['name']) . PHPFOX_DS;
		$sLocation = PHPFOX_DIR_CACHE  . $sLocationId;
		
		mkdir($sLocation);
		
		$sThemeName = str_replace(array('phpfox-theme-', '.zip'), '', $aFile['name']);
		
		Phpfox::getLib('archive', $sExt)->extract($aFile['tmp_name'], $sLocation);
		
		$aFiles = Phpfox::getLib('file')->getAllFiles($sLocation);
		foreach ($aFiles as $sFile)
		{
			$sNewFile = str_replace($sLocation, '', $sFile);
			
			if (!preg_match('/([a-zA-Z0-9-]\.(xml|css|png|gif|jpg|jpeg|html.php))/i', $sFile)
					|| !preg_match('/theme\/frontend\/' . $sThemeName . '\//i', $sFile)	
				)
			{
				continue;
			}

			if (substr($sFile, -9) == '.html.php')
			{
				$sContent = file_get_contents($sFile);
				$hFile = fopen($sFile, 'w');
				fwrite($hFile, "<?php defined('PHPFOX') or exit('NO DICE!'); ?>\n" . $sContent);
				fclose($hFile);
			}
						
			$aParts = explode(PHPFOX_DS, $sNewFile);
			unset($aParts[(count($aParts) - 1)]);
			$sDirPath = implode(PHPFOX_DS, $aParts);
			
			$sDirPath = ltrim($sDirPath, 'upload/');
			if (preg_match('/([a-zA-Z0-9-]\.(png|gif|jpg|jpeg))/i', $sFile))
			{
				Phpfox::getLib('cdn')->put($sFile, str_replace('upload/', '', $sNewFile));
			}
			
			// Phpfox::getLib('ftp')->mkdir(PHPFOX_DIR . $sDirPath, true);	
			// Phpfox::getLib('ftp')->put($sFile, PHPFOX_DIR . $sNewFile);			
		}
				
		// Phpfox::getLib('file')->delete_directory($sLocation);
				
		return $sLocationId;		
	}
}

?>
