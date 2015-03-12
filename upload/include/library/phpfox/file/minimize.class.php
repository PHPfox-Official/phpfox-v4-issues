<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: minimize.class.php 7236 2014-03-28 12:51:07Z Fern $
 */
class Phpfox_File_Minimize
{
	public function __construct()
	{		
	}
	
	public function js($sContent)
	{		
		if (file_exists(PHPFOX_DIR_LIB . 'jsmin/jsmin.class.php'))
		{
			require_once(PHPFOX_DIR_LIB . 'jsmin/jsmin.class.php');		
			
			return JSMin::minify($sContent);
		}
		
		return $sContent;
	}
	
	public function css($sContent)
	{
		$sContent = preg_replace_callback('/url\([\'"](.*?)[\'"]\)/is', array($this, '_replaceImages'), $sContent);		
		$sContent = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $sContent);
		$sContent = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $sContent);				
		
		return $sContent;
	}
	
	public function _replaceImages($aMatches)
	{
		$sMatch = trim($aMatches[1]);
		$sMatch = str_replace('../image/', '', $sMatch);
		
		return 'url(\'' . Phpfox::getLib('template')->getStyle('image', $sMatch) . '\')';
	}

	/*
	 * @param array|string $aFiles What to minify, may be a string or an array of strings
	 * @param string $sVersion To add to the url to output
	 * @param boolean $bIsJS
	 * @param boolean $bDoInit In some cases we may not want to add the Core.init() to the JS file
	 * @param boolean $bReturn Sometimes we just need to minify and not to store the file anywhere specific
	 * @param boolean $bReplaceUrl When creating the master files it is not needed to replace the url in CSS: url(/../../
	 */ 
    public function minify($aFiles, $sVersion, $bIsJS = true, $bDoInit = false, $bReturn = false, $bReplaceUrl = true)
    {
        static $oFormat = null;
        
        if (!isset($oFormat))
        {
            $oFormat = Phpfox::getLib('parse.format');
        }
        if (!is_array($aFiles))
        {
			$aFiles = array($aFiles);
		}
        $sHash = md5(implode($aFiles) . $sVersion);
        $sNameMd5 = md5(implode($aFiles) . $sVersion) . ($bIsJS ? '.js' : '.css');
        $sFilePath = PHPFOX_DIR_FILE . 'static' . PHPFOX_DS . $sNameMd5;
        $sUrl = Phpfox::getParam('core.path') .'file/static/'. $sNameMd5;
        
        $bExists = false;
        if (Phpfox::getParam('core.allow_cdn') && Phpfox::getParam('core.push_jscss_to_cdn'))
        {
        	$sCacheId = Phpfox::getLib('cache')->set(array('jscss', $sHash));
        	if ((Phpfox::getLib('cache')->get($sCacheId)))
        	{
        		$bExists = true;
        	}
        }
        else
        {
        	$bExists = file_exists($sFilePath);
        }

        if ($bExists)
        {
            if (Phpfox::getParam('core.allow_cdn') && Phpfox::getParam('core.push_jscss_to_cdn'))
            {
                $sUrl = Phpfox::getLib('cdn')->getUrl($sUrl);
            }
        }
        else
        {
            $sMinified = '';
            if ($bIsJS)
            {  
                foreach ($aFiles as $sFile)
                {
					$sOriginal = file_get_contents(PHPFOX_DIR . $sFile);    
					$oJsMin = new JSMin($sOriginal);
					$sCompressed = $oJsMin->min();                    
					// $sCompressed = $oFormat->helpJS($sCompressed);                    
					$sMinified .= "\n /* {$sFile} */" . $sCompressed;					
                }                
            }
            else
            {
				
				$sHomeThemePath = (Phpfox::getParam('core.force_https_secure_pages') && Phpfox::getParam('core.force_secure_site')) ? 'https://' : 'http://';
				$sHomeThemePath .= Phpfox::getParam('core.host') . Phpfox::getParam('core.folder') . 'theme';
				
                foreach ($aFiles as $sFile)
                {
					$sOriginal = file_get_contents(PHPFOX_DIR . $sFile);
					$sCompressed = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), ' ', $sOriginal);
					$sPathTo = substr($sFile, 0, strrpos($sFile, '/'));
					$sPathTo = substr($sPathTo, 0, strrpos($sPathTo, '/'));

					if (Phpfox::getParam('core.allow_cdn') && Phpfox::getParam('core.push_jscss_to_cdn') && defined('PHPFOX_IS_HOSTED_SCRIPT'))
					{
						$sCompressed = str_replace('url(\'..', 'url(\'' . Phpfox::getCdnPath() . '' . $sPathTo, $sCompressed, $iCount);
						$sCompressed = str_replace('url("..', 'url("' . Phpfox::getCdnPath() . '' . $sPathTo, $sCompressed, $iCount);
						$sCompressed = str_replace('url(..', 'url(' . Phpfox::getCdnPath() . '' . $sPathTo, $sCompressed, $iCount);
					}
					else if ($bReplaceUrl == true)
					{                    
						$sCompressed = str_replace('url(\'..', 'url(\'../../' . $sPathTo, $sCompressed, $iCount);
						$sCompressed = str_replace('url("..', 'url("../../' . $sPathTo, $sCompressed, $iCount);
						$sCompressed = str_replace('url(..', 'url(../../' . $sPathTo, $sCompressed, $iCount);
						$sCompressed = str_replace('../../theme', ''.$sHomeThemePath, $sCompressed, $iCount);
					}
											
					if ($bReplaceUrl == true)
					{
						$sCompressed = str_replace('css/', 'image/', $sCompressed);
					}					
                    $sMinified .= $sCompressed;
                }
            }
            if ($bReturn == true) return $sMinified;
            
            if ($bIsJS && $bDoInit)
            {
                 $sMinified .= "\n".'$Core.init();';
            }
            file_put_contents($sFilePath, $sMinified);

            // if cdn enabled put it in cdn as well here
            if (Phpfox::getParam('core.allow_cdn') && Phpfox::getParam('core.push_jscss_to_cdn'))
            {
            	Phpfox::getLib('cache')->save($sCacheId, '1');
                Phpfox::getLib('cdn')->put($sFilePath);      
                $sUrl = Phpfox::getLib('cdn')->getUrl($sUrl);
            }                
        }
        
        return $sUrl . $sVersion;
    }
    
}
