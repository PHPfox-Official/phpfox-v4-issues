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
 * @package  		Module_Admincp
 * @version 		$Id: setting.class.php 6545 2013-08-30 08:41:44Z Raymond_Benc $
 */
class Admincp_Service_Setting_Setting extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('setting');
	}
	
	public function getForSearch()
	{
		$aRows = $this->database()->select('s.*, lp.text AS language_var_name')
			->from($this->_sTable, 's')
			->group('setting_id')
			->where('s.is_hidden = 0')
			->leftJoin(Phpfox::getT('language_phrase'), 'lp', array(				
					"lp.language_id = '" . Phpfox::getLib('locale')->getLangId() . "'",
					"AND lp.var_name = s.phrase_var_name"
				)
			)			
			->execute('getSlaveRows');		
		
		$aReturn = array();
		foreach ($aRows as $iKey => $aRow)
		{
			if (!empty($aRow['language_var_name']))
			{
				$aParts = explode('</title><info>', $aRow['language_var_name']);
				$aReturn[] = array(
					'link' => Phpfox::getLib('url')->makeUrl('admincp.setting.edit', array('setting-id' => $aRow['setting_id'])),
					'type' => 'Global Setting',
					'title' => str_replace('<title>', '', $aParts[0])
				);
			}			
		}		
				
		return $aReturn;		
	}	
	
	public function getForEdit($iId)
	{
		if (!PHPFOX_DEBUG)
		{
			return false;	
		}
		
		$aSetting = $this->database()->select('s.*, lp.text AS language_var_name')
			->from($this->_sTable, 's')
			->leftJoin(Phpfox::getT('language_phrase'), 'lp', array(				
					"lp.language_id = '" . Phpfox::getLib('locale')->getLangId() . "'",
					"AND lp.var_name = s.phrase_var_name"
				)
			)			
			->where('s.setting_id = ' . (int) $iId)
			->execute('getSlaveRow');
			
		if (!$aSetting['setting_id'])
		{
			return false;	
		}			
		
		$aSetting['value'] = $aSetting['value_actual'];
		$aSetting['type'] = $aSetting['type_id'];

		if (!empty($aSetting['language_var_name']))
		{
			$aParts = explode('</title><info>', $aSetting['language_var_name']);			
			$aSetting['title'] = str_replace('<title>', '', $aParts[0]);
			$aSetting['info'] = str_replace(array("\n", '</info>'), array("<br />", ''), $aParts[1]);			
		}			
				
		return $aSetting;
	}
	
	public function isSetting($sVarName)
	{
		$aRow = $this->database()->select('setting.var_name')
			->from($this->_sTable, 'setting')			
			->where("setting.var_name = '" . $this->database()->escape($sVarName) . "'")
			->execute('getSlaveRow');
		
		if (!isset($aRow['var_name']))
		{
			return false;
		}		
		
		return $aRow['var_name'];
	}
	
	public function get($aCond = array())
	{
		if (PHPFOX_DEBUG)
		{
			$this->database()->select('lp2.text AS language_var_name, ')
			->leftJoin(Phpfox::getT('setting_group'), 'sg', 'sg.group_id = setting.group_id')
			->leftJoin(Phpfox::getT('language_phrase'), 'lp2', array(				
					"lp2.language_id = '" . Phpfox::getLib('locale')->getLangId() . "'",
					"AND lp2.var_name = sg.var_name"
				)				
			);
		}		
		
		$aRows = $this->database()->select("setting.*, language_phrase.text AS title")
			->from($this->_sTable, 'setting')
			->join(Phpfox::getT('module'), 'm', 'm.module_id = setting.module_id AND m.is_active = 1')	
			->leftJoin(Phpfox::getT('language_phrase'), 'language_phrase', array(				
					"language_phrase.language_id = '" . Phpfox::getLib('locale')->getLangId() . "'",
					"AND language_phrase.var_name = setting.phrase_var_name"
				)
			)
			->where($aCond)
			->group('setting.setting_id')
			->order("setting.ordering ASC")
			->execute('getSlaveRows');		
		
		$sCdnDir = PHPFOX_DIR_LIB . PHPFOX_DS . 'phpfox' . PHPFOX_DS . 'cdn' . PHPFOX_DS . 'module' . PHPFOX_DS;
		$aCdns = array();
		$hDir = opendir($sCdnDir);		
		while ($sFile = readdir($hDir))
		{
			if (substr($sFile, -10)  != '.class.php')
			{
				continue;
			}
			
			$aCdns[] = substr_replace($sFile, '', -10);
		}
		if (count($aCdns))
		{
			$aCdns = array_merge(array(''), $aCdns);
		}
		closedir($hDir);
		
		// Load all fonts used for CAPTCHA
		$sFontDir = Phpfox::getParam('core.dir_static') . 'image' . PHPFOX_DS . 'font' . PHPFOX_DS;
		$aFonts = array();
		$hDir = opendir($sFontDir);		
		while ($sFile = readdir($hDir))
		{
			if (!preg_match("/ttf/i", substr($sFile, -3)))
			{
				continue;
			}
			
			$aFonts[] = $sFile;
		}
		closedir($hDir);
		
		// Load all the editors that are valid
		$aWysiwygs = array();
		$aEditors = Phpfox::getLib('file')->getFiles(Phpfox::getParam('core.dir_static') . 'jscript' . PHPFOX_DS . 'wysiwyg' . PHPFOX_DS);
		foreach ($aEditors as $sEditor)
		{
			if (!file_exists(Phpfox::getParam('core.dir_static') . 'jscript' . PHPFOX_DS . 'wysiwyg' . PHPFOX_DS . $sEditor . PHPFOX_DS . 'core.js'))
			{
				continue;
			}
			$aWysiwygs[] = $sEditor;
		}
				
		$aTimezones = Phpfox::getService('core')->getTimeZones();
		
		if (defined('PHPFOX_IS_HOSTED_SCRIPT') && !defined('PHPFOX_GROUPLY_TEST'))
		{
			$aNotAllowedToEdit = array(
					'core.allow_cdn',
					'core.amazon_access_key',
					'core.amazon_secret_key',
					'core.amazon_bucket',
					'core.amazon_bucket_created',
					'core.cdn_cname',
					'core.cdn_amazon_https',
					'core.cdn_service',
					'core.enable_amazon_expire_urls',
					'core.amazon_s3_expire_url_timeout',
					'core.rackspace_username',
					'core.rackspace_key',
					'core.rackspace_container',
					'core.rackspace_url',
					'core.unzip_path',
					'core.tar_path',
					'core.zip_path',
					'core.session_prefix',
					'core.cookie_path',
					'core.cookie_domain',
					'core.admin_debug_mode',
					'core.log_missing_images',
					'core.cache_plugins',
					'core.ftp_enabled',
					'core.ftp_host',
					'core.ftp_username',
					'core.ftp_password',
					'core.ftp_dir_path',
					'log.active_session',
					'core.build_format',
					'core.log_site_activity',
					'core.cache_js_css',
					'core.enable_getid3_check',
					'core.force_https_secure_pages',
					'core.disable_hash_bang_support',
					'core.site_wide_ajax_browsing',
					'core.mail_smtp_password',
					'core.use_dnscheck',
					'core.mail_smtp_port',
					'core.mail_smtp_username',
					'core.mail_smtp_authentication',
					'core.mailsmtphost',
					'core.method',
					'apps.openssl_config_path',
					'apps.token_keep_alive',
					'video.allow_video_uploading',
				'video.params_for_ffmpeg',
				'video.params_for_mencoder',
				'video.params_for_mencoder_fallback',
				'video.enable_flvtool2',
				'video.params_for_flvtool2',
				'video.flvtool2_path',
				'video.vidly_support',
				'video.vidly_user_key',
				'video.vidly_api_key',
				'video.mencoder_path',
				'video.ffmpeg_path',
				'photo.rename_uploaded_photo_names',
				'photo.delete_original_after_resize',
				'core.build_file_dir',
				'core.allow_html_in_activity_feed'
			);
		}
		
		$aCacheSetting = array();
		foreach ($aRows as $iKey => $aRow)
		{
			if (isset($aCacheSetting[$aRow['var_name']]))
			{
				unset($aRows[$iKey]);
				
				continue;
			}			
			
			if (defined('PHPFOX_IS_HOSTED_SCRIPT') && !defined('PHPFOX_SHOW_HIDDEN') && !defined('PHPFOX_GROUPLY_TEST'))
			{				
				if (in_array($aRow['module_id'] . '.' . $aRow['var_name'], $aNotAllowedToEdit))
				{
					unset($aRows[$iKey]);
					
					continue;
				}	
			}
			
			$aCacheSetting[$aRow['var_name']] = true;
			
			if (!empty($aRow['language_var_name']))
			{
				$aParts = explode('</title><info>', $aRow['language_var_name']);			
				$aRows[$iKey]['group_title'] = str_replace('<title>', '', $aParts[0]);				
			}			
			
			if ($aRow['type_id'] == 'drop')
			{				
				$aArray = unserialize($aRow['value_actual']);				
				
				// Make sure an editor is valid before we display it
				if ($aRow['var_name'] == 'wysiwyg')
				{					
					/*
					foreach ($aArray['values'] as $iSubKey => $sSubValue)
					{
						if (!in_array($sSubValue, $aWysiwygs))
						{
							unset($aArray['values'][$iSubKey]);
						}
					}
					*/
					
					$aArray['values'] = $aWysiwygs;					
					$aRows[$iKey]['values'] = $aArray;					
					$aRows[$iKey]['value_actual'] = implode(',', $aRows[$iKey]['values']['values']);					
				}				
				else 
				{
					$aRows[$iKey]['values'] = $aArray;
					$aRows[$iKey]['value_actual'] = implode(',', $aRows[$iKey]['values']['values']);
				}
			}	

			if ($aRow['type_id'] == 'array')
			{				
				if (!empty($aRow['value_actual']))
				{
					$aRow['value_actual'] = preg_replace("/s:(.*):\"(.*?)\";/ise", "'s:'.strlen('$2').':\"$2\";'", $aRow['value_actual']);
					
					eval("\$aRows[\$iKey]['value_actual'] = " . unserialize($aRow['value_actual']) . "");
				}
			}	
			
			if (!empty($aRow['title']))
			{
				$aParts = explode('</title><info>', $aRow['title']);
			}
			else if (!empty($aRow['phrase_var_name']) && !empty($aRow['module_id']))
			{
				
				$aParts = explode('</title><info>', Phpfox::getPhrase($aRow['module_id'] . '.'.$aRow['phrase_var_name']));				
			}
			
			if (isset($aParts[0]))
			{
				$aRows[$iKey]['setting_title'] = (isset($aParts[0]) ? str_replace('<title>', '', $aParts[0]) : '');
				if (isset($aParts[1]))
				{
					$aParts[1] = Phpfox::getLib('parse.bbcode')->preParse($aParts[1]);
					$aParts[1] = Phpfox::getLib('parse.bbcode')->parse($aParts[1]);			
				}
				$aRows[$iKey]['setting_info'] = (isset($aParts[1]) ? str_replace(array("\n", '</info>'), array("<br />", ''), $aParts[1]) : '');				
				if ($aRows[$iKey]['setting_info'])
				{					
					$aRows[$iKey]['setting_info'] = preg_replace("/<setting>([a-z\._]+)<\/setting>/i", "<a href=\"" . Phpfox::getLib('url')->makeUrl('admincp', array('setting', 'search', 'var' => '$1')) . "\">$1</a>", $aRows[$iKey]['setting_info']);
					$aRows[$iKey]['setting_info'] = preg_replace("/\{url link\='(.*?)'\}/is", "" . Phpfox::getLib('url')->makeUrl('$1') . "", $aRows[$iKey]['setting_info']);				
				}
			}			
			
			unset($aRows[$iKey]['title']);
			
			if ($aRow['var_name'] == 'on_signup_new_friend' || ($aRow['var_name'] == 'admin_in_charge_of_page_claims'))
			{
				$aUserArray = array();
				$aUsers = $this->database()->select('user_id, full_name')
					->from(Phpfox::getT('user'))
					->where('user_group_id = ' . ADMIN_USER_ID)
					->execute('getSlaveRows');
				$aUserArray[0] = Phpfox::getPhrase('user.none');
				foreach ($aUsers as $aUser)
				{
					$aUserArray[$aUser['user_id']] = $aUser['full_name'];
				}				
				$aRows[$iKey]['type_id'] = 'drop_with_key';
				$aRows[$iKey]['values'] = $aUserArray;		
			}
			
			if ($aRow['var_name'] == 'cdn_service')
			{
				$aRows[$iKey]['type_id'] = 'drop';
				$aRows[$iKey]['values'] = array(
					'default' => $aRow['value_actual'],
					'values' => $aCdns
				);
				$aRows[$iKey]['value_actual'] = implode(',', $aCdns);				
			}
			
			if ($aRow['var_name'] == 'captcha_font')
			{
				$aRows[$iKey]['type_id'] = 'drop';
				$aRows[$iKey]['values'] = array(
					'default' => $aRow['value_actual'],
					'values' => $aFonts
				);
				$aRows[$iKey]['value_actual'] = implode(',', $aFonts);				
			}
			
			if ($aRow['var_name'] == 'default_time_zone_offset')
			{
				$aRows[$iKey]['type_id'] = 'drop_with_key';
				$aRows[$iKey]['values'] = $aTimezones;					
			}
			
			if ($aRow['var_name'] == 'ip_check')
			{
				$aIpCheck = array(
					'0' => '255.255.255.255',
					'1' => '255.255.255.0',
					'2' => '255.255.0.0'
				);
				$aRows[$iKey]['type_id'] = 'drop_with_key';
				$aRows[$iKey]['values'] = $aIpCheck;
			}
			
			if ($aRow['var_name'] == 'ftp_password')
			{
				$aRows[$iKey]['value_actual'] = substr_replace(base64_decode(base64_decode($aRow['value_actual'])), '', -32);									
			}
			
			if ($aRow['var_name'] == 'points_conversion_rate')
			{
				$aValueActuals = array();
				if (!empty($aRow['value_actual']))
				{
					$aValueActuals = json_decode($aRow['value_actual'], true);					
				}
				$aCurrencies = Phpfox::getService('core.currency')->get();
				$aDisplayValues = array();
				foreach ($aCurrencies as $sCurrencyKey => $aCurrencyValue)
				{
					$aDisplayValues[$sCurrencyKey] = (isset($aValueActuals[$sCurrencyKey]) ? $aValueActuals[$sCurrencyKey] : '');
				}

				$aRows[$iKey]['type_id'] = 'multi_text';
				$aRows[$iKey]['values'] = $aDisplayValues;				
			}
		}	
		
		(($sPlugin = Phpfox_Plugin::get('admincp.service_setting_setting_get')) ? eval($sPlugin) : false);

		return $aRows;
	}
	
	public function export($sProductId, $sModuleId = null, $bCore = false)
	{
		$aWhere = array();
		$aWhere[] = "setting.product_id = '" . $sProductId . "'";
		if ($sModuleId !== null)
		{
			$aWhere[] = " AND setting.module_id = '" . $sModuleId . "'";
		}
		
		$aRows = $this->database()->select('setting.*, product.title AS product_name, m.module_id AS module_name, setting_group.group_id AS group_name')
			->from($this->_sTable, 'setting')
			->leftJoin(Phpfox::getT('product'), 'product', 'product.product_id = setting.product_id')
			->leftJoin(Phpfox::getT('module'), 'm', 'm.module_id = setting.module_id')
			->leftJoin(Phpfox::getT('setting_group'), 'setting_group', 'setting_group.group_id = setting.group_id')
			->where($aWhere)
			->execute('getRows');
		
		if (!isset($aRows[0]['product_name']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.product_does_not_have_any_settings'));
		}	
		
		if (!count($aRows))
		{
			return false;
		}
		
		$oXmlBuilder = Phpfox::getLib('xml.builder');
		$oXmlBuilder->addGroup('settings');
			
		$aCache = array();
		foreach ($aRows as $aSetting)
		{
			if (isset($aCache[$aSetting['var_name']]))
			{
				continue;
			}
			$aCache[$aSetting['var_name']] = $aSetting['var_name'];

			$aSetting[($bCore ? 'value_default' : 'value_actual')] = str_replace("\r\n", "\n", $aSetting[($bCore ? 'value_default' : 'value_actual')]);
			$oXmlBuilder->addTag('setting', $aSetting[($bCore ? 'value_default' : 'value_actual')], array(
					'group' => $aSetting['group_name'],
					'module_id' => $aSetting['module_name'],
					'is_hidden' => $aSetting['is_hidden'],
					'type' => $aSetting['type_id'],
					'var_name' => $aSetting['var_name'],
					'phrase_var_name' => $aSetting['phrase_var_name'],
					'ordering' => $aSetting['ordering'],
					'version_id' => $aSetting['version_id']
				)
			);			
		}	
		$oXmlBuilder->closeGroup();
				
		return true;
	}
	
	public function exportGroup($sProductId, $sModuleId = null)
	{
		$aSql = array();
		if ($sModuleId !== null)
		{
			$aSql[] = "setting_group.module_id = '" . $sModuleId . "' AND";
		}
		$aSql[] = "setting_group.product_id = '" . $sProductId . "'";
		
		$aRows = $this->database()->select('setting_group.*, product.title AS product_name')
			->from(Phpfox::getT('setting_group'), 'setting_group')
			->leftJoin(Phpfox::getT('product'), 'product', 'product.product_id = setting_group.product_id')
			->where($aSql)
			->execute('getRows');
		
		if (!isset($aRows[0]['product_name']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.product_does_not_have_any_settings'));
		}		
		
		if (!count($aRows))
		{
			return false;
		}
		
		$oXmlBuilder = Phpfox::getLib('xml.builder');
		$oXmlBuilder->addGroup('setting_groups');
			
		$aCache = array();
		foreach ($aRows as $aSetting)
		{
			if (isset($aCache[$aSetting['var_name']]))
			{
				continue;
			}
			$aCache[$aSetting['var_name']] = $aSetting['var_name'];			
			$oXmlBuilder->addTag('name', $aSetting['group_id'], array(
					'module_id' => $aSetting['module_id'],
					'version_id' => $aSetting['version_id'],
					'var_name' => $aSetting['var_name']
				)
			);			
		}	
		$oXmlBuilder->closeGroup();
				
		return true;
	}	
	
	public function search($aCond = array())
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.service_setting_setting_search')) ? eval($sPlugin) : false);
		
		$aRows = $this->database()->select('setting.*')
			->from($this->_sTable, 'setting')
			->where($aCond)
			->execute('getSlaveRows');
		
		return $aRows;	
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
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_setting_setting___call'))
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