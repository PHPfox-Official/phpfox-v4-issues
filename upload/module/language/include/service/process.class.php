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
class Language_Service_Process extends Phpfox_Service 
{
	private $_aFile = array();
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('language');
	}
	
	public function import($aVals, $sProductName = null, $bMissingOnly = false, $bIsInstall = false)
	{
		if ($bMissingOnly)
		{
			$aLang = Phpfox::getService('language')->getLanguageByName($aVals['settings']['title']);
			
			if (!isset($aLang['language_id']))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('language.cannot_import'));
			}
			
			$aSql = array();
			foreach ($aVals['phrases']['phrase'] as $aValue)
			{
				$sPhrase = $aValue['module_id'] . '.' . $aValue['var_name'];
				$bPassed = true;
				if (!$bIsInstall && !Phpfox::getLib('locale')->isPhrase($sPhrase))
				{
					$bPassed = false;	
				}
				
				if ($bPassed)
				{
					$iModuleId = Phpfox::getLib('module')->getModuleId($aValue['module_id']);
					$aSql[] = array(
						$aLang['language_id'],
						$iModuleId,
						$sProductName,
						$aValue['version_id'],
						$aValue['var_name'],
						$aValue['value'],
						$aValue['value'],
						$aValue['added']
					);					
				}
			}			
			
			if ($aSql)
			{
				$this->database()->multiInsert(Phpfox::getT('language_phrase'), array(
					'language_id',
					'module_id',
					'product_id',
					'version_id',
					'var_name',
					'text',
					'text_default',
					'added'
				), $aSql);					
				
				$this->cache()->remove('locale', 'substr');	
			}
			
			return true;
		}
		else 
		{			
			$this->add(array(				
					'title' => $aVals['settings']['title'],
					'user_select' => $aVals['settings']['user_select'],
					'language_code' => $aVals['settings']['language_code'],
					'charset' => $aVals['settings']['charset'],
					'direction' => $aVals['settings']['direction'],
					'time_stamp' => $aVals['settings']['time_stamp'],
					'created' => $aVals['settings']['created'],
					'site' => $aVals['settings']['site'],
					'is_default' => ($bIsInstall ? 1 : 0),
					'is_master' => ($bIsInstall ? 1 : 0)
				)
			);

			$aSql = array();
			$iLength = 0;		
			$iLanguageId = $aVals['settings']['language_code'];
			foreach ($aVals['phrases']['phrase'] as $aValue)
			{				
				$iModuleId = Phpfox::getLib('module')->getModuleId($aValue['module']);
				$aSql[] = array(
					$iLanguageId,
					$iModuleId,
					$sProductName,
					$aValue['version_id'],
					$aValue['var_name'],
					$aValue['value'],
					$aValue['value'],
					$aValue['added']
				);
				
				$iLength += strlen($aValue['value']);				
				
				if ($iLength > 102400)
				{					
					$this->database()->multiInsert(Phpfox::getT('language_phrase'), array(
						'language_id',
						'module_id',
						'product_id',
						'version_id',
						'var_name',
						'text',
						'text_default',
						'added'
					), $aSql);					
					
					$aSql = array();
					$iLength = 0;
				}
			}	
			
			if ($aSql)
			{
				$this->database()->multiInsert(Phpfox::getT('language_phrase'), array(
					'language_id',
					'module_id',
					'product_id',
					'version_id',
					'var_name',
					'text',
					'text_default',
					'added'
				), $aSql);		
			}			
			
			unset($aSql, $iLength);
			
			$this->cache()->remove('locale', 'substr');
		}		

		return true;
	}
	
	public function add($aVals)
	{
		$oFilter = Phpfox::getLib('parse.input');
		
		$aCheck = array(
			'parent_id' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('language.select_a_language_package_to_clone')
			),
			'title' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('language.provide_a_name_for_your_language_package')
			),
			'language_code' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('language.provide_an_abbreviation_code')
			),
			/*
			'charset' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('language.provide_an_html_character_set')
			),
			*/
			'direction' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('language.provide_the_text_direction')
			),
			'user_select' => array(
				'type' => 'int:required'
			),
			'created' => array(
				'type' => 'string'
			),
			'site' => array(
				'type' => 'string'
			)			
		);
		
		$aVals = $this->validator()->process($aCheck, $aVals);
		
		if (!Phpfox_Error::isPassed())
		{
			return false;
		}		
		
		if (!$this->_checkImage())
		{
			return false;
		}

		$aOlds = $this->database()->select('title')
			->from($this->_sTable)
			->where("title LIKE '%" . $this->database()->escape($aVals['title']) . "%'")
			->execute('getRows');	
			
		$iTotal = 0;
		foreach ($aOlds as $aOld)
		{
			if (preg_replace("/(.*?)\([0-9]\)/i", "$1", $aOld['title']) === $aVals['title'])
			{
				$iTotal++;
			}
		}		
		
		$aOldsId = $this->database()->select('language_id')
			->from($this->_sTable)
			->where("language_id LIKE '%" . $this->database()->escape($aVals['language_code']) . "%'")
			->execute('getRows');	
			
		$iTotalId = 0;
		foreach ($aOldsId as $aOldId)
		{
			if (preg_replace("/(.*?)-[0-9]/i", "$1", $aOldId['language_id']) === $aVals['language_code'])
			{
				$iTotalId++;
			}
		}		
		
		$sLanguageId = $aVals['language_code']  . ($iTotalId > 0 ? '-' . ($iTotalId + 1) . '' : '');		
		
		if (!empty($aVals['site']))
		{
			if ($this->validator()->check($aVals['site'], 'url'))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('language.not_a_valid_url'));
			}
			
			if (!preg_match('/(http|https):\/\/(.*?)/i', $aVals['site']))
			{
				$aVals['site'] = 'http://' . $aVals['site'];
			}
		}			
		
		$this->database()->insert($this->_sTable, array(				
				'language_id' => $sLanguageId,
				'parent_id' => $aVals['parent_id'],
				'title' => $oFilter->clean($aVals['title'], 255) . ($iTotal > 0 ? '(' . ($iTotal + 1) . ')' : ''),
				'user_select' => (int) $aVals['user_select'],
				'language_code' => $aVals['language_code'],
				// 'charset' => $aVals['charset'],
				'charset' => 'UTF-8',
				'direction' => $aVals['direction'],
				'time_stamp' => (isset($aVals['time_stamp']) ? (int) $aVals['time_stamp'] : PHPFOX_TIME),
				'created' => (empty($aVals['created']) ? null : $oFilter->clean($aVals['created'])),
				'site' => (empty($aVals['site']) ? null : $oFilter->clean($aVals['site'])),
				'is_default' => 0,
				'is_master' => 0
			)
		);		
		
		$this->cache()->remove('locale', 'substr');
		
		$this->_uploadImage($sLanguageId);
		
		return $sLanguageId;
	}	
	
	public function installPackFromFolder($sPack, $sCustomDir = '')
	{
		if (!empty($sCustomDir))
		{
			if (!preg_match('/phpfox-language-([a-zA-Z0-9]+)\.zip/i', $_FILES['import']['name'], $aMatches))
			{
				return Phpfox_Error::set('This is not a valid language package.');
			}
			
			$sPack = $aMatches[1];
		}
		
		$sDir = (empty($sCustomDir) ? PHPFOX_DIR_INCLUDE : $sCustomDir . str_replace(PHPFOX_DIR, '', PHPFOX_DIR_INCLUDE)) . 'xml' . PHPFOX_DS . 'language' . PHPFOX_DS . $sPack . PHPFOX_DS;		

		if (!is_dir($sDir))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('language.not_a_valid_language_package_to_install'));
		}
		
		if (!file_exists($sDir . 'phpfox-language-import.xml'))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('language.not_a_valid_language_package_to_install_missing_the_xml_file'));	
		}
		
		$aData = Phpfox::getLib('xml.parser')->parse($sDir . 'phpfox-language-import.xml');
		
		$aCheck = array(
			'title' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('language.provide_a_name_for_your_language_package')
			),
			'language_code' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('language.provide_an_abbreviation_code')
			),
			'direction' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('language.provide_the_text_direction')
			),
			'user_select' => array(
				'type' => 'int:required'
			),
			'created' => array(
				'type' => 'string'
			),
			'site' => array(
				'type' => 'string'
			),
			'flag_id' => array(
				'type' => 'string'
			),
			'image' => array(
				'type' => 'string'
			),
			'charset' => array(
				'type' => 'string'
			),
			'is_default' => array(
				'type' => 'int'
			),
			'is_master' => array(
				'type' => 'int'
			)
		);		
		
		$aData['settings'] = $this->validator()->process($aCheck, $aData['settings']);
		
		if (!Phpfox_Error::isPassed())
		{
			return false;
		}			
		
		if (isset($aData['settings']['image']))
		{
			if (file_exists(Phpfox::getParam('core.dir_pic') . 'flag' . PHPFOX_DS . $sPack . '.' . $aData['settings']['flag_id']))
			{
				unlink(Phpfox::getParam('core.dir_pic') . 'flag' . PHPFOX_DS . $sPack . '.' . $aData['settings']['flag_id']);
			}				
			
			Phpfox::getLib('file')->write(Phpfox::getParam('core.dir_pic') . 'flag' . PHPFOX_DS . $sPack . '.' . $aData['settings']['flag_id'], base64_decode($aData['settings']['image']));
			
			unset($aData['settings']['image']);
		}
		
		$aData['settings']['language_id'] = $sPack;
		$aData['settings']['time_stamp'] = PHPFOX_TIME;
		
		$this->database()->insert(Phpfox::getT('language'), $aData['settings']);
		
		return true;
	}
	
	public function update($sLangId, $aVals)
	{		
		$aCheck = array(
			'title' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('language.provide_a_name_for_your_language_package')
			),
			'language_code' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('language.provide_an_abbreviation_code')
			),
			'direction' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('language.provide_the_text_direction')
			),
			'user_select' => array(
				'type' => 'int:required'
			),
			'created' => array(
				'type' => 'string'
			),
			'site' => array(
				'type' => 'string'
			)			
		);
		
		$aVals = $this->validator()->process($aCheck, $aVals);
		
		if (!Phpfox_Error::isPassed())
		{
			return false;
		}		

		if (!$this->_checkImage())
		{
			return false;
		}			
		
		if (!empty($aVals['site']))
		{
			if ($this->validator()->check($aVals['site'], 'url'))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('language.not_a_valid_url'));
			}
			
			if (!preg_match('/(http|https):\/\/(.*?)/i', $aVals['site']))
			{
				$aVals['site'] = 'http://' . $aVals['site'];
			}
		}		
		
		$aVals['title'] = $this->preParse()->clean($aVals['title']);
		
		$this->database()->update(Phpfox::getT('language'), $aVals, 'language_id = \'' . $this->database()->escape($sLangId) . '\'');
		
		$this->_uploadImage($sLangId);
		
		$this->cache()->remove('locale', 'substr');
		
		return true;
	}
	
	public function delete($iId)
	{
		$aLanguage = Phpfox::getService('language')->getLanguage($iId);
		
		$this->database()->delete($this->_sTable, "language_id = '" . $this->database()->escape($iId) . "'");
		$this->database()->delete(Phpfox::getT('language_phrase'), "language_id = '" . $this->database()->escape($iId) . "'");
		
		if (file_exists(Phpfox::getParam('core.dir_pic') . 'flag' . PHPFOX_DS . $iId . '.' . $aLanguage['flag_id']))
		{
			unlink(Phpfox::getParam('core.dir_pic') . 'flag' . PHPFOX_DS . $iId . '.' . $aLanguage['flag_id']);
		}		
		
		$this->cache()->remove('locale', 'substr');
		
		return true;
	}
	
	public function setDefault($iId)
	{		
		$this->database()->update($this->_sTable, array(
			'is_default' => 0
		), "is_default = 1");
		
		$this->database()->update($this->_sTable, array(
			'is_default' => 1
		), "language_id = '" . $this->database()->escape($iId) . "'");	
		
		$this->database()->update(Phpfox::getT('setting'), array('value_actual' => $iId), 'module_id = \'core\' AND var_name = \'default_lang_id\'');
		
		$this->cache()->remove('locale', 'substr');
		$this->cache()->remove('setting', 'substr');
		
		return true;
	}
	
	public function useLanguage($sLanguageId)
	{
		if (Phpfox::isUser())
		{		
			$this->database()->update(Phpfox::getT('user'), array('language_id' => $sLanguageId), 'user_id = ' . Phpfox::getUserId());
		}
		else 
		{
			Phpfox::getLib('session')->set('language_id', $sLanguageId);
		}
		
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
		if ($sPlugin = Phpfox_Plugin::get('language.service_process__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}
	
	private function _checkImage()
	{
		if (!empty($_FILES['icon']['name']))
		{
			if (!($this->_aFile = Phpfox::getLib('file')->load('icon', array('jpg', 'gif', 'png'))))
			{
				return false;
			}
		}
		
		return true;
	}
	
	private function _uploadImage($sLanguageId)
	{
		if (!empty($this->_aFile['name']))
		{
			if (file_exists(Phpfox::getParam('core.dir_pic') . 'flag' . PHPFOX_DS . $sLanguageId . '.' . $this->_aFile['ext']))
			{
				unlink(Phpfox::getParam('core.dir_pic') . 'flag' . PHPFOX_DS . $sLanguageId . '.' . $this->_aFile['ext']);
			}
			
			if (Phpfox::getLib('file')->upload('icon', Phpfox::getParam('core.dir_pic') . 'flag' . PHPFOX_DS, $sLanguageId, false, 0644, false))
			{
				$this->database()->update(Phpfox::getT('language'), array('flag_id' => $this->_aFile['ext']), 'language_id = \'' . $this->database()->escape($sLanguageId) . '\'');	
			}
		}
	}
}

?>
