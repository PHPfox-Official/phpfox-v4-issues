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
 * @version 		$Id: process.class.php 7129 2014-02-19 13:27:09Z Fern $
 */
class Admincp_Service_Setting_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('setting');
	}
	
	public function add($aVals)
	{		
		switch($aVals['type'])
		{
			case 'array':
				// Make sure its an array
				if (preg_match("/^array\((.*)\);$/i", $aVals['value']))
				{			
					$aVals['value'] = serialize($aVals['value']);
				}
				else 
				{
					return Phpfox_Error::set(Phpfox::getPhrase('admincp.not_valid_array'));
				}
				break;
			case 'integer':
				if (!is_numeric($aVals['value']))
				{					
					return Phpfox_Error::set(Phpfox::getPhrase('admincp.value_must_be_numeric'));
				}
				break;
			case 'drop':
				$aDropDowns = explode(',', $aVals['value']);

				$aVals['value'] = serialize(array(
						'default' => $aDropDowns[0],
						'values' => $aDropDowns
					)
				);
				break;
			default:
				
				break;
		}		
		
		$iGroupId = $aVals['group_id'];
		$iModule = $aVals['module_id'];
		$iProductId = $aVals['product_id'];
		$aVals['var_name'] = preg_replace('/ +/', '_', preg_replace('/[^0-9a-zA-Z_ ]+/', '', trim($aVals['var_name'])));
		$aVals['var_name'] = strtolower($aVals['var_name']);
		
		$sPhrase = 'setting_' . Phpfox::getService('language.phrase.process')->prepare($aVals['var_name']);
		
		$iLastOrder = $this->database()->select('ordering')
			->from($this->_sTable)
			->where("group_id = '{$iGroupId}' AND module_id = '{$iModule}' AND product_id = '{$iProductId}'")
			->order('ordering DESC')
			->execute('getSlaveField');		
			
		$iId = $this->database()->insert($this->_sTable, array(
				'group_id' => (empty($iGroupId) ? null : $iGroupId),
				'module_id' => (empty($iModule) ? null : $iModule),
				'product_id' => $iProductId,
				'version_id' => PhpFox::getId(),
				'type_id' => $aVals['type'],
				'var_name' => $aVals['var_name'],
				'phrase_var_name' => $sPhrase,
				'value_actual' => $aVals['value'],
				'value_default' => $aVals['value'],
				'ordering' => ((int) $iLastOrder + 1)
			)
		);
		
		$sPhrase = Phpfox::getService('language.phrase.process')->add(array(
				'var_name' => 'setting_' . $aVals['var_name'],
				'product_id' => $iProductId,
				'module' => (empty($iModule) ? 'core|core' : $iModule . '|' . $iModule),
				'text' => array(
					'en' => '<title>' . $aVals['title'] .'</title><info>' . $aVals['info'] .'</info>'
				)
			)
		);
		
		// Clear the setting cache
		$this->cache()->remove('setting');
		
		return (empty($iModule) ? '' : $iModule . '.') . $aVals['var_name'];
	}
	
	public function update($aVals)
	{		
		
		if (isset($aVals['order']))
		{
			foreach ($aVals['order'] as $sVar => $iOrder)
			{
				$this->database()->update($this->_sTable, array('ordering' => (int) $iOrder), "var_name = '" . $this->database()->escape($sVar) . "'");
			}		
		}
				
		if (isset($aVals['value']['admin_debug_mode']) && file_exists(PHPFOX_DIR . 'file' . PHPFOX_DS . 'log' . PHPFOX_DS . 'debug.php'))
		{
			Phpfox::getLib('file')->unlink(PHPFOX_DIR . 'file' . PHPFOX_DS . 'log' . PHPFOX_DS . 'debug.php');
		}
		
		if (isset($aVals['value']['ftp_enabled']) && $aVals['value']['ftp_enabled'])
		{			
			define('PHPFOX_FTP_LOGIN_PASS', true);
	
			if (Phpfox::getLib('ftp')->connect($aVals['value']['ftp_host'], $aVals['value']['ftp_username'], $aVals['value']['ftp_password']))
			{
				if (!Phpfox::getLib('ftp')->test($aVals['value']['ftp_dir_path']))
				{
					return false;
				}
			}
			
			if (!Phpfox_Error::isPassed())
			{
				return false;
			}			
		}
		
		if (isset($aVals['value']['enable_api_support']) && $aVals['value']['enable_api_support'])
		{
			if (!Phpfox::getService('api')->test())
			{
				return false;
			}
		}
		
		if (isset($aVals['value']['enable_janrain_login']) && $aVals['value']['enable_janrain_login'] == 1 &&
			( (isset($aVals['value']['janrain_api_key']) && empty($aVals['value']['janrain_api_key'])) ||
				(isset($aVals['value']['janrain_application_domain']) && empty($aVals['value']['janrain_application_domain']))
			)
			)
		{			
			return Phpfox_Error::set('To enable Janrain you must set the API Key and the Application domain');
		}
		
		if (isset($aVals['value']['method']) && $aVals['value']['method']['value'] == 'smtp')
		{			
			Phpfox_Error::skip(true);
			
			$bSent = Phpfox::getLib('mail', 'smtp')->test($aVals['value'])
				->to($aVals['value']['email_from_email'])
				->subject('Test SMTP E-mail')
				->message('SMTP is working!')
				->send();				
				
			if ($bSent === false)
			{
				$sEmailHeader = ob_get_contents();
				
				ob_clean();
				
				if (!empty($sEmailHeader))
				{
					Phpfox_Error::set('<b>SMTP Error Message</b>: ' . $sEmailHeader);
				}
				
				return false;
			}
			
			Phpfox_Error::skip(false);
		}			

		if (!empty($_FILES['watermark']['name']))
		{
			$aImage = Phpfox::getLib('file')->load('watermark', array('jpg', 'gif', 'png'));
			if ($aImage === false)
			{
				return false;
			}
			
			$hDir = opendir(Phpfox::getParam('core.dir_watermark'));
			while ($sFile = readdir($hDir))
			{
				if (!preg_match('/(.*)\.(jpg|jpeg|gif|png)/i', $sFile))
				{
					continue;
				}
				
				Phpfox::getLib('file')->unlink(Phpfox::getParam('core.dir_watermark') . $sFile);
			}
			closedir($hDir);
			
			if (!($sWatermarkName = Phpfox::getLib('file')->upload('watermark', Phpfox::getParam('core.dir_watermark'), 'watermark', true, 0644, false)))
			{
				return false;	
			}
			
			$aVals['value']['watermark_image'] = $sWatermarkName;			
		}		
		
		$aValues = array();

		if (!isset($aVals['value']))
		{ // when logged out because of inactivity and refresh and resubmit it would throw an undefined index error
				$this->cache()->remove();
				return true;
		}
		foreach ($aVals['value'] as $sKey => $mValue)
		{
			if (is_array($mValue))
			{
				if ($sKey == 'points_conversion_rate')
				{
					$aValues['value_actual'] = json_encode($mValue);
				}				
				elseif ($sKey == 'captcha_font' || $sKey == 'cdn_service')
				{
					$aValues['value_actual'] = $mValue['value'];	
				}
				else 
				{
					if (isset($mValue['real']) && isset($mValue['value']))
					{
						$mValue['value'] = trim($mValue['value']);
						$aSub = array();
						$aSub[] = $mValue['value'];
						$aParts = explode(',', $mValue['real']);					
						foreach ($aParts as $sPart)
						{
							$sPart = trim($sPart);
							if ($sPart == $mValue['value'])
							{
								continue;
							}
							$aSub[] = $sPart;
						}
						
						if ($sKey == 'admin_debug_mode' && $mValue['value'] != 'level_0')
						{
							if ($hFile = @fopen(PHPFOX_DIR . 'file' . PHPFOX_DS . 'log' . PHPFOX_DS . 'debug.php', 'w+'))
							{			
								fwrite($hFile, '<?php define(\'PHPFOX_DEBUG\', true); define(\'PHPFOX_DEBUG_LEVEL\', ' . trim(preg_replace('/Level(_)/i', '', $mValue['value'])) . '); ?>');
								fclose($hFile);		
							}							
						}
						
						// Prepare the array for the database
						$aValues['value_actual'] = serialize(array(
								'default' => $mValue['value'],
								'values' => $aSub
							)
						);
					}
					else 
					{
						$aCached = array();
						foreach ($mValue as $iValueKey => $sValueKey)
						{						
							// Make sure we don't have any duplicate values
							if (isset($aCached[$sValueKey]))
							{
								// Remove the duplicate value
								unset($mValue[$iValueKey]);
							}
							// Cache for duplicate value check
							$aCached[$sValueKey] = $sValueKey;
						}
			
						// Prepare the array for the database
						$aValues['value_actual'] = serialize(str_replace('array ', 'array', var_export($mValue, true)) . ';');
					}
				}
			}
			else 
			{
				if ($sKey == 'title_delim' || $sKey == 'required_symbol')
				{
					$mValue = Phpfox::getLib('parse.input')->convert($mValue);
				}
				
				// Encode the ftp password with the server salt
				if ($sKey == 'ftp_password')
				{
					$mValue = base64_encode(base64_encode($mValue . md5(Phpfox::getParam('core.salt'))));
				}			
				
				if ($sKey == 'session_prefix')
				{
					$mValue = substr(preg_replace("/[^A-Za-z0-9]/", "", $mValue), 0, 15);					
				}
				
				// clear the cache from the featured users
				if ($sKey == 'how_many_featured_members')
				{
					$this->cache()->remove('featured_users');
				}
				$aValues['value_actual'] = $mValue;
				
				if ($sKey == 'admin_cp' && $mValue != 'admincp')
				{
					if (empty($mValue) || !Phpfox::getLib('parse.input')->allowTitle($mValue, Phpfox::getPhrase('admincp.admincp_name_not_allowed') . ': ' . strip_tags($mValue)))
					{
						return false;
					}					
				}
				
				if ($sKey == 'allow_video_uploading' && $mValue == '1')
				{
					$aVals['value']['ffmpeg_path'] = Phpfox::getParam('video.ffmpeg_path');
					$aVals['value']['mencoder_path'] = Phpfox::getParam('video.mencoder_path');
					
					if (!($mReturn = Phpfox::getService('video')->requirementCheck($aVals['value'])))
					{
						return false;
					}
				}
				
				if ($sKey == 'profile_use_id' && $mValue == '1')
				{
					$aUsers = $this->database()->select('user_id')	
						->from(Phpfox::getT('user'))
						->execute('getRows');
					foreach ($aUsers as $aUser)
					{
						$this->database()->update(Phpfox::getT('user'), array('user_name' => 'profile-' . $aUser['user_id']), 'user_id = ' . $aUser['user_id']);
					}
				}
				
				if ($sKey == 'cron_delete_messages_delay')
				{
					$this->database()->update(Phpfox::getT('cron'), array('every' => $mValue), "module_id = 'mail'");
				}
			}						
	
			$this->database()->update($this->_sTable, $aValues, "var_name = '" . $this->database()->escape($sKey) . "'");
		}		

		// Clear the setting cache
		$this->cache()->remove();
		
		// Phpfox::getLib('setting')->set();
		
		return true;
	}
	
	public function import($aVals, $bMissingOnly = false)
	{
		$oSetting = Phpfox::getLib('setting');

		if (!isset($aVals['product']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.unable_import_settings'));
		}
		
		if (!isset($aVals['setting']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.unable_import_settings'));
		}
		
		$iProductId = Phpfox::getService('admincp.product')->getId($aVals['product']);
		if (!$iProductId)
		{
			$iProductId = 1;
		}		
		
		/*
		$aRows = $this->database()->select('group_id, var_name')
			->from(Phpfox::getT('setting_group'))
			->execute('getRows', array(
					'free_result' => true
				));
		$aGroups = array();
		foreach ($aRows as $aRow)
		{
			$aGroups[$aRow['var_name']] = $aRow['group_id'];
		}		
		*/
		
		if ($bMissingOnly)
		{		
			$aCache = array();
			$aRows = $this->database()->select('var_name')
				->from($this->_sTable)
				->execute('getRows', array(
					'free_result' => true
				));
			foreach ($aRows as $aRow)
			{
				$aCache[$aRow['var_name']] = $aRow['var_name'];
			}			
			
			$aSql = array();
			foreach ($aVals['setting'] as $aSetting)
			{
				if (!in_array($aSetting['var_name'], $aCache))
				{		
					$iModuleId = Phpfox::getLib('module')->getModuleId($aSetting['module']);				
					$aSql[] = array(
						(empty($aSetting['group']) ? null : $aSetting['group']),
						$iModuleId,
						$iProductId,
						$aValue['is_hidden'],
						$aSetting['version_id'],
						$aSetting['type'],
						$aSetting['var_name'],
						$aSetting['phrase_var_name'],
						$aSetting['value'],
						$aSetting['value'],
						$aSetting['ordering']
					);
				}
			}		
			
			if ($aSql)
			{
				$this->database()->multiInsert($this->_sTable, array(
					'group_id',
					'module_id',
					'product_id',
					'is_hidden',
					'version_id',
					'type',
					'var_name',
					'phrase_var_name',
					'value_actual',
					'value_default',
					'ordering'
				), $aSql);
			}
		}
		else 
		{			
			$aSql = array();		
			foreach ($aVals['setting'] as $aValue)
			{
				$iModuleId = (int) Phpfox::getLib('module')->getModuleId($aValue['module']);
				$aSql[] = array(
					(empty($aSetting['group']) ? null : $aSetting['group']),
					$iModuleId,
					$iProductId,
					$aValue['is_hidden'],
					$aValue['version_id'],
					$aValue['type'],
					$aValue['var_name'],
					$aValue['phrase_var_name'],
					$aValue['value'],
					$aValue['value'],
					$aValue['ordering']
					
				);
			}	
			
			$this->database()->multiInsert($this->_sTable, array(
				'group_id',
				'module_id',
				'product_id',
				'is_hidden',
				'version_id',
				'type',
				'var_name',
				'phrase_var_name',
				'value_actual',
				'value_default',
				'ordering'
			), $aSql);				
		}
	
		return count($aSql);
	}
	
	public function removeSettingFromArray($sSetting, $sValue)
	{
		$aSetting = $this->database()->select('setting_id, value_actual')
			->from(Phpfox::getT('setting'))
			->where('var_name = \'' . $this->database()->escape($sSetting) . '\'')
			->execute('getRow');
			
		if (!isset($aSetting['setting_id']))
		{
			return Phpfox_Error::set('Unable to find the setting you are trying to edit.');
		}
		
		$aCache = array();
		if (!empty($aSetting['value_actual']))
		{
			$aSetting['value_actual'] = preg_replace("/s:(.*):\"(.*?)\";/ise", "'s:'.strlen('$2').':\"$2\";'", $aSetting['value_actual']);			
			
			$sValues = unserialize($aSetting['value_actual']);
			
			eval('$aValues = ' . $sValues . '');			
			
			foreach ($aValues as $mValue)
			{
				if (empty($mValue))
				{
					continue;
				}
				
				if ($mValue == $sValue)
				{
					continue;
				}
				
				$aCache[] = $mValue;
			}
		}

		$this->database()->update(Phpfox::getT('setting'), array('value_actual' => (count($aCache) ? '' . serialize(str_replace('array ', 'array', var_export($aCache, true)) . ';') : '')), 'setting_id = ' . $aSetting['setting_id']);
		
		// Clear the setting cache
		$this->cache()->remove();
		
		return true;
	}
	
	public function findMissingSettings($aXml)
	{
		$iCnt = 0;
		foreach ($aXml as $sModule => $aSettings)
		{
			$aRows = (isset($aSettings['setting'][1]) ? $aSettings['setting'] : array($aSettings['setting']));
			
			foreach ($aRows as $aSetting)
			{
				$iMissing = $this->database()->select('COUNT(*)')
					->from(Phpfox::getT('setting'))
					->where('module_id = \'' . $sModule . '\' AND var_name = \'' . $aSetting['var_name'] . '\'')
					->execute('getSlaveField');
				
				if (!$iMissing)
				{				
					$iCnt++;					
					$this->database()->insert(Phpfox::getT('setting'), array(
							'group_id' => (empty($aSetting['group']) ? null : $aSetting['group']),
							'module_id' => $sModule,
							'product_id' => 'phpfox',
							'is_hidden' => $aSetting['is_hidden'],
							'version_id' => $aSetting['version_id'],
							'type_id' => $aSetting['type'],
							'var_name' => $aSetting['var_name'],
							'phrase_var_name' => $aSetting['phrase_var_name'],
							'value_actual' => $aSetting['value'],
							'value_default' => $aSetting['value'],
							'ordering' => $aSetting['ordering']
						)
					);					
				}
			}
		}
		
		return $iCnt;
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
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_setting_process__call'))
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
