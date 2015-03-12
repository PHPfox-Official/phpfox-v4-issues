<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Display a 404 error
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Error
 * @version 		$Id: 404.class.php 5846 2013-05-09 10:47:40Z Raymond_Benc $
 */
class Error_Component_Controller_404 extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aRequests = Phpfox::getLib('request')->getRequests();
        
        if ($sPlugin = Phpfox_Plugin::get('error.component_controller_notfound_1')){eval($sPlugin); if (isset($mReturnPlugin)){ return $mReturnPlugin;}}
        
		$aNewRequests = array();
		$iCnt = 0;
		foreach ($aRequests as $sKey => $sValue)
		{
			if (!preg_match('/req[0-9]/', $sKey))
			{
				$aNewRequests[$sKey] = $sValue;
				
				continue;
			}
						
			if ($sValue == 'public')
			{
				continue;
			}
			
			$iCnt++;
			
			$aNewRequests['req' . $iCnt] = $sValue;
		}	
		
		if (isset($aNewRequests['req1']))
		{
			if ($aNewRequests['req1'] == 'gallery')
			{
				$aNewRequests['req1'] = 'photo';
			}
			elseif ($aNewRequests['req1'] == 'browse')
			{
				$aNewRequests['req1'] = 'user';
			}		
			elseif ($aNewRequests['req1'] == 'groups')
			{
				$aNewRequests['req1'] = 'group';
			}		
			elseif ($aNewRequests['req1'] == 'videos')
			{
				$aNewRequests['req1'] = 'video';
			}	
			elseif ($aNewRequests['req1'] == 'listing')
			{
				$aNewRequests['req1'] = 'marketplace';
			}				
		}
		
		if (isset($aNewRequests['req1']) && Phpfox::isModule($aNewRequests['req1']) && Phpfox::hasCallback($aNewRequests['req1'], 'legacyRedirect'))
		{
			$sRedirect = Phpfox::callback($aNewRequests['req1'] . '.legacyRedirect', $aNewRequests);	
		}
		
		if (isset($sRedirect) && $sRedirect !== false && !defined('PHPFOX_IS_FORCED_404'))
		{
			header('HTTP/1.1 301 Moved Permanently');
			
			if (is_array($sRedirect))
			{
				$this->url()->send($sRedirect[0], $sRedirect[1]);	
			}
			
			$this->url()->send($sRedirect);
		}
		
		if (Phpfox::getParam(array('balancer', 'enabled')))
		{
			$sDo = $this->request()->get(PHPFOX_GET_METHOD);
				
			if (preg_match('/\/file\/css\/(.*)_(.*)/i', $sDo, $aMatches))
			{
				$sContent = file_get_contents(Phpfox::getLib('server')->getServerUrl($aMatches[1]) . ltrim($sDo, '/'));
				
				$hFile = fopen(PHPFOX_DIR . ltrim($sDo, '/'), 'w+');
				fwrite($hFile, $sContent);
				fclose($hFile);				
				
				header("Content-type: text/css");
				echo $sContent;
				exit;
			}				
		}
		
		header("HTTP/1.0 404 Not Found");
		
		$sUrl = (isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : '');
		$sCurrentUrl = $_SERVER['REQUEST_URI'];
		$aParts = explode('?', $sCurrentUrl);
		$sNewUrl = $aParts[0];
		
		if (substr($sNewUrl, -3) == '.js')
		{
			exit('JavaScript file not found.');
		}
		elseif (substr($sNewUrl, -4) == '.css')
		{
			exit('CSS file not found.');
		}		
		
		if ($sUrl)
		{
			// If its an image lets create a small "not found" image
			if (substr($sUrl, -4) == '.gif' || substr($sUrl, -4) == '.png' || substr($sUrl, -4) == '.jpg' || substr($sUrl, -5) == '.jpeg') 
			{
		        // Log any missing images if the setting is enabled (Mostly used when developing new themes)
				if (Phpfox::getParam('core.log_missing_images'))
		        {
					if ($hFile = @fopen(PHPFOX_DIR . 'file/log/phpfox_missing_images.log', 'a+'))
					{
				        $sData = $sUrl . (isset($_SERVER['HTTP_REFERER']) ? " ({$_SERVER['HTTP_REFERER']})" : "");
						fwrite($hFile, $sUrl . "\n");
				        fclose($hFile);
					}
		        }
				
				$sText = 'Not Found!';
				$nW = 100;
		        $nH = 30;
		        $nLeft = 5;
		        $nTop = 5;
				$hImg = imageCreate($nW, $nH);
			    $nBgColor  = imageColorAllocate($hImg, 0, 0, 0);
		        $nTxtColor = imageColorAllocate($hImg, 255, 255, 255);
		        imageString($hImg, 5, $nLeft, $nTop,  $sText, $nTxtColor);
		        
		        ob_clean();
		        header('Content-Type: image/jpeg');
		        imagejpeg($hImg);        
				exit;		
			}	
		}
		
		$this->template()->errorClearAll();
		$this->template()->setTitle('Page Not Found');	
		$this->template()->setBreadcrumb('Page Not Found');
		$this->template()->assign('aFilterMenus', array());		
	}
}

?>
