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
 * @version 		$Id: language.class.php 4605 2012-08-20 11:17:45Z Miguel_Espinoza $
 */
class Language_Service_Language extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('language');
	}
	
	public function get($aConds = array())
	{
		$sCacheId = $this->cache()->set(array('locale', 'language_table_' . md5((is_array($aConds) ? implode('', $aConds) : $aConds))));
		if (!($aRows = $this->cache()->get($sCacheId)))
		{
			$aRows = $this->database()->select('l.*')
				->from($this->_sTable, 'l')
				->where($aConds)
				->order('l.is_default DESC, l.title')
				->execute('getSlaveRows');		
				
			foreach ($aRows as $iKey => $aRow)
			{
				$aRows[$iKey]['image'] = (file_exists(Phpfox::getParam('core.dir_pic') . 'flag' . PHPFOX_DS . $aRow['language_id'] . '.' . $aRow['flag_id']) ? Phpfox::getParam('core.url_pic') . 'flag/' . $aRow['language_id'] . '.' . $aRow['flag_id'] : '');
			}
				
			$this->cache()->save($sCacheId, $aRows);
		}
		
		$this->database()->clean();
		
		return $aRows;
	}
	
	public function getForAdminCp($aConds = array())
	{
		$aRows = $this->database()->select('l.*')
			->from($this->_sTable, 'l')
			->where($aConds)
			->order('l.is_default DESC, l.title')
			->execute('getSlaveRows');		
				
		foreach ($aRows as $iKey => $aRow)
		{
			$aRows[$iKey]['image'] = (file_exists(Phpfox::getParam('core.dir_pic') . 'flag' . PHPFOX_DS . $aRow['language_id'] . '.' . $aRow['flag_id']) ? Phpfox::getParam('core.url_pic') . 'flag/' . $aRow['language_id'] . '.' . $aRow['flag_id'] : '');
		}	
		
		return $aRows;
	}	
	
	public function getAll()
	{
		return $this->database()->select('*')
			->from(Phpfox::getT('language'))
			->execute('getRows');
	}
	
	public function getWithPhrase($sPhrase)
	{
		$aRows = $this->database()->select('l.language_id, l.title, p.phrase_id, p.text')
			->from($this->_sTable, 'l')
			->leftJoin(Phpfox::getT('language_phrase'), 'p', "p.language_id = l.language_id AND p.var_name = '" . $this->database()->escape($sPhrase) . "'")
			->execute('getRows');			
		
		$aLangs = array();
		foreach ($aRows as $aRow)
		{
			$aLangs[$aRow['language_id']] = $aRow;
		}		
		
		return $aLangs;
	}
	
	public function getLanguage($iId)
	{		
		$aRow = $this->database()->select('l.*')
			->from($this->_sTable, 'l')
			->where('l.language_id = \'' . $this->database()->escape($iId) . '\'')
			->execute('getSlaveRow');
			
		if (!isset($aRow['language_id']))
		{
			return false;
		}
			
		$aRow['image'] = (file_exists(Phpfox::getParam('core.dir_pic') . 'flag' . PHPFOX_DS . $aRow['language_id'] . '.' . $aRow['flag_id']) ? Phpfox::getParam('core.url_pic') . 'flag/' . $aRow['language_id'] . '.' . $aRow['flag_id'] : '');			
			
		return $aRow;
	}
	
	public function getLanguageByName($sName)
	{		
		return $this->database()->select('l.*')
			->from($this->_sTable, 'l')
			->where("l.title = '" . $this->database()->escape($sName) . "'")
			->execute('getSlaveRow');			
	}

	public function exportForDownload($sLanguageId, $bDoCustom = false)
	{
		if (!defined('PHPFOX_XML_SKIP_STAMP'))
		{
			define('PHPFOX_XML_SKIP_STAMP', true);
		}
		
		$oXmlBuilder = Phpfox::getLib('xml.builder');
		
		$aLanguage = $this->getLanguage($sLanguageId);
			
		if (!isset($aLanguage['language_id']))
		{
			return false;
		}
								
		$sFolder = md5($aLanguage['language_id'] . uniqid() . Phpfox::getUserId());
		$sFullPath = PHPFOX_DIR_CACHE . $sFolder . PHPFOX_DS . 'upload' . PHPFOX_DS . 'include' . PHPFOX_DS . 'xml' . PHPFOX_DS . 'language' . PHPFOX_DS . $aLanguage['language_id'] . PHPFOX_DS;

		if (is_dir($sFolder))
		{
		//	Phpfox::getLib('file')->delete_directory($sFullPath);	
		}
			
		Phpfox::getLib('file')->mkdir($sFullPath, true);		
		
		$oXmlBuilder->addGroup('language');				
		$oXmlBuilder->addGroup('settings');
		foreach ($aLanguage as $sKey => $sValue)
		{
			if ($sKey == 'language_id' || $sKey == 'is_default' || $sKey == 'is_master' || $sKey == 'image')
			{
				continue;
			}
			$oXmlBuilder->addTag($sKey, $sValue);
		}
		if (!empty($aLanguage['image']))
		{
			$oXmlBuilder->addTag('image', base64_encode(file_get_contents(str_replace(Phpfox::getParam('core.url_pic'), Phpfox::getParam('core.dir_pic'), $aLanguage['image']))));
		}
		$oXmlBuilder->closeGroup();
		$oXmlBuilder->closeGroup();
			
		Phpfox::getLib('file')->write($sFullPath . 'phpfox-language-import.xml', $oXmlBuilder->output());
		
		$aModules = Phpfox::getLib('module')->getModules();
		
		foreach($aModules as $sModule)
		{
			$this->export($aLanguage['language_id'], ($bDoCustom ? null : 'phpfox'), $sModule, true, false);
			
			Phpfox::getLib('file')->write($sFullPath . 'module-' . $sModule . '.xml', $oXmlBuilder->output());
		}
			
		/*return array(
			'name' => $aLanguage['language_id'],
			'folder' => $sFolder
		);http://www.phpfox.com/tracker/view/10626/
		*/
		$iServerId = 0;
		if (Phpfox::getParam('core.allow_cdn'))
		{
			$iServerId = Phpfox::getLib('cdn')->getServerId();
		}
			
		return array(
			'name' => $aLanguage['language_id'],
			'folder' => $sFolder,
			'server_id' => $iServerId
		); 
	}
	
	public function export($iLanguageId, $sProductId = null, $sModuleName = null, $bOnlyPhrases = false, $bCore = false)
	{		
		$aPhrases = $this->database()->select('lp.*, p.title AS product_name, m.module_id AS module_name')
			->from(Phpfox::getT('language_phrase'), 'lp')
			->join(Phpfox::getT('product'), 'p', ($sProductId === null ? "" : "p.product_id = '" . $sProductId . "' AND") . " p.product_id = lp.product_id")
			->leftJoin(Phpfox::getT('module'), 'm', "m.module_id = lp.module_id")
			->where("lp.language_id = '" . $iLanguageId . "'" . ($sModuleName === null ? '' : ' AND lp.module_id = \'' . $this->database()->escape($sModuleName) . '\''))
			->order('lp.phrase_id ASC')
			->execute('getSlaveRows');
			
		if (!isset($aPhrases[0]['product_name']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('language.product_does_not_have_any_phrases_export'));
		}
	
		if (!count($aPhrases))
		{
			return false;
		}
		
		$oXmlBuilder = Phpfox::getLib('xml.builder');
		
		if (!$bOnlyPhrases)
		{
			$aLanguage = $this->database()->select('l.*')
				->from($this->_sTable, 'l')
				->where("l.language_id = '" . $iLanguageId . "'")
				->execute('getSlaveRow');

			$oXmlBuilder->addGroup('language');
				
			$oXmlBuilder->addGroup('settings');
			foreach ($aLanguage as $sKey => $sValue)
			{
				if ($sKey == 'language_id' || $sKey == 'is_default' || $sKey == 'is_master')
				{
					continue;
				}
				$oXmlBuilder->addTag($sKey, $sValue);
			}
			$oXmlBuilder->closeGroup();			
		}		
		
		$oXmlBuilder->addGroup('phrases');
		
		$aCache = array();
		foreach ($aPhrases as $aPhrase)
		{
			if (isset($aCache[$aPhrase['module_name'] . $aPhrase['var_name']]))
			{
				continue;
			}
			
			$aCache[$aPhrase['module_name'] . $aPhrase['var_name']] = true;
			
			$oXmlBuilder->addTag('phrase', $aPhrase[($bCore ? 'text_default' : 'text')], array(
					'module_id' => $aPhrase['module_name'],
					'version_id' => $aPhrase['version_id'],
					'var_name' => $aPhrase['var_name'],
					'added' => $aPhrase['added']
				)
			);
		}
		$oXmlBuilder->closeGroup();		
		
		if (!$bOnlyPhrases)
		{
			// Close main group	
			$oXmlBuilder->closeGroup();		
		}
		
		return true;
	}
	
	public function getForInstall()
	{
		$aPacks = array();
		$sDir = PHPFOX_DIR_INCLUDE . 'xml' . PHPFOX_DS . 'language' . PHPFOX_DS;		
		$hDir = opendir($sDir);
		while ($sFolder = readdir($hDir))
		{
			if ($sFolder == '.' || $sFolder == '..')
			{
				continue;
			}
			
			if (!file_exists($sDir . $sFolder . PHPFOX_DS . 'phpfox-language-import.xml'))
			{
				continue;
			}
			
			$iCnt = $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('language'))
				->where('language_id = \'' . $this->database()->escape($sFolder) . '\'')
				->execute('getField');
				
			if (!$iCnt)
			{
				$aData = Phpfox::getLib('xml.parser')->parse(file_get_contents($sDir . $sFolder . PHPFOX_DS . 'phpfox-language-import.xml'));
				
				$aPacks[] = array_merge(array('language_id' => $sFolder), $aData['settings']);
			}
		}
		closedir($hDir);
		
		return $aPacks;
	}

	/**
	 * This function scans every .php file in PHPFOX_DIR for >subject() and >message() and picks up 
	 * the language phrase used in each case then it renews the cache file
	 * @param bool $bForce Forces to create the cache file anew, if false it only returns the cache file if available
	 * @return array
	 */
	public function getMailPhrases($bForce = false)
	{
		$sCacheId = $this->cache()->set('language_mail_phrases');
		$aPhrases = array();
		if ($bForce || !($aPhrases = $this->cache()->get($sCacheId)))
		{
			$aAllFiles = Phpfox::getLib('file')->getAllFiles(PHPFOX_DIR_MODULE, true);
			foreach ($aAllFiles as $sFileName)
			{
				$aSubjects = $aMessages = array();
				if (substr($sFileName, strrpos($sFileName, '.') + 1) != 'php')
				{ // only check .php files
					continue;
				}

				$sContent = file_get_contents($sFileName);
				$iSubject = preg_match_all('/>subject\((.+[^ ])\)/', $sContent, $aSubjects);
				$iMessage = preg_match_all('/>message\((.+[^ ])\)/', $sContent, $aMessages);
				if ($iSubject === false || $iMessage === false)
				{
					return Phpfox_Error::set('Error finding subjects and messages');
				}
				if (empty($aSubjects) && empty($aMessages) || (empty($aSubjects[1]) && empty($aMessages[1])))
				{
					continue;
				}
				$aTemp = array_merge($aSubjects[1], $aMessages[1]);
				foreach ($aTemp as $sTemp)
				{
					if (preg_match('/([a-z]+\.[a-z\_]+)/', $sTemp, $aMatch))
					{
						if (!Phpfox::getLib('locale')->isPhrase($aMatch[1]))
						{
							continue;
						}
						$aPhrase = explode('.', $aMatch[1]);
						$aPhrases[$aMatch[1]] = array(
							'file' => $sFileName,
							'var_name' => $aPhrase[1],
							'module' => $aPhrase[0],
							'phrase_id' => $aMatch[1]);
					}
				}
			}
			$this->cache()->save($sCacheId, $aPhrases);
		}
		return $aPhrases;
	}
	
	
	public function getPhraseInEveryLanguage($sModule, $sVar)
	{
		$aPhrases = $this->database()->select('language_id, phrase_id, text')
			->from(Phpfox::getT('language_phrase'))
			->where('module_id = "'. $sModule .'" AND var_name = "'. $sVar .'"')
			->execute('getSlaveRows');
		
		return $aPhrases;	
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
		if ($sPlugin = Phpfox_Plugin::get('language.service_language__call'))
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