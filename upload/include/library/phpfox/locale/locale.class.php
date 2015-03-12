<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Language Localization
 * Class is used to display all the phrases on the site allowing phpFox to support multiple languages
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: locale.class.php 6981 2013-12-09 17:40:04Z Fern $
 */
class Phpfox_Locale
{
	/**
	 * ARRAY of all the phrases
	 *
	 * @var array
	 */
	private $_aPhrases = array();
	
	/**
	 * ARRAY of the current language package being used
	 *
	 * @var array
	 */
	private $_aLanguage = array();
	
	/**
	 * ARRAY of all the language packages
	 *
	 * @var array
	 */
	private $_aLanguages = array();
	
	/**
	 * ASCII conversion for URL strings (non-latin character support)
	 *
	 * @var array
	 */
	private $_aAscii = array(
		// Svenska
		'246' => 'o',
		'228' => 'a',
		'229' => 'a',
		'214' => 'O',
		'196' => 'A',
		'197' => 'A'
	);	
	
	/**
	 * ARRAY of phrases to be cached on a specific page
	 *
	 * @var array
	 */
	private $_aCache = array();
	
	/**
	 * Cache ID associated with the caching of phrases for a specific page
	 *
	 * @var string
	 */
	private $_sCacheId;
	
	/**
	 * Cache object
	 *
	 * @see Phpfox_Cache
	 * @var object
	 */
	private $_oCache = null;
	
	/**
	 * Check to see if we already cached this page
	 *
	 * @var bool
	 */
	private $_bIsCached = false;
	
	/**
	 * Regex rules to manipulate phrases
	 *
	 * @var array
	 */
	private $_aRules = array();
	
	/**
	 * Use this variable to override the default language ID
	 *
	 * @var unknown_type
	 */
	private $_sOverride = '';
	
	private $_aPhraseHistory = array();
	
	/**
	 * Class constructor used to load the default language package and all the phrases that are part
	 * of that language package. Also loads languag rules for that specific language package. All this information
	 * is cached and database queries are only executed the first time the site is loaded after a hard
	 * re-cache.
	 *
	 */
	public function __construct()
	{
		$oCache = Phpfox::getLib('cache');
		$oDb = Phpfox::getLib('database');
		
		$sLangAllId = $oCache->set(array('locale', 'language'));
		
		if (!($this->_aLanguages = $oCache->get($sLangAllId)))
		{
			$aRows = $oDb->select('*')
				->from(Phpfox::getT('language'))
				->execute('getRows');		
				
			foreach ($aRows as $aRow)
			{
				$this->_aLanguages[$aRow['language_id']] = true;
			}
			
			$oCache->save($sLangAllId, $this->_aLanguages);
		}
		
		$sLangId = $oCache->set(array('locale', 'language_' . $this->getLangId()));
		
		if (!($this->_aLanguage = $oCache->get($sLangId)))
		{			
			$this->_aLanguage = $oDb->select('*')
				->from(Phpfox::getT('language'))
				->where("language_id = '" . $oDb->escape($this->getLangId()) . "'")
				->execute('getRow');	
				
			$this->_aLanguage['image'] = (file_exists(Phpfox::getParam('core.dir_pic') . 'flag' . PHPFOX_DS . $this->_aLanguage['language_id'] . '.' . $this->_aLanguage['flag_id']) ? Phpfox::getParam('core.url_pic') . 'flag' . PHPFOX_DS . $this->_aLanguage['language_id'] . '.' . $this->_aLanguage['flag_id'] : '');			
	
			$_aPhrasess = $this->_getPhrases($this->getLangId());
			if ($this->getLangId() != 'en')
			{
				$aDefaultPhrases = $this->_getPhrases('en');
				
				foreach ($aDefaultPhrases as $sKey => $aPhrases)
				{
					foreach ($aPhrases as $sPhraseVar => $aPhrase)
					{
						if (!isset($_aPhrasess[$sKey][$sPhraseVar]))
						{	
							$_aPhrasess[$sKey][$sPhraseVar] = $aPhrase;
						}
					}
				}
			}			
						
			foreach (array_keys($_aPhrasess) as $sKey)
			{
				$iPhraseId = $oCache->set(array('locale', 'language_' . $this->getLangId() . '_phrase_' . $sKey));
				if (!$oCache->get($iPhraseId))
				{
					$oCache->save($iPhraseId, $_aPhrasess[$sKey]);
					$oCache->close($iPhraseId);
				}
			}
			
			$oCache->save($sLangId, $this->_aLanguage);			
		}		
		$oCache->close($sLangId);	
		
		$sRuleId = $oCache->set(array('locale', 'language_rule_' . $this->getLangId()));
		if (!($this->_aRules = $oCache->get($sRuleId)))
		{
			$aRules = Phpfox::getLib('database')->select('var_name, rule, rule_value, ordering')
				->from(Phpfox::getT('language_rule'))
				->where('language_id = \'' . $this->getLangId() . '\'')
				->order('ordering ASC')
				->execute('getRows');
				
			foreach ($aRules as $aRule)
			{
				$this->_aRules[$aRule['var_name']][$aRule['ordering']] = $aRule;
			}
			
			$oCache->save($sRuleId, $this->_aRules);
		}
		$oCache->close($sRuleId);
		
		(($sPlugin = Phpfox_Plugin::get('locale_contruct__end')) ? eval($sPlugin) : false);
		
		define('PHPFOX_LOCALE_LOADED', true);
	}
	
	/**
	 * Get all the information provided on the current language package being used.
	 *
	 * @return array
	 */
	public function getLang()
	{		
		$this->_aLanguage['image'] = (file_exists(Phpfox::getParam('core.dir_pic') . 'flag' . PHPFOX_DS . $this->_aLanguage['language_id'] . '.' . $this->_aLanguage['flag_id']) ? Phpfox::getParam('core.url_pic') . 'flag/' . $this->_aLanguage['language_id'] . '.' . $this->_aLanguage['flag_id'] : '');							
		
		return $this->_aLanguage;
	}
	
	/**
	 * Get all the information for a specific language package
	 *
	 * @param string $sVar Language ID to look for
	 * @return mixed ARRAY if we found the language package, emptry STRING if we didnt.
	 */
	public function getLangBy($sVar)
	{
		return (isset($this->_aLanguage[$sVar]) ? $this->_aLanguage[$sVar] : '');
	}
	
	/**
	 * Return the language ID for the current language package in use. This value is based on several
	 * variables as specific users can select a language package they want to browse the site in
	 * and admins can also select the default language package for the site.
	 *
	 * @return string Language ID for the language package in use.
	 */
	public function getLangId()
	{
		if ($this->_sOverride != '')
		{
			return $this->_sOverride;
		}
		if (Phpfox::isUser())
		{
			$sLanguageId = Phpfox::getUserBy('language_id');
			if (empty($sLanguageId))
			{
				$sLanguageId = $this->autoLoadLanguage();	
			}
		}
		else 
		{
			if (($sLanguageId = Phpfox::getLib('session')->get('language_id')))
			{
				
			}
			else 
			{
				$sLanguageId = $this->autoLoadLanguage();
			}
		}
		
		if (!isset($this->_aLanguages[$sLanguageId]))
		{
			$sLanguageId = 'en';
		}		
				
		return $sLanguageId;
	}
	
	public function autoLoadLanguage()
	{
		static $sNewLanguage = null;
		
		if ($sNewLanguage !== null)
		{
			return $sNewLanguage;
		}
		
		if (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('language.auto_detect_language_on_ip') && Phpfox::getParam('core.ip_infodb_api_key') != '')
		{		
			if (($sLanguageId = Phpfox::getLib('session')->get('language_id')))
			{
				$sNewLanguage = $sLanguageId;

				return $sNewLanguage;
			}			
			else
			{
				//$sUrl = 'http://api.ipinfodb.com/v2/ip_query.php?ip=' . Phpfox::getLib('request')->getIp() . '&key=' . Phpfox::getParam('core.ip_infodb_api_key');
				$sUrl = 'http://api.ipinfodb.com/v3/ip-city/?key='.Phpfox::getParam('core.ip_infodb_api_key').'&ip='.Phpfox::getLib('request')->getIp().'&format=xml';
				if (function_exists('file_get_contents') && ini_get('allow_url_fopen'))
				{
					$sXML = file_get_contents($sUrl);
				}
				else
				{
					$sXML = Phpfox::getLib('request')->send($sUrl, array(), 'GET');
				}
				$aCallback = Phpfox::getLib('xml.parser')->parse($sXML, 'UTF-8');			

				if (!empty($aCallback['countryCode']))
				{
					foreach ($this->_aLanguages as $sLangId => $bLang)
					{
						if (strtolower($sLangId) == strtolower($aCallback['countryCode']))
						{
							Phpfox::getLib('session')->set('language_id', $sLangId);

							$sNewLanguage = $sLangId;

							return $sNewLanguage;
						}
					}
				}
			}
			$sLangId = Phpfox::getParam('core.default_lang_id');
			Phpfox::getLib('session')->set('language_id', $sLangId);
		}
		
		$sNewLanguage = Phpfox::getParam('core.default_lang_id');
		
		return $sNewLanguage;
	}
	
	/**
	 * Checks if a phrase exists in the language package or not
	 *
	 * @param string $sParam Phrase to check if it exists
	 * @return bool TRUE if it exists, FALSE if it does not
	 */
	public function isPhrase($sParam)
	{
		if (strpos($sParam, '.') === false)
		{
			return '';
		}		
		if (strpos($sParam, ' '))
		{
			return false;
		}
		list($sModule, $sVar) = explode('.', $sParam);		
		
		if (!isset($this->_aPhrases[$sModule]))
		{
			$this->_getModuleLanguage($sModule);
		}		
		
		return (isset($this->_aPhrases[$sModule][$sVar]) ? true : false);
	}
	
	/**
	 * Gets a phrase from a language.
	 * 
	 * Example Usage (PHP)
	 * <code>
	 * Phpfox::getPhrase('foo.bar');
	 * </code>
	 * 
	 * Example Usage (HTML)
	 * <code>
	 * {phrase var='for.bar'}
	 * </code>
	 *
	 * @param string $sParam Phrase param that is unique for that specific phrase.
	 * @param array $aParams (Optional) ARRAY of data we need to replace in the phrase
	 * @param bool $bNoDebug (Optional) FALSE allows debug mode to be executed, while TRUE forces that there is no debug output.
	 * @param string $sDefault (Optional) If the phrase is not found you can pass a default string in its place and we will return that instead.
	 * @param string $sLang (Optional) By default we use the default language ID, however you can specifiy to load a phrase for a specific language package here.
	 * @return string Phrase value associated with the 1st argument passed.
	 */
	public function getPhrase($sParam, $aParams = array(), $bNoDebug = false, $sDefault = null, $sLang = '')
	{
		if (strpos($sParam, '.') === false)
		{
			if ((Phpfox::getParam('language.lang_pack_helper') && !$bNoDebug))
			{
				return "#{$sParam}#";
			}
			return '';
		}
		
		list($sModule, $sVar) = explode('.', $sParam);		

		
		if ($sLang != null && $sLang != '' && ($sLang != $this->getLangId()) && isset($this->_aLanguages[$sLang]))
		{
			$this->_sOverride = $sLang;
			$this->_aPhrases = array();
			$this->_getModuleLanguage($sModule);
			$sPhrase = $this->getPhrase($sParam, $aParams);
			$this->_sOverride = '';
			$this->_aPhrases = array();
			
			return $sPhrase;
		}
		
		if (!isset($this->_aPhrases[$sModule]))
		{
			$this->_getModuleLanguage($sModule);			
		}
		
		$bPassed = true;
		if (!isset($this->_aPhrases[$sModule][$sVar]))
		{
			$bPassed = false;
			if (defined('PHPFOX_INSTALLER') || Phpfox::getParam('language.cache_phrases'))
			{
				$this->_getModuleLanguage($sModule, true);
				if (isset($this->_aPhrases[$sModule][$sVar]))
				{
					$bPassed = true;
				}				
			}			
			
			if (!$bPassed)
			{				
				if ($sDefault !== null)
				{
					return $sDefault;
				}
                
                if ($sPlugin = Phpfox_Plugin::get('library_phpfox_locale_phrase_not_found')){eval ($sPlugin); if (isset($mPluginReturn)){return $mPluginReturn;}}
				
				if (PHPFOX_DEBUG)
				{
					Phpfox_Error::trigger('Unable to find the phrase: ' . strip_tags($sParam));
				}
				return '';
			}
		}		
		
		$sPhrase = $this->_aPhrases[$sModule][$sVar] ;		
			
		if ((defined('PHPFOX_INSTALLER')) || (Phpfox::getParam('language.cache_phrases') && !$this->_bIsCached))
		{
			$this->_aCache[$sModule][$sVar] = $sPhrase;
		}			
	
		if (isset($aParams['user']))
		{
			if (!is_array($aParams['user']))
			{
				Phpfox_Error::trigger('The key "user" needs to be an array of the users details.');
			}
			
			$sUserPrefix = (isset($aParams['user_prefix']) ? $aParams['user_prefix'] : '');	
			
			$aUser = $aParams['user'];
			$aUser['user_link'] = '<a href="' . Phpfox::getLib('url')->makeUrl($aUser[$sUserPrefix . 'user_name']) . '">' . Phpfox::getLib('parse.output')->clean($aUser[$sUserPrefix . 'full_name']) . '</a>';
			unset($aParams['user']);
			$aParams = array_merge($aParams, $aUser);
		}
		
		if ($aParams)
		{
			$aFind = array();
			$aReplace = array();
			foreach ($aParams as $sKey => $sValue)
			{
				if (is_array($sValue))
				{
					continue;
				}
				$aFind[] = '{' . $sKey . '}';				
				$aReplace[] = '' . $sValue . '';		
			}		
			
			$sPhrase = str_replace($aFind, $aReplace, $sPhrase);
		}			
			
		if (isset($this->_aRules[$sModule . '.' . $sVar]))
		{
			$sEval = '';
			$iCnt = 0;
			foreach ($this->_aRules[$sModule . '.' . $sVar] as $aRule)
			{
				$iCnt++;
				
				$aFind = array();
				$aReplace = array();
				foreach ($aParams as $sKey => $sValue)
				{
					$aFind[] = '/{' . $sKey . '}/i';					
					$aReplace[] = '' . $sValue . '';		
				}			
				
				$aRule['rule'] = preg_replace($aFind, $aReplace, $aRule['rule']);
				$aRule['rule_value'] = preg_replace($aFind, $aReplace, $aRule['rule_value']);				
				
				$sEval .= ($iCnt === 1 ? 'if' : 'elseif') . ' (' . $aRule['rule'] . ') { $sPhrase = \'' . str_replace("'", "\'", $aRule['rule_value']) . '\'; } ';
			}			
			
			eval($sEval);
		}
		
		$sPhrase = ((Phpfox::getParam('language.lang_pack_helper') && !$bNoDebug) ? '{' . $sPhrase . '}' : $sPhrase);
		
		if (isset($aParams['phpfox_squote']))
		{
			$sPhrase = str_replace("'", "\\'", $sPhrase);
		}
		
		if (!defined('PHPFOX_INSTALLER') && $sParam == 'user.full_name' && Phpfox::getParam('user.display_or_full_name') == 'display_name')
		{
			return Phpfox::getPhrase('user.display_name');
		}
		
		$this->_aPhraseHistory[md5($sPhrase)] = array('var_name' => $sParam, 'params' => $aParams);
		
		return $sPhrase;
	}
	
	public function getPhraseHistory($sPhraseValue, $sLanguageId = null)
	{
		if (!isset($this->_aPhraseHistory[md5($sPhraseValue)]))
		{
			return $sPhraseValue;
		}
		
		$aPhrase = $this->_aPhraseHistory[md5($sPhraseValue)];		
	
		$aParts = explode('.', $aPhrase['var_name']);
		$aRow = Phpfox::getLib('database')->select('text')
			->from(Phpfox::getT('language_phrase'))
			->where('language_id = \'' . Phpfox::getLib('database')->escape($sLanguageId) . '\' AND var_name = \'' . $aParts[1] . '\'')
			->execute('getSlaveRow');
		
		if (!empty($aRow['text']))
		{
			$sPhrase = $aRow['text'];			
			if (!empty($aPhrase['params']))
			{
				$aFind = array();
				$aReplace = array();
				foreach ($aPhrase['params'] as $sKey => $sValue)
				{
					$aFind[] = '{' . $sKey . '}';
					$aReplace[] = '' . $sValue . '';
				}
					
				$sPhrase = str_replace($aFind, $aReplace, $sPhrase);
			}			
			
			return $sPhrase;
		}
		
		return $sPhraseValue;
	}	
	
	/**
	 * Sets the cache ID when caching phrases for a specific page.
	 *
	 */
	public function setCache()
	{
		$this->_oCache = Phpfox::getLib('cache');
		$this->_sCacheId = $this->_oCache->set(array('locale', 'language-' . $this->getLangId() . '-page-' . str_replace('/', '-', Phpfox::getLib('url')->getUrl()) . '-' . Phpfox::getLib('module')->getModuleName() . '-' . str_replace('_', '-', Phpfox::getLib('module')->getControllerName())));
		if (($this->_aPhrases = $this->_oCache->get($this->_sCacheId)))
		{		
			$this->_bIsCached = true;
		}
	}
	
	/**
	 * Caches all the phrases being used on a specific page.
	 *
	 */
	public function cache()
	{
		if ($this->_oCache == null)
		{
			$this->setCache();
		}
		if (!$this->_bIsCached)
		{
			$this->_oCache->save($this->_sCacheId, $this->_aCache);
			$this->_bIsCached = false;
			$this->_aCache = array();
		}
	}
	
	/**
	 * Translates a phrase from one language to another, if the translation exists; otherwise we return the default phrase.
	 *
	 * @param string $sStr Full string of the phrase.
	 * @param mixed $sPrefix (Optional) Unique ID of a group of phrases.
	 * @return string If a phrase is found we return the translated phrase or we simply return the default phrase string.
	 */
	public function translate($sStr, $sPrefix = null)
	{
		$sPhrase = 'language.translate_' . ($sPrefix ? $sPrefix . '_' : '') . strtolower(preg_replace("/\W/i", "_", $sStr));		

		if ($this->isPhrase($sPhrase))
		{
			return $this->getPhrase($sPhrase);
		}
		
		// In case this is a module ID# lets change the modules to have at least the first letter uppercase
		if ($sPrefix == 'module')
		{
			$sStr = ucwords($sStr);
		}		
		
		return (Phpfox::getParam('language.lang_pack_helper') ? '{' . $sStr . '}' : $sStr);	
	}
	
	/**
	 * Parses a phrase to convert ASCII rules.
	 *
	 * @see self::_parse()
	 * @param string $sTxt Phrase to parse.
	 * @return string Returns the newly parsed string.
	 */
	public function parse($sTxt)
	{		
		$sTxt = preg_replace("/&\#(.*?)\;/ise", "'' . \$this->_parse('$1') . ''", $sTxt);

		return $sTxt;
	}
	
	/**
	 * Converts HTML template code in phrases into actual phrases.
	 *
	 * @see self::_convert()
	 * @param string $sPhrase Phrase to convert.
	 * @return string Fully converted phrase.
	 */
	public function convert($sPhrase)
	{		
		if (preg_match('/\{phrase var=(.*)\}/i', $sPhrase, $aMatches))
		{
			$sPhrase = ' ' . $sPhrase . ' ';
			
			$sPhrase = preg_replace_callback('/ {phrase var=(.*?)} /is', array($this, '_convert'), $sPhrase);
			
			return trim($sPhrase);
		}
		
		return $sPhrase;
	}
	
	/**
	 * Parses a phrase to convert ASCII rules.
	 *
	 * @see self::parse()
	 * @param string $sTxt Phrase to parse.
	 * @return string Returns the newly parsed string.
	 */
	private function _parse($mParam)
	{
		return (isset($this->_aAscii[$mParam]) ? $this->_aAscii[$mParam] : '&#' . $mParam . ';');
	}
	
	/**
	 * Loads and caches phrases for a specific module.
	 *
	 * @param string $sModule Module ID
	 * @param bool $bForce TRUE to force loading phrases or FALSE to not.
	 * @return mixed ARRAY of phrases if it already has been cached, otherwise NULL.
	 */
	private function _getModuleLanguage($sModule, $bForce = false)
	{				
		if (!$bForce && isset($this->_aPhrases[$sModule]))
		{			
			return $this->_aPhrases[$sModule];
		}		
		
		$oCache = Phpfox::getLib('cache');
		
		$sId = $oCache->set(array('locale', 'language_' . $this->getLangId() . '_phrase_' . $sModule));

		if (!is_array($this->_aPhrases))
		{
			$this->_aPhrases = array();
		} // saw this error showing up on >2 sites, think its related to caching 

		if (!$bForce && ($this->_aPhrases[$sModule] = $oCache->get($sId)))
		{
			// $this->_aPhrases[$sModule] = $oCache->get($sId);			
		}
		else 
		{			
			if (!($this->_aPhrases[$sModule] = $oCache->get($sId)))
			{			
				$aRows = Phpfox::getLib('database')->select('p.var_name, p.text')
					->from(Phpfox::getT('language_phrase'), 'p')
					->join(Phpfox::getT('product'), 'product', 'product.product_id = p.product_id AND product.is_active = 1')
					->join(Phpfox::getT('module'), 'm', "m.module_id = '" . $sModule . "' AND p.module_id = m.module_id AND m.is_active = 1")
					->where("p.language_id = '" . Phpfox::getLib('database')->escape($this->getLangId()) . "'")
					->execute('getRows');
	
				foreach ($aRows as $aRow)
				{
					$this->_aPhrases[$sModule][$aRow['var_name']] = $aRow['text'];	
				}
	
				$oCache->save($sId, $this->_aPhrases[$sModule]);	
			}
		}
	}	
	
	/**
	 * Get all the phrases for a specific language package.
	 *
	 * @param string $sId Language ID.
	 * @return array ARRAY of phrases.
	 */
	private function _getPhrases($sId)
	{
		$aRows = Phpfox::getLib('database')->select('p.var_name, p.text, m.module_id')
			->from(Phpfox::getT('language_phrase'), 'p')
			->leftJoin(Phpfox::getT('module'), 'm', 'p.module_id = m.module_id AND m.is_active = 1')
			->join(Phpfox::getT('product'), 'product', 'p.product_id = product.product_id AND product.is_active = 1')
			->where("p.language_id = '" . Phpfox::getLib('database')->escape($sId) . "'")
			->execute('getRows');		
				
		$_aPhrasess = array();
		foreach ($aRows as $aRow)
		{
			$_aPhrasess[$aRow['module_id']][$aRow['var_name']] = $aRow['text'];	
		}
			
		return $_aPhrasess;
	}
	
	/**
	 * Converts HTML template code in phrases into actual phrases.
	 *
	 * @see self::convert()
	 * @param string $sPhrase Phrase to convert.
	 * @return string Fully converted phrase.
	 */
	private function _convert($aMatches)
	{
		$sPhrase = trim(trim($aMatches[1], "&#039;"), "'");
		$aParts = explode('.', $sPhrase);
		if (!Phpfox::isModule($aParts[0]))
		{
			return '';
		}
		
		return Phpfox::getPhrase($sPhrase);	
	}
}

?>
