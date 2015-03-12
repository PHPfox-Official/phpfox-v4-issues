<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Validatior
 * Used for site wide validation of POST forms. Includes the feature to validate
 * forms using JavaScript and PHP as a failsafe.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: validator.class.php 6599 2013-09-06 08:18:37Z Miguel_Espinoza $
 */
class Phpfox_Validator
{	
	/**
	 * List of all the errors.
	 * 
	 * @var array
	 */
	private $aErrors = array();
	
	/**
	 * Name of the curremt HTML form.
	 * 
	 * @var string
	 */
	private $sFormName;
	
	/**
	 * Name of the validation.
	 * 
	 * @var string
	 */
	private $_sName;
	
	/**
	 * List of default regex rules.
	 * 
	 * @var array
	 */
	private $_aDefaults;
	
	/**
	 * Check to see if we should load a parent check.
	 * 
	 * @var bool
	 */
	private $_bParent = false;
	
	private $_bAllowZero = false;
	
	/**
	 * Default regex rules.
	 * 
	 * @var array
	 */
	private $_aRegex = array(
		'user_name' => '/^[a-zA-Z0-9_\- ]{5,25}$/',
		'email' => '/^[0-9a-zA-Z]([+\-.\w]*[0-9a-zA-Z]?)*@([0-9a-zA-Z][\-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,}$/',
		'html' => '/<(.*?)>/',
		'url' => '~(?>[a-z+]{2,}://|www\.)(?:[a-z0-9]+(?:\.[a-z0-9]+)?@)?(?:(?:[a-z](?:[a-z0-9]|(?<!-)-)*[a-z0-9])(?:\.[a-z](?:[a-z0-9]|(?<!-)-)*[a-z0-9])+|(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?))(?:/[^\\/:?*"<>|\n]*[a-z0-9])*/?(?:\?[a-z0-9_.%]+(?:=[a-z0-9_.%:/+-]*)?(?:&[a-z0-9_.%]+(?:=[a-z0-9_.%:/+-]*)?)*)?(?:#[a-z0-9_%.]+)?~is',
		'currency_id' => '/^[A-Z]{3,3}$/'
	);
	
	public function allowZero()
	{
		$this->_bAllowZero = true;
		return $this;
	}
	/**
	 * Class constructor used to load default validator rules.
	 * Found in the file: include/setting/validator.sett.php
	 * 
	 */
	public function __construct()
	{		
		// Require validation rule set
		require_once(PHPFOX_DIR_SETTING . 'validator.sett.php');
		
		$this->_aRegex['user_name'] = '/^[a-zA-Z0-9_\- ]{' . Phpfox::getParam('user.min_length_for_username') . ',' . Phpfox::getParam('user.max_length_for_username') . '}$/';
		
		(($sPlugin = Phpfox_Plugin::get('validator_construct')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Verify a regex pattern against a string value.
	 *
	 * @param string $sPattern Regex pattern to check.
	 * @param string $sValue String value.
	 * @return bool TRUE if string passed, FALSE if string failed; comes with error message.
	 */
	public function verify($sPattern, $sValue)
	{		
		if (!isset($this->_aDefaults[$sPattern]))
		{
			return Phpfox_Error::trigger('Invalid pattern.', E_USER_ERROR);
		}

		if (!preg_match($this->_aDefaults[$sPattern]['pattern'], $sValue))
		{
			return (isset($this->_aDefaults[$sPattern]['pattern']) ? Phpfox_Error::set($this->_aDefaults[$sPattern]['title']) : false);
		}
		
		return true;
	}
	
	/**
	 * Check a string value against multiple regex checks.
	 *
	 * @param string $sString Value to check.
	 * @param array $aParams ARRAY of regex checks to perform.
	 * @return bool FALSE if string failed, TRUE if string passed.
	 */
	public function check($sString, $aParams = array())
	{
		if (!is_array($aParams))
		{
			$aParams = array($aParams);
		}
		
		$bFailed = 0;		
		foreach ($aParams as $sRegex)
		{
			if (preg_match($this->_aRegex[$sRegex], $sString))
			{				
				$bFailed++;					
			}			
		}		
		
		return ($bFailed > 0 ? false : true);
	}
	
	/**
	 * Process a form and perform regex checks on all the values.
	 *
	 * @param array $aParams ARRAY of regex checks.
	 * @param array $aValues ARRAY of form values.
	 * @return mixed Returns all the values cleaned if everything is okay, however if something failed a regex check we return FALSE.
	 */
	public function process($aParams, $aValues)
	{
		foreach ($aValues as $sValueKey => $sValue)
		{
			if (!isset($aParams[$sValueKey]))
			{
				unset($aValues[$sValueKey]);
			}
		}		
		
	 	$sDebug = '';
		foreach ($aParams as $sKey => $aParam)
		{			
			if (!is_array($aParam))
			{
				$aParam = array('type' => $aParam);
			}
			
			if (!is_array($aParam['type']))
			{
				$aParam['type'] = array($aParam['type']);
			}			
			
			$bFailed = false;
			foreach ($aParam['type'] as $sType)
			{				
				switch ($sType)
				{
					case 'array:required':
					case 'array':
						
						if ($sType == 'array:required')
						{
							if (empty($aValues[$sKey]))
							{
								$bFailed = true;
								$sDebug = 'Value for array is empty.';										
							}							
						}
					
						if ($bFailed === false && isset($aValues[$sKey]) && !is_array($aValues[$sKey]))
						{
							$bFailed = true;
							$sDebug = 'Value is not an array.';		
						}
							
						break;			
					case 'phrase':
					case 'phrase:required':
						
						if ($sType == 'phrase:required')
						{
							if (empty($aValues[$sKey]))
							{
								$bFailed = true;
								$sDebug = 'Value for phrase is empty.';										
							}							
						}			
						
						if ($bFailed === false && isset($aValues[$sKey]) && !is_array($aValues[$sKey]))
						{
							$bFailed = true;
							$sDebug = 'Value for phrase is not an array.';		
						}
						
						if ($bFailed === false)
						{
							$iPhraseCount = 0;
							foreach ($aValues[$sKey] as $sLanguage => $sPhrase)
							{
								if (!empty($sPhrase))
								{
									$iPhraseCount++;
								}
							}
							
							if ($iPhraseCount === 0)
							{
								$bFailed = true;
								$sDebug = 'Phrase values are all empty.';
							}
						}					
						
						break;
					case 'php_code':
					case 'php_code:required':
						
						if ($sType == 'php_code:required')
						{
							if (empty($aValues[$sKey]))
							{
								$bFailed = true;
								$sDebug = 'Value for PHP code is empty.';										
							}							
						}
						
						if ($bFailed === false)
						{
							if (!empty($aValues[$sKey]))
							{
								$aValues[$sKey] = Phpfox::getLib('parse.format')->phpCode($aValues[$sKey]);	
							}
						}
						
						break;		
					case 'currency:required':
						if (!isset($aValues[$sKey]))
						{
							$bFailed = true;	
							$sDebug = 'Value not found.';
						}
						else 
						{
							if (!is_array($aValues[$sKey]))
							{
								$bFailed = true;
								$sDebug = 'Value is not an array.';
							}
						}			
						
						if ($bFailed === false)
						{
							$aValues[$sKey] = (array) $aValues[$sKey];
							
							foreach ($aValues[$sKey] as $sCurrency => $mValue)
							{
								if (empty($mValue) && strlen($mValue) < 1)
								{
									// unset($aValues[$sKey][$sCurrency]);
									$bFailed = true;
									$sDebug = 'Value of array is empty.';										
									
									break;
								}
								
								$sPrice = str_replace(array(' ', ','), '', $mValue);
								$aParts = explode('.', $sPrice);		
								if (count($aParts) > 2)
								{
									$iCnt = 0;
									$sPrice = '';
									foreach ($aParts as $sPart)
									{
										$iCnt++;
										$sPrice .= (count($aParts) == $iCnt ? '.' : '') . $sPart;
									}															
								}	
								
								if (!is_numeric($sPrice))
								{
									unset($aValues[$sKey][$sCurrency]);
								}	
							}
							
							if (!count($aValues[$sKey]))
							{
								$bFailed = true;
								$sDebug = 'Value of array is empty.';								
							}
						}				
						break;					
					case 'price:required':
						
						if (empty($aValues[$sKey]) && (int) $aValues[$sKey] !== 0)
						{
							$bFailed = true;
							$sDebug = 'Value not found.';
						}
						else 
						{
							$sPrice = str_replace(array(' ', ','), '', $aValues[$sKey]);
							$aParts = explode('.', $sPrice);		
							if (count($aParts) > 2)
							{
								$iCnt = 0;
								$sPrice = '';
								foreach ($aParts as $sPart)
								{
									$iCnt++;
									$sPrice .= (count($aParts) == $iCnt ? '.' : '') . $sPart;
								}
							}
							
							if (is_numeric($sPrice))
							{
								$aValues[$sKey] = $sPrice;
							}
							else 
							{
								$bFailed = true;
								$sDebug = 'Value is not a numeric value.';								
							}
						}
											
						break;					
					case 'string:required':
					case 'string':
						$bCatchZero = true;
						if ($this->_bAllowZero == true && $aValues[$sKey] == '0')
						{
							$bCatchZero = false;
						}
						if ($sType == 'string:required' && empty($aValues[$sKey]) && $bCatchZero)
						{
							$bFailed = true;
							$sDebug = 'Value not found.';
						}
						
						if (!empty($aValues[$sKey]) && !is_string($aValues[$sKey]) && $bCatchZero)
						{
							$bFailed = true;
							$sDebug = 'Value is not a string.';
						}
						
						break;
					case 'int:required':						
						if (!isset($aValues[$sKey]))
						{
							$bFailed = true;							
							$sDebug = 'Value not found.';
						}
						else 
						{
							if (!is_numeric($aValues[$sKey]))
							{
								$bFailed = true;
								$sDebug = 'Value is not a numeric value.';
							}
						}			
						
						if ($bFailed === false)
						{
							$aValues[$sKey] = (int) $aValues[$sKey];
						}
						break;
					case 'int':
						if (isset($aValues[$sKey]))
						{
							if (!is_numeric($aValues[$sKey]))
							{
								$bFailed = true;
								$sDebug = 'Value is not a numeric value.';								
							}
							else 
							{
								$aValues[$sKey] = (int) $aValues[$sKey];
							}
						}
						break;
					case 'boolean':
						if (isset($aValues[$sKey]))
						{
							if (!is_bool($aValues[$sKey]))
							{
								$bFailed = true;
								$sDebug = 'Value is not a boolean value.';								
							}											
						}
						break;
					case 'product_id':
					case 'product_id:required':
						
						if ($sType == 'php_code:required')
						{
							if (empty($aValues[$sKey]))
							{
								$bFailed = true;
								$sDebug = 'Product ID is missing.';										
							}														
						}							
						
						break;
					case 'module_id':
					case 'module_id:required':
						
						if ($sType == 'module_id:required')
						{
							if (empty($aValues[$sKey]))
							{
								$bFailed = true;
								$sDebug = 'Module ID is missing.';										
							}														
						}						
						
						if (($bFailed === false && $sType == 'module_id:required') || ($sType == 'module_id' && !empty($aValues[$sKey])))
						{
							if (!Phpfox::isModule($aValues[$sKey]))
							{
								$bFailed = true;
								$sDebug = 'Not a valid module.';
							}
						}
						
						break;
					default:						
						if (preg_match('/^regex:(.*?)$/', $sType, $aMatches))
						{
							if (isset($this->_aRegex[$aMatches[1]]) && !preg_match($this->_aRegex[$aMatches[1]], $aValues[$sKey]))
							{
								$bFailed = true;
								$sDebug = 'Regex "' . $aMatches[1] . '" failed.';
							}			
						}
						else 
						{
							return Phpfox_Error::trigger('Not a valid validation type: ' . $sType, E_USER_ERROR);
						}
						break;
				}
				
				if ($bFailed)
				{
					Phpfox_Error::set((isset($aParam['message']) ? $aParam['message'] : $sDebug . '(' . $sKey . ')') . ((PHPFOX_DEBUG && isset($aParam['message'])) ? ' DEBUG: ' . $sDebug : ''));
				}				
			}
			
			if ($bFailed === false)
			{
				if (isset($aParam['convert']))
				{
					$aValues[$sKey] = Phpfox::getLib('parse.input')->convert($aValues[$sKey]);
				}
			}
		}		
				
		return $aValues;
	}
	
	/**
	 * Build a form validation check.
	 *
	 * @param array $aParams ARRAY of settings.
	 * @return object Return self.
	 */
	public function set($aParams)
	{
		$this->sFormName = 'Validation_' . $aParams['sFormName'];
		$this->_sName = $aParams['sFormName'];
		$this->aFields = $aParams['aParams'];	
		
		if (isset($aParams['bParent']))
		{
			$this->_bParent = true;
		}
		
		return $this;
	}
	
	/**
	* This implements checks for Input fields
	*/
	public function setAction($sAction)
	{
		if (!Phpfox::isModule('input'))
		{
			return false;
		}
		
		list($sModule, $sAction) = explode('.', $sAction);
		if (Phpfox::isModule($sModule) && Phpfox::hasCallback($sModule, 'getEnabledInputField'))
		{
			$aInputs = Phpfox::callback($sModule.'.getEnabledInputField');
			$aActions = array();
			foreach ($aInputs as $aInput)
			{
				$aActions[] = $aInput['action'];
			}
			if (!empty($aActions))
			{
				// get required fields (we can cache this)
				$aRequired = Phpfox::getLib('database')->select('i.field_id, i.phrase_var, ifc.table_name, ifc.column_name, ifc.operand, ifc.full_value')
					->from(Phpfox::getT('input_field'), 'i')
					->leftjoin(Phpfox::getT('input_field_condition'), 'ifc', 'ifc.field_id = i.field_id')
					->where('module_id = "'.$sModule .'" AND action IN ("'. implode('","',$aActions).'") AND is_required = 1')
					->execute('getSlaveRows');					
				$oInput = Phpfox::getService('input');
				foreach ($aRequired as $aInput)
				{
					if ($oInput->canEnterInfo($aInput))
					{
						$this->aFields['input_' . $aInput['field_id']] = array(
							'title' => 'Please provide a value for ' . Phpfox::getPhrase($aInput['phrase_var']), 
							'def' => 'required');
					}
				}
			}
		}
	}
	/**
	 * Create the JS form onsubmit=""
	 *
	 * @param bool $bReturn TRUE to include the "return" in the JavaScript code.
	 * @return	string	Call to JS function
	 */
	public function getJsForm($bReturn = true)
	{
		return ($bReturn ? 'return ' : '') . $this->sFormName .'()' . ($bReturn ? ';' : '');
	}

	/**
	 * Server Side check
	 *
	 * @param	array	$aVal	holds all the post arrays
	 * @return	boolean	Check if everything is valid or not
	 */
	public function isValid($aVal)
	{		
		foreach($this->aFields as $sFieldKey => $aFieldValue)
		{
			$this->_checkRoutine($aFieldValue, $sFieldKey, 'php', (isset($aVal[$sFieldKey]) ? $aVal[$sFieldKey] : null));
		}
		
		return Phpfox_Error::isPassed();
	}

	/**
	 * Client side check
	 * 
	 * @return	string	Javascript data needed for a specific form
	 */
	public function createJS()
	{
		$sStr = "\n" . '<div id="' . $this->_sName . '_msg"></div>';
		$sStr .= "\n" . '<script type="text/javascript">' . "\n";
	 	$sStr .= "function " . $this->sFormName . "()\n{\n";
	 	$sStr .= "\t" . '$(\'#' . $this->_sName . '_msg\').hide(\'\');' . "\n";
	 	$sStr .= "\t" . '$(\'#' . $this->_sName . '_msg\').html(\'\');' . "\n";
	 	$sStr .= "\t" . "var bIsValid = true;\n";	 	
		$sStr .= "\tvar bReturn = false;\n";
		$sStr .= "\t".'$(".error_message").each(function(){$(this).remove();});';
		
		foreach ($this->aFields as $sFieldKey => $aFieldValue)
		{
			$sStr .= $this->_checkRoutine($aFieldValue, $sFieldKey, 'js');
		}
		
		$sStr .= "\t" . "if (bReturn) return false;\n\t if ( bIsValid ) { return true; } \$('#" . $this->_sName . "_msg').show(); window.location.hash = '#pem'; return false;\n";
		$sStr .= '}' . "\n</script>\n";

		return $sStr;
	}
	
	/**
	 * Method is used to check if POST data fields is valid
	 * for either PHP or Javascript.
	 *
	 * @param	array	$aFieldValue	is the array of field values
	 * @param	string	$sFieldKey		is the KEY or form ID
	 * @param	string	$sType			is the type of form
	 * @param	string	$sValue			is the value, only for PHP
	 * @return	mixed	PHP returns bool|JS returns JS layout	
	 */
	private function _checkRoutine($aFieldValue, $sFieldKey, $sType = 'php', $sValue = '')
	{
		if ($sType == 'js' && $sFieldKey == 'image_verification' && Phpfox::getParam('captcha.recaptcha'))
		{
			$sFieldKey = 'recaptcha_response_field';
		}
		
		if (!is_array($aFieldValue))
		{
			$aFieldValue = array(
				'title' => $aFieldValue,
				'def' => 'required'
			);
		}		
		
		$sStr = '';
		if ($sFieldKey == 'email' && function_exists('filter_var') && !empty($sValue) && !filter_var($sValue, FILTER_VALIDATE_EMAIL))
		{
		    Phpfox_Error::set($aFieldValue['title']);
		}
	 	else if ( isset($aFieldValue['pattern']) )
	 	{
	 		if ( $sType == 'php' && !preg_match($aFieldValue['pattern'], $sValue) )
	 		{
	 			Phpfox_Error::set($aFieldValue['title']);
		 	}
	 		else
	 		{
	 			$sStr .= $this->_createIfJS('oJs.value(\''. $sFieldKey .'\').search('. $aFieldValue['pattern'] .') == -1', $aFieldValue['title'], $sFieldKey);
	 		}
	 	}
	 	elseif ( isset($aFieldValue['maxlen']) )
	 	{
			if ( $sType == 'php' && strlen($sValue) > $aFieldValue['maxlen'] )
			{
				Phpfox_Error::set($aFieldValue['title']);
			}
			else
			{						
				$sStr .= $this->_createIfJS('$(\'#'. $sFieldKey .'\').val().length > '. $aFieldValue['maxlen'] .'', $aFieldValue['title'], $sFieldKey);
			}	 		
	 	}
	 	elseif ( isset($aFieldValue['def']) )
	 	{
	 	 	if ($aFieldValue['def'] == 'required')
	 	 	{
			 	if ($sType == 'php' && $sFieldKey == 'image_verification')
				{
					if (Phpfox::isModule('captcha') && !Phpfox::getService('captcha')->checkHash($sValue))
					{
						Phpfox_Error::set(Phpfox::getPhrase('captcha.captcha_failed_please_try_again'));
					}
				}
	 	 		else 
	 	 		{	 	 			
	 	 			if ($sType == 'php')
		 	 		{
		 	 			if (isset($aFieldValue['php_id']))
		 	 			{
		 	 				if (strpos($aFieldValue['php_id'], ']'))
		 	 				{
		 	 					$aParts = explode('[', $aFieldValue['php_id']);
		 	 					$aPostArray = Phpfox::getLib('request')->getArray($aParts[0]);
		 	 					$aKeyParts = explode('_', $sFieldKey);
		 	 					if (isset($aPostArray[$aKeyParts[(count($aKeyParts) - 1)]]))
		 	 					{
		 	 						$sValue = $aPostArray[$aKeyParts[(count($aKeyParts) - 1)]];
		 	 					}
		 	 				}
		 	 			}
		 	 			
		 	 			if (empty($sValue) && $sValue != '0')
		 	 			{
		 	 				Phpfox_Error::set($aFieldValue['title']);
		 	 			}
		 	 			elseif (is_string($sValue) && Phpfox::getLib('parse.format')->isEmpty($sValue))
		 	 			{		 	 						 	 				
		 	 				Phpfox_Error::set($aFieldValue['title']);
		 	 			}
						else if (is_array($sValue) && empty($sValue))
						{
							Phpfox_Error::set($aFieldValue['title']);
						}
		 	 		}
		 	 		else
		 	 		{
		 	 			(($sPlugin = Phpfox_Plugin::get('validator_check_routine_default')) ? eval($sPlugin) : false);
		 	 			
		 	 			if (!isset($bSkipDefaultCheck))
		 	 			{
			 	 			if ($this->_bParent === true)
			 	 			{
			 	 				$sStr .= $this->_createIfJS('$(\'#' . $this->_sName . '\').find(\'.' . $sFieldKey . '\').val() == \'\'', $aFieldValue['title'], $sFieldKey);	
			 	 			}
			 	 			else 
			 	 			{
			 	 				$sStr .= $this->_createIfJS('' . (($sFieldKey == 'text' && Phpfox::getParam('core.wysiwyg') == 'tinymce') ? '(Editor.sEditor == \'tinymce\' && typeof(tinyMCE) == \'object\' && tinyMCE.activeEditor.getContent().replace(/<\/?[^>]+>/gi, \'\').length == 0) || (typeof(tinyMCE) != \'object\' && $(\'#'. $sFieldKey .'\').val() == \'\') || (Editor.sEditor != \'tinymce\' && typeof(tinyMCE) == \'object\' && $(\'#'. $sFieldKey .'\').val() == \'\')' : '$(\'#'. $sFieldKey .'\').val() == \'\'') . '', $aFieldValue['title'], $sFieldKey);
			 	 			}
		 	 			}
		 	 		}
	 	 		}
	 	 	}
	 	 	elseif ( $aFieldValue['def'] == 'checkbox' )
	 	 	{
	 	 		if ($sType == 'php' && empty($sValue))
	 	 		{
	 	 			Phpfox_Error::set($aFieldValue['title']);
	 	 		}
	 	 		else
	 	 		{
	 	 			$sStr .= $this->_createIfJS('!$(\'#'. $sFieldKey .'\').get(0).checked', $aFieldValue['title'], $sFieldKey);
	 	 		}
	 	 	}
	 		elseif ( isset($this->_aDefaults[$aFieldValue['def']]) )
	 		{
				$aDefault = $this->_aDefaults[$aFieldValue['def']];				
				$sFieldTitle = (isset($aFieldValue['title']) ? $aFieldValue['title'] : $aDefault['title']);
				$sFieldGuide = (isset($aDefault['guide']) ? $aDefault['guide'] : '');
				if ( isset($aDefault['pattern']) )
				{
					if ( $sType == 'php' && !preg_match($aDefault['pattern'], $sValue) )
					{
						Phpfox_Error::set($sFieldTitle);
					}
					else
					{
						$sStr .= $this->_createIfJS('$(\'#'. $sFieldKey .'\').val().search('. $aDefault['pattern'] .') == -1', $sFieldTitle, $sFieldKey, $sFieldGuide);
					}						
				}
				
				if ( isset($aDefault['minlen']) )
				{
					if ( $sType == 'php' && strlen($sValue) < $aDefault['minlen'] )
					{
						Phpfox_Error::set($aDefault['title']);
					}
					else
					{
						$sStr .= $this->_createIfJS('$(\'#'. $sFieldKey .'\').val().length < '. $aDefault['minlen'] .'', $aDefault['title'], $sFieldKey);
					}						
				}	
				
				if ( isset($aDefault['maxlen']) )
				{
					if ( $sType == 'php' && strlen($sValue) > $aDefault['maxlen'] )
					{
						Phpfox_Error::set($aDefault['title']);
					}
					else
					{						
						$sStr .= $this->_createIfJS('$(\'#'. $sFieldKey .'\').val().length > '. $aDefault['maxlen'] .'', $aDefault['title'], $sFieldKey);
					}
				}	
	 		}
	 	}
	 	else
	 	{
	 		if ($sType == 'php')
	 		{
	 			Phpfox_Error::set($aFieldValue['title']);	
	 		}
	 		else
	 		{
	 			$sStr .= $this->_createIfJS('oJs.value(\''. $sFieldKey .'\') == \'\'', $aFieldValue['title']);
	 		}		 		
	 	}
		$sStr .= "\n";

		return ($sType != 'php' ? $sStr : '');
	}

	/**
	 * Creates a JS IF statment
	 *
	 * @param	string	$sIfStatment	is the JS IF statment will plan to execute
	 * @param	string	$sTitle	is the error message if the check has failed
	 * @param string $sFieldKey Field ID/Class if using a parent check.
	 * @param string $sInfoGuide Info guide to explain the error in more detail.
	 * @return	string	JS Content returned
	 */
	private function _createIfJS($sIfStatment, $sTitle, $sFieldKey = '', $sInfoGuide = '')
	{
		$sStr = "\t";
		$sStr .= "if (" . $sIfStatment . ")\n\t{\n";
		$sStr .= "\t\t" . "bIsValid = false; \n";
		$sStr .= "\t\t" . '$(\'#' . $this->_sName . '_msg\').message(\''. str_replace("'", "\'", $sTitle) .'\', \'error\');' . "\n";
		if ($sFieldKey)
		{
			if ($this->_bParent === true)
			{
				$sStr .= "\t\t" . '$(\'#' . $this->_sName . '\').find(\'.' . $sFieldKey . '\').addClass(\'alert_input\');' . "\n";
			}
			else 
			{
				$sStr .= "\t\t" . '$(\'#'. $sFieldKey .'\').addClass(\'alert_input\');' . "\n";
			}
			if (!empty($sInfoGuide))
			{
				$sStr .= "\t\t" . 'oJs.className(\'FormInfo_'. $sFieldKey .'\', \'FormInfo\');' . "\n\t\t" .'oJs.id(\'FormInfo_'. $sFieldKey .'\').innerHTML=\'' . $sInfoGuide . '\';' . "\n";
			}
		}
		$sStr .= "\t" . '}' . "\n";
		return $sStr;
	}
}

?>