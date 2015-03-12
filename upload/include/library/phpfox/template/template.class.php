<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Template
 * Loads all templates and converts it into PHP code and then caches it.
 * 
 * Class is also able to:
 * - Assign variables to templates.
 * - Identify a pages title.
 * - Identify a pages breadcrumb structure.
 * - Create meta tags.
 * - Load CSS and JavaScript files.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: template.class.php 7317 2014-05-09 17:38:54Z Fern $
 */
class Phpfox_Template
{	
	/**
	 * Default template name.
	 *
	 * @var string
	 */
	public $sDisplayLayout = 'template';
	
	/**
	 * Check to see if we are displaying a sample page.
	 *
	 * @var bool
	 */
	public $bIsSample = false;
	
	/**
	 * Theme ID#
	 *
	 * @var int
	 */
	public $iThemeId = 0;	
	
	/**
	 * Reserved variable name. Which is $phpfox.
	 *
	 * @var string
	 */
	protected $sReservedVarname = 'phpfox';
	
	/**
	 * Left delimiter for custom functions. It is: {
	 *
	 * @var string
	 */
	protected $sLeftDelim = '{';
	
	/**
	 * Right delimiter for custom functions. It is: }
	 *
	 * @var string
	 */
	protected $sRightDelim = '}';	
	
	/**
	 * List of plugins.
	 *
	 * @var array
	 */
	protected $_aPlugins = array();
	
	/**
	 * List of sections.
	 *
	 * @var array
	 */
	private $_aSections = array();
	
	/**
	 * List of all the variables assigned to templates.
	 *
	 * @var array
	 */
	private $_aVars = array('bUseFullSite' => false);
	
	/**
	 * List of titles assigned to a page.
	 *
	 * @var array
	 */
	private $_aTitles = array();
	
	/**
	 * List of data to add within the templates HTML <head></head>.
	 *
	 * @var array
	 */
	private $_aHeaders = array();
	
	/**
	 * List of breadcrumbs.
	 *
	 * @var array
	 */
	private $_aBreadCrumbs = array();
	
	/**
	 * Information about the title of the current page, which is part of the breadcrumb.
	 *
	 * @var array
	 */
	private $_aBreadCrumbTitle = array();
	
	/**
	 * Default file cache time.
	 *
	 * @var int
	 */
	private $_iCacheTime = 60;
	
	/**
	 * Override the layout of the current theme being used.
	 *
	 * @var bool
	 */
	private $_sSetLayout = false;
	
	/**
	 * Check to see if a template is part of the AdminCP.
	 *
	 * @var bool
	 */
	private $_bIsAdminCp = false;	
	
	/**
	 * Folder of the theme being used.
	 *
	 * @var string
	 */
	private $_sThemeFolder;
	
	/**
	 * Theme layout to load.
	 *
	 * @var string
	 */
	private $_sThemeLayout;
	
	/**
	 * Folder of the style being used.
	 *
	 * @var string
	 */
	private $_sStyleFolder;	
	
	/**
	 * List of meta data.
	 *
	 * @var array
	 */
	private $_aMeta = array();
	
	/**
	 * List of phrases to load and create JavaScript variables for.
	 *
	 * @var array
	 */
	private $_aPhrases = array();
	
	/**
	 * Information about the text editor.
	 *
	 * @var array
	 */
	private $_aEditor = array();
	
	/**
	 * URL of the current page we are on.
	 *
	 * @var string
	 */
	private $_sUrl = null;
	
	/**
	 * Information about the current theme we are using.
	 *
	 * @var array
	 */
	private $_aTheme = array(
		'theme_parent_id' => 0
	);
	
	/**
	 * Rebuild URL brought from cache.
	 *
	 * @var array
	 */
	private $_aNewUrl = array();
	
	/**
	 * Remove URL brought from cache.
	 *
	 * @var array
	 */
	private $_aRemoveUrl = array();
	
	/**
	 * List of images to be loaded and converted into a JavaScript object.
	 *
	 * @var array
	 */
	private $_aImages = array();
	
	/**
	 * Cache of all the <head></head> content being loaded.
	 *
	 * @var array
	 */
	private $_aCacheHeaders = array();
	
	/**
	 * Check to see if we are currently in test mode.
	 *
	 * @var bool
	 */
	private $_bIsTestMode = false;
	
	/**
	 * Mobile headers.
	 *
	 * @var array
	 */
	private $_aMobileHeaders = array();
	
	/**
	 * Holds section menu information
	 *
	 * @var array
	 */
	private $_aSectionMenu = array();
	
    
    private $_sFooter = '';
    
	/**
	 * Static variable of the current theme folder.
	 *
	 * @static 
	 * @var string
	 */
	protected static $_sStaticThemeFolder = null;
	
	/**
	 * Class constructor we use to build the current theme and style
	 * we are using.
	 *
	 */	
	public function __construct()
	{        
		if (defined('PHPFOX_INSTALLER'))
		{
			$this->_sThemeLayout = 'install';
			$this->_sThemeFolder = 'default';	
			$this->_sStyleFolder = 'default';
		}
		else 
		{
			$this->_bIsAdminCp = (strtolower(Phpfox::getLib('request')->get('req1')) == Phpfox::getParam('admincp.admin_cp'));			
			
			if ($this->_bIsAdminCp)
			{
				$this->_sThemeLayout = 'adminpanel';
				$this->_sThemeFolder = Phpfox::getParam('core.default_theme_name');
				$this->_sStyleFolder = Phpfox::getParam('core.default_style_name');
			}
			else 
			{
				$this->_sThemeLayout = (Phpfox::isMobile() ? 'mobile' : 'frontend');
				
				$aCachedThemes = array();
				$oCache = Phpfox::getLib('cache');
				$sCacheId = $oCache->set(array('theme', 'theme_all'));
				
				if (!($aCachedThemes = $oCache->get($sCacheId)))
				{				
					$aThemes = Phpfox::getLib('database')->select('ts.style_id')
						->from(Phpfox::getT('theme_style'), 'ts')
						->join(Phpfox::getT('theme'), 't', 't.theme_id = ts.theme_id AND t.is_active = 1')
						->where('ts.is_active = 1')
						->execute('getRows');
						
					$aCachedThemes = array();
					foreach ($aThemes as $aRow)
					{
						$aCachedThemes[$aRow['style_id']] = true;
					}
					
					$oCache->save($sCacheId, $aCachedThemes);				
				}
				
				$oSession = Phpfox::getLib('session');
				$bThemeCached = false;
				/*
				if ($sThemeCache = $oSession->get(Phpfox::getParam('core.theme_session_prefix') . 'theme'))				
				{
					$aTheme = unserialize($sThemeCache);
										
					if ((!isset($aTheme['style_id'])) || (isset($aTheme['style_id']) && !isset($aCachedThemes[$aTheme['style_id']])))
					{
						$bThemeCached = false;	
						$oSession->remove(Phpfox::getParam('core.theme_session_prefix') . 'theme');								
						unset($aTheme);			
					}
					else 
					{
						$bThemeCached = true;					
					}
				}				
				*/				
				
				if (Phpfox::getParam('core.super_cache_system') && ($aUserStaticData = Phpfox::getService('user')->getData('theme')) !== false)
				{
					$aTheme = $aUserStaticData;
					$bThemeCached = true;		
				}
				
				if ($bThemeCached === false)
				{					
					if ((Phpfox::isUser() && Phpfox::getUserBy('style_id') > 0) || (!Phpfox::isUser() && $oSession->get('style_id')))
					{
						$aTheme = Phpfox::getLib('database')->select('s.style_id, s.parent_id AS style_parent_id, s.folder AS style_folder_name, t.folder AS theme_folder_name, t.parent_id AS theme_parent_id, t.total_column, s.l_width, s.c_width, s.r_width')
							->from(Phpfox::getT('theme_style'), 's')
							->join(Phpfox::getT('theme'), 't', 't.theme_id = s.theme_id AND t.is_active')
							->where((Phpfox::isUser() ? 's.style_id = ' . (int) Phpfox::getUserBy('style_id') : 's.style_id = ' . (int) $oSession->get('style_id')) . ' AND s.is_active = 1')
							->execute('getRow');							
					}
					
					if (empty($aTheme['style_id']))
					{
						$aTheme = Phpfox::getLib('database')->select('s.style_id, s.parent_id AS style_parent_id, s.folder AS style_folder_name, t.folder AS theme_folder_name, t.parent_id AS theme_parent_id, t.total_column, s.l_width, s.c_width, s.r_width')
							->from(Phpfox::getT('theme_style'), 's')
							->join(Phpfox::getT('theme'), 't', 't.theme_id = s.theme_id')
							->where('s.is_default = 1')
							->execute('getRow');							
					}
					
					if (isset($aTheme['style_parent_id']) && $aTheme['style_parent_id'] > 0)
					{
						$aStyleExtend = Phpfox::getLib('database')->select('folder AS parent_style_folder')
							->from(Phpfox::getT('theme_style'))
							->where('style_id = ' . $aTheme['style_parent_id'])
							->execute('getRow');
							
						if (isset($aStyleExtend['parent_style_folder']))
						{
							$aTheme['parent_style_folder'] = $aStyleExtend['parent_style_folder'];
						}
					}					
					
					if (empty($aTheme))
					{
						$aTheme = Phpfox::getLib('database')->select('s.style_id, s.parent_id AS style_parent_id, s.folder AS style_folder_name, t.folder AS theme_folder_name, t.parent_id AS theme_parent_id, t.total_column, s.l_width, s.c_width, s.r_width')
							->from(Phpfox::getT('theme_style'), 's')
							->join(Phpfox::getT('theme'), 't', 't.folder = \'default\'')
							->where('s.folder = \'default\'')
							->execute('getRow');														
					}					
					
					if (Phpfox::getParam('core.super_cache_system'))
					{
						Phpfox::getService('user.process')->saveData(array('theme' => $aTheme));
					}
				}
				
				$this->_sThemeFolder = (isset($aTheme['theme_folder_name']) ? $aTheme['theme_folder_name'] : 'default');
				$this->_sStyleFolder = (isset($aTheme['style_folder_name']) ? $aTheme['style_folder_name'] : 'default');									
				$this->_aTheme = $aTheme;					
			}

			// Hack to force admincp layout during an AJAX call, I don't like it but it will do for the time being.
			if (($sMainUrl = Phpfox::getLib('request')->get('main_url')) && preg_match("/\/" . Phpfox::getParam('admincp.admin_cp') . "\//i", $sMainUrl))
			{
				$this->_sThemeLayout = 'adminpanel';
				$this->_sStyleFolder = Phpfox::getParam('core.default_style_name');
			}			
		}		

		self::$_sStaticThemeFolder = $this->_sThemeFolder;
	}
	
	/**
	 * Sets all the images we plan on using within JavaScript.
	 *
	 * PHP usage:
	 * <code>
	 * Phpfox::getLib('template')->setImage(array('layout_sample_image', 'layout/sample.png'));
	 * </code>
	 * 
	 * In JavaScript the above image can be accessed by:
	 * <code>
	 * oJsImages['layout_sample_image'];
	 * </code>
	 * 
	 * @param unknown_type $aImages
	 * @return unknown
	 */
	public function setImage($aImages)
	{	
		foreach ($aImages as $sKey => $sImage)
		{
			$this->_aImages[$sKey] = $this->getStyle('image', $sImage);
		}
		
		return $this;
	}	
	
	/**
	 * Get the current theme we are using.
	 *
	 * @return string
	 */
	public function getThemeLayout()
	{
		return $this->_sThemeLayout;
	}
	
	/**
	 * Get the cached information about the theme we are using.
	 *
	 * @return array
	 */
	public function getThemeCache()
	{
		return $this->_aTheme;
	}
	
	/**
	 * Override the current theme.
	 *
	 * @param array $aTheme ARRAY of values to override.
	 */
	public function setStyle($aTheme)
	{
		$this->_sThemeFolder = $aTheme['theme_folder_name'];
		$this->_sStyleFolder = $aTheme['style_folder_name'];		
		$this->_aTheme = $aTheme;

		self::$_sStaticThemeFolder = $this->_sThemeFolder;
	}
	
	/**
	 * Get all the information regarding the theme/style we are using.
	 *
	 * @return array
	 */
	public function getStyleInUse()
	{
		return $this->_aTheme;
	}	
	
	/**
	 * Get the total number of columns this template supports.
	 *
	 * @return int
	 */
	public function columns()
	{
		return (int) (isset($this->_aTheme['total_column']) ? $this->_aTheme['total_column'] : 3);	
	}
	
	/**
	 * Test a style by attempting to load and display it for the user.
	 * This is used when a user is trying to demo a style.
	 *
	 * @param int $iId ID of the style.
	 * @return bool TRUE if style can be loaded, FALSE if not.
	 */
	public function testStyle($iId = null)
	{
		$sWhere = '';
		if ($iId === null)
		{
			$sWhere = 't.is_default = 1 AND s.is_default = 1';
		}
		else
		{
			$sWhere = 's.style_id = ' . (int) $iId;
		}
		$aTheme = Phpfox::getLib('database')->select('s.style_id, s.parent_id AS style_parent_id, s.folder AS style_folder_name, t.folder AS theme_folder_name, t.parent_id AS theme_parent_id')		
			->from(Phpfox::getT('theme_style'), 's')
			->join(Phpfox::getT('theme'), 't', 't.theme_id = s.theme_id')
			->where($sWhere)
			->execute('getRow');	
			
		if (!isset($aTheme['style_id']))
		{
			return false;
		}
			
		$this->_sThemeFolder = $aTheme['theme_folder_name'];
		$this->_sStyleFolder = $aTheme['style_folder_name'];
		
		if ($aTheme['style_parent_id'] > 0)
		{
			$aStyleExtend = Phpfox::getLib('database')->select('folder AS parent_style_folder')
				->from(Phpfox::getT('theme_style'))
				->where('style_id = ' . $aTheme['style_parent_id'])
				->execute('getRow');
							
			if (isset($aStyleExtend['parent_style_folder']))
			{
				$aTheme['parent_style_folder'] = $aStyleExtend['parent_style_folder'];
			}
		}
					
		if ($aTheme['theme_parent_id'] > 0)
		{
			$aThemeExtend = Phpfox::getLib('database')->select('folder AS parent_theme_folder')
				->from(Phpfox::getT('theme'))
				->where('theme_id = ' . $aTheme['theme_parent_id'])
				->execute('getRow');
							
			if (isset($aThemeExtend['parent_theme_folder']))
			{
				$aTheme['parent_theme_folder'] = $aThemeExtend['parent_theme_folder'];
			}
		}			
		
		$this->_aTheme = $aTheme;
		$this->_bIsTestMode = true;
		
		self::$_sStaticThemeFolder = $this->_sThemeFolder;
		
		return true;
	}
	
	/**
	 * Get the theme folder being used.
	 *
	 * @return string
	 */
	public function getThemeFolder()
	{		
		return $this->_sThemeFolder;
	}
	
	/**
	 * Get the parent theme folder being used.
	 * Issue:  http://www.phpfox.com/tracker/view/15384/
	 * 
	 * @return string
	 */
	public function getParentThemeFolder()
	{
		if(isset($this->_aTheme['parent_theme_folder']))
		{
			return $this->_aTheme['parent_theme_folder'];
		}
		else
		{
			return $this->_sThemeFolder;
		}
	}
	
	/**
	 * Get the style folder being used.
	 *
	 * @return string
	 */
	public function getStyleFolder()
	{		
		return $this->_sStyleFolder;
	}	
	
	/**
	 * Get the logo for the site based on the style being used.
	 *
	 * @return string
	 */
	public function getStyleLogo()
	{
		$oCache = Phpfox::getLib('cache');
		$sCacheId = $oCache->set(array('theme', 'theme_logo_' . $this->_sThemeFolder . '_' . $this->_sStyleFolder));
		if (!($aTheme = $oCache->get($sCacheId)))
		{		
			$aTheme = Phpfox::getLib('database')->select('logo_id, logo, file_ext')
				->from(Phpfox::getT('theme_style_logo'))
				->where('style_id = ' . $this->_aTheme['style_id'])
				->execute('getRow');
			
			if (!empty($aTheme))
			{
				$oCacheLogo = Phpfox::getLib('cache', array(
						'storage' => 'file',
						'free' => true
					)
				);
				
				$sLogoCacheId = $oCacheLogo->set(PHPFOX_DIR_FILE . 'static' . PHPFOX_DS . md5($this->_sThemeFolder . $this->_sStyleFolder) . '.' . $aTheme['file_ext']);
				if (!$oCacheLogo->isCached($sLogoCacheId))
				{
					$oCacheLogo->save($sLogoCacheId, base64_decode($aTheme['logo']));
				}
			}
		
			$oCache->save($sCacheId, (isset($aTheme['file_ext']) ? array('file_ext' => $aTheme['file_ext'], 'logo_id' => $aTheme['logo_id']) : array()));
		}

		return (isset($aTheme['file_ext']) && file_exists(PHPFOX_DIR_FILE . 'static' . PHPFOX_DS . md5($this->_sThemeFolder . $this->_sStyleFolder) . '.' . $aTheme['file_ext']) ? Phpfox::getParam('core.url_file') . 'static/' . md5($this->_sThemeFolder . $this->_sStyleFolder) . '.' . $aTheme['file_ext'] . '?id=' . $aTheme['logo_id'] : '');
	}
	
	/**
	 * Override the layout of the site.
	 *
	 * @param string $sName Layout we should load.
	 */
	public function setLayout($sName)
	{
		$this->_sSetLayout = $sName;
	}
	
	/**
	 * Force the page to use its full width and not display anything within the sidepanel.
	 *
	 * @return object Returns self.
	 */
	public function setFullSite()
	{
		$this->assign(array('bUseFullSite' => true));
		
		return $this;
	}	
	
	/**
	 * Sets phrases we can later use in JavaScript.
	 *
	 * @param array $mPhrases ARRAY of pharses to build.
	 * @return object Returns self.
	 */
	public function setPhrase($mPhrases)
	{
		foreach ($mPhrases as $sVar)
		{
			$sPhrase = Phpfox::getPhrase($sVar);
			$sPhrase = str_replace("'", '&#039;', $sPhrase);
			if (preg_match("/\n/i", $sPhrase))
			{
				$aParts = explode("\n", $sPhrase);
				$sPhrase = '';
				foreach ($aParts as $sPart)
				{
					$sPart = trim($sPart);
					if (empty($sPart))
					{
						$sPhrase .= '\n ';
						
						continue;
					}
					
					$sPhrase .= $sPart . ' ';
				}
				$sPhrase = trim($sPhrase);
			}
			
			$this->_aPhrases[$sVar] = $sPhrase;
		}
		
		return $this;
	}
	
	/**
	 * Get all the phrases set by a controller
	 *
	 * @return array ARRAY of phrases
	 */
	public function getPhrases()
	{
		return (array) $this->_aPhrases;
	}
	
	/**
	 * Sets the breadcrumb structure for the site.
	 *
	 * @param string $sPhrase Breadcrumb title.
	 * @param string $sLink Breadcrumb link.
	 * @param bool $bIsTitle TRUE if this is the title breadcrumb for the page.
	 * @return object Returns self.
	 */
	public function setBreadCrumb($sPhrase, $sLink = '', $bIsTitle = false)
	{		
		(($sPlugin = Phpfox_Plugin::get('template_template_setbreadcrump')) ? eval($sPlugin) : false);
		
		if (is_array($sPhrase))
		{
			foreach ($sPhrase as $aPhrase)
			{
				((isset($aPhrase[2]) && $aPhrase[2]) ? $this->_aBreadCrumbTitle = array($aPhrase[0], $aPhrase[1]) : $this->_aBreadCrumbs[$aPhrase[1]] = $aPhrase[0]);
			}
			return $this;
		}		
		
		// $aCache = $this->_aBreadCrumbTitle;
		
		if ($bIsTitle === true)
		{
			$this->_aBreadCrumbTitle = array(Phpfox::getLib('locale')->convert($sPhrase), $sLink);
			if (!empty($sLink))
			{
				$this->setMeta('og:url', $sLink);
			}
		}
		
		if (!defined('PHPFOX_INSTALLER'))
		{
			$this->_aBreadCrumbs[$sLink] = Phpfox::getLib('locale')->convert($sPhrase);
		}
		
		/*
		if ($bIsTitle === true)
		{
			if (count($aCache))
			{
				$this->setBreadCrumb($aCache[0], $aCache[1]);
			}
		}
		*/		
		
		return $this;
	}	
	
	/**
	 * Get all the breadcrumbs we have loaded so far.
	 *
	 * @return array
	 */
	public function getBreadCrumb()
	{
		if (count($this->_aBreadCrumbTitle))
		{
			foreach ($this->_aBreadCrumbs as $sKey => $mValue)
			{
				if ($sKey === $this->_aBreadCrumbTitle[1])
				{
					unset($this->_aBreadCrumbs[$sKey]);
				}
			}		
			
			if (isset($this->_aBreadCrumbTitle[1]))
			{
				$this->setMeta('canonical', $this->_aBreadCrumbTitle[1]);
			}
		}
		
		if (count($this->_aBreadCrumbs) === 1 && !count($this->_aBreadCrumbTitle))
		{
			$sKey = array_keys($this->_aBreadCrumbs);
			$this->setMeta('canonical', $sKey[0]);
		}
		
		return array($this->_aBreadCrumbs, $this->_aBreadCrumbTitle);
	}
	
	/**
	 * Clear the breadcrumb information.
	 *
	 */
	public function clearBreadCrumb()
	{
		$this->_aBreadCrumbs = array();
		$this->_aBreadCrumbTitle = array();
	}
	
	public function errorClearAll()
	{
		$this->clearBreadcrumb();
		$this->_aTitles = array();
	}	
	
	/**
	 * Set the page title in a public array so we can get it later
	 * and display within the template.
	 *
	 * @see getTitle()
	 * @param string $sTitle Title to display on a specific page
	 * @return object Returns self.
	 */
	public function setTitle($sTitle)
	{
		$this->_aTitles[] = $sTitle;
		
		$this->setMeta('og:site_name', Phpfox::getParam('core.site_title'));
		$this->setMeta('og:title', $sTitle);		
		
		return $this;
	}

	/**
	 * Set the current template for the site.
	 *
	 * @param string $sLayout Template name.
	 * @return object Returns self.
	 */
	public function setTemplate($sLayout)
	{
		$this->sDisplayLayout = $sLayout;
		
		return $this;
	}

	/**
	 * All data placed between the HTML tags <head></head> can be added with this method.
	 * Since we rely on custom templates we need the header data to be custom as well. Current 
	 * support is for: css & JavaScript
	 * All HTML added here is coded under XHTML standards.
	 *
	 * @access public
	 * @param unknown_type $mHeaders
	 * @return object Returns self.
	 */
	public function setHeader($mHeaders, $mValue = null)
	{		
		if ($mHeaders == 'cache')
		{
			if (Phpfox::getParam('core.cache_js_css') && !PHPFOX_IS_AJAX)
			{				
				foreach ($mValue as $sKey => $mNewValue)
				{
					$this->_aCacheHeaders[$sKey][$mNewValue] = true;
				}
			}

			$this->_aHeaders[] = $mValue;
		}
		else 
		{
			if ($mValue !== null)
			{
				if ($mHeaders == 'head')
				{
					$mHeaders = array($mValue);
				}
				else
				{
					$mHeaders = array($mHeaders => $mValue);
				}
			}
			
			$this->_aHeaders[] = $mHeaders;
		}	
				
		return $this;
	}	
	
	/**
	 * All data placed between the HTML tags <head></head> can be added with this method for mobile devices.
	 * Since we rely on custom templates we need the header data to be custom as well. Current 
	 * support is for: css & JavaScript
	 * All HTML added here is coded under XHTML standards.
	 *
	 * @access public
	 * @param unknown_type $mHeaders
	 * @return object Returns self.
	 */
	public function setMobileHeader($mHeaders, $mValue = null)
	{
		if ($mValue !== null)
		{
			$mHeaders = array($mHeaders => $mValue);
		}
			
		$this->_aMobileHeaders[] = $mHeaders;
		
		return $this;
	}
	
	/**
	 * Set settings for the text editor in use.
	 *
	 * @param array $aParams ARRAY of settings.
	 * @return object Returns self.
	 */
	public function setEditor($aParams = array())
	{		
		if (count($aParams))
		{
			$this->_aEditor = $aParams;
		}
		
		$this->_aEditor['active'] = true;
		$this->_aEditor['toggle_image'] = $this->getStyle('image', 'editor/fullscreen.png');
		$this->_aEditor['toggle_phrase'] = Phpfox::getPhrase('core.toggle_fullscreen');

		$this->setHeader('cache', array(
				'editor.css' => 'style_css',
				'editor.js' => 'static_script',
				'wysiwyg/default/core.js' => 'static_script'
			)
		);
		
		return $this;
	}
	
	/**
	 * Get the title for the current page beind displayed.
	 * All titles are added earlier in the script using self::setTitle().
	 * Each title is split with a delimiter specificed from the Admin CP.
	 *
	 * @see setTitle()
	 * @return string $sData Full page title including delimiter
	 */
	public function getTitle()
	{		
		$oFilterOutput = Phpfox::getLib('parse.output');
		
		(($sPlugin = Phpfox_Plugin::get('template_gettitle')) ? eval($sPlugin) : false);
		
		$sData = '';
		/*
		// Display the user name in the title in case we are developing with many browsers
		if (defined('PHPFOX_ADD_USER_TITLE') && PHPFOX_ADD_USER_TITLE && Phpfox::getUserId())
		{
			$sData = Phpfox::getUserBy('full_name') . ' (#' . Phpfox::getUserId() . '): ';
		}
		*/
		foreach ($this->_aTitles as $sTitle) 
		{		
			$sData .= $oFilterOutput->clean($sTitle) . ' ' . Phpfox::getParam('core.title_delim') . ' ';
		}
				
		if (!Phpfox::getParam('core.include_site_title_all_pages'))
		{
			$sData .= (defined('PHPFOX_INSTALLER') ? Phpfox::getParam('core.global_site_title') : Phpfox::getLib('locale')->convert(Phpfox::getParam('core.global_site_title')));
		}
		else
		{
			$sData = trim(rtrim(trim($sData), Phpfox::getParam('core.title_delim')));
			if (empty($sData))
			{
				$sData = (defined('PHPFOX_INSTALLER') ? Phpfox::getParam('core.global_site_title') : Phpfox::getLib('locale')->convert(Phpfox::getParam('core.global_site_title')));
			}
		}
		
		$sSort = Phpfox::getLib('request')->get('sort');
		if (!empty($sSort))
		{
			$mSortName = Phpfox::getLib('search')->getPhrase('sort', $sSort);
			if ($mSortName !== false)
			{
				$sData .= ' ' . Phpfox::getParam('core.title_delim') . ' ' . $mSortName[1];
			}
		}
		
		if (!Phpfox::getParam('core.branding'))
		{
			$sData .= ' - ' . PhpFox::link(false, false) . '';
		}

		return $sData;
	}
	
	/**
	 * Gets all the keywords from a string.
	 *
	 * @param string $sTitle Title to parse.
	 * @return string Splits all the keywords from a title.
	 */
	public function getKeywords($sTitle)
	{		
		$aWords = explode(' ', $sTitle);
		$sKeywords = '';
		foreach ($aWords as $sWord)
		{
			if (empty($sWord))
			{
				continue;
			}
			
			if (strlen($sWord) < 2)
			{
				continue;
			}
			
			$sKeywords .= $sWord . ',';
		}
		$sKeywords = rtrim($sKeywords, ',');
		
		return $sKeywords;
	}

	/**
	 * Set all the meta tags to be used on the site.
	 *
	 * @param array $mMeta ARRAY of meta tags.
	 * @param string $sValue Value of meta tags in case the 1st argument is a string.
	 * @return object Returns self.
	 */
	public function setMeta($mMeta, $sValue = null)
	{
		if (!is_array($mMeta))
		{
			$mMeta = array($mMeta => $sValue);
		}

		// http://www.phpfox.com/tracker/view/14577/
		if(isset($mMeta['keywords']))
		{
			// get custom metas added through the AdminCP -> Tools -> SEO
			$aSiteMetas = Phpfox::getService('admincp.seo')->getSiteMetas();
			
			$sThisController = Phpfox::getService('admincp.seo')->getUrl( (isset($_GET[PHPFOX_GET_METHOD]) ? $_GET[PHPFOX_GET_METHOD] : '/') );
			
			if(is_array($aSiteMetas) && !empty($aSiteMetas))
			{
				// make sure this is the right controller
				foreach ($aSiteMetas as $iKey => $aSiteMeta)
				{
					if (empty($aSiteMeta['url']) || strpos($sThisController, $aSiteMeta['url']) === false)
					{
						unset($aSiteMetas[$iKey]);
					}
				}
				
				if(!empty($sThisController))
				{
					// remove the general keywords
					$mMeta['keywords'] = array(str_replace(Phpfox::getParam('core.keywords'), '', $mMeta['keywords']));
					// check each new custom keywords
					foreach ($aSiteMetas as $aSiteMeta)
					{
						// keywords
						if($aSiteMeta['type_id'] == 0)
						{
							$mMeta['keywords'][] = $aSiteMeta['content'];
						}
					}
					$mMeta['keywords'] = join(',', $mMeta['keywords']);
				}
			}
		}
		// end
		
		foreach ($mMeta as $sKey => $sValue)
		{
			/*
			if ($sKey == 'description')
			{
				if (!isset($this->_aMeta['og:description']))
				{
					$this->_aMeta['og:description'] = '';
				}
				$this->_aMeta['og:description'] .= $sValue;
			}
			*/
			if ($sKey == 'og:url')
			{
				$this->_aMeta[$sKey] = $sValue;
				
				return $this;
			}
			
			if (isset($this->_aMeta[$sKey]))
			{
				$this->_aMeta[$sKey] .= ($sKey == 'keywords' ? ', ' : ' ') . $sValue;
			}
			else 
			{
				$this->_aMeta[$sKey] = $sValue;
			}
			$this->_aMeta[$sKey] = ltrim($this->_aMeta[$sKey], ', ');
		}
		
		return $this;
	}
	
	/**
	 * Gets any data we plan to place within the HTML tags <head></head> for mobile devices.
	 * This method also groups the data to give the template a nice clean look.
	 *
	 * @return string $sData Returns the HTML data to be placed within <head></head>
	 */	
	public function getMobileHeader()
	{		
		return $this->getHeader();	
	}
	
	/**
	 * Gets a 32 string character of the version of the static files
	 * on the site.
	 *
	 * @return string 32 character MD5 sum
	 */
	public function getStaticVersion()
	{
		$sVersion = md5((((defined('PHPFOX_NO_CSS_CACHE') && PHPFOX_NO_CSS_CACHE) || $this->_bIsTestMode === true) ? PHPFOX_TIME : PhpFox::getId() . Phpfox::getBuild()) . (defined('PHPFOX_INSTALLER') ? '' : '-' . Phpfox::getParam('core.css_edit_id') . Phpfox::getBuild() . '-' . $this->_sThemeFolder . '-' . $this->_sStyleFolder));	
		
		(($sPlugin = Phpfox_Plugin::get('template_getstaticversion')) ? eval($sPlugin) : false);
		
		return $sVersion;
	}
		
	/**
	 * Gets any data we plan to place within the HTML tags <head></head>.
	 * This method also groups the data to give the template a nice clean look.
	 *
	 * @return string $sData Returns the HTML data to be placed within <head></head>
	 */
	public function getHeader($bReturnArray = false)
	{		
		if (Phpfox::isMobile())
		{				
			$this->setHeader(array(
					'mobile.css' => 'style_css'
				)
			);			
		}

		if (!defined('PHPFOX_INSTALLER'))
		{
			$this->setHeader(array('custom.css' => 'style_css'));

			$aLocale = Phpfox::getLib('locale')->getLang();
			if ($aLocale['direction'] == 'rtl')
			{
				$this->setHeader(array(
						'rtl.css' => 'style_css'
					)
				);
			}
			
			$sCustomCss = '';			
			$aThemeCache = $this->getThemeCache();
			if (isset($aThemeCache['l_width']) && $aThemeCache['l_width'] > 0)
			{
				$sCustomCss .= '#left { width:' . (int) $aThemeCache['l_width'] . 'px; }';
				$sCustomCss .= '#main_content { margin-left:' . (int) $aThemeCache['l_width'] . 'px; }';
			}			
			if (isset($aThemeCache['c_width']) && $aThemeCache['c_width'] > 0)
			{
				$sCustomCss .= '.content3, .item_view .js_feed_comment_border, .item_view .item_tag_holder, .item_view .attachment_holder_view { width:' . (int) $aThemeCache['c_width'] . 'px; }';				
			}
			if (isset($aThemeCache['r_width']) && $aThemeCache['r_width'] > 0)
			{
				$sCustomCss .= '#right { width:' . (int) $aThemeCache['r_width'] . 'px; }';
				$sCustomCss .= '.content4 { width:' . (960 - (int) $aThemeCache['r_width']) . 'px; }';
			}

			if (!empty($sCustomCss))
			{
				$this->setHeader('<style type="text/css">' . $sCustomCss . '</style>');
			}			
		}
		$aArrayData = array();
		$sData = '';
		$sCss = '';
		$sJs = '';
		$iVersion = $this->getStaticVersion();
		$oUrl = Phpfox::getLib('url');		
		if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
		{
			$oCache = Phpfox::getLib('cache');			
		}
		else
		{
			$oCache = Phpfox::getLib('cache', array(
					'storage' => 'file',
					'free' => true
				)
			);		
		}
		$aUrl = $oUrl->getParams();
		if (Phpfox::getUserParam('core.can_design_dnd') && Phpfox::getService('theme')->isInDnDMode() && (!isset($aUrl['req2']) || $aUrl['req2'] != 'designer'))
		{
			if (!defined('PHPFOX_DESIGN_DND')) 
			{
				define('PHPFOX_DESIGN_DND', true);
			}
			
			/* .
			 * Tells if the user is Design mode with Drag and Drop support.
			 * Its important to note the difference in the purpose of this
			 * constant as it does Not tell if the user CAN enter DesignDND 
			 * mode but instead it tells if the user IS already in this 
			 * mode
			 * .
			 */
			$this->_aHeaders[] = array('designdnd.js' => 'module_theme');
		}
		else
		{
			if (!defined('PHPFOX_DESIGN_DND'))
			{
				define('PHPFOX_DESIGN_DND', false);
			}
		}
			
		if (!PHPFOX_IS_AJAX_PAGE)
		{
			if (!defined('PHPFOX_INSTALLER'))
			{
				if (!Phpfox::isAdminPanel())
				{
					$oDb = Phpfox::getLib('database');
					$oFileCache = Phpfox::getLib('cache');
					$sFileThemeCssId = $oFileCache->set(array('theme', 'theme_css' . $iVersion));
					$aCacheStyles = array();
					if (!($aCacheStyles = $oFileCache->get($sFileThemeCssId)))
					{
						$aSavedStyles = $oDb->select('tc.module_id, tc.file_name')
							->from(Phpfox::getT('theme_css'), 'tc')
							->where('style_id = ' . (int) $this->_aTheme['style_id'] . '')		
							->execute('getRows');
						foreach ($aSavedStyles as $aSavedStyle)
						{
							$aCacheStyles[($aSavedStyle['module_id'] ? $aSavedStyle['module_id'] : null)][$aSavedStyle['file_name']] = true;
						}			
						
						$oFileCache->save($sFileThemeCssId, $aCacheStyles);
					}					
				}
			}			
		
			(($sPlugin = Phpfox_Plugin::get('template_getheader')) ? eval($sPlugin) : false);
			
			$sJs .= "\t\t\tvar oCore = {'core.is_admincp': " . (Phpfox::isAdminPanel() ? 'true' : 'false') . ", 'core.section_module': '" . Phpfox::getLib('module')->getModuleName() . "', 'profile.is_user_profile': " . (defined('PHPFOX_IS_USER_PROFILE') && PHPFOX_IS_USER_PROFILE ? 'true' : 'false') . ", 'log.security_token': '" . Phpfox::getService('log.session')->getToken() . "', 'core.url_rewrite': '" . Phpfox::getParam('core.url_rewrite') . "', 'core.country_iso': '" . (Phpfox::isUser() ? Phpfox::getUserBy('country_iso') : '') . "', 'core.can_move_on_a_y_and_x_axis' : " . ((!defined('PHPFOX_INSTALLER') && Phpfox::getParam('core.can_move_on_a_y_and_x_axis')) ? 'true' : 'false') . ", 'core.default_currency': '" . (defined('PHPFOX_INSTALLER') ? 'USD' : Phpfox::getService('core.currency')->getDefault()) . "', 'core.enabled_edit_area': " . (Phpfox::getParam('core.enabled_edit_area') ? 'true' : 'false') . ", 'core.disable_hash_bang_support': " . (Phpfox::getParam('core.disable_hash_bang_support') ? 'true' : 'false') . ", 'core.site_wide_ajax_browsing': " . ((!defined('PHPFOX_IN_DESIGN_MODE') && Phpfox::getParam('core.site_wide_ajax_browsing') && !Phpfox::isAdminPanel() && Phpfox::isUser()) ? 'true' : 'false') . ", 'profile.user_id': " . (defined('PHPFOX_IS_USER_PROFILE') && PHPFOX_IS_USER_PROFILE ? Phpfox::getService('profile')->getProfileUserId() : 0) . "};\n";
// You are filtering out the controllers which should not load 'content' ajaxly, finding a way for pages.view/1/info and like that
			$sProgressCssFile = $this->getStyle('css', 'progress.css');
			$sStylePath = str_replace(Phpfox::getParam('core.path'), '', str_replace('progress.css', '', $sProgressCssFile));
			
			$aJsVars = array(
				'sJsHome' => Phpfox::getParam('core.path'),
				'sJsHostname' => $_SERVER['HTTP_HOST'],
				'sSiteName' => Phpfox::getParam('core.site_title'),
				'sJsStatic' => $oUrl->getDomain() . PHPFOX_STATIC,
				'sJsStaticImage' => Phpfox::getParam('core.url_static_image'),
				'sImagePath' => $this->getStyle('image'),
				'sStylePath' => $this->getStyle('css'),
				'sVersion' => Phpfox::getId(),
				'sJsAjax' => $oUrl->getDomain() . PHPFOX_STATIC . 'ajax.php',
				'sStaticVersion' => $iVersion,
				'sGetMethod' => PHPFOX_GET_METHOD,
				'sDateFormat' => (defined('PHPFOX_INSTALLER') ? '' : Phpfox::getParam('core.date_field_order')),
				'sJsAjax' => $oUrl->getDomain() . PHPFOX_STATIC . 'ajax.php',
				'sEgiftStyle' => $this->getStyle('css','display.css','egift'),
				'sGlobalTokenName' => Phpfox::getTokenName(),
				'sController' => Phpfox::getLib('module')->getFullControllerName(),
				'bJsIsMobile' => (Phpfox::isMobile() ? true : false),
				'sProgressCssFile' => $sProgressCssFile,
				'sHostedVersionId' => (defined('PHPFOX_IS_HOSTED_VERSION') ? PHPFOX_IS_HOSTED_VERSION : '')
			);	
			
			if (!defined('PHPFOX_INSTALLER'))
			{
				$aJsVars['bWysiwyg'] = ((Phpfox::getParam('core.wysiwyg') != 'default' && Phpfox::getParam('core.allow_html')) ? true : false);
				$aJsVars['sEditor'] = Phpfox::getParam('core.wysiwyg');	
				$aJsVars['sJsCookiePath'] = Phpfox::getParam('core.cookie_path');
				$aJsVars['sJsCookieDomain'] = Phpfox::getParam('core.cookie_domain');
				$aJsVars['sJsCookiePrefix'] = Phpfox::getParam('core.session_prefix');	
				$aJsVars['bPhotoTheaterMode'] = (Phpfox::isModule('photo') ? Phpfox::getParam('photo.view_photos_in_theater_mode') : false);
				$aJsVars['bUseHTML5Video'] = (Phpfox::getParam('video.upload_for_html5') ? true : false);				
				if (Phpfox::isAdmin())
				{
					$aJsVars['sAdminCPLocation'] = Phpfox::getParam('admincp.admin_cp');
				}
				else
				{
					$aJsVars['sAdminCPLocation'] = '';
				}
				if (Phpfox::isModule('notification'))
				{
					$aJsVars['notification.notify_ajax_refresh'] = Phpfox::getParam('notification.notify_ajax_refresh');
				}
				if (Phpfox::isModule('im'))
				{
					if (Phpfox::isUser())
					{
						$aJsVars['im_beep'] = Phpfox::getUserBy('im_beep');
					}
					$this->setHeader(array('player/' . Phpfox::getParam('core.default_music_player') . '/core.js' => 'static_script'));
					
					$aJsVars['im_interval_for_update'] = Phpfox::getParam('im.js_interval_value');
					if (Phpfox::getParam('im.server_for_ajax_calls') != '')
					{
						$aJsVars['im_server'] = Phpfox::getParam('im.server_for_ajax_calls');
					}
				}
				// Video pop-up does not work because core.js is missing when the IM module is disabled.
				elseif (Phpfox::isModule('video'))
				{
					$this->setHeader(array('player/' . Phpfox::getParam('core.default_music_player') . '/core.js' => 'static_script'));
				}
				
				$sLocalDatepicker = PHPFOX_STATIC .'jscript/jquery/locale/jquery.ui.datepicker-' . strtolower(Phpfox::getLib('locale')->getLangId()) . '.js';				
				
				if (file_exists($sLocalDatepicker))
				{
					$sFile = str_replace(PHPFOX_STATIC . 'jscript/', '', $sLocalDatepicker);
					$this->setHeader(array($sFile => 'static_script'));					
				}
				
				/* Only in a few cases will we want to add the visitor's IP */
				if (Phpfox::getParam('core.google_api_key') != '' && Phpfox::getParam('core.ip_infodb_api_key'))
				{
					// $aJsVars['sIP'] = Phpfox::getLib('request')->getIp();
				}
				
				$aJsVars['bEnableMicroblogSite'] = (Phpfox::isModule('microblog') ? Phpfox::getParam('microblog.enable_microblog_site') : false);		
			}
			
			(($sPlugin = Phpfox_Plugin::get('template_getheader_setting')) ? eval($sPlugin) : false);
			
			if (Phpfox::isModule('input') && false)
			{
				$this->setHeader('cache', array('browse.css' => 'style_css'));
			}
			$sJs .= "\t\t\tvar oParams = {";
			$iCnt = 0;
			foreach ($aJsVars as $sVar => $sValue)
			{
				$iCnt++;
				if ($iCnt != 1)
				{
					$sJs .= ",";
				}
				
				if (is_bool($sValue))
				{
					$sJs .= "'{$sVar}': " . ($sValue ? 'true' : 'false');	
				}
				elseif (is_numeric($sValue))
				{
					$sJs .= "'{$sVar}': " . $sValue;	
				}
				else 
				{
					$sJs .= "'{$sVar}': '" . str_replace("'", "\'", $sValue) . "'";	
				}
			}			
			$sJs .= "};\n";		
			
			if (!defined('PHPFOX_INSTALLER'))
			{			
				$aLocaleVars = array(
					'core.are_you_sure',
					'core.yes',
					'core.no',
					'core.save',
					'core.cancel',
					'core.go_advanced',
					'core.processing',
					'emoticon.emoticons',
					'attachment.attach_files',
					'core.close',					
					'core.language_packages',
					'core.move_this_block',
					'core.uploading',
					'language.loading',
					'core.saving',
					'core.loading_text_editor',
					'core.quote',
					'core.loading'
				);
				
				if (Phpfox::isModule('im') && Phpfox::getParam('im.enable_im_in_footer_bar'))
				{
					$aLocaleVars[] = 'im.find_your_friends';
				}
				
				(($sPlugin = Phpfox_Plugin::get('template_getheader_language')) ? eval($sPlugin) : false);
				
				$sJs .= "\t\t\tvar oTranslations = {";
				$iCnt = 0;
				foreach ($aLocaleVars as $sValue)
				{
					$aParts = explode('.', $sValue);
					
					if ($aParts[0] != 'core' && !Phpfox::isModule($aParts[0]))
					{
						continue;
					}					
					
					$iCnt++;
					if ($iCnt != 1)
					{
						$sJs .= ",";
					}
	
					$sJs .= "'{$sValue}': '" . html_entity_decode(str_replace("'", "\'", Phpfox::getPhrase($sValue)), null, 'UTF-8') . "'";
				}				
				$sJs .= "};\n";			
					
				$aModules = Phpfox::getLib('module')->getModules();
				$sJs .= "\t\t\tvar oModules = {";
				$iCnt = 0;
				foreach ($aModules as $sModule => $iModuleId)
				{
					$iCnt++;
					if ($iCnt != 1)
					{
						$sJs .= ",";
					}				
					$sJs .= "'{$sModule}': true";
				}
				$sJs .= "};\n";			
			}			

			if (count($this->_aImages))
			{
				$sJs .= "\t\t\tvar oJsImages = {";
				foreach ($this->_aImages as $sKey => $sImage)
				{
					$sJs .= $sKey . ': \'' . $sImage. '\',';
				}
				$sJs = rtrim($sJs, ',');
				$sJs .= "};\n";			
			}		

		/*
		if (count($this->_aEditor) && isset($this->_aEditor['active']) && $this->_aEditor['active'])
		{
		*/
			$aEditorButtons = Phpfox::getLib('editor')->getButtons();
			
			$iCnt = 0;						
			$sJs .= "\t\t\tvar oEditor = {";
			
			if (count($this->_aEditor) && isset($this->_aEditor['active']) && $this->_aEditor['active'])
			{
				foreach ($this->_aEditor as $sVar => $mValue)
				{
					$iCnt++;
					if ($iCnt != 1)
					{
						$sJs .= ",";
					}				
					$sJs .= "'{$sVar}': " . (is_bool($mValue) ? ($mValue === true ? 'true' : 'false') : "'{$mValue}'") . "";
				}
				
				$sJs .= ", ";
			}
			$sJs .= "images:[";
			foreach ($aEditorButtons as $mEditorButtonKey => $aEditorButton)
			{
				$sJs .= "{";
				foreach ($aEditorButton as $sEditorButtonKey => $sEditorButtonValue)			
				{
					$sJs .= "" . $sEditorButtonKey . ": '" . $sEditorButtonValue . "',";	
				}
				$sJs = rtrim($sJs, ',') . "},";
			}	
			$sJs = rtrim($sJs, ',') . "]";
			
			$sJs .= "};\n";	
		// }

			if (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('core.load_jquery_from_google_cdn'))
			{
				$sData .= "\t\t" . '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/' . Phpfox::getParam('core.jquery_google_cdn_version') . '/jquery.min.js"></script>' . "\n";
			}
		}

		if (PHPFOX_IS_AJAX_PAGE)
		{
			$this->_aCacheHeaders = array();
		}
		
		$bIsHttpsPage = false;
		if (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('core.force_https_secure_pages'))
		{
			if (in_array(str_replace('mobile.', '', Phpfox::getLib('module')->getFullControllerName()), Phpfox::getService('core')->getSecurePages())
				&& (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
				)
			{
				$bIsHttpsPage = true;
			}	
		}
		
			$aSubCache = array();
			$sStyleCacheData = '';
			$sJsCacheData = '';		
			$aUrl = Phpfox::getLib('url')->getParams();
			// These two arrays hold the files to be combined+minified and put in CDN (if available)
            $aCacheJs = array();
            $aCacheCSS = array();
            
            $this->_sFooter = '';
            $sJs .= "\t\t\t" . 'var $Behavior = {};' . "\n";
            $sJs .= "\t\t\t" .'var $Core = {};' . "\n";            
            
            if (Phpfox::getParam('core.defer_loading_user_images') || Phpfox::getParam('core.defer_loading_images'))
            {
				$this->setHeader('cache', array(
					'defer_image.js' => 'module_core'
				));
			}
            
            if (Phpfox::getParam('core.include_master_files'))
            {
				$aMasterJS = array();
				$aMasterCSS = array();
			}

			$aCustomCssFile = array();
			
			foreach ($this->_aHeaders as $aHeaders)
			{
				if (!is_array($aHeaders))
				{
					$aHeaders = array($aHeaders);
				}			
				
				foreach ($aHeaders as $mKey => $mValue)
				{															
					$sQmark = (strpos($mKey, '?') ? '&amp;' : '?');

					if (is_numeric($mKey))
					{
						if ($mValue === null)
						{
							continue;
						}				

						if ($bReturnArray)
						{
							$aArrayData[] = $mValue;
						}
						else 
						{
							
                            if (is_string($mValue) && (strpos($mValue, '.js') !== false || strpos($mValue, 'javascript') !== false))
                            {
								if (strpos($mValue, 'RecaptchaOptions'))
								{
									$sData .= "\t\t" . $mValue . "\n";
								}
								else
								{
                                	$this->_sFooter .= "\t\t". $mValue;
								}
                            }
							else if (is_string($mValue))
                            {
                                $sData .= "\t\t" . $mValue . "\n";
                            }
							else
							{
								$sData .= "\t\t" . implode($mValue) . "\n";
							}
						}
                        
					}
					else if ($mKey == 'master')
					{						
						$aMaster = array('css' => array(), 'jscript' => array());
						foreach ($mValue as $sValKey => $sValVal)
						{
							if (strpos($sValKey, '.css') !== false)
							{
								if ($sValVal == 'style_css')							
								{
									$aMaster['css'][] = 'theme' . PHPFOX_DS . 'frontend' . PHPFOX_DS . $this->getThemeFolder() . PHPFOX_DS . 'style' . PHPFOX_DS . $this->getStyleFolder() . PHPFOX_DS . 'css' . PHPFOX_DS . $sValKey;
								}
								else if (strpos($sValVal, 'module_') !== false)
								{
									$aMaster['css'][] = 'module' . PHPFOX_DS . (str_replace('module_','',$sValVal)) . PHPFOX_DS . 'static' . PHPFOX_DS . 'css' . PHFPFOX_DS . $this->getThemeFolder() . PHPFOX_DS . $this->getStyleFolder() . PHPFOX_DS . $sValKey;
								}
							}
							else if (strpos($sValKey, '.js') !== false)
							{
								if ($sValVal == 'static_script')
								{
									$aMaster['jscript'][] = 'static' . PHPFOX_DS . 'jscript' . PHPFOX_DS . $sValKey;
								}
								else if (strpos($sValVal, 'module_') !== false)
								{
									$aMaster['jscript'][] = 'module' . PHPFOX_DS . (str_replace('module_', '', $sValVal)) . PHPFOX_DS . 'static' . PHPFOX_DS . 'jscript' . PHPFOX_DS . $sValKey;
								}
							}
						}

						unset($this->_aHeaders[$mKey]); // just to avoid confusions
						$this->_aHeaders['master'] = $aMaster;
					}
					else 
					{		
						$bToHead = false;
						// This happens when the developer needs something to go to <head>
						if (is_array($mValue))
						{
							$aKeyHead = array_keys($mValue);
							$aKeyValue = array_values($mValue);
							$bToHead = ($mKey == 'head');
							$mKey = array_pop($aKeyHead);
							$mValue = array_pop($aKeyValue);
						}
									
						switch ($mValue)
						{
							case 'style_script':
								
								if (isset($aSubCache[$mKey][$mValue]))
								{
									continue;
								}								
								
								if ($bReturnArray)
								{
									$aArrayData[] = $this->getStyle('jscript', $mKey);	
								}
								else 
								{
                                    //$sJsCacheData .= str_replace(Phpfox::getParam('core.path'), '', $this->getStyle('jscript', $mKey)) . ',';
                                    if ($bToHead == 'head')
                                    {
										$aCacheCSS[] = str_replace(Phpfox::getParam('core.path'), '', $this->getStyle('jscript', $mKey));
									}
                                    else
                                    {
										$aCacheJs[] = str_replace(Phpfox::getParam('core.path'), '', $this->getStyle('jscript', $mKey));
									}
									
								}
							break;
							case 'style_css':							
								$bCustomStyle = false;
								if (!defined('PHPFOX_INSTALLER') && !Phpfox::isAdminPanel())
								{									
									if (isset($aCacheStyles[null][$mKey]))
									{
										if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
										{
											$sCssCustomCacheId = $oCache->set($this->_aTheme['style_id'] . '_custom_css_file');
										}
										else
										{	
											if ($bIsHttpsPage)
											{
												$sCssCustomCacheId = $oCache->set(PHPFOX_DIR_FILE . 'static' . PHPFOX_DS . $this->_aTheme['style_id'] . '_secure_' . $mKey);
											}
											else
											{
												$sCssCustomCacheId = $oCache->set(PHPFOX_DIR_FILE . 'static' . PHPFOX_DS . $this->_aTheme['style_id'] . '_' . $mKey);												
											}
										}

										if (!($aCss = (defined('PHPFOX_IS_HOSTED_SCRIPT') ? ($oCache->get($sCssCustomCacheId)) : ($oCache->isCached($sCssCustomCacheId)))))										
										{		
											$oDb = Phpfox::getLib('database');

											$aCss = $oDb->select('tc.css_id, tc.css_data, tc.css_data_original')
												->from(Phpfox::getT('theme_css'), 'tc')
												->where('style_id = ' . (int) $this->_aTheme['style_id'] . ' AND file_name = \'' . $oDb->escape($mKey) . '\'')		
												->execute('getRow');

											if (isset($aCss['css_id']))
											{								
												$oCache->save($sCssCustomCacheId, (defined('PHPFOX_IS_HOSTED_SCRIPT') ? $aCss : Phpfox::getLib('file.minimize')->css($aCss['css_data'])));												
												
												$bCustomStyle = true;
											}									
										}
										else 
										{
											if (defined('PHPFOX_IS_HOSTED_SCRIPT') && isset($aCss['css_id']))
											{
												$bCustomStyle = true;
											}
											else
											{
												if (file_exists(PHPFOX_DIR_FILE . 'static' . PHPFOX_DS . $this->_aTheme['style_id'] . '_' . $mKey))
												{
													$bCustomStyle = true;
												}
											}
										}								
									}
									else 
									{
										if (file_exists(PHPFOX_DIR_FILE . 'static' . PHPFOX_DS . $this->_aTheme['style_id'] . '_' . $mKey))
										{
											$bCustomStyle = true;
										}										
									}
								}
							
								if ($bCustomStyle === false)
								{
									if ($bReturnArray)
									{
										$aArrayData[] = $this->getStyle('css', $mKey);
									}
									else 
									{
										$aCacheCSS[] = str_replace(Phpfox::getParam('core.path'), '', $this->getStyle('css', $mKey));
									}
								}
								else 
								{
									if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
									{
										$bLoadCustomThemeOverwrite = true;
									}
									else
									{
										if ($bReturnArray)
										{
											$aArrayData[] = Phpfox::getParam('core.url_file') . 'static/' . $this->_aTheme['style_id'] . '_' . $mKey;
										}
										else
										{
											if (isset($this->_aCacheHeaders[$mKey]))
											{
												// $sStyleCacheData .= str_replace(Phpfox::getParam('core.path'), '', Phpfox::getParam('core.url_file')) . 'static/' . $this->_aTheme['style_id'] . '_' . $mKey . ',';
												$aCustomCssFile[] = Phpfox::getParam('core.url_file') . 'static/' . $this->_aTheme['style_id'] . '_' . $mKey . '';
											}
											else
											{
													if ($bIsHttpsPage)
													{
														//$sData .= "\t\t" . '<link rel="stylesheet" type="text/css" href="' . Phpfox::getParam('core.url_file') . 'static/' . $this->_aTheme['style_id'] . '_secure_' . $mKey . '?v=' . $iVersion . '" />' . "\n";
														$aCustomCssFile[] = Phpfox::getParam('core.url_file') . 'static/' . $this->_aTheme['style_id'] . '_secure_' . $mKey;
													}
													else
													{
														//$sData .= "\t\t" . '<link rel="stylesheet" type="text/css" href="' . Phpfox::getParam('core.url_file') . 'static/' . $this->_aTheme['style_id'] . '_' . $mKey . '?v=' . $iVersion . '" />' . "\n";
														$aCustomCssFile[] = Phpfox::getParam('core.url_file') . 'static/' . $this->_aTheme['style_id'] . '_' . $mKey;
													}

											}
										}
									}
								}
								
								break;
							case 'static_script':
								if (isset($aSubCache[$mKey][$mValue]))
								{
									continue;
								}							
											
								if (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('core.load_jquery_from_google_cdn'))
								{											
									if ($mKey == 'jquery/ui.js' || $mKey == 'jquery/jquery.js')
									{				
										if ($mKey == 'jquery/ui.js')
										{
                                            $this->_sFooter .= "\t\t" . '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/' . Phpfox::getParam('core.jquery_ui_google_cdn_version') . '/jquery-ui.min.js"></script>' . "\n";											
                                        }
										
										continue;
									}									
								}								
								
								if ($bReturnArray)
								{
									$aArrayData[] = Phpfox::getParam('core.url_static_script') . $mKey;	
								}
								else 
								{
									if (isset($this->_aCacheHeaders[$mKey]))
									{
										// $sJsCacheData .= $mKey . ',';
                                        if ($bToHead == 'head')
                                        {
											$aCacheCSS[] = 'static' . PHPFOX_DS . 'jscript' . PHPFOX_DS . $mKey;
										}
                                        else
                                        {
											$aCacheJs[] =  'static' . PHPFOX_DS . 'jscript' . PHPFOX_DS . $mKey;
										}
									}
									else 
									{							
										//$sData .= "\t\t" . '<script type="text/javascript" src="' . Phpfox::getParam('core.url_static_script') . $mKey . $sQmark . 'v=' . $iVersion . '"></script>' . "\n";
										if ($bToHead == 'head')
                                        {
											$aCacheCSS[] = 'static/jscript/' . $mKey;
										}
                                        else
                                        {
											$aCacheJs[] = 'static/jscript/' . $mKey;
										}
									}
								}
								break;
							
							default:
								if (preg_match('/module/i', $mValue))
								{
									$aParts = explode('_', $mValue);
									if (isset($aParts[1]) && Phpfox::isModule($aParts[1]))
									{
										if (substr($mKey, -3) == '.js')
										{											
											if ($bReturnArray)
											{
												$aArrayData[] = Phpfox::getParam('core.path') . 'module/' . $aParts[1] . '/static/jscript/' . $mKey;
											}
											else 
											{
												if (isset($this->_aCacheHeaders[$mKey]))
												{
													//$sJsCacheData .= 'module/' . $aParts[1] . '/static/jscript/' . $mKey . ',';
                                                    $aCacheJs[] = 'module/' . $aParts[1] . '/static/jscript/' . $mKey;
												}
												else 
												{
													/*
													if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
													{
														$sData .= "\t\t" . '<script type="text/javascript" src="' . Phpfox::getCdnPath() . 'module/' . $aParts[1] . '/static/jscript/' . $mKey . $sQmark . 'v=' . $iVersion . '"></script>' . "\n";
													}	
													else
													{
													*/
														//$sData .= "\t\t" . '<script type="text/javascript" src="' . Phpfox::getParam('core.path') . 'module/' . $aParts[1] . '/static/jscript/' . $mKey . $sQmark . 'v=' . $iVersion . '"></script>' . "\n";
                                                        $aCacheJs[] = 'module/' . $aParts[1] . '/static/jscript/'.$mKey;
													// }
												}
											}
										}
										elseif (substr($mKey, -4) == '.css')
										{			
                                            
                                            $aCacheCSS[] = str_replace(Phpfox::getParam('core.path'),'',$this->getStyle('css', $mKey, $aParts[1]));
											$bCustomStyle = false;

											if (!defined('PHPFOX_INSTALLER') && !Phpfox::isAdminPanel())
											{											
												if (isset($aCacheStyles[$aParts[1]][$mKey]))
												{
													$sCssCustomCacheId = $oCache->set(PHPFOX_DIR_FILE . 'static' . PHPFOX_DS . $this->_aTheme['style_id'] . '_' . $aParts[1] . '_' . $mKey);
													
													if (!($oCache->isCached($sCssCustomCacheId)))										
													{						
																	
														$oDb = Phpfox::getLib('database');
														$aCss = $oDb->select('tc.css_id, tc.css_data')
															->from(Phpfox::getT('theme_css'), 'tc')
															->where('module_id = \'' . $oDb->escape($aParts[1]) . '\' AND style_id = ' . (int) $this->_aTheme['style_id'] . ' AND file_name = \'' . $oDb->escape($mKey) . '\'')		
															->execute('getRow');
															
														if (isset($aCss['css_id']))
														{															
															$oCache->save($sCssCustomCacheId, Phpfox::getLib('file.minimize')->css($aCss['css_data']));																							
															
															$bCustomStyle = true;
														}									
													}
													else 
													{
														if (file_exists(PHPFOX_DIR_FILE . 'static' . PHPFOX_DS . $this->_aTheme['style_id'] . '_' . $aParts[1] . '_' . $mKey))
														{
															$bCustomStyle = true;
														}
													}										
												}
												else 
												{
													if (file_exists(PHPFOX_DIR_FILE . 'static' . PHPFOX_DS . $this->_aTheme['style_id'] . '_' . $aParts[1] . '_' . $mKey))
													{
														$bCustomStyle = true;
													}													
												}
											}
											
											if ($bCustomStyle === false)
											{
												if ($bReturnArray)
												{
													//$aArrayData[] = $this->getStyle('css', $mKey, $aParts[1]);
                                                    $aCachesCSS[] = str_replace(Phpfox::getParam('core.path'), '', $this->getStyle('css', $mKey, $aParts[1]));
												}
												else 
												{
													/*
                                                    if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
                                                    {
                                                        $sData .= "\t\t" . '<link rel="stylesheet" type="text/css" href="' . str_replace(Phpfox::getParam('core.path'), Phpfox::getCdnPath(), $this->getStyle('css', $mKey, $aParts[1])) . $sQmark . 'v=' . $iVersion . '" />' . "\n";
                                                    }
                                                    else
                                                    {
                                                    */
                                                        $aCachesCSS[] = str_replace(Phpfox::getParam('core.path'), '', $this->getStyle('css', $mKey, $aParts[1]));
                                                    // }
												}
											}
											else 
											{
												//$sStyleCacheData .= str_replace(Phpfox::getParam('core.path'), '', Phpfox::getParam('core.url_file')) . 'static/' . $this->_aTheme['style_id'] . '_' . $aParts[1] . '_' . $mKey . ',';
												$aCachesCSS[] = str_replace(Phpfox::getParam('core.path'), '', Phpfox::getParam('core.url_file')) . 'static/' . $this->_aTheme['style_id'] . '_' . $aParts[1] . '_' . $mKey;
											}
										}
									}
								}							
								break;							
							}
							
						$aSubCache[$mKey][$mValue] = true;
					}
				}
			}
		
		$sCacheData = '';
		$sCacheData .= "\n\t\t<script type=\"text/javascript\">\n";
		$sCacheData .= $sJs;
		$sCacheData .= "\t\t</script>";
        
		if (!empty($sStyleCacheData))
		{
			$sCacheData .= "\n\t\t" . '<link rel="stylesheet" type="text/css" href="' . Phpfox::getParam('core.url_static') . 'gzip.php?t=css&amp;s=' . $sStylePath . '&amp;f=' . rtrim($sStyleCacheData, ',') . '&amp;v=' . $iVersion . '" />';
		}
		
		if (!empty($sJsCacheData))
		{
			$sCacheData .= "\n\t\t" . '<script type="text/javascript" src="' . Phpfox::getParam('core.url_static') . 'gzip.php?t=js&amp;f=' . rtrim($sJsCacheData, ',') . '&amp;v=' . $iVersion . '"></script>';
		}		
		
		if (Phpfox::getParam('core.include_master_files') && Phpfox::isAdminPanel() != true && isset($this->_aHeaders['master']))
        {
			// $this->_aHeaders[master] is created in the foreach above and it takes the files listed in Phpfox::getMasterFiles
			$aMasterFiles = $this->_aHeaders['master'];
			require_once(PHPFOX_DIR_LIB . 'jsmin/jsmin2.class.php');
			
			// if the file doesnt exist load the default ones
			if ($this->_sThemeFolder != 'default' || $this->_sStyleFolder != 'default')
			{
				foreach ($aMasterFiles['css'] as $iKey => $sFile)
				{
					if ( file_exists(PHPFOX_DIR . $sFile) != true)
					{
						// include the default master file
						$sFile = str_replace($this->getThemeFolder(), 'default', $sFile);
						$sFile = str_replace($this->getStyleFolder(), 'default', $sFile);
						$aMasterFiles['css'][$iKey] = $sFile;
					}
				}
			}
			$sMasterCSSUrl = Phpfox::getLib('file.minimize')->minify($aMasterFiles['css'], $sQmark . 'v=' . $iVersion, false);
			$sCacheData .= "\n\t\t". '<!-- CSS Master --> <link rel="stylesheet" type="text/css" href="' . $sMasterCSSUrl . '" />';
			
			$sMasterJSUrl = Phpfox::getLib('file.minimize')->minify($aMasterFiles['jscript'], $sQmark . 'v=' . $iVersion, true);
			$this->_sFooter .= "\n\t\t" .'<!-- JS Master --> <script type="text/javascript" src="' . $sMasterJSUrl . '"></script>';			
		}
		
		if (!empty($sCacheData))
		{
			$sData = preg_replace('/<link rel="shortcut icon" type="image\/x-icon" href="(.*?)" \/>/i', '<link rel="shortcut icon" type="image/x-icon" href="\\1" />' . $sCacheData, $sData);
		}		
		
		if ($bReturnArray)
		{
			$sData = '';
		}
		$aCacheJs = array_unique($aCacheJs);
        
        if (Phpfox::getParam('core.cache_js_css'))
        {
            $aJqueryPlugins = array();
            foreach ($aCacheJs as $iKey => $sFile)
            {
               //  if ( (strpos($sFile, 'jquery') !== false) && (strpos($sFile, 'plugin') !== false) )
                if ((strpos($sFile, 'jquery') !== false))
                {
                    // We minify JQuery plug-ins in their own file
                    $aJqueryPlugins[] = $sFile;
                    unset($aCacheJs[$iKey]);
                }

				if ($sFile == 'static/jscript/wysiwyg/tiny_mce/tiny_mce.js')
				{
					$this->_sFooter .= "\n\t\t" . '<!-- TinyMCE --> <script type="text/javascript" src="' . Phpfox::getParam('core.path')  . $sFile . '?v=' . $iVersion . '"></script>' . "";
					unset($aCacheJs[$iKey]);
				}
            }
            
            require_once(PHPFOX_DIR_LIB . 'jsmin/jsmin2.class.php');            
            if (!empty($aJqueryPlugins))
            {
            	$sPluginsUrl = Phpfox::getLib('file.minimize')->minify($aJqueryPlugins, $sQmark . 'v=' . $iVersion, true);
            	$this->_sFooter .= "\n\t\t" . '<!-- JQuery Plugins --> <script type="text/javascript" src="' . $sPluginsUrl . '"></script>' . "";
            }            
            
            if (!empty($aCacheJs))
            {
				$aCacheJs = array_unique($aCacheJs);
            	$sJsUrl = Phpfox::getLib('file.minimize')->minify($aCacheJs, $sQmark .'v=' . $iVersion, true, true);
            	$this->_sFooter .= "\n\t\t".'<!-- Minified --> <script type="text/javascript" src="' . $sJsUrl . '"></script>' . "";
            }            
            
            if (!empty($aCacheCSS))
            {
                $sCSSUrl = Phpfox::getLib('file.minimize')->minify($aCacheCSS, $sQmark . 'v=' . $iVersion, false);
                $sData .= "\n\t\t".'<!-- Minified --> <link rel="stylesheet" type="text/css" href="' . $sCSSUrl . '" />' . "";                
            }

			if (!empty($aCustomCssFile))
			{
				foreach ($aCustomCssFile as $sCustomCssFile)
				{
					$sData .= "\n\t\t".'<!-- Custom --> <link rel="stylesheet" type="text/css" href="' . $sCustomCssFile . '" />' . "";
				}
			}
        }
        else
        {
			$aSubCacheCheck = array();
            foreach ($aCacheCSS as $sFile)
            {
            	if (defined('PHPFOX_INSTALLER'))
            	{
            		$sData .= "\t\t" . '<link rel="stylesheet" type="text/css" href="' . $sFile . $sQmark .'v=' . $iVersion . '" />' . "\n";
            	}
            	else
            	{
					if (isset($aSubCacheCheck[$sFile]))
					{
						continue;
					}
					$aSubCacheCheck[$sFile] = true;
                	$sData .= "\t\t" . '<link rel="stylesheet" type="text/css" href="' . Phpfox::getParam('core.path') . $sFile . $sQmark .'v=' . $iVersion . '" />' . "\n";
            	}
            }
			
			

			if (!empty($aCustomCssFile))
			{
				foreach ($aCustomCssFile as $sCustomCssFile)
				{
					$sData .= "\n\t\t".'<!-- Custom --> <link rel="stylesheet" type="text/css" href="' . $sCustomCssFile . '" />' . "";
				}
			}
            
            if (Phpfox::getParam('core.defer_loading_js'))
            {
				
			}
            else
            {
				foreach ($aCacheJs as $sFile)
				{
					if (defined('PHPFOX_INSTALLER'))
					{
						$this->_sFooter .= "\t\t" . '<script type="text/javascript" src="../' . $sFile . $sQmark .'v=' . $iVersion . '"></script>' . "\n";
					}
					else
					{
						$this->_sFooter .= "\t\t" . '<script type="text/javascript" src="' . Phpfox::getParam('core.path') . $sFile . $sQmark .'v=' . $iVersion . '"></script>' . "\n";
					}
				}
			}
			if (!defined('PHPFOX_INSTALLER'))
			{
            	$this->_sFooter .= "\t\t" . '<script type="text/javascript"> $Core.init(); </script>' . "\n";
			}
        }
        
        if (defined('PHPFOX_TEMPLATE_CSS_FILE'))
		{
			//$this->setHeader(PHPFOX_TEMPLATE_CSS_FILE);
			$sData .= PHPFOX_TEMPLATE_CSS_FILE;
		}
			
        // And in its own file custom.css maybe check if its not empty like when using the default theme
		/*
        $sCustomFile = 'theme/' . (Phpfox::isAdminPanel() ? 'adminpanel' : (Phpfox::isMobile() ? 'mobile' : 'frontend')) . '/' . $this->getThemeFolder() . '/style/' . $this->getStyleFolder() . '/css/custom.css';
        
        if (Phpfox::getParam('core.cache_js_css') && file_exists(PHPFOX_DIR . $sCustomFile) && filesize(PHPFOX_DIR . $sCustomFile) > 0)
        {
			$sCustomUrl = Phpfox::getLib('file.minimize')->minify($sCustomFile, $sQmark . 'v=' . $iVersion, false);
			$sData .= "\n\t\t" . '<!-- Custom --> <link rel="stylesheet" type="text/css" href="' . $sCustomUrl .'" />';
		}
		*/
        
		if (count($this->_aPhrases))
		{
			$sData .= "\n\t\t<script type=\"text/javascript\">\n\t\t";
			foreach ($this->_aPhrases as $sVar => $sPhrase)
			{
				$sPhrase = html_entity_decode($sPhrase, null, 'UTF-8');
				
				$sData .= "\t\t\toTranslations['{$sVar}'] = '" . str_replace("'", "\'", $sPhrase) . "';\n";
			}
			$sData .= "\t\t</script>\n";
		}		
		
		if ($bReturnArray)
		{
			$aArrayData[] = $sData;			
			
			return $aArrayData;
		}
	
		// Convert meta data
		$bHasNoDescription = false;
		if (count($this->_aMeta) && !PHPFOX_IS_AJAX_PAGE && !defined('PHPFOX_INSTALLER'))
		{
			$oPhpfoxParseOutput = Phpfox::getLib('parse.output');
			$aFind = array(
				'&lt;',
				'&gt;',
				'$'
			);
			$aReplace = array(
				'<',
				'>',
				'&36;'
			);

			foreach ($this->_aMeta as $sMeta => $sMetaValue)
			{
				$sMetaValue = str_replace($aFind, $aReplace, $sMetaValue);
				$sMetaValue = strip_tags($sMetaValue);
				$sMetaValue = str_replace(array("\n", "\r"), "", $sMetaValue);		
				$bIsCustomMeta = false;
						
				switch ($sMeta)
				{
					case 'keywords':						
						$sKeywordSearch = Phpfox::getParam('core.words_remove_in_keywords');
						if (!empty($sKeywordSearch))
						{
							$aKeywordsSearch = array_map('trim', explode(',', $sKeywordSearch));							
						}
						$sMetaValue = $oPhpfoxParseOutput->shorten($oPhpfoxParseOutput->clean($sMetaValue), Phpfox::getParam('core.meta_keyword_limit'));
						
						$sMetaValue = trim(rtrim(trim($sMetaValue), ','));
						$aParts = explode(',', $sMetaValue);
						$sMetaValue = '';
						$aKeywordCache = array();
						foreach ($aParts as $sPart)
						{
							$sPart = trim($sPart);
							
							if (isset($aKeywordCache[$sPart]))
							{
								continue;
							}
							
							if (isset($aKeywordsSearch) && in_array(strtolower($sPart), array_map('strtolower', $aKeywordsSearch)))
							{
								continue;
							}
							
							$sMetaValue .= $sPart . ', ';
							
							$aKeywordCache[$sPart] = true;
						}
						$sMetaValue = rtrim(trim($sMetaValue), ',');
						break;
					case 'description':
						$bHasNoDescription = true;
						$sMetaValue = $oPhpfoxParseOutput->shorten($oPhpfoxParseOutput->clean($sMetaValue), Phpfox::getParam('core.meta_description_limit'));
						break;
					case 'robots':
						$bIsCustomMeta = false;
						break;
					default:
						$bIsCustomMeta = true;
						break;
				}
				$sMetaValue = str_replace('"', '\"', $sMetaValue);
				$sMetaValue = Phpfox::getLib('locale')->convert($sMetaValue);				
				$sMetaValue = html_entity_decode($sMetaValue, null, 'UTF-8');
				$sMetaValue = str_replace(array('<', '>'), '', $sMetaValue);	
					
				if ($bIsCustomMeta)
				{
					if ($sMeta == 'og:description')
					{
						$sMetaValue = $oPhpfoxParseOutput->shorten($oPhpfoxParseOutput->clean($sMetaValue), Phpfox::getParam('core.meta_description_limit'));
					}
					
					switch ($sMeta)
					{
						case 'canonical':
							$sCanonical = $sMetaValue;
							$sCanonical = preg_replace('/\/when\_([a-zA-Z0-9\-]+)\//i', '/', $sCanonical);
							$sCanonical = preg_replace('/\/show\_([a-zA-Z0-9\-]+)\//i', '/', $sCanonical);
							$sCanonical = preg_replace('/\/view\_\//i', '/', $sCanonical);
							
							if (Phpfox::isMobile())
							{
								if (Phpfox::getParam('core.url_rewrite') == '1')
								{
									$sCanonical = str_replace(Phpfox::getParam('core.path') . 'mobile/', Phpfox::getParam('core.path'), $sMetaValue);
								}								
								elseif (Phpfox::getParam('core.url_rewrite') == '2')
								{
									$sCanonical = str_replace('?' . PHPFOX_GET_METHOD . '=/mobile/', '?' . PHPFOX_GET_METHOD . '=/', $sMetaValue);
								}
							}
														
							$sData .= "\t\t<link rel=\"canonical\" href=\"{$sCanonical}\" />\n";
							
							if (!Phpfox::isMobile())
							{
								$sMobileReplace = '';
								if (Phpfox::getParam('core.url_rewrite') == '1')
								{
									$sMobileReplace = str_replace(Phpfox::getParam('core.path'), Phpfox::getParam('core.path') . 'mobile/', $sCanonical);
								}								
								elseif (Phpfox::getParam('core.url_rewrite') == '2')
								{
									$sMobileReplace = str_replace('?' . PHPFOX_GET_METHOD . '=/', '?' . PHPFOX_GET_METHOD . '=/mobile/', $sCanonical);
								}
															
								$sData .= "\t\t<link rel=\"alternate\" media=\"only screen and (max-width: 640px)\" href=\"{$sMobileReplace}\" />\n";
							}
							break;
						default:
							$sData .= "\t\t<meta property=\"{$sMeta}\" content=\"{$sMetaValue}\" />\n";
							break;
					}
						
				}
				else 
				{
					if (strpos($sData, 'meta name="'. $sMeta . '"') !== false)
					{
						$sData = preg_replace("/<meta name=\"{$sMeta}\" content=\"(.*?)\" \/>\n\t/i", "<meta" . ($sMeta == 'description' ? ' property="og:description" ' : '') . " name=\"{$sMeta}\" content=\"" . $sMetaValue . "\" />\n\t", $sData);
						
					}
					else
					{
						$sData = preg_replace('/<meta/', '<meta name="'. $sMeta . '" content="' . $sMetaValue . '" />' . "\n\t\t" . '<meta', $sData, 1);
					}
				}
				
			}

			if (!$bHasNoDescription)
			{
				$sData .= "\t\t" . '<meta name="description" content="' . Phpfox::getLib('parse.output')->clean(Phpfox::getLib('locale')->convert(Phpfox::getParam('core.description'))) . '" />' . "\n";
			}
		}

		// Clear from memory
		$this->_aHeaders = array();		
		$this->_aMeta = array();

		if (isset($bLoadCustomThemeOverwrite))
		{
			$sData .= "\t\t" . '<link rel="stylesheet" type="text/css" href="' . Phpfox::getParam('core.rackspace_url') . 'file/static/' . $aCss['css_data_original'] . '" />' . "\n";
		}
		
		return $sData;
	}

	/**
	 * Get the template header file if it exists.
	 *
	 * @return mixed File path if it exists, otherwise FALSE.
	 */
	public function getHeaderFile()
	{
		$sFile = $this->getStyle('php', 'header.php');		
		$sFile = str_replace(Phpfox::getParam('core.path'), PHPFOX_DIR, $sFile);
		
		if (file_exists($sFile))
		{
			return $sFile;
		}
		
		return false;
	}	
	
	/**
	 * Gets the full path of a file based on the current style being used.
	 *
	 * @param string $sType Type of file we are working with.
	 * @param string $sValue File name.
	 * @param string $sModule Module name. Only if its part of a module.
	 * @return string Returns the full path to the item.
	 */
	public function getStyle($sType = 'css', $sValue = null, $sModule = null)
	{		
		if ($sModule !== null)
		{
			if ($sType == 'static_script')
			{
				$sType = 'jscript';
			}
			
			$sUrl = Phpfox::getParam('core.path') . 'module/' . $sModule . '/static/' . $sType . '/';
			$sDir = PHPFOX_DIR_MODULE . $sModule . PHPFOX_DS . 'static' . PHPFOX_DS . $sType . PHPFOX_DS;
			
			if ($sType == 'jscript')
			{
				$sPath = $sUrl . $sValue; 	
			}
			else
			{
				$bPass = false;			
				if (file_exists($sDir . $this->_sThemeFolder . PHPFOX_DS . $this->_sStyleFolder . PHPFOX_DS . $sValue))
				{
					$bPass = true;
					$sPath = $sUrl . $this->_sThemeFolder . '/' . $this->_sStyleFolder . '/' . $sValue;
				}	
				
				if ($bPass === false)
				{
					$sPath = $sUrl . 'default/default/' . $sValue;	
				}
			}
			
			return $sPath;		
		}
		
		if ($sType == 'static_script')
		{			
			$sPath = Phpfox::getParam('core.url_static_script') . $sValue; 	
		}
		else
		{				
			$sPath = (defined('PHPFOX_INSTALLER') ? Phpfox_Installer::getHostPath() : Phpfox::getParam('core.path')) . 'theme/' . $this->_sThemeLayout . '/' . $this->_sThemeFolder . '/style/' . $this->_sStyleFolder . '/' . $sType . '/';
			if ($sPlugin = Phpfox_Plugin::get('library_template_getstyle_1')){eval($sPlugin);if (isset($bReturnFromPlugin)) return $bReturnFromPlugin;}
			if ($sValue !== null)
			{			
				$bPass = false;
		
				if (isset($this->_aTheme['style_parent_id']) && $this->_aTheme['style_parent_id'] > 0)
				{
					$bPass = false;				
					if (file_exists(PHPFOX_DIR . 'theme' . PHPFOX_DS . $this->_sThemeLayout . PHPFOX_DS . $this->_sThemeFolder . PHPFOX_DS . 'style' . PHPFOX_DS . $this->_sStyleFolder . PHPFOX_DS . $sType . PHPFOX_DS . $sValue))
					{
						$bPass = true;
						$sPath = Phpfox::getParam('core.path') . 'theme' . '/' . $this->_sThemeLayout . '/' . $this->_sThemeFolder . '/' . 'style' . '/' . $this->_sStyleFolder . '/' . $sType . '/' . $sValue;
					}
	
					if (isset($this->_aTheme['parent_theme_folder']))
					{
						if ($bPass === false && file_exists(PHPFOX_DIR . 'theme' . PHPFOX_DS . $this->_sThemeLayout . PHPFOX_DS . $this->_aTheme['parent_theme_folder'] . PHPFOX_DS . 'style' . PHPFOX_DS . $this->_aTheme['parent_style_folder'] . PHPFOX_DS . $sType . PHPFOX_DS . $sValue))
						{
							$bPass = true;
							$sPath = Phpfox::getParam('core.path') . 'theme' . '/' . $this->_sThemeLayout . '/' . $this->_aTheme['parent_theme_folder'] . '/' . 'style' . '/' . $this->_aTheme['parent_style_folder'] . '/' . $sType . '/' . $sValue;
						}						
					}
					else 
					{					
						if ($bPass === false && file_exists(PHPFOX_DIR . 'theme' . PHPFOX_DS . $this->_sThemeLayout . PHPFOX_DS . $this->_sThemeFolder . PHPFOX_DS . 'style' . PHPFOX_DS . $this->_aTheme['parent_style_folder'] . PHPFOX_DS . $sType . PHPFOX_DS . $sValue))
						{
							$bPass = true;
							$sPath = Phpfox::getParam('core.path') . 'theme' . '/' . $this->_sThemeLayout . '/' . $this->_sThemeFolder . '/' . 'style' . '/' . $this->_aTheme['parent_style_folder'] . '/' . $sType . '/' . $sValue;
						}					
					}
				}	
				else 
				{
					if (!defined('PHPFOX_INSTALLER'))
					{
						if (file_exists(PHPFOX_DIR . 'theme' . PHPFOX_DS . $this->_sThemeLayout . PHPFOX_DS . $this->_sThemeFolder . PHPFOX_DS . 'style' . PHPFOX_DS . $this->_sStyleFolder . PHPFOX_DS . $sType . PHPFOX_DS . $sValue))
						{
							$bPass = true;
							$sPath = Phpfox::getParam('core.path') . 'theme' . '/' . $this->_sThemeLayout . '/' . $this->_sThemeFolder . '/' . 'style' . '/' . $this->_sStyleFolder . '/' . $sType . '/' . $sValue;
						}				
					}
				}
	
				if ($bPass === false)
				{
					if (defined('PHPFOX_INSTALLER'))
					{
						$sPath = (defined('PHPFOX_INSTALLER') ? Phpfox_Installer::getHostPath() : Phpfox::getParam('core.path')) . 'theme' . '/' . $this->_sThemeLayout . '/' . 'default' . '/' . 'style' . '/' . 'default' . '/' . $sType . '/' . $sValue;						
					}
					else
					{
						if (file_exists(PHPFOX_DIR . 'theme' . '/' . $this->_sThemeLayout . '/' . 'default' . '/' . 'style' . '/' . 'default' . '/' . $sType . '/' . $sValue))
						{
							$sPath = Phpfox::getParam('core.path') . 'theme' . '/' . $this->_sThemeLayout . '/' . 'default' . '/' . 'style' . '/' . 'default' . '/' . $sType . '/' . $sValue;
						}
						else
						{
							if (file_exists(PHPFOX_DIR . 'theme' . '/frontend/' . $this->_sThemeFolder . '/' . 'style' . '/' . $this->_sStyleFolder . '/' . $sType . '/' . $sValue))
							{
								$sPath = Phpfox::getParam('core.path') . 'theme' . '/frontend/' . $this->_sThemeFolder . '/' . 'style' . '/' . $this->_sStyleFolder . '/' . $sType . '/' . $sValue;
							}
							else
							{
								$sPath = Phpfox::getParam('core.path') . 'theme' . '/frontend/' . 'default' . '/' . 'style' . '/' . 'default' . '/' . $sType . '/' . $sValue;
							}
						}
					}					
				}				
			}			
		}
		
		return $sPath;
	}	
	
	/**
	 * Assign a variable so we can use it within an HTML template.
	 * 
	 * PHP assign:
	 * <code>
	 * Phpfox::getLib('template')->assign('foo', 'bar');
	 * </code>
	 * 
	 * HTML usage:
	 * <code>
	 * {$foo}
	 * // Above will output: bar
	 * </code>
	 *
	 * @param mixed $mVars STRING variable name or ARRAY of variables to assign with both keys and values.
	 * @param string $sValue Variable value, only if the 1st argument is a STRING.
	 * @return object Returns self.
	 */
	public function assign($mVars, $sValue = '')
	{
		if (!is_array($mVars))
		{
			$mVars = array($mVars => $sValue);
		}
	
		foreach ($mVars as $sVar => $sValue)
		{
			$this->_aVars[$sVar] = $sValue;
		}
			
		return $this;
	}
	
	/**
	 * Get a variable we assigned with the method assign().
	 *
	 * @see self::assign()
	 * @param string $sName Variable name.
	 * @return string Variable value.
	 */
	public function getVar($sName)
	{
		return (isset($this->_aVars[$sName]) ? $this->_aVars[$sName] : '');
	}
	
	/**
	 * Clean all or a specific variable from memory.
	 *
	 * @param mixed $mName Variable name to destroy, or leave blank to destory all variables or pass an ARRAY of variables to destroy.
	 */
	public function clean($mName = '')
	{
		if ($mName)
		{
			if (!is_array($mName))
			{
				$mName = array($mName);
			}

			foreach ($mName as $sName)
			{
				unset($this->_aVars[$sName]);
			}
			
			return;
		}
		
		unset($this->_aVars);
	}
	
	/**
	 * Loads the current template.
	 *
	 * @param string $sName Layout name.
	 * @param bool $bReturn TRUE to return the template code, FALSE will echo it.
	 * @return mixed STRING if 2nd argument is TRUE. Otherwise NULL.
	 */
	public function getLayout($sName, $bReturn = false)
	{		
		$this->_getFromCache($this->getLayoutFile($sName));

		if ($bReturn)
		{
			return $this->_returnLayout();
		}
	}
	
	/**
	 * Get the full path of the current layout file.
	 *
	 * @param string $sName Name of the layout file.
	 * @return string Full path to the layout file.
	 */
	public function getLayoutFile($sName)
	{		
		$sFile = PHPFOX_DIR_THEME . $this->_sThemeLayout . PHPFOX_DS . $this->_sThemeFolder . PHPFOX_DS . 'template' . PHPFOX_DS . $sName . PHPFOX_TPL_SUFFIX;
		if ($sPlugin = Phpfox_Plugin::get('library_template_getlayoutfile_1')){eval($sPlugin);if (isset($bReturnFromPlugin)) return $bReturnFromPlugin;}
		if (!file_exists($sFile))
		{				
			if ($this->_aTheme['theme_parent_id'] > 0 && !empty($this->_aTheme['parent_theme_folder']))
			{
				$sFile = PHPFOX_DIR_THEME . $this->_sThemeLayout . PHPFOX_DS . $this->_aTheme['parent_theme_folder'] . PHPFOX_DS . 'template' . PHPFOX_DS . $sName . PHPFOX_TPL_SUFFIX;
			}
		}
		
		if (!file_exists($sFile))
		{
			$sFile = PHPFOX_DIR_THEME . $this->_sThemeLayout . PHPFOX_DS . 'default' . PHPFOX_DS . 'template' . PHPFOX_DS . $sName . PHPFOX_TPL_SUFFIX;
		}
		
		if ($this->_sThemeLayout == 'mobile' && !file_exists($sFile))
		{
			$sFile = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . 'default' . PHPFOX_DS . 'template' . PHPFOX_DS . $sName . PHPFOX_TPL_SUFFIX;
		}
				
		return $sFile;
	}	
	
	public function getBuiltFile($sFile)
	{
		$sCacheName = 'block_' . $sFile;
		
		if (!$this->_isCached($sCacheName))
		{
			$mContent = Phpfox::getLib('template')->getTemplateFile($sFile, true);
			if (is_array($mContent))
			{
				$mContent = $mContent[0];
			}
			else
			{
				$mContent = file_get_contents($mContent);
			}			
		
			$oTplCache = Phpfox::getLib('template.cache');
			$oTplCache->compile($this->_getCachedName($sCacheName), $mContent, true);
		}
		
		if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
		{
			$oCache = Phpfox::getLib('cache');
			$sId = $oCache->set(md5($this->_getCachedName($sCacheName)));
			$mContent = $oCache->get($sId);
			eval(' ?>' . $mContent . '<?php ');				
			
			return;
		}		
			
		require($this->_getCachedName($sCacheName));				
	}

	/**
	 * Get the full path to the modular template file we are loading.
	 *
	 * @param string $sTemplate Name of the file.
	 * @param bool $bCheckDb TRUE to check the database if the file exists there.
	 * @return string Full path to the file we are loading.
	 */
	public function getTemplateFile($sTemplate, $bCheckDb = false)
	{
		(($sPlugin = Phpfox_Plugin::get('template_gettemplatefile')) ? eval($sPlugin) : false);

		$aParts = explode('.', $sTemplate);
		
		$sModule = $aParts[0];
		
		if (defined('PHPFOX_INSTALLER') && !Phpfox::isModule('video'))
		{
			return array('', '');
		}		
		
		unset($aParts[0]);		
		
		$sName = implode('.', $aParts);		
		
		$sName = str_replace('.', PHPFOX_DS, $sName);
		
		if (!defined('PHPFOX_INSTALLER') && !defined('PHPFOX_LIVE_TEMPLATES') && $bCheckDb === true)
		{			
			$oDb = Phpfox::getLib('database');
			$aTemplate = $oDb->select('html_data')
				->from(Phpfox::getT('theme_template'))
				->where("folder = '" . $this->_sThemeFolder . "' AND type_id = '" . $oDb->escape($aParts[1]) . "' AND module_id = '" . $oDb->escape($sModule) . "' AND name = '" . $oDb->escape($aParts[2]) . (isset($aParts[3]) ? '/' . $aParts[3] : ''). PHPFOX_TPL_SUFFIX . "'")
				->execute('getSlaveRow');	

			if (!empty($aTemplate))
			{
				return array($aTemplate['html_data']);
			}
		}		
		
		$bPass = false;		
		if (file_exists(PHPFOX_DIR_MODULE . $sModule . PHPFOX_DIR_MODULE_TPL . PHPFOX_DS . $this->_sThemeFolder . PHPFOX_DS . $sName . PHPFOX_TPL_SUFFIX))
		{
			$sFile = PHPFOX_DIR_MODULE . $sModule . PHPFOX_DIR_MODULE_TPL . PHPFOX_DS . $this->_sThemeFolder . PHPFOX_DS . $sName . PHPFOX_TPL_SUFFIX;
			$bPass = true;
		}
		
		if ($bPass === false && file_exists(PHPFOX_DIR_MODULE . $sModule . PHPFOX_DIR_MODULE_TPL . PHPFOX_DS . $this->_sThemeFolder . PHPFOX_DS . $sName . PHPFOX_TPL_SUFFIX))
		{
			$sFile = PHPFOX_DIR_MODULE . $sModule . PHPFOX_DIR_MODULE_TPL . PHPFOX_DS . $this->_sThemeFolder . PHPFOX_DS . $sName . PHPFOX_TPL_SUFFIX;			
			$bPass = true;		
		}		
		
		if ($bPass === false && isset($aParts[2]) && file_exists(PHPFOX_DIR_MODULE . $sModule . PHPFOX_DIR_MODULE_TPL . PHPFOX_DS . $this->_sThemeFolder . PHPFOX_DS . $sName . PHPFOX_DS . $aParts[2] . PHPFOX_TPL_SUFFIX))
		{
			$sFile =  PHPFOX_DIR_MODULE . $sModule . PHPFOX_DIR_MODULE_TPL . PHPFOX_DS . $this->_sThemeFolder . PHPFOX_DS . $sName . PHPFOX_DS . $aParts[2] . PHPFOX_TPL_SUFFIX;				
			$bPass = true;
		}

		if (isset($this->_aTheme['theme_parent_id']) && $this->_aTheme['theme_parent_id'] > 0 && !empty($this->_aTheme['parent_theme_folder']))
		{			
			if ($bPass === false && file_exists(PHPFOX_DIR_MODULE . $sModule . PHPFOX_DIR_MODULE_TPL . PHPFOX_DS . $this->_aTheme['parent_theme_folder'] . PHPFOX_DS . $sName . PHPFOX_TPL_SUFFIX))
			{
				$sFile =  PHPFOX_DIR_MODULE . $sModule . PHPFOX_DIR_MODULE_TPL . PHPFOX_DS . $this->_aTheme['parent_theme_folder'] . PHPFOX_DS . $sName . PHPFOX_TPL_SUFFIX;
				$bPass = true;
			}
						
			if ($bPass === false && file_exists(PHPFOX_DIR_MODULE . $sModule . PHPFOX_DIR_MODULE_TPL . PHPFOX_DS . $this->_aTheme['parent_theme_folder'] . PHPFOX_DS . $sName . PHPFOX_TPL_SUFFIX))
			{			
				$sFile =  PHPFOX_DIR_MODULE . $sModule . PHPFOX_DIR_MODULE_TPL . PHPFOX_DS . $this->_aTheme['parent_theme_folder'] . PHPFOX_DS . $sName . PHPFOX_TPL_SUFFIX;			
				$bPass = true;
			}

			if ($bPass === false && isset($aParts[2]) && file_exists(PHPFOX_DIR_MODULE . $sModule . PHPFOX_DIR_MODULE_TPL . PHPFOX_DS . $this->_aTheme['parent_theme_folder'] . PHPFOX_DS . $sName . PHPFOX_DS . $aParts[2] . PHPFOX_TPL_SUFFIX))		
			{
				$sFile =  PHPFOX_DIR_MODULE . $sModule . PHPFOX_DIR_MODULE_TPL . PHPFOX_DS . $this->_aTheme['parent_theme_folder'] . PHPFOX_DS . $sName . PHPFOX_DS . $aParts[2] . PHPFOX_TPL_SUFFIX;				
				$bPass = false;
			}	
		}		
		
		if (!isset($sFile))
		{
			$sFile = PHPFOX_DIR_MODULE . $sModule . PHPFOX_DIR_MODULE_TPL . PHPFOX_DS . 'default' . PHPFOX_DS . $sName . PHPFOX_TPL_SUFFIX;	
		}
		
		if (!file_exists($sFile))
		{
			Phpfox_Error::trigger('Unable to load module template: ' . $sModule .'->' . $sName, E_USER_ERROR);				
		}		
		
		return $sFile;
	}

	/**
	 * Get a template that has already been built.
	 *
	 * @param string $sLayout Template name.
	 * @param string $sCacheName Cache name of the file. 
	 * @return string HTML layout of the file.
	 */
	public function getBuiltTemplate($sLayout, $sCacheName)
	{		
		if (!$this->_isCached($sCacheName))
		{
			if (!defined('PHPFOX_INSTALLER') && !defined('PHPFOX_LIVE_TEMPLATES') && $this->_bIsAdminCp === false)
			{						
				$oDb = Phpfox::getLib('database');					
				$aTemplate = $oDb->select('html_data')
					->from(Phpfox::getT('theme_template'))
					->where("folder = '" . $this->_sThemeFolder . "' AND type_id = 'layout' AND name = '" . $oDb->escape($sLayout) . ".html.php'")
					->execute('getSlaveRow');				
			}							

			$sLayoutContent = (isset($aTemplate['html_data']) ? $aTemplate['html_data'] : file_get_contents($this->getLayoutFile($sLayout)));
				
			$sLayoutContent = str_replace('{layout_content}', '<?php echo $this->_aVars[\'sContent\']; ?>', $sLayoutContent);
				
			$oTplCache = Phpfox::getLib('template.cache');
			$oTplCache->compile($this->_getCachedName($sCacheName), $sLayoutContent, true);
		}
		
		$sOriginalContent = ob_get_contents();
		
		ob_clean();
		
		require($this->_getCachedName($sCacheName));	
							
		$sCurrentContent = $this->_returnLayout();
		
		echo $sOriginalContent;
		
		return $sCurrentContent;
	}

	/**
	 * Get the current template data.
	 *
	 * @param string $sTemplate Template name.
	 * @param bool $bReturn TRUE to return its content or FALSE to just echo it.
	 * @return mixed STRING content only if the 2nd argument is TRUE.
	 */
	public function getTemplate($sTemplate, $bReturn = false)
	{	
		(($sPlugin = Phpfox_Plugin::get('template_gettemplate')) ? eval($sPlugin) : false);
		
		$sFile = $this->getTemplateFile($sTemplate);
		
		if ($bReturn)
		{
			$sOriginalContent = ob_get_contents();
			
			ob_clean();
		}

		if ($this->_sSetLayout)
		{			
			if (!$this->_isCached($sFile))
			{
				if (!defined('PHPFOX_INSTALLER') && !defined('PHPFOX_LIVE_TEMPLATES') && $this->_bIsAdminCp === false)
				{						
					$oDb = Phpfox::getLib('database');					
					
					$aTemplate = $oDb->select('html_data')
						->from(Phpfox::getT('theme_template'))
						->where("folder = '" . $this->_sThemeFolder . "' AND type_id = 'layout' AND name = '" . $oDb->escape($this->_sSetLayout) . ".html.php'")
						->execute('getSlaveRow');						
				}				

				$sLayoutContent = (isset($aTemplate['html_data']) ? $aTemplate['html_data'] : file_get_contents($this->getLayoutFile($this->_sSetLayout)));
				$sName = $this->_getCachedName($sFile);
				
				if (!defined('PHPFOX_INSTALLER') && !defined('PHPFOX_LIVE_TEMPLATES'))
				{
					if (preg_match("/(.*?)template_(.*?)_template_(.*?)_(.*?)_(.*?)\.php$/i", $this->_getCachedName($sFile), $aMatches) && isset($aMatches[5]) && !preg_match("/admincp_(.*?)/", $aMatches[4]))
					{				
						$oDb = Phpfox::getLib('database');
						$aSubTemplate = $oDb->select('html_data')
							->from(Phpfox::getT('theme_template'))
							->where("folder = '" . $this->_sThemeFolder . "' AND type_id = '" . $oDb->escape($aMatches[4]) . "' AND module_id = '" . $oDb->escape($aMatches[2]) . "' AND name = '" . $oDb->escape(str_replace('_', '/', $aMatches[5])) . "'")
							->execute('getSlaveRow');
					}				
					elseif (preg_match("/(.*?)template_(.*?)_(.*?)_template_(.*?)\.php$/i", str_replace('template/', 'template_', $sName), $aMatches) && isset($aMatches) && $aMatches[2] == 'frontend')
					{			
						$oDb = Phpfox::getLib('database');				
						$aSubTemplate = $oDb->select('html_data')
							->from(Phpfox::getT('theme_template'))
							->where("folder = '" . $this->_sThemeFolder . "' AND type_id = 'layout' AND name = '" . $oDb->escape($aMatches[4]) . "'")
							->execute('getSlaveRow');				
					}
					elseif (preg_match("/(.*?)template_(.*?)_template_(.*?)_(.*?)_(.*?)\.php$/i", str_replace('template/', 'template_', $sName), $aMatches) && isset($aMatches[5]) && !preg_match("/admincp_(.*?)/", $aMatches[4]))
					{
						$oDb = Phpfox::getLib('database');

						$aSubTemplate = $oDb->select('html_data')
							->from(Phpfox::getT('theme_template'))
							->where("folder = '" . $this->_sThemeFolder . "' AND type_id = '" . $oDb->escape($aMatches[4]) . "' AND module_id = '" . $oDb->escape($aMatches[2]) . "' AND name = '" . $oDb->escape(str_replace('_', '/', $aMatches[5])) . "'")
							->execute('getSlaveRow');				
					}				
				}
				
				$sLayoutContent = str_replace('{layout_content}', (isset($aSubTemplate['html_data']) ? $aSubTemplate['html_data'] : file_get_contents($sFile)), $sLayoutContent);
				
				$oTplCache = Phpfox::getLib('template.cache');
				
				$oTplCache->compile($this->_getCachedName($sFile), $sLayoutContent, true, (isset($aSubTemplate['html_data']) ? true : false));
			}
			
			$this->_sSetLayout = '';
			$this->_requireFile($sFile);
			$this->_sSetLayout = '';		
		}
		else
		{
			$this->_getFromCache($sFile);
		}
		
		if ($bReturn)
		{	
			$sReturn = $this->_returnLayout();
			
			echo $sOriginalContent;
			
			return $sReturn;
		}
	}	
	
	/**
	 * Rebuild a cached menu.
	 *
	 * @param string $sConnection Menu connection.
	 * @param array $aNewUrl ARRAY of the new values.
	 * @return object Return self.
	 */
	public function rebuildMenu($sConnection, $aNewUrl)
	{		
		$this->_aNewUrl[$sConnection] = $aNewUrl;
				
		return $this;
	}

	/**
	 * Remove a URL from a built cached menu.
	 *
	 * @param string $sConnection Menu connection.
	 * @param string $sUrl URL value to identify what menu to remove.
	 * @return object Return self.
	 */
	public function removeUrl($sConnection, $sUrl)
	{
		$this->_aRemoveUrl[$sConnection][$sUrl] = true;
		
		return $this;
	}
	
	/**
	 * Gets all the sites custom menus, such as the Main, Header, Footer and Sub menus.
	 * Since information is stored in the database we cache the information so we only run
	 * the query once. 
	 *
	 * @param sting $sConnection Current page we are viewing (Example: account/login)
	 * @return array $aMenus Is an array of the menus data
	 */
	public function getMenu($sConnection = null)
	{
		$oCache = Phpfox::getLib('cache');
		$oDb = Phpfox::getLib('database');
		$oReq = Phpfox::getLib('request');
		
		(($sPlugin = Phpfox_Plugin::get('template_template_getmenu_1')) ? eval($sPlugin) : false);
		$aMenus = array();		
		
		$bIsModulePage = false;
		if ($sConnection === null)
		{
			$sConnection = Phpfox::getLib('module')->getFullControllerName();
			$bIsModulePage = true;

			$sConnection = preg_replace('/(.*)\.profile/i', '\\1.index', $sConnection);
			
			if (($sConnection == 'user.photo' && $oReq->get('req3') == 'register') || ($sConnection == 'invite.index' && $oReq->get('req2') == 'register'))
			{
				return array();
			}
		}		
		//$sConnection = strtolower($sConnection);			
		$sConnection = strtolower(str_replace('/','.',$sConnection));			
		if ($sConnection == 'profile.private')
		{
			return array();
		}		
		
		$sCachedId = $oCache->set(array('theme', 'menu_' . str_replace(array('/', '\\'), '_', $sConnection) . (Phpfox::isUser() ? Phpfox::getUserBy('user_group_id') : 0)));
		
		if ((!($aMenus = $oCache->get($sCachedId))) && is_bool($aMenus) && !$aMenus)
		{
			$aParts = explode('.', $sConnection);		
			$aMenus1 = $this->_getMenu($sConnection);	
			$aCached = array();
			foreach ($aMenus1 as $aMenu1)
			{
				$aCached[] = $aMenu1['menu_id'];
			}			
			
			$aMenus2 = $this->_getMenu($aParts[0]);		
			foreach ($aMenus2 as $iKey => $aMenu2)
			{
				if (in_array($aMenu2['menu_id'], $aCached))
				{
					unset($aMenus2[$iKey]);
				}
			}			
				
			$aFinal = array_merge($aMenus1, $aMenus2);			
			
			$aMenus = array();
			foreach ($aFinal as $aMenu)
			{				
				// test if this menu points to a real location				
				if (isset($aMenu['url']) && !empty($aMenu['url']) && strpos($aMenu['url'], 'http') !== false)
				{
					$aMenu['external'] = true;
					
				}
				else if (isset($aMenu['url']) && $aMenu['url'] == '#')
				{
					$aMenu['no_link'] = true;
				}
				// $aChildren1 = array();				
				if ($aMenu['parent_id'] > 0)
				{
					continue;
				}
				
				/*
				if ($aMenu['m_connection'] == 'main' || $aMenu['m_connection'] == 'main_right' || $aMenu['m_connection'] == 'application')
				{
					$aChildParts = explode('.', $aMenu['url']);
					$aChildren1 = $this->_getMenu('', $aMenu['menu_id']);												
				}
				
				$aMenu['children'] = $aChildren1;
				 * 
				 */
				
				$aMenus[$aMenu['menu_id']] = $aMenu;
			}
			
			$aParents = Phpfox::getLib('database')->select('m.menu_id, m.parent_id, m.m_connection, m.var_name, m.disallow_access, mo.module_id AS module, m.url_value AS url, mo.is_active AS module_is_active')
				->from(Phpfox::getT('menu'), 'm')
				->join(Phpfox::getT('module'), 'mo', 'mo.module_id = m.module_id AND mo.is_active = 1')
				->join(Phpfox::getT('product'), 'p', 'm.product_id = p.product_id AND p.is_active = 1')
				->where("m.parent_id > 0 AND m.is_active = 1")
				->order('m.ordering ASC')
				->execute('getRows');
				
			if (count($aParents))
			{
				foreach ($aParents as $aParent)
				{
					if (!isset($aMenus[$aParent['parent_id']]))
					{
						continue;
					}
					
					if (isset($aParent['url']) && $aParent['url'] == 'profile.designer' && Phpfox::getUserParam('profile.can_custom_design_own_profile') == false)
					{
						continue;
					}
					$aMenus[$aParent['parent_id']]['children'][] = $aParent;
				}
			}

            if ($sPlugin = Phpfox_Plugin::get('template_template_getmenu_2')){eval($sPlugin);}
			$oCache->save($sCachedId, $aMenus);
		}				

		if (!is_array($aMenus))
		{
			return array();
		}			

		if ($sConnection == 'main' && Phpfox::isUser())
		{
			$aUserMenusCache = array();
			$sUserMenuCache = Phpfox::getLib('cache')->set(array('user', 'nbselectname_' . Phpfox::getUserId()));
			if (!($aUserMenusCache = Phpfox::getLib('cache')->get($sUserMenuCache)))
			{
				$aUserMenus = Phpfox::getLib('database')->select('*')->from(Phpfox::getT('theme_umenu'))->where('user_id = ' . (int) Phpfox::getUserId())->execute('getSlaveRows');
				foreach ((array) $aUserMenus as $aUserMenu)
				{
					$aUserMenusCache[$aUserMenu['menu_id']] = true;
				}			
				Phpfox::getLib('cache')->save($sUserMenuCache, $aUserMenusCache);
			}
		}
		
		foreach ($aMenus as $iKey => $aMenu)
		{	
			if (Phpfox::getParam('core.phpfox_is_hosted') && isset($aMenu['module']) && !Phpfox::isModule($aMenu['module']))
			{
				unset($aMenus[$iKey]);
				
				continue;
			}
			
			if (Phpfox::getParam('core.phpfox_is_hosted') 
				&& $sConnection == 'main'
				&& $aMenu['url'] == 'forum'
			)
			{
				unset($aMenus[$iKey]);
				
				continue;
			}
			
			if (substr($aMenu['url'], 0, 1) == '#')
			{
				$aMenus[$iKey]['css_name'] = 'js_core_menu_' . str_replace('#', '', str_replace('-', '_', $aMenu['url']));
			}
			
			if (($aMenu['url'] == 'ad' || $aMenu['url'] == 'ad.index') && !Phpfox::getUserParam('ad.can_create_ad_campaigns'))
			{
				unset($aMenus[$iKey]);
				
				continue;					
			}
			
			if ($aMenu['url'] == 'mail.compose' && Phpfox::getUserParam('mail.restrict_message_to_friends') && !Phpfox::isModule('friend'))
			{
				unset($aMenus[$iKey]);
				
				continue;									
			}
			
			if (isset($aUserMenusCache[$aMenu['menu_id']]))
			{
				$aMenus[$iKey]['is_force_hidden'] = true;
			}
/*
			if (Phpfox::isModule('pages') && (Phpfox::getService('pages')->isViewMode() || defined('PHPFOX_IS_PAGES_VIEW')) && $aMenu['url'] == 'photo.add')
			{
				$aPage = Phpfox::getService('pages')->getPage();

				$aMenus[$iKey]['url'] = 'photo.add.module_pages.item_' . $aPage['page_id'];
			}
*/
			// Bug: http://www.phpfox.com/tracker/view/14383/
			if(defined('PHPFOX_IS_PAGES_VIEW'))
			{
				if (Phpfox::isModule('pages') && $aMenu['url'] == 'blog.add')
				{
					$iPage = $this->_aVars['aPage']['page_id'];

					$aMenus[$iKey]['url'] = 'blog.add.module_pages.item_' . $iPage;
				}
				if (Phpfox::isModule('pages') && $aMenu['url'] == 'event.add')
				{
					$iPage = $this->_aVars['aPage']['page_id'];

					$aMenus[$iKey]['url'] = 'event.add.module_pages.item_' . $iPage;
				}
				if (Phpfox::isModule('pages') && $aMenu['url'] == 'music.add')
				{
					$iPage = $this->_aVars['aPage']['page_id'];

					$aMenus[$iKey]['url'] = 'music.add.module_pages.item_' . $iPage;
				}
				if (Phpfox::isModule('pages') && $aMenu['url'] == 'video.add')
				{
					$iPage = $this->_aVars['aPage']['page_id'];

					$aMenus[$iKey]['url'] = 'video.add.module_pages.item_' . $iPage;
				}
				if (Phpfox::isModule('pages') && $aMenu['url'] == 'photo.add')
				{
					$iPage = $this->_aVars['aPage']['page_id'];

					$aMenus[$iKey]['url'] = 'photo.add.module_pages.item_' . $iPage;
				}
			}
			
			if (($aMenu['url'] == $oReq->get('req1')) || 
				(empty($aMenu['url']) && $oReq->get('req1') == PHPFOX_MODULE_CORE) || 
				($this->_sUrl !== null && $this->_sUrl == $aMenu['url']) || 
				(str_replace('/','.',$oReq->get('req1').$oReq->get('req2')) == str_replace('.','',$aMenu['url'])))
			{				
				$aMenus[$iKey]['is_selected'] = true;
			}			
			
			if ($aMenu['url'] == 'admincp')
			{
				if (!Phpfox::isAdmin())
				{
					unset($aMenus[$iKey]);
					
					continue;
				}
			}
			else 
			{				
				if (!empty($aMenu['disallow_access']))
				{
					$aUserGroups = unserialize($aMenu['disallow_access']);			
					if (in_array(Phpfox::getUserBy('user_group_id'), $aUserGroups))
					{
						unset($aMenus[$iKey]);
						
						continue;
					}
				}	
				
				if (isset($aMenu['children']) && is_array($aMenu['children']))
				{
					foreach ($aMenu['children'] as $iChildMenuMain => $aChildMenuMain)
					{						
						if (!empty($aChildMenuMain['disallow_access']))
						{													
							$aUserGroups = unserialize($aChildMenuMain['disallow_access']);			
							if (in_array(Phpfox::getUserBy('user_group_id'), $aUserGroups))
							{								
								unset($aMenus[$iKey]['children'][$iChildMenuMain]);
								
								//break;
							}
						}							
					}
				}				
			}

			if (isset($this->_aNewUrl[$sConnection]))
			{
				$aMenus[$iKey]['url'] = $this->_aNewUrl[$sConnection][0] . '.' . implode('.', $this->_aNewUrl[$sConnection][1]) . '.' . $aMenu['url'];
			}
			
			if (isset($this->_aRemoveUrl[$sConnection][$aMenu['url']]))
			{
				unset($aMenus[$iKey]);
				
				continue;
			}
			
			if ($sConnection == 'explore')
			{
				$aMenus[$iKey]['module_image'] = $this->getStyle('image', 'module/' . $aMenu['module'] . '.png');
				if (!file_exists(str_replace(Phpfox::getParam('core.path'), PHPFOX_DIR, $aMenus[$iKey]['module_image'])))
				{
					unset($aMenus[$iKey]['module_image']);	
				}
			}
			
			if (isset($aMenu['children']))
			{
				foreach ($aMenu['children'] as $iChildKey => $aChild)
				{
					if ($aChild['m_connection'] == 'video.index' && $aChild['url'] == 'video.upload' && !Phpfox::getParam('video.allow_video_uploading'))
					{
						unset($aMenus[$iKey]['children'][$iChildKey]);						
					}
				}
			}					
		}
				
		return $aMenus;
	}	
	
	/**
	 * Set the current URL for the site.
	 *
	 * @param string $sUrl URL value.
	 * @return object Return self.
	 */
	public function setUrl($sUrl)
	{
		$this->_sUrl = $sUrl;
		
		return $this;
	}
	
	/**
	 * Load and get the XML information about the theme used when custom designing a profile.
	 *
	 * @param string $sXml XML id.
	 * @return string ARRAY of XML data.
	 */
	public function getXml($sXml)
	{
		static $aXml = array();
		
		if (isset($aXml[$sXml]))
		{
			return $aXml[$sXml];
		}
		
		$oCache = Phpfox::getLib('cache');
		$sCacheId = $oCache->set(array('theme', 'theme_xml_' . $this->_sThemeLayout));
		
		if (!($aXml = $oCache->get($sCacheId)))
		{
            $sFile = PHPFOX_DIR_THEME . $this->_sThemeLayout . PHPFOX_DS . $this->_sThemeFolder . PHPFOX_DS . 'xml' . PHPFOX_DS . 'phpfox.xml.php';
            if (!empty($this->_aTheme['parent_theme_folder']) && !file_exists($sFile))
            {
                $sFile = PHPFOX_DIR_THEME . $this->_sThemeLayout . PHPFOX_DS . $this->_aTheme['parent_theme_folder'] . PHPFOX_DS . 'xml' . PHPFOX_DS . 'phpfox.xml.php';
            }            
            
            if (!file_exists($sFile))
            {
            	$sFile = PHPFOX_DIR_THEME . $this->_sThemeLayout . PHPFOX_DS . 'default' . PHPFOX_DS . 'xml' . PHPFOX_DS . 'phpfox.xml.php';
            }
			
			$aXml = Phpfox::getLib('xml.parser')->parse(file_get_contents($sFile));
			
			$oCache->save($sCacheId, $aXml);
		}

		return $aXml[$sXml];
	}	
	
	/**
	 * Build subsection menu. Also assigns all variables to the template for us.
	 *
	 * @param string $sSection Internal section URL string.
	 * @param array $aFilterMenu Array of menu.
	 */
	public function buildSectionMenu($sSection, $aFilterMenu)
	{	
		// Add a hook with return here 
		$sView = Phpfox::getLib('request')->get('view');	
		$aFilterMenuCache = array();		
		$iFilterCount = 0;
		$bHasMenu = false;		
		foreach ($aFilterMenu as $sMenuName => $sMenuLink)
		{
			if (is_numeric($sMenuName))
			{
				$aFilterMenuCache[] = array();
				
				continue;
			}
			$sMenuName = str_replace('phpfox_numeric_friend_list_', '', $sMenuName);
			$bForceActive = false;
			$bIsView = true;
			if (strpos($sMenuLink, '.'))
			{
				$bIsView = false;
			}
			
			$iFilterCount++;
			
			if ($bIsView)
			{
				if ($sView == $sMenuLink && $bHasMenu === false)
				{
					$bHasMenu = true;	
				}

				if (!empty($sView) && $sView == $sMenuLink)
				{
					$this->setTitle(preg_replace('/<span(.*)>(.*)<\/span>/i', '', $sMenuName));
					$this->setBreadcrumb(preg_replace('/<span(.*)>(.*)<\/span>/i', '', $sMenuName), Phpfox::getLib('url')->makeUrl($sSection, (empty($sMenuLink) ? array() : array('view' => $sMenuLink))), true);
				}				
			}
			else 
			{				
				if ((empty($sView) && str_replace('/', '.', Phpfox::getLib('url')->getUrl()) == $sMenuLink) 
					|| (!empty($sView) && str_replace('/', '.', Phpfox::getLib('url')->getUrl()) . '.view_' . $sView == $sMenuLink) || (Phpfox::getLib('module')->getFullControllerName() == $sMenuLink)
					|| (!empty($sView) && Phpfox::getLib('url')->getUrl() . '.view_' . $sView . '.id_' . Phpfox::getLib('request')->getInt('id') == $sMenuLink)	
					|| (!empty($sView) && preg_match('/\/view_' . $sView . '\//i', $sMenuLink))
				)
				{					
					$bHasMenu = true;
					$bForceActive = true;

					$this->setTitle(preg_replace('/<span(.*)>(.*)<\/span>/i', '', $sMenuName));
					// $this->setBreadcrumb(preg_replace('/<span(.*)>(.*)<\/span>/i', '', $sMenuName), Phpfox::getLib('url')->makeUrl($sSection, (empty($sMenuLink) ? array() : array('view' => $sMenuLink))), true);
					$this->setBreadcrumb(preg_replace('/<span(.*)>(.*)<\/span>/i', '', $sMenuName), Phpfox::getLib('url')->makeUrl($sMenuLink), true);
					
					foreach ($aFilterMenuCache as $iSubKey => $aFilterMenuCacheRow)
					{
						if (isset($aFilterMenuCache[$iSubKey]['active']) && $aFilterMenuCache[$iSubKey]['active'] === true)
						{
							$aFilterMenuCache[$iSubKey]['active'] = false;	
							break;
						}
					}
				}
			}
			
			$aFilterMenuCache[] = array(
				'name' => $sMenuName,
				'link' => (!$bIsView ? Phpfox::getLib('url')->makeUrl($sMenuLink) : Phpfox::getLib('url')->makeUrl($sSection, (empty($sMenuLink) ? array() : array('view' => $sMenuLink)))),
				'active' => ($bForceActive ? true : ($sView == $sMenuLink ? true : false)),
				'last' => (count($aFilterMenu) === $iFilterCount ? true : false)
			);
		}
		
		if (!$bHasMenu && isset($aFilterMenuCache[0]))
		{
			$aFilterMenuCache[0]['active'] = true;
		}

		$this->assign(array(
				'aFilterMenus' => $aFilterMenuCache,
			)
		);	
	}
	
	/**
	 * Gets the JavaScript code needed for section menus built with self::buildPageMenu()
	 *
	 * @see self::buildPageMenu()
	 * @return string Returns JS code
	 */
	public function getSectionMenuJavaScript()
	{
		if (!isset($this->_aSectionMenu['name']))
		{
			return '<script type="text/javascript">$Behavior.pageSectionMenuRequest = function() { }</script>';
		}

		if ($this->_aSectionMenu['bIsFullLink'])
		{
			return '<script type="text/javascript">$Behavior.pageSectionMenuRequest = function() { }</script>';
		}		
		
		$sName = $this->_aSectionMenu['name'];
		$aMenu = $this->_aSectionMenu['menu'];
		$aLink = $this->_aSectionMenu['link'];
		
		$sReq = Phpfox::getLib('request')->get('req3');
		if (empty($sReq))
		{
			foreach ($aMenu as $sKey => $sValue)
			{
				$sReq = $sKey;
				break;
			}
		}		

		$sNewReq = preg_replace('/[^a-z\s]/i', '', $sReq);
		if (!empty($sReq))
		{			
			return '<script type="text/javascript">var bIsFirstRun = false; $Behavior.pageSectionMenuRequest = function() { if (!bIsFirstRun) { $Core.pageSectionMenuShow(\'#' . $sName . '_' . $sNewReq . '\'); if ($(\'#page_section_menu_form\').length > 0) { $(\'#page_section_menu_form\').val(\'' . $sName . '_' . $sNewReq . '\'); } bIsFirstRun = true; } }</script>';
		}		
	}
	
	/**
	 * Builds a section menu for adding/editing items
	 *
	 * @param string $sName Name of the menu
	 * @param array $aMenu ARRAY of menus
	 * @param mixed $aLink ARRAY for custom view link, NULL to do nothing
	 */
	public function buildPageMenu($sName, $aMenu, $aLink = null, $bIsFullLink = false)
	{		
		$this->_aSectionMenu = array(
			'name' => $sName,
			'menu' => $aMenu,
			'link' => $aLink,
			'bIsFullLink' => $bIsFullLink
		);
		
		$sPageCurrentUrl = Phpfox::getLib('url')->makeUrl('current');
				
		$this->assign(array(
				'sPageSectionMenuName' => $sName,
				'aPageSectionMenu' => $aMenu,
				'aPageExtraLink' => $aLink,
				'bPageIsFullLink' => $bIsFullLink,
				'sPageCurrentUrl' => $sPageCurrentUrl
			)
		);
	}
	
	/**
	 * This function controls if we should load `content` delayed. It is called from the template.cache library
	 */ 
	public function shouldLoadDelayed($sController)
	{
		$sController = Phpfox::getLib('phpfox.module')->getFullControllerName();

		$bDelayed = false;
		
		// Special case
		if ($sController == 'feed.comment')
		{
			return true;
		}

		if (Phpfox::isAdminPanel())
		{
			return false;
		}

		$aControllers = Phpfox::getParam('core.controllers_to_load_delayed');
		
		if ( (is_array($aControllers) && !empty($aControllers)) &&
			(in_array($sController, $aControllers)) &&
			( (defined('PHPFOX_IS_PAGES_VIEW') && $sController == 'pages.view') || (!defined('PHPFOX_IS_PAGES_VIEW')))
		)
		{
			$bDelayed = true;
		}
		$aSearch = Phpfox::getLib('request')->get('search');
		if (!empty($aSearch))
		{
			$bDelayed = false;
		}

		return $bDelayed;
	}
	
	
	/**
	 * Get a menu.
	 *
	 * @param string $sConnection Connection for the menu.
	 * @param int $iParent Parent ID# number for the menu.
	 * @return array ARRAY of menus.
	 */
	private function _getMenu($sConnection = null, $iParent = 0)
	{		
		return Phpfox::getLib('database')->select('m.menu_id, m.parent_id, m.m_connection, m.var_name, m.disallow_access, mo.module_id AS module, m.url_value AS url, mo.is_active AS module_is_active, m.mobile_icon')
			->from(Phpfox::getT('menu'), 'm')
			->join(Phpfox::getT('module'), 'mo', 'mo.module_id = m.module_id AND mo.is_active = 1')
			->join(Phpfox::getT('product'), 'p', 'm.product_id = p.product_id AND p.is_active = 1')
			->where("m.parent_id = " . (int) $iParent . " AND m.m_connection = '" . Phpfox::getLib('database')->escape($sConnection) . "' AND m.is_active = 1")
			->group('m.menu_id')
			->order('m.ordering ASC')
			->execute('getRows');		
	}

	/**
	 * Returns the content of a template that has already been echoed.
	 *
	 * @return unknown
	 */
	private function _returnLayout()
	{
		$sContent = ob_get_contents();
		
		ob_clean();
		
		return $sContent;		
	}
	
	/**
	 * Gets a template file from cache. If the file does not exist we re-cache the template.
	 *
	 * @param string $sFile Full path of the template we are loading.
	 */
	private function _getFromCache($sFile)
	{		
		if (!$this->_isCached($sFile))
		{
			$oTplCache = Phpfox::getLib('template.cache');
	
			$sContent = (file_exists($sFile) ? file_get_contents($sFile) : null);
			
			$mData = $oTplCache->compile($this->_getCachedName($sFile), $sContent);
		}		
		
		// No cache directory so we must 
		if (defined('PHPFOX_INSTALLER_NO_TMP'))
		{
			eval(' ?>' . $mData . '<?php ');
			exit;
		}

		(PHPFOX_DEBUG ? Phpfox_Debug::start('template') : false);		
		$this->_requireFile($sFile);
		(PHPFOX_DEBUG ? Phpfox_Debug::end('template', array('name' => $sFile)) : false);
	}
	
	private function _requireFile($sFile)
	{
		if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
		{
			$oCache = Phpfox::getLib('cache');
			$sId = $oCache->set(md5($this->_getCachedName($sFile)));
			eval('?>' . $oCache->get($sId) . '<?php ');
		}
		else
		{
			require($this->_getCachedName($sFile));
		}		
	}
	
	/**
	 * Checks to see if a template has already been cached or not.
	 *
	 * @param string $sName Full path to the template file.
	 * @return bool TRUE is cached, FALSE is not cached.
	 */
	private function _isCached($sName)
	{		
		if (defined('PHPFOX_NO_TEMPLATE_CACHE'))
		{
			return false;
		}
		
		if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
		{			
			return Phpfox::getLib('cache')->memcache()->append(md5(PHPFOX_IS_HOSTED_SCRIPT . md5($this->_getCachedName($sName))), '');
		}
		
		if (!file_exists($this->_getCachedName($sName)))
		{
			return false;
		}
		
		if (file_exists($sName))
		{
			$iTime = filemtime($sName);
			
			// Check if a file has been updated recently, if it has make sure we return false to we recache it.
			if (($iTime + $this->_iCacheTime) > PHPFOX_TIME)
			{
				return false;
			}		
		}
		
		return true;
	}
	
	/**
	 * Gets the full path of the cached template file
	 * 
	 * @param string $sName Name of the template
	 * @return string Full path to cached template
	 */
	private function _getCachedName($sName)
	{		
		if (!defined('PHPFOX_TMP_DIR'))
		{
			if (!is_dir(PHPFOX_DIR_CACHE . 'template' . PHPFOX_DS))
			{
				mkdir(PHPFOX_DIR_CACHE . 'template' . PHPFOX_DS);
				chmod(PHPFOX_DIR_CACHE . 'template' . PHPFOX_DS, 0777);
			}
		}
		
		return (defined('PHPFOX_IS_HOSTED_SCRIPT') ? PHPFOX_IS_HOSTED_SCRIPT . Phpfox::getCleanVersion() . '' : '') . (defined('PHPFOX_TMP_DIR') ? PHPFOX_TMP_DIR : PHPFOX_DIR_CACHE) . ((defined('PHPFOX_TMP_DIR') || PHPFOX_SAFE_MODE) ? 'template_' : 'template/') . str_replace(array(PHPFOX_DIR_THEME, PHPFOX_DIR_MODULE, PHPFOX_DS), array('', '', '_'), $sName) . (Phpfox::isAdminPanel() ? '_admincp' : '') . (PHPFOX_IS_AJAX ? '_ajax' : '') . '.php';
	}	
	
	private function _register($sType, $sFunction, $sImplementation)
	{
		$this->_aPlugins[$sType][$sFunction] = $sImplementation;
	}
}

?>
