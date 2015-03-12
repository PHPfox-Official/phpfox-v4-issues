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
 * @package  		Module_Language
 * @version 		$Id: process.class.php 4961 2012-10-29 07:11:34Z Raymond_Benc $
 */
class Language_Service_Phrase_Process extends Phpfox_Service 
{
	private $_aRemove = array(
		'the'
	);
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('language_phrase');
		
		(($sPlugin = Phpfox_Plugin::get('language.service_phrase_process___construct')) ? eval($sPlugin) : false);
	}
	
	public function prepare($sText)
	{
		static $aCache = array();
		
		if (isset($aCache[$sText]))
		{
			return $aCache[$sText];
		}
		
		$sText = trim($sText);	
		
		$sPhrase = $sText;
		
		$aCache[$sText] = strtolower(preg_replace('/ +/', '-', preg_replace('/[^0-9a-zA-Z]+/', '_', $sPhrase)));
		
		$aCache[$sText] = trim($aCache[$sText], '_');	
		
		if (empty($aCache[$sText]))
		{
			$aCache[$sText] = uniqid();
		}			
				
		return $aCache[$sText];
	}
	
	public function add($aVals, $bClean = false)
	{	
		$sPhrase = $this->prepare($aVals['var_name']);
		$oParseInput = Phpfox::getLib('parse.input');		
		
		if (isset($aVals['module']))
		{
			$aParts = explode('|', $aVals['module']);
		}		
		
		foreach ($aVals['text'] as $iId => $sText)
		{
			$sText = trim($sText);
			
			if (empty($sText))
			{
				// continue;
			}
			
			if ($bClean === true)
			{
				$sText = $oParseInput->clean($sText);
			}
			else 
			{
				$sText = $oParseInput->convert($sText);
			}			
			
			$this->database()->insert($this->_sTable, array(
					'language_id' => $iId,
					'module_id' => (isset($aParts) ? $aParts[0] : 'core'),
					'product_id' => $aVals['product_id'],
					'version_id' => PhpFox::getId(),
					'var_name' => $sPhrase,
					'text' => $sText,
					'text_default' => $sText,
					'added' => PHPFOX_TIME
				)
			);
		}
		
		$sFinalPhrase = (isset($aVals['module']) ? $aParts[1] . '.' . $sPhrase : $sPhrase);
		
		if (isset($aVals['is_help']))
		{
			Phpfox::getService('help.process')->add(array('var_name' => $sFinalPhrase));
		}
		
		Phpfox::getService('log.staff')->add('phrase', 'add', array('phrase' => $sPhrase));		
		
		$this->cache()->remove('locale', 'substr');
		
		return $sFinalPhrase;
	}
	
	public function update($iId, $sText, $aExtra = array())
	{
		$aUpdate = array(
			'text' => Phpfox::getLib('parse.input')->convert($sText)
		);
		
		if ($aExtra)
		{
			$aUpdate = array_merge($aUpdate, $aExtra);
		}		
		
		$this->database()->update($this->_sTable, $aUpdate, 'phrase_id = ' . (int) $iId);
		
		$this->cache()->remove('language', 'substr');
		
		return true;
	}
	
	public function delete($mId, $bIsVar = false)
	{
		if ($bIsVar)
		{
			$aParts = explode('.', $mId);
		}

		$this->database()->delete($this->_sTable, ($bIsVar ? "module_id = '" . $this->database()->escape($aParts[0]) . "' AND var_name = '" . $this->database()->escape($aParts[1]) . "'" : 'phrase_id = ' . (int) $mId));
		
		$this->cache()->remove('locale', 'substr');
		return true;
	}	
	
	public function revert($aIds)
	{
		if (!is_array($aIds))
		{
			return false;
		}
		
		if (!count($aIds))
		{
			return false;
		}
		
		$aRows = $this->database()->select('phrase_id, text_default')
			->from($this->_sTable)
			->where("phrase_id IN(" . implode(',', $aIds) . ")")
			->execute('getRows');
			
		foreach ($aRows as $aRow)
		{
			$this->update($aRow['phrase_id'], $aRow['text_default']);
		}	
		
		$this->cache()->remove('language', 'substr');
		
		return true;
	}	
	
	public function updateVarName($sLanguage, $sVarName, $sValue, $bOverWrite = false)
	{		
		list($sModule, $sVarName) = explode('.', $sVarName);
		
		$aSql = array(
			'text' => Phpfox::getLib('parse.input')->convert($sValue)
		);
		
		if ($bOverWrite)
		{
			$aSql['text_default'] = Phpfox::getLib('parse.input')->convert($sValue);
		}		
		
		$this->database()->update($this->_sTable, $aSql, 'language_id = \'' . $this->database()->escape($sLanguage) . '\' AND module_id = \'' . $this->database()->escape($sModule) . '\' AND var_name = \'' . $this->database()->escape($sVarName) . '\'');
		
		$this->cache()->remove('language', 'substr');
		
		return true;
	}
	
	/**
	 * @deprecated Use self::updateVarName() instead.
	 * @since 2.0.0alpha3	 
	 */
	public function updateVar($sVar, $aVals, $bOverwrite = false)
	{		
		return Phpfox_Error::trigger('This method is deprecated. Use self::updateVarName() instead.', E_USER_ERROR);
	}
	
	public function importPhrases($sLanguageId, $iPage = 0, $iLimit = 500)
	{		
		$aLanguage = $this->database()->select('*')
			->from(Phpfox::getT('language'))
			->where('language_id = \'' . $this->database()->escape($sLanguageId) . '\'')
			->execute('getRow');
			
		if (!isset($aLanguage['language_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('language.language_package_not_found'));
		}	
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('language_phrase'))
			->where('language_id = \'' . $this->database()->escape($aLanguage['parent_id']) . '\'')
			->execute('getField');	
		
		if (!$iCnt)
		{
			return false;
		}
		
		$aParentPhrases = $this->database()->select('*')
			->from(Phpfox::getT('language_phrase'))
			->where('language_id = \'' . $this->database()->escape($aLanguage['parent_id']) . '\'')
			->limit($iPage, $iLimit, $iCnt)
			->order('phrase_id ASC')
			->execute('getRows');
		foreach ($aParentPhrases as $aParentPhrase)
		{
			$aInsert = array();
			foreach ($aParentPhrase as $sKey => $sValue)
			{
				if ($sKey == 'phrase_id')
				{
					continue;
				}
				
				if ($sKey == 'language_id')
				{
					$sValue = $sLanguageId;
				}
				
				$aInsert[$sKey] = $sValue;
			}

			$this->database()->insert(Phpfox::getT('language_phrase'), $aInsert);
		}		
		
		return $iCnt;
	}
	
	public function findMissingPhrases($sLangId, $aXml, $bCheck = false)
	{
		$iCnt = 0;
		foreach ($aXml as $sModule => $aPhrases)
		{
			if ($bCheck === true)
			{
				$aRows = $this->database()->select('*')
					->from(Phpfox::getT('language_phrase'))
					->where('language_id = \'en\' AND module_id = \'' . $this->database()->escape($sModule) . '\'')
					->execute('getRows');			
			}
			else 
			{
				$aRows = (isset($aPhrases['phrase'][1]) ? $aPhrases['phrase'] : array($aPhrases['phrase']));			
			}
			
			foreach ($aRows as $aPhrase)
			{
				$iMissing = $this->database()->select('COUNT(*)')
					->from(Phpfox::getT('language_phrase'))
					->where('language_id = \'' . $sLangId . '\' AND module_id = \'' . $sModule . '\' AND var_name = \'' . $aPhrase['var_name'] . '\'')
					->execute('getSlaveField');
					
				if (!$iMissing)
				{					
					$iCnt++;
					
					if (!isset($aPhrase['value']))
					{
						$aPhrase['value'] = $aPhrase['text'];
					}
					
					$this->database()->insert(Phpfox::getT('language_phrase'), array(
							'language_id' => $sLangId,
							'module_id' => $sModule,
							'product_id' => 'phpfox',
							'version_id' => $aPhrase['version_id'],
							'var_name' => $aPhrase['var_name'],
							'text' => $aPhrase['value'],
							'text_default' => $aPhrase['value'],
							'added' => $aPhrase['added']
						)
					);
				}
			}			
		}		
		
		return $iCnt;
	}	
	
	public function installFromFolder($sPack, $iPage = 0, $iLimit = 5)
	{
		$iGroup = (($iPage * $iLimit) + 1);	
		if (is_array($sPack))
		{
			$sDir = PHPFOX_DIR_CACHE . $sPack[0] . PHPFOX_DS . 'upload' . PHPFOX_DS . str_replace(PHPFOX_DIR, '', PHPFOX_DIR_INCLUDE) . 'xml' . PHPFOX_DS . 'language' . PHPFOX_DS . $sPack[1] . PHPFOX_DS;
			$sPack = $sPack[1];
		}
		else
		{
			$sDir = PHPFOX_DIR_INCLUDE . 'xml' . PHPFOX_DS . 'language' . PHPFOX_DS . $sPack . PHPFOX_DS;
		}
				
		if (!is_dir($sDir))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('language.not_a_valid_language_package_to_install'));
		}
		
		if (!file_exists($sDir . 'phpfox-language-import.xml'))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('language.not_a_valid_language_package_to_install_missing_the_xml_file'));	
		}
		
		$iCnt = 0;		
		$iActualCount = 0;		
		$hDir = opendir($sDir);
		while ($sFile = readdir($hDir))
		{			
			if ($sFile == '.' || $sFile == '..')
			{
				continue;
			}

			if (preg_match('/^module-(.*?)\.xml$/i', $sFile, $aMatches))
			{				
				if (Phpfox::isModule($aMatches[1]))
				{
					$iActualCount++;
					
					if ($iActualCount < $iGroup)
					{				
						continue;
					}					
					
					$aPhrases = Phpfox::getLib('xml.parser')->parse(file_get_contents($sDir . $sFile));		
					$aRows = (isset($aPhrases['phrase'][1]) ? $aPhrases['phrase'] : array($aPhrases['phrase']));
					foreach ($aRows as $aPhrase)
					{
						$this->database()->insert(Phpfox::getT('language_phrase'), array(
								'language_id' => $sPack,
								'module_id' => $aMatches[1],
								'product_id' => 'phpfox',
								'version_id' => $aPhrase['version_id'],
								'var_name' => $aPhrase['var_name'],
								'text' => $aPhrase['value'],
								'text_default' => $aPhrase['value'],
								'added' => $aPhrase['added']
							)
						);
					}
					
					$iCnt++;
					
					if ($iCnt === (int) $iLimit)
					{
						break;
					}						
				}
			}
		}
		closedir($hDir);

		return ($iCnt ? true : 'done');
	}

	/**
	 * This function updates language phrases based on the changes made by the user from the
	 * controller admincp.language.email
	 * In this context phrase_id is the full phrase variable: <module>.<var_name>
	 * @param arary $aVals
	 */
	public function updateMailPhrases($aVals)
	{
		// Safetey checks		
		if (!isset($aVals['text']) || !is_array($aVals['text']))
		{
			return Phpfox_Error::set('This shouldnt happen.');
		}

		if (isset($aVals['language_id']) && $aVals['language_id'] != '')
		{
			$sLanguage = $aVals['language_id'];
		}
		else
		{
			$sLanguage = Phpfox::getLib('locale')->getLang();
			$sLanguage = $sLanguage['language_id'];
		}
		
		foreach ($aVals['text'] as $sPhraseId => $sNewText)
		{
			// update the phrase
			$aVar = explode('.', $sPhraseId);
			$aUpdate = array(
				'text' => Phpfox::getLib('parse.input')->convert($sNewText)
			);
			$sWhere = 'language_id = "' . $sLanguage . '" AND module_id = "' . $aVar[0] . '" AND var_name = "' . $aVar[1] . '"';
			$this->database()->update($this->_sTable, $aUpdate, $sWhere);
		}
		$this->cache()->remove('locale', 'substr');
		
		return true;
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
		if ($sPlugin = Phpfox_Plugin::get('language.service_phrase_process__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}
}

?>