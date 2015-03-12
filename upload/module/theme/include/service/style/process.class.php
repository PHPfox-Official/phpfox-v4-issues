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
 * @package 		Phpfox_Service
 * @version 		$Id: process.class.php 5612 2013-04-05 07:46:26Z Miguel_Espinoza $
 */
class Theme_Service_Style_Process extends Phpfox_Service 
{
	private $_aStyleStructure = array(
		'css',
		'image',
		'jscript',
        'php'
	);
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('theme_style');	
	}
	
	public function revertLogo($iId)
	{
		$aStyle = $this->database()->select('ts.style_id, ts.folder, t.folder AS theme_folder, tsl.file_ext')
			->from($this->_sTable, 'ts')
			->join(Phpfox::getT('theme'), 't', 't.theme_id = ts.theme_id')
			->join(Phpfox::getT('theme_style_logo'), 'tsl', 'tsl.style_id = ts.style_id')
			->where('ts.style_id = ' . (int) $iId)
			->execute('getRow');		
			
		if (!isset($aStyle['style_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('theme.not_a_valid_style'));
		}			
		
		$this->database()->delete(Phpfox::getT('theme_style_logo'), 'style_id = ' . $aStyle['style_id']);
		$this->cache()->remove('theme_logo_' . $aStyle['theme_folder'] . '_' . $aStyle['folder']);	

		$sLogoFile = PHPFOX_DIR_FILE . 'static' . PHPFOX_DS . md5($aStyle['theme_folder'] . $aStyle['folder']) . '.' . $aStyle['file_ext'];
		if (file_exists($sLogoFile))
		{
			Phpfox::getLib('file')->unlink($sLogoFile);
		}		
		
		$sLogoFile = PHPFOX_DIR_FILE . 'static' . PHPFOX_DS . md5($aStyle['theme_folder'] . $aStyle['folder']) . '_thumb.' . $aStyle['file_ext'];
		if (file_exists($sLogoFile))
		{
			Phpfox::getLib('file')->unlink($sLogoFile);
		}				
		
		return true;
	}
	
	public function changeLogo($iId, $aImage, $bResize = false)
	{
		$aStyle = $this->database()->select('ts.style_id, ts.folder, t.folder AS theme_folder, ts.logo_image')
			->from($this->_sTable, 'ts')
			->join(Phpfox::getT('theme'), 't', 't.theme_id = ts.theme_id')
			->where('ts.style_id = ' . (int) $iId)
			->execute('getRow');
			
		if (!isset($aStyle['style_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('theme.not_a_valid_style'));
		}
		
		$aInfo = getimagesize($aImage['tmp_name']);
		
		switch ($aInfo['mime'])
		{
			case 'image/png':
				$sExt = 'png';
				break;
			case 'image/gif':
				$sExt = 'gif';
				break;
			case 'image/jpg':
			case 'image/jpeg':
				$sExt = 'jpg';
				break;	
			default:
				return Phpfox_Error::set(Phpfox::getPhrase('theme.not_a_valid_file_extension'));
				break;
		}			
		
		$this->database()->delete(Phpfox::getT('theme_style_logo'), 'style_id = ' . $aStyle['style_id']);
		$iLogoId = $this->database()->insert(Phpfox::getT('theme_style_logo'), array(
				'style_id' => $aStyle['style_id'],
				'logo' => base64_encode(file_get_contents($aImage['tmp_name'])),
				'file_ext' => $sExt
			)
		);
		
		$this->cache()->remove(array('theme', 'theme_logo_' . $aStyle['theme_folder'] . '_' . $aStyle['folder']));	

		$sLogoFile = PHPFOX_DIR_FILE . 'static' . PHPFOX_DS . md5($aStyle['theme_folder'] . $aStyle['folder']) . '.' . $sExt;
		if (file_exists($sLogoFile))
		{
			Phpfox::getLib('file')->unlink($sLogoFile);
		}
		
		if (@move_uploaded_file($aImage['tmp_name'], $sLogoFile))
		{		
			$sImage = PHPFOX_DIR . 'theme' . PHPFOX_DS . 'frontend' . PHPFOX_DS . '' . $aStyle['theme_folder'] . '' . PHPFOX_DS . 'style' . PHPFOX_DS . '' . $aStyle['folder'] . '' . PHPFOX_DS . 'image' . PHPFOX_DS . 'layout' . PHPFOX_DS . '' . $aStyle['logo_image'];
			if (file_exists($sImage))
			{
				list($iWidth, $iHeight) = getimagesize($sImage);
			}
			else 
			{
				$iWidth = 200;
				$iHeight = 150;
			}
						
			Phpfox::getLib('image')->createThumbnail($sLogoFile, PHPFOX_DIR_FILE . 'static' . PHPFOX_DS . md5($aStyle['theme_folder'] . $aStyle['folder']) . '_thumb.' . $sExt, $iWidth, $iHeight);
			
			if ($bResize === true)
			{
				Phpfox::getLib('image')->createThumbnail($sLogoFile, $sLogoFile, $iWidth, $iHeight);	
			}
		
			return true;
		}
		
		return Phpfox_Error::set(Phpfox::getPhrase('theme.unable_to_upload_image'));
	}
	
	public function setStyle($iId)
	{
		$this->database()->update(Phpfox::getT('user'), array(
				'style_id' => (int) $iId
			), 'user_id = ' . Phpfox::getUserId()
		);
		
		Phpfox::getLib('session')->remove('theme');
		
		return true;
	}
	
	public function update($aVals)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);			
		
		$aStyle = Phpfox::getService('theme.style')->getStyle($aVals['style_id']);
		
		if (!isset($aStyle['style_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('theme.unable_to_find_style'));
		}
		
		$aCss = $this->database()->select('css_id, is_custom, css_data_original')
			->from(Phpfox::getT('theme_css'))
			->where('module_id = \'' . $this->database()->escape($aVals['module_id']) . '\' AND style_id = ' . $aStyle['style_id'] . ' AND file_name = \'' . $this->database()->escape($aVals['file_name']) . '\'')
			->execute('getRow');
		
		$aForm = array(
			'product_id' => array(
				'type' => 'product_id'
			),
			'module_id' => array(
				'type' => 'module_id'
			),
			'style_id' => array(
				'type' => 'int:required'
			),
			'file_name' => array(
				'type' => 'string:required'
			),
			'css_data' => array(
				'type' => 'string:required'
			)
		);
		
		$aVals = $this->validator()->process($aForm, $aVals);
		
		$aVals['full_name'] = $this->preParse()->clean(Phpfox::getUserBy('full_name'), 255);
		
		if (isset($aCss['is_custom']) && $aCss['is_custom'])
		{
			$aVals['time_stamp_update'] = PHPFOX_TIME;
		}
		else 
		{
			$aVals['time_stamp'] = PHPFOX_TIME;
		}		
		
		if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
		{
			$sName = md5(PHPFOX_IS_HOSTED_SCRIPT . uniqid()) . '.css';
			$sTempFile = PHPFOX_DIR_CACHE . $sName;			
			
			$aVals['css_data_original'] = $sName;
			
			$hFile = fopen($sTempFile, 'w+');
			fwrite($hFile, $aVals['css_data']);
			fclose($hFile);
			
			if (!empty($aCss['css_data_original']))
			{
				Phpfox::getLib('cdn')->remove('file/static/' . $aCss['css_data_original']);
			}
			Phpfox::getLib('cdn')->put($sTempFile, 'file/static/' . $sName);
			
			unlink($sTempFile);			
		} 
		
		if (isset($aCss['css_id']) && $aCss['css_id'])
		{		
			$this->database()->update(Phpfox::getT('theme_css'), $aVals, 'css_id = ' . (int) $aCss['css_id']);
		}
		else 
		{
			$this->database()->insert(Phpfox::getT('theme_css'), $aVals);
		}
		
		$this->database()->update(Phpfox::getT('setting'), array('value_actual' => ((int) Phpfox::getParam('core.css_edit_id') + 1)), 'var_name = \'css_edit_id\'');
		
		$this->cache()->remove('setting');
		if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
		{
			$this->cache()->remove($aStyle['style_id'] . '_custom_css_file');
		}
		$this->cache()->removeStatic();		
		
		return true;
	}
	
	public function revert($aVals)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);			
		
		$sQuery = 'module_id = \'' . $this->database()->escape($aVals['module_id']) . '\' AND style_id = ' . $aVals['style_id'] . ' AND file_name = \'' . $this->database()->escape($aVals['file_name']) . '\'';
		
		$aCss = $this->database()->select('css_id, is_custom, css_data_original')
			->from(Phpfox::getT('theme_css'))
			->where($sQuery)
			->execute('getRow');
		
		if ((int) $aCss['is_custom'] > 0)
		{
			$this->database()->update(Phpfox::getT('theme_css'), array('css_data' => $aCss['css_data_original'], 'time_stamp_update' => '0', 'full_name' => null), 'css_id = ' . $aCss['css_id']);
		}
		else 
		{
			$this->database()->delete(Phpfox::getT('theme_css'), $sQuery);
		}		
		
		$this->cache()->remove();
		
		Phpfox::getLib('template.cache')->remove();
		Phpfox::getLib('cache')->removeStatic();		

		return true;
	}

	public function addStyle($aVals, $iEditId = null, &$aStyle = null)
	{
		$aForm = array(			
			'name' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('theme.style_requires_a_name')
			),
			'folder' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('theme.style_requires_a_folder_name')
			),
			'theme_id' => array(
				'type' => 'int:required',
				'message' => Phpfox::getPhrase('theme.select_a_parent_theme_for_this_style')
			),			
			'parent_id' => array(
				'type' => 'int'				
			),
			'creator' => array(
				'type' => 'string'
			),
			'website' => array(
				'type' => 'string'
			),
			'version' => array(
				'type' => 'string'
			),			
			'is_active' => array(
				'type' => 'int:required',
				'message' => Phpfox::getPhrase('theme.provide_if_the_style_is_active_or_not')
			),
			'is_default' => array(
				'type' => 'int'				
			),
			'logo_image' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('theme.provide_a_default_logo_name')
			),
			'l_width' => array(
				'type' => 'int'				
			),		
			'c_width' => array(
				'type' => 'int'				
			),
			'r_width' => array(
				'type' => 'int'				
			)			
		);				
		
		if ($aStyle !== null)
		{
			$aCache = $aVals;
		}
		
		if ($iEditId !== null)
		{
			unset(
				$aForm['folder'],
				$aForm['theme_id'],
				$aForm['parent_id']
			);
		}
		
		if (isset($aVals['theme_id']))
		{
			$aTheme = Phpfox::getService('theme')->getTheme($aVals['theme_id']);
		}
		
		$aVals = $this->validator()->process($aForm, $aVals);
		
		if (!empty($aVals['creator']))
		{
			$aVals['creator'] = $this->preParse()->clean($aVals['creator'], 255);
		}		
		
		if (!Phpfox_Error::isPassed())
		{
            return false;
		}
		
		if ($iEditId === null)
		{			
			$aVals['created'] = PHPFOX_TIME;			
			$aVals['folder'] = $this->preParse()->cleanFileName($aVals['folder']);
			
			if (empty($aVals['folder']))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('theme.folder_is_not_valid'));
			}
	
			if (is_dir(PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aTheme['folder'] . PHPFOX_DS . 'style' . PHPFOX_DS . $aVals['folder']))
			{
                return Phpfox_Error::set(Phpfox::getPhrase('theme.this_folder_is_already_in_use'));
			}		

            /*
			$iCheck = $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('theme_style'))
				->where('folder = \'' . $this->database()->escape($aVals['folder']) . '\'')
				->execute('getField');
				
			if ($iCheck)
			{
				return Phpfox_Error::set('There is already a style with the same folder name.');
			}
             */
			
			$iId = $this->database()->insert(Phpfox::getT('theme_style'), $aVals);					
			/*
			if (Phpfox::getParam('core.ftp_enabled'))
			{
				$sDir = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aTheme['folder'] . PHPFOX_DS . 'style' . PHPFOX_DS . $this->database()->escape($aVals['folder']) . PHPFOX_DS;	
					
				Phpfox::getLib('ftp')->mkdir($sDir);
				foreach ($this->_aStyleStructure as $sFileDirectory)
				{
				 	Phpfox::getLib('ftp')->mkdir($sDir . $sFileDirectory . PHPFOX_DS);
				}
			}
			*/
		}
		else 
		{
			if (isset($aVals['is_default']) && $aVals['is_default'])
			{
				$this->database()->update($this->_sTable, array('is_default' => '0'), 'style_id > 0');
				
				Phpfox::getLib('session')->remove(Phpfox::getParam('core.theme_session_prefix') . 'theme');
			}			
			
			$this->database()->update(Phpfox::getT('theme_style'), $aVals, 'style_id = ' . (int) $iEditId);	
			if (Phpfox::getParam('core.super_cache_system'))
			{
				// The function get() in the user service queries the table theme_style
				$this->cache()->remove('profile', 'substr');
			}	
			$iId = $iEditId;	
		}
		
			if ($aStyle !== null)
			{			
				if (isset($aCache))
				{
					$aVals = $aCache;
				}
				
				$sDir = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aTheme['folder'] . PHPFOX_DS . 'style' . PHPFOX_DS . $aVals['folder'] . PHPFOX_DS;				
				
				if (!is_dir($sDir))
				{
					Phpfox::getLib('ftp')->mkdir($sDir);
				}
				foreach ($this->_aStyleStructure as $sFileDirectory)
				{
				 	if (!is_dir($sDir . $sFileDirectory . PHPFOX_DS))
				 	{
						Phpfox::getLib('ftp')->mkdir($sDir . $sFileDirectory . PHPFOX_DS);
				 	}
				}
				
				if (isset($aStyle['css']['data']['name']))
				{
					$aStyle['css']['data'] = array($aStyle['css']['data']);
				}								
				
				if (isset($aStyle['css']['data']) && is_array($aStyle['css']['data']))
				{
					foreach ($aStyle['css']['data'] as $aCss)
					{				
						if (!empty($aCss['module']))
						{
							$sModuleDirectory = PHPFOX_DIR_MODULE . $aCss['module'] . PHPFOX_DS . 'static' . PHPFOX_DS . 'css' . PHPFOX_DS . $aTheme['folder'] . PHPFOX_DS . $aVals['folder'] . PHPFOX_DS;	
							if (!is_dir($sModuleDirectory))
							{
								Phpfox::getLib('ftp')->mkdir($sModuleDirectory, true);
							}
							$sTempFile = 'theme_style_cache_css_' . md5($aCss['module'] . $aCss['name'] . $iId);
							Phpfox::getLib('file')->writeToCache($sTempFile, $aCss['value']);		
							if (file_exists($sModuleDirectory . $aCss['name']))
							{
								Phpfox::getLib('ftp')->unlink($sModuleDirectory . $aCss['name']);
							}
							Phpfox::getLib('ftp')->move(PHPFOX_DIR_CACHE . $sTempFile, $sModuleDirectory . $aCss['name']);
							if (file_exists($sTempFile))
							{
								unlink($sTempFile);
							}						
						}
						else 
						{
							$sTempFile = 'theme_style_cache_css_' . md5($aCss['name'] . $iId);
							Phpfox::getLib('file')->writeToCache($sTempFile, $aCss['value']);		
							if (file_exists($sDir . 'css' . PHPFOX_DS . $aCss['name']))
							{
								Phpfox::getLib('ftp')->unlink($sDir . 'css' . PHPFOX_DS . $aCss['name']);
							}
							Phpfox::getLib('ftp')->move(PHPFOX_DIR_CACHE . $sTempFile, $sDir . 'css' . PHPFOX_DS . $aCss['name']);
							if (file_exists($sTempFile))
							{
								unlink($sTempFile);
							}
						}
					}			
				}
				
				if (isset($aStyle['images']['image']['name']))
				{
					$aStyle['images']['image'] = array($aStyle['images']['image']);
				}
					
				if (isset($aStyle['images']['image']) && is_array($aStyle['images']['image']))
				{					
					foreach ($aStyle['images']['image'] as $aImage)
					{
						if (!empty($aImage['path']))
						{
							if (!is_dir($sDir . 'image' . PHPFOX_DS . $aImage['path'] . PHPFOX_DS))
							{
								Phpfox::getLib('ftp')->mkdir($sDir . 'image' . PHPFOX_DS . $aImage['path'] . PHPFOX_DS);	
							}
						}					
	
						$sTempFile = 'theme_style_cache_image_' . md5($aImage['name'] . $iId);
						Phpfox::getLib('file')->writeToCache($sTempFile, base64_decode($aImage['value']));
						if (file_exists($sDir . 'image' . PHPFOX_DS . (empty($aImage['path']) ? '' : $aImage['path'] . PHPFOX_DS) . $aImage['name']))
						{
							Phpfox::getLib('ftp')->unlink($sDir . 'image' . PHPFOX_DS . (empty($aImage['path']) ? '' : $aImage['path'] . PHPFOX_DS) . $aImage['name']);
						}					
						Phpfox::getLib('ftp')->move(PHPFOX_DIR_CACHE . $sTempFile, $sDir . 'image' . PHPFOX_DS . (empty($aImage['path']) ? '' : $aImage['path'] . PHPFOX_DS) . $aImage['name']);
						if (file_exists($sTempFile))
						{
							unlink($sTempFile);
						}					
					}
				}
				
				if (isset($aStyle['scripts']['script']['name']))
				{
					$aStyle['scripts']['script'] = array($aStyle['scripts']['script']);
				}				
				
				if (isset($aStyle['scripts']['script']) && is_array($aStyle['scripts']['script']))
				{
					foreach ($aStyle['scripts']['script'] as $aScript)
					{				
						$sTempFile = 'theme_style_cache_script_' . md5($aScript['name'] . $iId);
						Phpfox::getLib('file')->writeToCache($sTempFile, $aScript['value']);		
						if (file_exists($sDir . 'jscript' . PHPFOX_DS . $aScript['name']))
						{
							Phpfox::getLib('ftp')->unlink($sDir . 'jscript' . PHPFOX_DS . $aScript['name']);
						}					
						Phpfox::getLib('ftp')->move(PHPFOX_DIR_CACHE . $sTempFile, $sDir . 'jscript' . PHPFOX_DS . $aScript['name']);
						if (file_exists($sTempFile))
						{
							unlink($sTempFile);
						}
					}			
				}
				
				if (isset($aStyle['display_logo']))
				{
					$sTempFile = 'theme_style_cache_logo_' . $iId;
					Phpfox::getLib('file')->writeToCache($sTempFile, base64_decode($aStyle['display_logo']));		
					if (file_exists($sDir . 'phpfox.gif'))
					{
						Phpfox::getLib('ftp')->unlink($sDir . 'phpfox.gif');
					}					
					Phpfox::getLib('ftp')->move(PHPFOX_DIR_CACHE . $sTempFile, $sDir . 'phpfox.gif');
					if (file_exists($sTempFile))
					{
						unlink($sTempFile);
					}					
				}

                if (isset($aStyle['php_header']['code']))
				{
					$sTempFile = 'theme_style_cache_php_header_' . $iId;
					Phpfox::getLib('file')->writeToCache($sTempFile, $aStyle['php_header']['code']);
					if (file_exists($sDir . 'php'. PHPFOX_DS . 'header.php'))
					{
						Phpfox::getLib('ftp')->unlink($sDir . 'php'. PHPFOX_DS . 'header.php');
					}
					Phpfox::getLib('ftp')->move(PHPFOX_DIR_CACHE . $sTempFile, $sDir . 'php'. PHPFOX_DS . 'header.php');
					if (file_exists($sTempFile))
					{
						unlink($sTempFile);
					}
                }
			}		
		
		return true;
	}
	
	public function updateStyle($iId, $aVals)
	{
		return $this->addStyle($aVals, $iId);
	}
	
	public function addCss($aVals)
	{
		$aForm = array(
			'module_id' => array(
				'type' => 'module_id'
			),
			'product_id' => array(
				'type' => 'product_id'
			),
			'style_id' => array(
				'type' => 'int:required',
				'message' => Phpfox::getPhrase('theme.select_a_style')
			),
			'file_name' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('theme.provide_a_file_name')
			),
			'css_data' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('theme.provide_css_code')
			)
		);
		
		$aVals = $this->validator()->process($aForm, $aVals);
		
		if (!Phpfox_Error::isPassed())
		{
			return false;
		}
		
		$aVals['file_name'] = $this->preParse()->cleanFileName($aVals['file_name']);
		
		if (empty($aVals['file_name']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('theme.file_name_is_not_valid'));
		}		
		
		$aVals['file_name'] = $aVals['file_name'] . '.css';
		
		$aStyle = $this->database()->select('ts.folder AS style_folder, t.folder AS theme_folder')
			->from(Phpfox::getT('theme_style'), 'ts')
			->join(Phpfox::getT('theme'), 't', 't.theme_id = ts.theme_id')
			->where('ts.style_id = ' . (int) $aVals['style_id'])
			->execute('getRow');

		if (file_exists(PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aStyle['theme_folder'] . PHPFOX_DS . 'style' . PHPFOX_DS . $aStyle['style_folder'] . PHPFOX_DS . 'css' . PHPFOX_DS . $aVals['file_name']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('theme.the_file_name_is_already_in_use'));
		}
		
		$iCheck = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('theme_css'))
			->where('style_id = ' . (int) $aVals['style_id'] . ' AND file_name = \'' . $this->database()->escape($aVals['file_name']) . '\'')
			->execute('getField');
			
		if ($iCheck)
		{
			return Phpfox_Error::set(Phpfox::getPhrase('theme.the_file_name_is_already_in_use'));
		}
		
		$aVals['full_name'] = (empty($aVals['full_name']) ? null : $this->preParse()->clean($aVals['full_name'], 255));
		$aVals['time_stamp'] = PHPFOX_TIME;
		$aVals['css_data_original'] = $aVals['css_data'];
		$aVals['is_custom'] = '1';
		$aVals['module_id'] = (empty($aVals['module_id']) ? null : $aVals['module_id']);
		
		$this->database()->insert(Phpfox::getT('theme_css'), $aVals);
		
		return true;
	}

	public function updateActivity($iId, $iType)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);		
	
		$this->database()->update($this->_sTable, array('is_active' => (int) ($iType == '1' ? 1 : 0)), 'style_id = ' . (int) $iId);
		
		$this->cache()->remove();
	}	
	
	public function delete($iId)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);		
		
		$aStyle = Phpfox::getService('theme.style')->getStyle($iId);
		
		if (!isset($aStyle['style_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('theme.not_a_valid_style'));
		}
		
		$this->database()->delete(Phpfox::getT('theme_css'), 'style_id = ' . (int) $iId);
		$this->database()->delete(Phpfox::getT('theme_style_logo'), 'style_id = ' . (int) $iId);
		$this->database()->delete(Phpfox::getT('theme_style'), 'style_id = ' . (int) $iId);
		
		$this->database()->update(Phpfox::getT('user'), array('style_id' => '0'), 'style_id = ' . (int) $iId);
		$this->database()->update(Phpfox::getT('user_field'), array('designer_style_id' => '0'), 'designer_style_id = ' . (int) $iId);	
		
		if (Phpfox::getParam('core.super_cache_system'))
		{
			$this->cache()->remove('profile', 'substr');
		}
		
		if (Phpfox::getParam('core.ftp_enabled'))
		{
			if (is_dir(PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aStyle['theme_folder'] . PHPFOX_DS . 'style' . PHPFOX_DS . $aStyle['folder'] . PHPFOX_DS))
			{
				Phpfox::getLib('ftp')->rmdir(PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aStyle['theme_folder'] . PHPFOX_DS . 'style' . PHPFOX_DS . $aStyle['folder'] . PHPFOX_DS);
			}
			
			$hDir = opendir(PHPFOX_DIR_MODULE);
			while ($sModule = readdir($hDir))
			{
				if ($sModule == '.' || $sModule == '..')
				{
					continue;
				}
				
				$sDir = PHPFOX_DIR_MODULE . $sModule . PHPFOX_DS . 'static' . PHPFOX_DS . 'css' . PHPFOX_DS . $aStyle['theme_folder'] . PHPFOX_DS . $aStyle['folder'] . PHPFOX_DS;				
				if (is_dir($sDir))
				{
					Phpfox::getLib('ftp')->rmdir($sDir);					
				}
			}
			closedir($hDir);					
		}				
		
		$this->cache()->remove();
		
		return true;
	}
	
	public function deleteCss($sFileName, $iStyleId, $sModuleId)
	{		
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);			
		
		$this->database()->delete(Phpfox::getT('theme_css'), (empty($sModuleId) ? '' : 'module_id = \'' . $this->database()->escape($sModuleId) . '\' AND') . ' style_id = ' . (int) $iStyleId . ' AND file_name = \'' . $this->database()->escape($sFileName)  . '\'');
		
		$this->cache()->remove();	
		
		return true;
	}
	
	public function installStyleFromFolder($sTheme, $sStyle, $mForce = false)
	{
		if ($mForce && Phpfox::getParam('core.phpfox_is_hosted'))
		{
			$sDir = PHPFOX_DIR_CACHE . $mForce . PHPFOX_DS . 'upload' . PHPFOX_DS . 'theme' . PHPFOX_DS . 'frontend' . PHPFOX_DS . $sTheme . PHPFOX_DS . 'style' . PHPFOX_DS . $sStyle . PHPFOX_DS;
		}
		else
		{
			$sDir = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $sTheme . PHPFOX_DS . 'style' . PHPFOX_DS . $sStyle . PHPFOX_DS;
		}

		if (!file_exists($sDir . 'phpfox.xml'))
		{
			return Phpfox_Error::set('Not a valid theme to install.');
		}
		
		$aParams = Phpfox::getLib('xml.parser')->parse(file_get_contents($sDir . 'phpfox.xml'));
		
		$aForm = array(			
			'name' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('theme.style_requires_a_name')
			),
			'folder' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('theme.style_requires_a_folder_name')
			),
			'theme_id' => array(
				'type' => 'int:required',
				'message' => Phpfox::getPhrase('theme.select_a_parent_theme_for_this_style')
			),			
			'parent_id' => array(
				'type' => 'int'				
			),
			'created' => array(
				'type' => 'int'
			),				
			'creator' => array(
				'type' => 'string'
			),
			'website' => array(
				'type' => 'string'
			),
			'version' => array(
				'type' => 'string'
			),			
			'logo_image' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('theme.provide_a_default_logo_name')
			)
		);		
		
		$aTheme = Phpfox::getService('theme')->getTheme($sTheme, true);			
		$aParams['theme_id'] = (isset($aTheme['theme_id']) ? $aTheme['theme_id'] : 0);
		$aParams['parent_id'] = 0;
		if (!empty($aParams['parent_style']))
		{
			$aStyleParentParts = explode('::', $aParams['parent_style']);
			
			$aTheme = Phpfox::getService('theme')->getTheme($aStyleParentParts[0], true);
			if (isset($aTheme['theme_id']))
			{
				$aStyleParent = Phpfox::getService('theme.style')->getStyleParent($aTheme['theme_id'], $aStyleParentParts[1]);
				if (isset($aStyleParent['style_id']))
				{
					$aParams['parent_id'] = $aStyleParent['style_id'];
				}
			}
		}		
		
		$aParams = $this->validator()->process($aForm, $aParams);
		
		if (!Phpfox_Error::isPassed())
		{
			return false;
		}		
		
		$aParams['is_active'] = 1;
		$aParams['is_default'] = 0;		
		
		$iId = $this->database()->insert(Phpfox::getT('theme_style'), $aParams);
		
		return $iId;
	}
	
	public function setToDefault($iStyleId, $iDefault)
	{
		$aStyle = $this->database()->select('style_id, folder')
			->from(Phpfox::getT('theme_style'))
			->where('style_id = ' . (int) $iStyleId)
			->execute('getRow');
			
		if (!isset($aStyle['folder']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('theme.not_a_valid_style_to_set_to_default'));
		}
		
		$iDefault = (int) $iDefault;
		
		$this->database()->update($this->_sTable, array('is_default' => '0'), 'style_id > 0');
		
		if ($iDefault === 0)
		{
			$aTheme = $this->database()->select('theme_id')
				->from(Phpfox::getT('theme'))
				->where('folder = \'default\'')
				->execute('getRow');
				
			$this->database()->update($this->_sTable, array('is_default' => '1'), 'theme_id = ' . $aTheme['theme_id'] . ' AND folder = \'default\'');	
		}
		else 
		{
			$this->database()->update($this->_sTable, array('is_default' => '1'), 'style_id = ' . $iStyleId);	
		}
		
		Phpfox::getLib('session')->remove(Phpfox::getParam('core.theme_session_prefix') . 'theme');	
		
		$this->database()->update(Phpfox::getT('setting'), array('value_actual' => uniqid()), 'var_name = \'theme_session_prefix\'');
		
		$this->cache()->remove();
		
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
		if ($sPlugin = Phpfox_Plugin::get('theme.service_style_process__call'))
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