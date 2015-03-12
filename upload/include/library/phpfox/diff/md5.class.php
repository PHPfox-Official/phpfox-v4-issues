<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Exports all the files used by the product and creates an MD5 identification for the 
 * file. This is mainly used to idenify if a script has been modified in comparison
 * to the default script provided by us.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: md5.class.php 1666 2010-07-07 08:17:00Z Raymond_Benc $
 */
class Phpfox_Diff_Md5
{
	/**
	 * Class constructor
	 *
	 */
	public function __construct()
	{	

	}
	
	/**
	 * Checks if there are any modified files in the product.
	 *
	 */
	public function verify()
	{
		$aVals = Phpfox::getLib('xml.parser')->parse(PHPFOX_DIR_XML . 'md5_sum' . PHPFOX_XML_SUFFIX);
		foreach ($aVals['file'] as $aVal)
		{			
			$aFile = file(PHPFOX_DIR . $aVal['value']);
			$sSource = '';
			foreach ($aFile as $sLine)
			{
				$sCheckLine = trim($sLine);
				
				if ($sCheckLine == ''
					|| $sCheckLine == '/**'
					|| $sCheckLine == '*'
					|| $sCheckLine == '*/'
					|| substr($sCheckLine, 0, 1) == '*'
					|| substr($sCheckLine, 0, 2) == '//'
				)
				{
					continue;
				}		
				
				$sSource .= $sLine;
			}			
			
			if ($aVal['hash'] != md5($sSource))
			{
				echo $aVal['hash'] . " -> " . md5($sSource) ." -> " . $aVal['value'] . "\n";
			}
		}
	}
	
	/**
	 * Creates an XML export of all the files in the product and includes an MD5 hash
	 * that identifies each of the files content
	 *
	 * @return string XML output
	 */
	public function export()
	{
		$oXmlBuilder = Phpfox::getLib('xml.builder');
		$oXmlBuilder->addGroup('files', array('version' => PhpFox::getId()));
		
		$aFiles = $this->_getFiles(rtrim(PHPFOX_DIR, PHPFOX_DS));	
		sort($aFiles);	
		foreach ($aFiles as $sFile)
		{
			if (preg_match("/\.svn/i", $sFile)
				|| preg_match("/tiny_mce/i", $sFile)
				|| preg_match("/fckeditor/i", $sFile)
				|| preg_match("/file\/cache/i", $sFile)
				|| preg_match("/jscript\/jquery/i", $sFile)
				|| preg_match("/include\/hook/i", $sFile)				
				|| preg_match("/file\\\cache/i", $sFile)
				|| preg_match("/file\\\static/i", $sFile)
				|| preg_match("/jscript\\\jquery/i", $sFile)
				|| preg_match("/include\\\plugin/i", $sFile)				
				
				|| (substr($sFile, -4) != '.php' && substr($sFile, -5) != '.html' && substr($sFile, -4) != '.css' && substr($sFile, -3) != '.js')
			)
			{
				continue;
			}	
			
			$aFile = file($sFile);
			$sSource = '';
			foreach ($aFile as $sLine)
			{
				$sCheckLine = trim($sLine);
				
				if ($sCheckLine == ''
					|| $sCheckLine == '/**'
					|| $sCheckLine == '*'
					|| $sCheckLine == '*/'
					|| substr($sCheckLine, 0, 1) == '*'
					|| substr($sCheckLine, 0, 2) == '//'
				)
				{
					continue;
				}		
				
				$sSource .= $sLine;
			}			
		
			$oXmlBuilder->addTag('file', str_replace('\\', '/', str_replace(PHPFOX_DIR, '', $sFile)), array(
					'hash' => md5($sSource)
				)
			);
		}
		
		$oXmlBuilder->closeGroup();
		
		return $oXmlBuilder->output();
	}
	
	/**
	 * Gets all the files found in the root directory of the script or 
	 * based on the 1st arg..
	 *
	 * @param string $sFrom Folder to get all the files from
	 * @return array An ARRAY of all the files found in a specific folder
	 */
	private function _getFiles($sFrom = '.')
	{
	    if (!is_dir($sFrom))
	    {
			return false;
	    }
	   
	    $aFiles = array();
	    $aDirs = array( $sFrom);
	    while(null !== ($sDir = array_pop( $aDirs)))
	    {
	        if( $hDir = opendir($sDir))
	        {
	            while(false !== ($sFile = readdir($hDir)))
	            {
	                if( $sFile == '.' || $sFile == '..')
	                {
	                    continue;
	                }	                
	                    
	                $sPath = $sDir . PHPFOX_DS . $sFile;	             
	                
	                if(is_dir($sPath))
	                {
	                    $aDirs[] = $sPath;
	                }
	                else
	                {
	                    $aFiles[] = $sPath;
	                }
	            }
	            closedir($hDir);
	        }
	    }
	    return $aFiles;
	}	
}

?>