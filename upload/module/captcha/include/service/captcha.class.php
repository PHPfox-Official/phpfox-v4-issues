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
 * @package  		Module_Captcha
 * @version 		$Id: captcha.class.php 6005 2013-06-06 14:12:12Z Raymond_Benc $
 */
class Captcha_Service_Captcha extends Phpfox_Service 
{
	private $_oSession;
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{		
		$this->_oSession = Phpfox::getService('log.session');
	}
	
	public function checkHash($sCode = null)
	{
		if (Phpfox::getParam('captcha.recaptcha'))
		{
			require_once(PHPFOX_DIR_LIB . 'recaptcha' . PHPFOX_DS . 'recaptchalib.php');		
		
			if (isset($_POST["recaptcha_response_field"])) 
			{			
		        $oResp = recaptcha_check_answer(Phpfox::getParam('captcha.recaptcha_private_key'), $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
		
		        if ($oResp->is_valid) 
		        {        	
		        	return true;
		        } 
		        else 
		        {               
		        	return false;
		        }	        
			}	
	
			return false;
		}		

		if (Phpfox::getParam('core.store_only_users_in_session'))
		{
			$oSession = Phpfox::getLib('session');

			$sSessionHash = $oSession->get('sessionhash');

			$aRow = $this->database()->select('*')
				->from(Phpfox::getT('log_session'))
				->where('session_hash = \'' . $this->database()->escape($sSessionHash) . '\'')
				->execute('getSlaveRow');

			if (isset($aRow['session_hash']) && $this->_getHash(strtolower($sCode), $aRow['session_hash']) == $aRow['captcha_hash'])
			{
				return true;
			}
		}
		else
		{
			if ($this->_getHash(strtolower($sCode), $this->_oSession->getSessionId()) == $this->_oSession->get('captcha_hash'))
			{
				return true;
			}
		}

		return false;
	}
	
	public function setHash($sCode)
	{
		if (Phpfox::getParam('core.store_only_users_in_session'))
		{
			$oRequest = Phpfox::getLib('request');
			$oSession = Phpfox::getLib('session');

			$sSessionHash = $oSession->get('sessionhash');
			$bCreate = true;

			if (!empty($sSessionHash))
			{
				$bCreate = false;
				$aRow = $this->database()->select('*')
					->from(Phpfox::getT('log_session'))
					->where('session_hash = \'' . $this->database()->escape($sSessionHash) . '\'')
					->execute('getSlaveRow');

				if (isset($aRow['session_hash']))
				{
					$this->database()->update(Phpfox::getT('log_session'), array('captcha_hash' => $this->_getHash($sCode, $sSessionHash)), "session_hash = '" . $sSessionHash . "'");
				}
				else
				{
					$bCreate = true;
				}
			}

			if ($bCreate)
			{
				$sSessionHash = $oRequest->getSessionHash();
				$this->database()->insert(Phpfox::getT('log_session'), array(
						'session_hash' => $sSessionHash,
						'id_hash' => $oRequest->getIdHash(),
						'captcha_hash' => $this->_getHash($sCode, $sSessionHash),
						'user_id' => Phpfox::getUserId(),
						'last_activity' => PHPFOX_TIME,
						'location' => '',
						'is_forum' => '0',
						'forum_id' => 0,
						'im_hide' => 0,
						'ip_address' => '',
						'user_agent' => ''
					)
				);
				$oSession->set('sessionhash', $sSessionHash);
			}
		}
		else
		{
			$iId = $this->_oSession->getSessionId();

			$this->database()->update(Phpfox::getT('log_session'), array('captcha_hash' => $this->_getHash($sCode, $iId)), "session_hash = '" . $iId . "'");
		}
	}
	
	public function displayCaptcha($sText)
	{
		((Phpfox::getParam('captcha.captcha_use_font') && function_exists('imagettftext')) ? $this->_writeFromFont($sText) : $this->_writeFromString($sText));
		
        ob_clean();
        
        header("X-Content-Encoded-By: phpFox " . PhpFox::getVersion());
        header("Pragma: no-cache");
		header('Cache-Control: no-store, no-cache, must-revalidate'); 
        header('Content-Type: image/jpeg');
        
        imagejpeg($this->_hImg);	
        imagedestroy($this->_hImg);		
	}	
	
	public function generateCode($sCharacters) 
   	{   
		$sPossible = Phpfox::getParam('captcha.captcha_code');
      	$sCode = '';
      	$i = 0;
      	while ($i < $sCharacters) 
      	{ 
			$sCode .= substr($sPossible, mt_rand(0, strlen($sPossible)-1), 1);
      	   	$i++;
      	}      
		return strtolower($sCode);
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
		if ($sPlugin = Phpfox_Plugin::get('captcha.service_captcha__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}		
	
	private function _getHash($sCode, $sSalt)
	{
		return md5(md5($sCode) . $sSalt);
	}
	
	private function _writeFromFont($sText)
	{
		$iString = strlen($sText);
		$iWidth = (($iString + 5) * 10 * 2);
		$iHeight = 45;
		$iTextSize = 20;
		$sFont = Phpfox::getParam('core.dir_static') . 'image/font/' . Phpfox::getParam('captcha.captcha_font');
		
		if (!file_exists($sFont))
		{
			return $this->_writeFromString($sText);
		}
		
		$this->_imageCreate($iWidth, $iHeight);
		
		$nBgColor  = imageColorAllocate($this->_hImg, 255, 255, 255);
        $nTxtColor = imageColorAllocate($this->_hImg, 0, 0, 0);		
        
		if (!($aBox = @imagettfbbox($iTextSize, 0, $sFont, $sText)))
		{
			return $this->_writeFromString($sText);
		}
		
		//Find out the width and height of the text box
		$iTextW = $aBox[2] - $aBox[0];
		$iTextH = $aBox[5] - $aBox[3];        

        if (function_exists('imagefilledellipse'))
	    {
	    	$nNoiseColor = imagecolorallocate($this->_hImg, 207, 181, 181);
	    	for ($i = 0; $i < ($iWidth*$iHeight) / 3; $i++)
	      	{
	        	imagefilledellipse($this->_hImg, mt_rand(0, $iWidth), mt_rand(0, $iHeight), 1, 1, $nNoiseColor);
			}
		}

		$iImageLineColor = imagecolorallocate($this->_hImg, 207, 181, 181);
	    for ($i = 0; $i < ($iWidth*$iHeight) / 150; $i++)
	    {
	      	imageline($this->_hImg, mt_rand(0, $iWidth), mt_rand(0, $iHeight), mt_rand(0, $iWidth), mt_rand(0, $iHeight), $iImageLineColor);
	    }		
      		
		// Calculate the positions
		$positionLeft = (($iWidth - $iTextW) / 2) - (20 + $iString);
		$positionTop = (($iHeight - $iTextH) / 2);
		
		for ($i = 0; $i < $iString; $i++) 
		{ 
			if (!@imagettftext($this->_hImg, $iTextSize, 0, $positionLeft, 30, $nTxtColor, $sFont, $sText[$i]))
			{
				return $this->_writeFromString($sText);
			}
			
			$positionLeft += 20;
		}
	}
	
	private function _writeFromString($sText)
	{
		$iString = strlen($sText);
		$iWidth = (($iString + 5) * 6.4 * 2);
		$iHeight = 40;
		
		$this->_imageCreate($iWidth, $iHeight);
		
		$nBgColor  = imageColorAllocate($this->_hImg, 255, 255, 255);
        $nTxtColor = imageColorAllocate($this->_hImg, 0, 0, 0);        
        
        $positionLeft = 20;
        
		for ($i = 0; $i < $iString; $i++) 
		{ 
			imagestring($this->_hImg, 5, $positionLeft, 12,  $sText[$i], $nTxtColor);
			
			$positionLeft += 15;
		}        
	}

	private function _imageCreate($iWidth, $iHeight)
	{
		$this->_hImg = imageCreate($iWidth, $iHeight);
	} 	
}

?>