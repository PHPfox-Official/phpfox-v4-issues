<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Global Site Settings
 * Class is used to load and retrieve global settings, which are
 * stored in the database table "setting". Admins can easily modify
 * these settings direct from the AdminCP. The most common interaction
 * with this class is to get a setting value and to do this we use our
 * core static class.
 *
 * Example:
 * <code>
 * Phpfox::getParam('foo.bar');
 * </code>
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: setting.class.php 7095 2014-02-06 16:19:52Z Fern $
 */
class Phpfox_Setting
{
	/**
	 * List of all the settings.
	 *
	 * @var array
	 */
	private $_aParams = array();

	/**
	 * Default settings we load and their values. We only
	 * use this when installing the script the first time
	 * since the database hasn't been installed yet.
	 *
	 * @var array
	 */
	private $_aDefaults = array(
		'core.session_prefix' => 'phpfox',
		'core.title_delim' => '&raquo;',
		'core.site_title' => 'phpFox',
		'core.branding' => false,
		'core.default_lang_id' => 'en',
		'core.default_style_name' => 'konsort',
		'core.default_theme_name' => 'default',
		'language.lang_pack_helper' => false,
		'core.cookie_path' => '/',
		'core.cookie_domain' => '',
		'core.use_gzip' => true,
		'core.url_rewrite' => '2',
		'core.is_installed' => false,
		'user.profile_use_id' => false,
		'user.disable_username_on_sign_up' => false,
		'core.site_copyright' => '',
		'db' => array(
			'prefix' => 'phpfox_',
			'host' => 'localhost',
			'user' => '',
			'pass' => '',
			'name' => '',
			'driver' => 'mysql',
			'slave' => false
		),
		'core.cache_skip' => false,
		'balancer' => array(
			'enabled' => false
		),
		'user.min_length_for_username' => '5',
		'user.max_length_for_username' => '25',
		'core.default_time_zone_offset' => '0',
		'core.identify_dst' => '1',
		'core.global_site_title' => 'phpFox',
		'core.phpfox_is_hosted' => false,
		'core.enabled_edit_area' => false,
		'core.site_wide_ajax_browsing' => false,
		'core.disable_hash_bang_support' => false,
		'core.use_jquery_datepicker' => false,
		'core.date_field_order' => 'MDY',
		'core.cache_storage' => 'file',
		'core.allow_cdn' => false,
		'core.is_auto_hosted' => false,
		'core.store_only_users_in_session' => false,
		'core.cache_js_css' => false,
		'core.ip_check' => 1,
		'profile.profile_caches_user' => false,
		'rate.cache_rate_profiles' => false,
		'core.defer_loading_js' => false,
		'core.use_custom_cookie_names' => false,
		'core.include_site_title_all_pages' => true,
		'core.defer_loading_user_images' => false,
		'core.include_master_files' => false,
		'core.force_secure_site' => false,
		'core.auth_user_via_session' => false,
		'core.defer_loading_images' => false,
		'video.convert_servers_enable' => false
	);

	public $override = [
		'core.site_wide_ajax_browsing' => false,
		'core.use_gzip' => true,
		'core.gzip_level' => 1,
		'core.cache_js_css' => false,
		'core.enable_getid3_check' => false,
		'core.disable_hash_bang_support' => false,
		'core.build_format' => 'Y/m',
		'core.build_file_dir' => true,
		'core.csrf_protection_level' => 'low',
		'user.randomize_featured_members' => false,
		'user.remove_users_hidden_age' => false,
		'user.min_count_for_top_rating' => 0,
		'user.no_show_activity_points' => true,
		'user.split_full_name' => false,
		'user.cache_featured_users' => false,
		'user.cache_user_inner_joins' => false,
		'feed.enable_check_in' => false,
		'feed.cache_timeout' => '0',
		'feed.refresh_activity_feed' => '0',
		'feed.feed_limit_days' => '0',
		'feed.twitter_share_via' => '',
		'feed.force_timeline' => false,
		'feed.can_add_past_dates' => false,
		'feed.timeline_optional' => false,
		'feed.add_feed_for_comments' => false,
		'feed.force_ajax_on_load' => false,
		'feed.cache_each_feed_entry' => false,
		'like.show_user_photos' => false,
		'ad.ad_cache_limit' => 60,
		'ad.ad_ajax_refresh' => false,
		'ad.ad_ajax_refresh_time' => 2,
		'ad.how_many_ads_per_location' => 1,
		'core.log_site_activity' => false,
		'photo.enabled_watermark_on_photos' => false,
		'friend.load_friends_online_ajax' => false,
		'core.auth_user_via_session' => false
	];

	public $hide = [
		'user.user_pic_sizes',
		'user.how_many_featured_members'
	];

	/**
	 * Class constructor. We run checks here to make sure the server setting file
	 * is in place and this is where we can judge if the script has been installed
	 * or not.
	 *
	 */
	public function __construct()
	{
		$_CONF = array();
		$sMessage = 'Oops! phpFox is not installed. Please run the install script to get your community setup.';

		if (defined('PHPFOX_IS_UPGRADE')) {
			$old = PHPFOX_DIR . '../include/setting/server.sett.php';
			if (file_exists($old)) {
				if (is_dir(PHPFOX_DIR_SETTINGS)) {
					copy($old, PHPFOX_DIR_SETTINGS . 'server.sett.php');
				} else {
					$_CONF = [];
					require($old);
				}
			}
		}

		if (file_exists(PHPFOX_DIR_SETTINGS . 'server.sett.php') || count($_CONF))
		{
			if (!count($_CONF)) {
				$_CONF = array();

				require(PHPFOX_DIR_SETTINGS . 'server.sett.php');
			}

			if (!defined('PHPFOX_INSTALLER'))
			{
				if (!isset($_CONF['core.is_installed']))
				{
					Phpfox::getLib('phpfox.api')->message($sMessage);
				}

				if (!$_CONF['core.is_installed'])
				{
					Phpfox::getLib('phpfox.api')->message($sMessage);
				}
			}

			if ($_CONF['core.db_table_installed'] === false && !defined('PHPFOX_SCRIPT_CONFIG'))
			{
				define('PHPFOX_SCRIPT_CONFIG', true);
			}
		}
		else
		{
			define('PHPFOX_SCRIPT_CONFIG', true);
		}

		if ((!isset($_CONF['core.host'])) || (isset($_CONF['core.host']) && $_CONF['core.host'] == 'HOST_NAME'))
		{
			$_CONF['core.host'] = $_SERVER['HTTP_HOST'];
		}

		if ((!isset($_CONF['core.folder'])) || (isset($_CONF['core.folder']) && $_CONF['core.folder'] == 'SUB_FOLDER'))
		{
			$_CONF['core.folder'] = '/';
		}

		if (!defined('PHPFOX_INSTALLER')
			&& $_CONF['core.url_rewrite'] == '1'
			&& !file_exists(PHPFOX_DIR_SETTINGS . 'rewrite.sett.php')
		) {
			$_CONF['core.url_rewrite'] = '2';
		}

		if (!defined('PHPFOX_INSTALLER') && $_CONF['core.url_rewrite'] == '2') {
			$_CONF['core.folder'] = $_CONF['core.folder'] . 'index.php/';
		}

		require_once(PHPFOX_DIR_SETTING . 'common.sett.php');

		if (defined('PHPFOX_INSTALLER'))
		{
			$_CONF['core.path'] = '../';
			$_CONF['core.url_file'] = '../file/';
		}

		if (file_exists(PHPFOX_DIR_SETTING . 'security.sett.php'))
		{
			require_once(PHPFOX_DIR_SETTING . 'security.sett.php');
		}
		else
		{
			require_once(PHPFOX_DIR_SETTING . 'security.sett.php.new');
		}

		$this->_aParams =& $_CONF;

		if (defined('PHPFOX_INSTALLER'))
		{
			$this->_aParams['core.url_rewrite'] = '2';
			// http://www.php.net/manual/en/intro.mysql.php
			if (isset($this->_aParams['db']) && ($this->_aParams['db']['driver'] == 'mysqli') && !function_exists('mysqli_connect'))
			{
				$this->_aParams['db']['driver'] = 'mysql';
			}
		}
	}

	/**
	 * @return Phpfox_Setting
	 */
	public static function instance() {
		return Phpfox::getLib('setting');
	}

	/**
	 * Creates a new setting.
	 *
	 * @param array $mParam ARRAY of settings and values.
	 * @param string $mValue Value of setting if the 1st argument is a string.
	 */
	public function setParam($mParam, $mValue = null)
	{
		if (is_string($mParam))
		{
			$this->_aParams[$mParam] = $mValue;
		}
		else
		{
			foreach ($mParam as $mKey => $mValue)
			{
				$this->_aParams[$mKey] = $mValue;
			}
		}
	}

	/**
	 * Build the setting cache by getting all the settings from the database
	 * and then caching it. This way we only load it from the database
	 * the one time.
	 *
	 */
	public function set()
	{
		if (defined('PHPFOX_INSTALLER') && defined('PHPFOX_SCRIPT_CONFIG'))
		{
			return;
		}

		$oCache = Phpfox::getLib('cache');
		$iId = $oCache->set('setting');

		if (!($aRows = $oCache->get($iId)))
		{
			$aRows = Phpfox_Database::instance()->select('s.type_id, s.var_name, s.value_actual, m.module_id AS module_name')
				->from(Phpfox::getT('setting'), 's')
				->join(Phpfox::getT('module'), 'm', 'm.module_id = s.module_id AND m.is_active = 1')
				->execute('getRows');

			foreach ($aRows as $iKey => $aRow)
			{
				if (in_array($aRow['var_name'], ['wysiwyg'])) {
					continue;
				}

				// Remove unactive module settings
				if (!empty($aRow['module_name']) && !Phpfox::isModule($aRow['module_name']))
				{
					unset($aRows[$iKey]);
					continue;
				}

				if ($aRow['var_name'] == 'allowed_html')
				{
					$aHtmlTags = array();
					$sAllowedTags = $aRow['value_actual'];
					preg_match_all("/<(.*?)>/i", $sAllowedTags, $aMatches);
					if (isset($aMatches[1]))
					{
						foreach ($aMatches[1] as $sHtmlTag)
						{
							$aHtmlParts = explode(' ', $sHtmlTag);
							$sHtmlTag = trim($aHtmlParts[0]);
							$aHtmlTags[$sHtmlTag] = true;
						}
					}

					$aRows[$iKey]['value_actual'] = $aHtmlTags;
				}

				if ($aRow['var_name'] == 'session_prefix')
				{
					$aRows[$iKey]['value_actual'] = $aRow['value_actual'] . substr($this->_aParams['core.salt'], 0, 2) . substr($this->_aParams['core.salt'], -2);
				}

				if ($aRow['var_name'] == 'description' || $aRow['var_name'] == 'keywords')
				{
					$aRows[$iKey]['value_actual'] = strip_tags($aRow['value_actual']);
					$aRows[$iKey]['value_actual'] = str_replace(array("\n", "\r"), "", $aRows[$iKey]['value_actual']);
				}

				// Lets set the correct type
				switch ($aRow['type_id'])
				{
					case 'boolean':
						if (strtolower($aRows[$iKey]['value_actual']) == 'true' || strtolower($aRows[$iKey]['value_actual']) == 'false')
						{
							$aRows[$iKey]['value_actual'] = (strtolower($aRows[$iKey]['value_actual']) == 'true' ? '1' : '0');
						}
						settype($aRows[$iKey]['value_actual'], 'boolean');
						break;
					case 'integer':
						settype($aRows[$iKey]['value_actual'], 'integer');
						break;
					case 'array':
						if (!empty($aRow['value_actual']))
						{
							// Fix unserialize sting length depending on the database driver					
							// $aRow['value_actual'] = preg_replace("/s:(.*):\"(.*?)\";/is", "'s:'.strlen('$2').':\"$2\";'", $aRow['value_actual']);
							$aRow['value_actual'] = preg_replace_callback("/s:(.*):\"(.*?)\";/is", function($matches) {
								return "s:".strlen($matches[2]).":\"{$matches[2]}\";";

							}, $aRow['value_actual']);

							eval("\$aRows[\$iKey]['value_actual'] = ". unserialize(trim($aRow['value_actual'])) . "");
						}

						if ($aRow['var_name'] == 'global_genders')
						{
							$aTempGenderCache = $aRows[$iKey]['value_actual'];
							$aRows[$iKey]['value_actual'] = array();
							foreach ($aTempGenderCache as $aGender)
							{
								$aGenderExplode = explode('|', $aGender);
								$aRows[$iKey]['value_actual'][$aGenderExplode[0]] = array($aGenderExplode[1], $aGenderExplode[2], (isset($aGenderExplode[3]) ? $aGenderExplode[3] : null), (isset($aGenderExplode[4]) ? $aGenderExplode[4] : null));
							}
						}
						break;
					case 'drop':
						// Get the default value from a drop-down setting
						$aCacheArray = unserialize($aRow['value_actual']);
						$aRows[$iKey]['value_actual'] = $aCacheArray['default'];
						unset($aCacheArray);
						break;
					case 'large_string':
						// $aRows[$iKey]['value_actual'] = preg_replace('/\{phrase var=\'(.*)\'\}/i', "' . Phpfox::getPhrase('\\1') . '", $aRow['value_actual']);
						break;
				}
			}

			$oCache->save($iId, $aRows);
		}

		foreach ($aRows as $aRow)
		{
			$this->_aParams[$aRow['module_name'] . '.' . $aRow['var_name']] = $aRow['value_actual'];
		}

		// Check if the browser supports GZIP
		if (isset($_SERVER['HTTP_ACCEPT_ENCODING']))
		{
			$this->_aParams['core.gzip_encodings'] = explode(',', strtolower(preg_replace("/\s+/", "", $_SERVER['HTTP_ACCEPT_ENCODING'])));
			if ((!in_array('gzip', $this->_aParams['core.gzip_encodings']) || !in_array('x-gzip', $this->_aParams['core.gzip_encodings']) || !isset($_SERVER['---------------'])) && !function_exists('ob_gzhandler') && ini_get('zlib.output_compression') && headers_sent())
			{
				$this->_aParams['core.use_gzip'] = false;
			}
		}
		else
		{
			$this->_aParams['core.use_gzip'] = false;
		}

		// Make sure we set the correct cookie domain in case the admin did not
		if ($this->_aParams['core.url_rewrite'] == '3' && empty($this->_aParams['core.cookie_domain']))
		{
			$this->_aParams['core.cookie_domain'] = preg_replace("/(.*?)\.(.*?)$/i", ".$2", $_SERVER['HTTP_HOST']);
		}

		$this->_aParams['core.theme_session_prefix'] = '';
		$this->_aParams['core.load_jquery_from_google_cdn'] = false;

		/**
		 * Override
		 */
		foreach ($this->override as $key => $value) {
			$this->_aParams[$key] = $value;
		}

		if (isset($_GET['phpfox-upgrade']) && !defined('PHPFOX_IS_UPGRADE')) {
			Phpfox_Url::instance()->send('');
		}
	}

	/**
	 * Get a setting and its value.
	 *
	 * @param mixed $mVar STRING name of the setting or ARRAY name of the setting.
	 * @param string $sDef Default value in case the setting cannot be found.
	 * @return nixed Returns the value of the setting, which can be a STRING, ARRAY, BOOL or INT.
	 */
	public function getParam($mVar, $sDef = '')
	{
		if ($mVar == 'core.branding')
		{
			if (!defined('PHPFOX_LICENSE_ID')) {
				return false;
			}

			if (PHPFOX_LICENSE_ID == 'techie') {
				return false;
			}

			return true;
		}

		if ($mVar == 'im.enable_im_in_footer_bar' && Phpfox::isMobile())
		{
			return false;
		}

		// http://www.phpfox.com/tracker/view/15079/
		/*if ($mVar == 'core.wysiwyg' && !defined('PHPFOX_INSTALLER') && Phpfox::isMobile())
		{
			return 'default';
		}*/

		if ($mVar == 'core.phpfox_is_hosted')
		{
			return $this->getParam('core.is_auto_hosted');
		}

		if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
		{
			/*
			if ($mVar == 'core.url_static_script')
			{
				return Phpfox::getCdnPath() . 'static/jscript/';
			}
			*/
			if ($mVar == 'core.setting_session_prefix')
			{
				return PHPFOX_IS_HOSTED_SCRIPT;
			}
			elseif ($mVar == 'video.allow_video_uploading')
			{
				return true;
			}
			/*
			elseif ($mVar == 'core.cache_js_css')
			{
				return true;			
			}
			*/
		}

		if (defined('PHPFOX_INSTALLER') && $mVar == 'core.cache_js_css')
		{
			return false;
		}

		if (is_array($mVar))
		{
			$sParam = (isset($this->_aParams[$mVar[0]][$mVar[1]]) ? $this->_aParams[$mVar[0]][$mVar[1]] : (isset($this->_aDefaults[$mVar[0]][$mVar[1]]) ? $this->_aDefaults[$mVar[0]][$mVar[1]] : Phpfox_Error::trigger('Missing Param: ' . $mVar[0] . '][' . $mVar[1])));
		}
		else
		{
			$sParam = (isset($this->_aParams[$mVar]) ? $this->_aParams[$mVar] : (isset($this->_aDefaults[$mVar]) ? $this->_aDefaults[$mVar] : Phpfox_Error::trigger('Missing Param: ' . $mVar)));

			if (!defined('PHPFOX_INSTALLER') && ($mVar == 'core.footer_bar_site_name' || $mVar == 'core.site_copyright'))
			{
				$sParam = Phpfox_Locale::instance()->convert($sParam);
			}

			if ($mVar == 'admincp.admin_cp')
			{
				$sParam = strtolower($sParam);
			}

			if ($mVar == 'user.points_conversion_rate')
			{
				$sParam = (empty($sParam) ? array() : json_decode($sParam, true));
			}
		}

		if ($mVar == 'core.wysiwyg' && !defined('PHPFOX_INSTALLER') && $sParam == 'tiny_mce' && !Phpfox::isModule('tinymce'))
		{
			return 'default';
		}

		return $sParam;
	}

	/**
	 * Checks to see if a setting exists or not.
	 *
	 * @param string $mVar Name of the setting.
	 * @return bool TRUE it exists, FALSE if it does not.
	 */
	public function isParam($mVar)
	{
		return (isset($this->_aParams[$mVar]) ? true : false);
	}
}
