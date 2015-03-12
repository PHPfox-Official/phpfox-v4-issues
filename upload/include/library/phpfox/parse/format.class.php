<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Common String Handling
 * This class is used to run common methods on strings or do sanity checks on a string.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: format.class.php 5538 2013-03-25 13:20:22Z Miguel_Espinoza $
 */
class Phpfox_Parse_Format
{
	/**
	 * Checks if a given string is serialized or not.
	 *
	 * @param string $sData Data to check.
	 * @return bool TRUE if string is serialized, FALSE if not.
	 */
	public function isSerialized($sData) 
	{		
		if (!is_string($sData))
		{
			return false;
		}
		
		$sData = trim($sData);
		
		if ('N;' == $sData)
		{
			return true;
		}
		
		if (!preg_match('/^([adObis]):/', $sData, $aMatches))
		{
			return false;
		}
		
		switch ($aMatches[1]) 
		{
			case 'a' :
			case 'O' :
			case 's' :
				if (preg_match("/^{$aMatches[1]}:[0-9]+:.*[;}]\$/s", $sData))
				{
					return true;
				}
				break;
			case 'b' :
			case 'i' :
			case 'd' :
				if (preg_match("/^{$aMatches[1]}:[0-9.E-]+;\$/", $sData ))
				{
					return true;
				}
				break;
			default:
				
				break;			
		}
		
		return false;
	}	
	
	/**
	 * Uses the class DOMDocument to clean HTML and make it valid XHTML.
	 *
	 * @link http://php.net/manual/en/class.domdocument.php 
	 * @param string $sStr String we need to parse.
	 * @return string Parsed string withn clean valid XHTML code.
	 */
	public function validXhtml($sStr)
	{
		if (class_exists('DOMDocument'))
		{
			static $oDoc = null;
			
			if ($oDoc === null)
			{
				$oDoc = new DOMDocument('1.0');
			}
			
			Phpfox_Error::skip(true);	
			$oDoc->loadHTML($sStr);			
			$sStr = $oDoc->saveHTML();
			$sStr = preg_replace('/^<!DOCTYPE.+?>/i', '', $sStr);
			$sStr = trim($sStr);
			if (substr($sStr, 0, 12) == '<html><body>')
			{
				$sStr = substr_replace($sStr, '', 0, 12);
			}
			if (substr($sStr, -14) == '</body></html>')
			{
				$sStr = substr_replace($sStr, '', -14);
			}					
			Phpfox_Error::skip(false);			
		}
		
		return $sStr;
	}
	
	/**
	 * Does a check to make sure a string is really not empty. This takes the PHP function
	 * empty a little further.
	 *
	 * @see empty()
	 * @param string $sStr String to check if it is empty or not.
	 * @return bool TRUE if string is empty, FALSE if not.
	 */
	public function isEmpty($sStr)
	{		
		$bEmpty = false;		
	
		if (preg_match("/&\#160;/i", Phpfox::getLib('parse.input')->clean($sStr)) && strlen(preg_replace_callback("/&\#160;/is", array($this, '_checkIfEmpty'), Phpfox::getLib('parse.input')->clean($sStr))) === 0)
		{
			$bEmpty = true;
		}	
		
		$sStr = preg_replace('/&nbsp;/i', '', $sStr);
		$sStr = preg_replace('/&nbsp/i', '', $sStr);
		$sStr = preg_replace('/&#160/i', '', $sStr);
		$sStr = preg_replace('/<img(.*?)>/is', '', $sStr);
		$sStr = preg_replace('/<a(.*?)><\/a>/is', '', $sStr);
		$sStr = str_replace('<p><br _mce_bogus="1"></p>', '', $sStr);

		if (strlen(preg_replace('/\s\s+/', '', $sStr)) === 0)
		{
			$bEmpty = true;
		}	
		
		return $bEmpty;
	}
	
	/**
	 * Hide the email service that is part of an email.
	 *
	 * Usage:
	 * <code>
	 * echo Phpfox::getLib('parse.format')->hideEmail('foo@bar.com');
	 * // Will output: foo@___.com
	 * </code>
	 * 
	 * @param string $sEmail Email to remove the email service.
	 * @return string Email without the email service.
	 */
	public function hideEmail($sEmail)
	{
		if (strpos($sEmail, '@') === false)
		{
			return $sEmail;
		}
		
		$aParts = explode('@', $sEmail);
		$aSubParts = explode('.', $aParts[1]);
		return $aParts[0] . '@____' . $aSubParts[1];
	}
	
	/**
	 * Parse PHP code with the correct amount of backslashes when storing it in a flat file.
	 *
	 * @param string $sCode PHP code to parse.
	 * @return string Parsed PHP code with the new backslashes in place.
	 */
	public function phpCode($sCode)
	{
		$sCode = str_replace('\\', '\\\\', $sCode);
		
		return $sCode;
	}
	
	/**
	 * Converting PHP htmlspecialchars()
	 *
	 * @see htmlspecialchars()
	 * @param string $sString String to convert.
	 * @return string Converted string to HTML.
	 */
	public function unhtmlspecialchars($sString)
	{
  		$sString = str_replace('&amp;', '&', $sString);
  		$sString = str_replace('&lt;', '<', $sString);
  		$sString = str_replace('&gt;', '>', $sString);
  		$sString = str_replace('&quot;', '"', $sString);
		$sString = str_replace('&#39;', '\'', $sString);
    	$sString = str_replace('&#039;', '\'', $sString);

  		return $sString;
	}	
	
	/**
	 * Check done via a callback within the isEmpty() method to see if a string is empty or not.
	 *
	 * @see self::isEmpty()
	 * @param array $aMatches ARRAY of matches passed by the callback.
	 * @return string If string is empty we an emptry string, if not we return 1.
	 */
	private function _checkIfEmpty($aMatches)
	{		
		if ($aMatches[0] == '&#160;')
		{
			return '';
		}
		return '1';
	}
	
	/**
	 * Checks JS code to add a semi colon so its ok to minify
	 * @param string $sJS
	 */ 
	public function helpJS($sJS)
	{
		// $sJS = str_replace("\n",'', $sJS);
		
		// function a(){} = 14 characters
		$iMinLength = 14;
		if (strlen($sJS) < $iMinLength) { return $sJS; }
		
		// 1. store the current position of cursor
		$iPos = 0;
		
		// 2. find the keyword "function"		
		while ( ($iPos < strlen($sJS)) )
		{
			$iPos = strpos($sJS, 'function', $iPos);
			if ($iPos === false)
			{
				//echo "\n\n\n\n\n\n\n\nNo more functions, im out!";
				break;
			}
			 
			// 3. get the previous character (ignoring white-spaces and line breaks)
			$iPosPrev = $iPos - 1;
			$bNeedsClosing = false;
			
            $iMaxBacktrack = 0;
			while( ($iPosPrev > 0) && ($iPosPrev <= $iPos) && $iMaxBacktrack < 7)
			{
				$cPrev = substr($sJS, $iPosPrev, 1);
				//d($iPosPrev . ',' . $iPos . ' = ' . $cPrev);
				switch( $cPrev )
				{
					// 4. If the previous character is a , or : this is an anonymous function and we skip it					
					case ' ':
					case "\n":
					case '(':
					case ';':		
						break;
					case ',':
					case ':':
							
						//d('1. Previous character "' . $cPrev . '"');
						break(2);
					case '=':						
					default:
						//d('2. Previous character"' . $cPrev . '"');
						$bNeedsClosing = true;
						$iMaxBacktrack = 8;
				}
				$iPosPrev--;
                $iMaxBacktrack++;
			}
			
			if ($bNeedsClosing == true)
			{
				// 5. if the previous character is a = then this function must end with a ; after the }
				// find where this function has the very first {
				$iBrackCnt = 0;
				
				// Move the pointer to the first {, at this moment iPos points to the keyword function
				$iPos = strpos($sJS, '{', $iPos); 
								
				// We will now count brackets 
				while ( ($iPos <= strlen($sJS) ) )
				{
					$cBracket = substr($sJS, $iPos, 1);
					//d('iBrackCnt: ' . $iBrackCnt . ' = "' . $cBracket . '"');
					if ($cBracket == '{') 
					{
						$iBrackCnt++;
						//echo '<span style="color:yellow;">'. $cBracket . '</span>';
					}
					else if ($cBracket == '}') 
					{
						$iBrackCnt--;						
					}
					else if ($iBrackCnt == 0)
					{
						// it closed the last bracket, we are at the end of the function
						// Check if the next character is a semicolon						
						if ($cBracket == ';') 
						{
							// All good
						}
						else
						{
							$sJS = substr($sJS, 0, $iPos) .';' .substr($sJS, $iPos);							
							break;
						}						
					}					
					$iPos++;
				}
			}
			else
			{
				$iPos++;
			}	
		}
		$sJS = str_replace('};)', '})', $sJS);
		return $sJS;
	}	

/*
	public function helpJS2($sJS)
	{
		$iMinLength = 14;
		$iLength = strlen($sJS);
		if ($iLengthh < $iMinLength) { die('returning at 1'); }
		$iPos = 0;
		
		$sOut = '';
		for ($iPos; $iPos < $iLength; $iPos++)
		{
			$cCurrent = substr($sJs, $iPos, 1);
			$sOut .= $cCurrent;
			
			// Check if the last word was function
			if (substr($sOut, (strlen($sOut) - strlen('function'))) == 'function')
			{
				$iLastFunctionPos = strrpos($sOut, 'function');
				$bFix = false;
				for ($iLastFunctionPos; $iLastFunctionPos > 0; $iLastFunctionPos--)
				{
					$cCheck = substr($sOut, $iLastFunctionPos, 1);
					if ( ($cCheck == '=') )
					{
						$bFix = true;
						break;
					}
				}
				if ($bFix == true)
				{
					// Now we search forward for the brackets and count them
					
				}
			}
		}
	}*/
}

?>
