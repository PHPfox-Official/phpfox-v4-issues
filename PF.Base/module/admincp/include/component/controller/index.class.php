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
 * @version 		$Id: index.class.php 7202 2014-03-18 13:38:56Z Raymond_Benc $
 */
class Admincp_Component_Controller_Index extends Phpfox_Component 
{
	private $_sController = 'index';
	private $_sModule;
	
	/**
	 * Controller
	 */
	public function process()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);

		if (Phpfox::getParam('core.admincp_http_auth'))
		{
			$aAuthUsers = Phpfox::getParam('core.admincp_http_auth_users');

			if((isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']) && isset($aAuthUsers[Phpfox::getUserId()])) && (($_SERVER['PHP_AUTH_USER'] == $aAuthUsers[Phpfox::getUserId()]['name']) && ($_SERVER['PHP_AUTH_PW'] == $aAuthUsers[Phpfox::getUserId()]['password'])))
			{

			}
			else
			{
				header("WWW-Authenticate: Basic realm=\"AdminCP\"");
				header("HTTP/1.0 401 Unauthorized");
				exit("NO DICE!");
			}
		}

		if (Phpfox::getParam('admincp.admin_cp') != $this->request()->get('req1'))
		{
			return Phpfox_Module::instance()->setController('error.404');
		}
		
		if (!Phpfox::getService('user.auth')->isActiveAdminSession())
		{		
			return Phpfox_Module::instance()->setController('admincp.login');
		}	
		
		if ($this->request()->get('upgraded'))
		{
			Phpfox::getLib('cache')->remove();
			Phpfox::getLib('template.cache')->remove();
			
			$this->url()->send('admincp');
		}

		$this->_sModule = (($sReq2 = $this->request()->get('req2')) ? strtolower($sReq2) : Phpfox::getParam('admincp.admin_cp'));
		if ($this->_sModule == 'logout')
		{
			$this->_sController = $this->_sModule;
			$this->_sModule = 'admincp';
		}
		else 
		{					
			$this->_sController = (($sReq3 = $this->request()->get('req3')) ? $sReq3 : $this->_sController);		
		}		
		if ($sReq4 = $this->request()->get('req4'))
		{
			$sReq4 = str_replace(' ', '', strtolower(str_replace('-', ' ', $sReq4)));
		}		
		$sReq5 = $this->request()->get('req5');		

		$bPass = false;
		if (file_exists(PHPFOX_DIR_MODULE . $this->_sModule . PHPFOX_DS . PHPFOX_DIR_MODULE_COMPONENT . PHPFOX_DS . 'controller' . PHPFOX_DS . 'admincp' . PHPFOX_DS . $this->_sController . '.class.php'))
		{		
			$this->_sController = 'admincp.' . $this->_sController;
			$bPass = true;			
		}
		
		if (!$bPass && $sReq5 && file_exists(PHPFOX_DIR_MODULE . $this->_sModule . PHPFOX_DS . PHPFOX_DIR_MODULE_COMPONENT . PHPFOX_DS . 'controller' . PHPFOX_DS . 'admincp' . PHPFOX_DS . $this->_sController . PHPFOX_DS . $sReq4 . PHPFOX_DS . $sReq5 . '.class.php'))
		{
			$this->_sController = 'admincp.' . $this->_sController . '.' . $sReq4 . '.' . $sReq5;
			$bPass = true;			
		}			
		
		if (!$bPass && $sReq4 && file_exists(PHPFOX_DIR_MODULE . $this->_sModule . PHPFOX_DS . PHPFOX_DIR_MODULE_COMPONENT . PHPFOX_DS . 'controller' . PHPFOX_DS . 'admincp' . PHPFOX_DS . $this->_sController . PHPFOX_DS . $sReq4 . '.class.php'))
		{
			$this->_sController = 'admincp.' . $this->_sController . '.' . $sReq4;
			$bPass = true;			
		}			
		
		if (!$bPass && file_exists(PHPFOX_DIR_MODULE . $this->_sModule . PHPFOX_DS . PHPFOX_DIR_MODULE_COMPONENT . PHPFOX_DS . 'controller' . PHPFOX_DS . 'admincp' . PHPFOX_DS . $this->_sController . PHPFOX_DS . $this->_sController . '.class.php'))
		{
			$this->_sController = 'admincp.' . $this->_sController . '.' . $this->_sController;
			$bPass = true;			
		}			
		
		if (!$bPass && $sReq4 && file_exists(PHPFOX_DIR_MODULE . $this->_sModule . PHPFOX_DS . PHPFOX_DIR_MODULE_COMPONENT . PHPFOX_DS . 'controller' . PHPFOX_DS . 'admincp' . PHPFOX_DS . $this->_sController . PHPFOX_DS . $sReq4 . '.class.php'))
		{
			$this->_sController = 'admincp.' . $this->_sController . '.' . $sReq4;			
			$bPass = true;
		}
		
		if (!$bPass && $sReq4 && file_exists(PHPFOX_DIR_MODULE . $this->_sModule . PHPFOX_DS . PHPFOX_DIR_MODULE_COMPONENT . PHPFOX_DS . 'controller' . PHPFOX_DS . 'admincp' . PHPFOX_DS . $this->_sController . PHPFOX_DS . $sReq4 . PHPFOX_DS . 'index.class.php'))
		{
			$this->_sController = 'admincp.' . $this->_sController . '.' . $sReq4 . '.index';						
			$bPass = true;					
		}			
		
		if (!$bPass && file_exists(PHPFOX_DIR_MODULE . $this->_sModule . PHPFOX_DS . PHPFOX_DIR_MODULE_COMPONENT . PHPFOX_DS . 'controller' . PHPFOX_DS . 'admincp' . PHPFOX_DS . $this->_sController . PHPFOX_DS . 'index.class.php'))
		{
			$this->_sController = 'admincp.' . $this->_sController . '.index';			
			$bPass = true;						
		}
			
		if (!$bPass && file_exists(PHPFOX_DIR_MODULE . 'admincp' . PHPFOX_DS . PHPFOX_DIR_MODULE_COMPONENT . PHPFOX_DS . 'controller' . PHPFOX_DS . $this->_sModule . PHPFOX_DS . $this->_sController . '.class.php'))
		{
			$this->_sController = $this->_sModule . '.' . $this->_sController;						
			$this->_sModule = 'admincp';
			$bPass = true;			
		}		
		
		if (!$bPass && $sReq4 && file_exists(PHPFOX_DIR_MODULE . 'admincp' . PHPFOX_DS . PHPFOX_DIR_MODULE_COMPONENT . PHPFOX_DS . 'controller' . PHPFOX_DS . $this->_sModule . PHPFOX_DS . $this->_sController . PHPFOX_DS . $sReq4 . '.class.php'))
		{
			$this->_sController = $this->_sModule . '.' . $this->_sController . '.' . $sReq4;			
			$this->_sModule = 'admincp';
			$bPass = true;			
		}	
		
		if (!$bPass && Phpfox::getParam('admincp.admin_cp') != 'admincp' && file_exists(PHPFOX_DIR_MODULE . $this->_sModule . PHPFOX_DS . PHPFOX_DIR_MODULE_COMPONENT . PHPFOX_DS . 'controller' . PHPFOX_DS . $this->_sController . '.class.php'))
		{			
			$bPass = true;		
		}

		$bForceIndex = false;
		if (!$bPass && Phpfox::isModule($this->request()->segment('req2'))) {
			$this->_sModule = 'admincp';
			$this->_sController = 'app.index';
			$bForceIndex = true;
			$bPass = true;
		}

		// Get the menu we will used to display all the "Modules"
		// $aModules = Phpfox::getService('admincp.module')->getAdminMenu();

		// Create AdminCP menu
		$aMenus = array(
			// 'admincp.dashboard' => 'admincp',
			/*
			'admincp.cms' => array(
				'admincp.menus' => array(
					'admincp.manage_menus' => 'admincp.menu',
					'admincp.add_new_menu' => 'admincp.menu.add'
				),
				'admincp.blocks' => array(
					'admincp.manage_blocks' => 'admincp.block',
					'admincp.add_new_block' => 'admincp.block.add'					
				),
				'admincp.pages' => array(
					'admincp.manage_pages' => 'admincp.page',
					'admincp.add_new_page' => 'admincp.page.add'
				)
			),
			*/

			'admincp.users' => array(
				'admincp.browse_members' => 'admincp.user.browse',				
				'admincp.user_group_manager' => array(
					'admincp.manage_user_groups' => 'admincp.user.group',
					'admincp.create_user_group' => 'admincp.user.group.add',
					'admincp.add_user_group_setting' => 'admincp.user.group.setting'
				),
				'admincp.user_cancellation_options' => array(
					'admincp.user_cancellation_options_add' => 'admincp.user.cancellations.add',
					'admincp.user_cancellation_options_manage' => 'admincp.user.cancellations.manage',
					'admincp.user_cancellations_feedback' => 'admincp.user.cancellations.feedback'
				),
				'user.promotions' => array(
					'user.manage_promotions' => 'admincp.user.promotion',
					'user.add_promotion' => 'admincp.user.promotion.add'
				),
				'admincp.inactive_members' => 'admincp.user.inactivereminder'
			),

			/*
			'admincp.extensions' => array(
				'admincp.module' => array(
					'admincp.manage_modules' => 'admincp.module',
					'admincp.create_new_module' => 'admincp.module.add',
					'admincp.add_component' => 'admincp.component.add',
					'admincp.manage_components' => 'admincp.component'
				),
				'admincp.language' => array(
					'admincp.manage_language_packs' => 'admincp.language',
					'admincp.phrase_manager' => 'admincp.language.phrase',
					'admincp.add_phrase' => 'admincp.language.phrase.add',
					'language.create_language_pack' => 'admincp.language.add',
					'language.import_language_pack' => 'admincp.language.import',
					'language.email_phrases' => 'admincp.language.email'
				),
				'admincp.products' => array(
					'admincp.manage_products' => 'admincp.product',
					'admincp.create_new_product' => 'admincp.product.add',
					'admincp.import_export' => 'admincp.product.file'
				),
				'admincp.plugin' => array(
					'admincp.manage_plugins' => 'admincp.plugin',
					'admincp.create_new_plugin' => 'admincp.plugin.add'
				),
				'admincp.theme' => array(
					'admincp.manage_themes' => 'admincp.theme',
					'theme.admincp_menu_create_theme' => 'admincp.theme.add',
					'theme.admincp_menu_create_style' => 'admincp.theme.style.add',
					'theme.create_a_new_template' => 'admincp.theme.template.add',
					'theme.admincp_create_css_file' => 'admincp.theme.style.css.add',
					'theme.admincp_menu_import_themes' => 'admincp.theme.import',
					'theme.admincp_menu_import_styles' => 'admincp.theme.style.import'
				),
				'admincp.plugin' => array(
					'admincp.manage_plugins' => 'admincp.plugin',
					'admincp.create_new_plugin' => 'admincp.plugin.add'
				),
				'apps.admincp_menu_apps' => array(
					'apps.categories' => 'admincp.apps.categories',
					'apps.install_app' => 'admincp.apps.import',
					'apps.export_apps' => 'admincp.apps.export'					
				)
			),
			*/
			/*
			'admincp.settings' => array(
				'admincp.system_settings_menu' => array(
					'admincp.manage_settings' => 'admincp.setting',
					'admincp.add_new_setting' => 'admincp.setting.add',
					'admincp.add_new_setting_group' => 'admincp.setting.group.add',
					'admincp.find_missing_settings' => 'admincp.setting.missing'
					// 'admincp.language_import_export' => 'admincp.setting.file'
				),
				'admincp.payment_gateways_menu' => 'admincp.api.gateway'
			),
			*/

		);

		$aMenus = [
			'<i class="fa fa-dashboard"></i>Dashboard' => 'admincp',
			'<i class="fa fa-cubes"></i>Apps' => 'admincp.apps',
			'<i class="fa fa-paint-brush"></i>Themes' => 'admincp.theme',

			'Members',
			'<i class="fa fa-search"></i>Search' => 'admincp.user.browse',
			'<i class="fa fa-users"></i>User Groups' => 'admincp.user.group',
			'<i class="fa fa-diamond"></i>Promotions' => 'admincp.user.promotion',
			'<i class="fa fa-th-list"></i>Custom Fields' => 'admincp.custom',

			'Site',
			'<i class="fa fa-file-text-o"></i>Pages' => 'admincp.page',
			'<i class="fa fa-bars"></i>Menus' => 'admincp.menu',
			'<i class="fa fa-th"></i>Blocks' => 'admincp.block',
			'<i class="fa fa-language"></i>Phrases' => 'admincp.language.phrase',

			'Tools',
			'Settings' => [
				// 'Site &amp; Server',
				'Countries' => 'admincp.core.country',
				'Currencies' => 'admincp.core.currency',
				'Attachments' => 'admincp.attachment',
				'Payment Gateways' => 'admincp.api.gateway',
				'Language' => 'admincp.language',
				'Short URLs' => 'admincp.setting.url',
				// 'admincp.menu_tools_emoticon_package' => 'admincp.emoticon.package',
				/*
				'Contact Us' => $this->url()->makeUrl('admincp.setting.edit', ['module-id' => 'contact']),
				'Activity Feed' => $this->url()->makeUrl('admincp.setting.edit', ['module-id' => 'feed']),
				'Private Messages' => $this->url()->makeUrl('admincp.setting.edit', ['module-id' => 'mail']),
				*/

				'User',
				'Settings' => $this->url()->makeUrl('admincp.setting.edit', ['module-id' => 'user']),
				'Registration' => $this->url()->makeUrl('admincp.setting.edit', ['group-id' => 'registration']),
				'Relationship Statues' => 'admincp.custom.relationships',
				'Cancellation Options' => 'admincp.user.cancellations.manage',
				'Subscription Packages' => 'admincp.subscribe',
				'E-Gifts' => 'admincp.egift.categories',
				'Anti-SPAM Questions' => 'admincp.user.spam',

				/*
				'SEO',
				'admincp.custom_elements' => 'admincp.seo.meta',
				'admincp.nofollow_urls' => 'admincp.seo.nofollow',
				'admincp.rewrite_url' => 'admincp.seo.rewrite'
				*/
			],
			'<i class="fa fa-th-large"></i>Modules' => 'admincp.product',
			'<i class="fa fa-bullhorn"></i>Announcements' => 'admincp.announcement',
			'<i class="fa fa-newspaper-o"></i>Newsletter' => 'admincp.newsletter.manage',
			'<i class="fa fa-info"></i>Status' => array(
				Phpfox::getPhrase('core.site_statistics') => 'admincp.core.stat',
				Phpfox::getPhrase('core.admincp_menu_system_overview') => 'admincp.core.system',
				Phpfox::getPhrase('admincp.inactive_members') => 'admincp.user.inactivereminder'
				// 'admincp.ip_address' => 'admincp.core.ip',
				// 'admincp.admincp_privacy' => 'admincp.privacy'
			),
			/*
			'admincp.menu_site_stats' => array(
				'admincp.menu_manage_stats' => 'admincp.stat',
				'admincp.menu_create_new_stat' => 'admincp.stat.add'
			),
			*/
			'<i class="fa fa-server"></i>Maintenance' => array(
				Phpfox::getPhrase('admincp.menu_cache_manager') => 'admincp.maintain.cache',
				'Reported Items' => 'admincp.report',
				Phpfox::getPhrase('admincp.admincp_menu_reparser') => 'admincp.maintain.reparser',
				Phpfox::getPhrase('admincp.remove_duplicates') => 'admincp.maintain.duplicate',
				Phpfox::getPhrase('admincp.counters') => 'admincp.maintain.counter',
				Phpfox::getPhrase('admincp.check_modified_files') => 'admincp.checksum.modified',
				Phpfox::getPhrase('admincp.check_unknown_files') => 'admincp.checksum.unknown',
				Phpfox::getPhrase('admincp.find_missing_settings') => 'admincp.setting.missing',
				'Toggle Modules' => $this->url()->makeUrl('admincp.module', ['view' => 'all'])
			),
			'<i class="fa fa-ban"></i>Ban Filters' => array(
				Phpfox::getPhrase('ban.ban_filter_username') => 'admincp.ban.username',
				Phpfox::getPhrase('ban.ban_filter_email') => 'admincp.ban.email',
				Phpfox::getPhrase('ban.ban_filter_display_name') => 'admincp.ban.display',
				Phpfox::getPhrase('ban.ban_filter_ip') => 'admincp.ban.ip',
				Phpfox::getPhrase('ban.ban_filter_word') => 'admincp.ban.word'
			)
		];

		/*
		$aThemes = [];
		foreach (Theme_Service_Theme::instance()->get() as $aTheme) {
			$aThemes[$aTheme['name']] = $this->url()->makeUrl('admincp.theme.manage', ['id' => $aTheme['theme_id']]);
		}
		*/
		// d($aThemes); exit;

		list($aGroups, $aModules, $aProductGroups) = Phpfox::getService('admincp.setting.group')->get();

		$aCache = $aGroups;
		$aGroups = [];

		// $aGroups[] = 'Site &amp; Server';
		foreach ($aCache as $key => $value) {

			$n = $key;
			switch ($value['group_id']) {
				case 'cookie':
					$n = 'Browser Cookies';
					break;
				case 'site_offline_online':
					$n = 'Toggle Site';
					break;
				case 'general':
					$n = 'Site Settings';
					break;
				case 'mail':
					$n = 'Mail Server';
					break;
				case 'spam':
					$n = 'Spam Assistance';
					break;
				case 'registration':
					continue 2;
					break;
			}


			// unset($aGroups[$key]);
			$aGroups[$n] = $value;
		}
		ksort($aGroups);

		// d($aGroups); exit;

		$aApps = [];
		/*
		$aProducts = Admincp_Service_Product_Product::instance()->getNewProductsForInstall();
		if (count($aProducts)) {
			foreach ($aProducts as $aProduct) {
				$aApps[$aProduct['title']] = [
					'highlight' => true,
					'message' => 'Install',
					'url' => $this->url()->makeUrl('admincp.product.install', ['id' => $aProduct['product_id']])
				];
			}
		}
		*/

		/*
		$aSkip = ['apps', 'user', 'track', 'tinymce', 'theme', 'tag', 'subscribe', 'share', 'search', 'rss', 'request', 'report', 'rate', 'profile', 'privacy', 'page', 'notification', 'mobile', 'log', 'link', 'like', 'language', 'input', 'admincp', 'api', 'apps', 'attachment', 'ban', 'comment', 'contact', 'core', 'custom', 'emoticon', 'error', 'favorite', 'help', 'im'];
		foreach (Phpfox_Module::instance()->getModules() as $sModule) {
			if (in_array($sModule, $aSkip)) {
				continue;
			}

			// $aApps[$sModule] = $this->url()->makeUrl('admincp.app', ['id' => $sModule]);
			$aApps[$sModule] = $this->url()->makeUrl('admincp.' . $sModule);
		}
		*/


		$aSettings = [];
		foreach ($aGroups as $sGroupName => $aGroupValues) {
			$aSettings[$sGroupName] = $this->url()->makeUrl('admincp.setting.edit', ['group-id' => $aGroupValues['group_id']]);
			// $aMenus['Settings'][$sGroupName] = '#';
		}

		// d($aSettings); exit;

		$aCache = $aMenus;
		$aMenus = [];
		foreach ($aCache as $sKey => $mValue) {

			/*
			if ($mValue == '#modules') {
				$aMenus[$sKey] = $aApps;

				continue;
			}
			else if ($mValue == '#themes') {
				$aMenus[$sKey] = $aThemes;

				continue;
			}
			*/

			/*
			if (is_string($mValue) && $mValue === 'Tools') {

				// d($mValue);
				$aMenus[$sKey] = 'Modules';
				foreach ((new Core\App())->all('__core') as $Core) {
					$icon = '';
					$name = $Core->name;
					$id = str_replace('__module_', '', $Core->id);
					switch ($id) {
						case 'ad':
							$icon = 'money';
							break;
						case 'blog':
							$icon = 'file';
							break;
					}

					if (!empty($icon)) {
						$icon = '<i class="fa fa-' . $icon . '"></i>';
					}

					$aMenus[$icon . $Core->name] = $this->url()->makeUrl('admincp.app', ['id' => $Core->id]);
				}

				$sKey++;
			}
			*/

			if ($sKey === 'Settings') {
				$sKey = '<i class="fa fa-cog"></i>Settings';
				/*
				$aMerge = [];
				foreach ($mValue as $sSubKey => $sSubValue) {
					if (strpos($sSubValue, '.')) {
						$aMerge[Phpfox::getPhrase($sSubKey)] = $sSubValue;
					}
					else {
						$aMerge[] = $sSubValue;
					}
				}
				$mValue = array_merge($aSettings, $aMerge);
				*/
				$moduleSettings = [];
				foreach ((new Core\App())->all('__core') as $Core) {
					$name = $Core->name;
					$id = str_replace('__module_', '', $Core->id);
					$url = $this->url()->makeUrl('admincp.app', ['id' => $Core->id]);
					$goSettings = false;
					$goIndex = false;

					switch ($id) {
						case 'ad':
							$name = 'Ad Campaigns';
							break;
						case 'blog':
							$name = 'Blog Categories &amp; Settings';
							break;
						case 'contact':
							$name = '"Contact Us" Form';
							break;
						/*
						case 'user':
							$goSettings = true;
							$name = 'User';
							break;
						*/
						case 'feed':
							$goSettings = true;
							$this->template()->setSectionTitle('Activity Feed');
							break;
						case 'forum':
							$name = 'Forums';
							$goIndex = true;
							break;
						case 'mail':
							$name = 'Private Messages';
							break;
						case 'event':
						case 'photo':
							case 'marketplace':
							case 'music':
							case 'pages':
							$goIndex = true;
							break;
					}

					if ($goSettings) {
						$url = $this->url()->makeUrl('admincp.setting.edit', ['module-id' => $id]);
					}
					else if ($goIndex) {
						$url = $this->url()->makeUrl('admincp.' . $id);
					}

					$moduleSettings[$name] = $url;
				}

				$mValue = array_merge($aSettings, $mValue, ['Modules'], $moduleSettings);
			}

			$aMenus[$sKey] = $mValue;

			if (is_string($mValue) && $mValue == 'admincp.theme' && PHPFOX_IS_TECHIE) {
				$aMenus['<i class="fa fa-sheqel"></i>Techie'] = [
					'Products' => 'admincp.product',
					'Modules' => 'admincp.module',
					'Plugins' => 'admincp.plugin',
					'Components' => 'admincp.component',
				];
			}
		}



		// $aMenus['<i class="fa fa-cog"></i>Settings'] = array_merge($aSettings, $aMenus['Settings']);
		// unset($aMenus['Settings']);

		// d($aMenus); exit;
		
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_index_process_menu')) ? eval($sPlugin) : false);
				
		$aUser = Phpfox::getUserBy();
		// $aUser['full_name'] = substr($aUser['full_name'], 0, Phpfox::getParam('user.maximum_length_for_full_name'));

		$sSectionTitle = '';
		$app = $this->request()->get('req2');
		$bForceIndex = true;
		if ($app == 'app') {
			$app = str_replace('__module_', '', $this->request()->get('id'));
			$bForceIndex = false;
		}

		$is_settings = false;
		if ($this->url()->getUrl() == 'admincp/setting/edit') {
			$app = $this->request()->get('module-id');
			$is_settings = true;
		}

		$aSkipModules = ['api', 'comment', 'feed', 'apps', 'friend', 'announcement', 'ban', 'facebook', 'user', 'core', 'custom', 'admincp', 'page', 'language', 'attachment', 'theme'];

		$searchSettings = Admincp_Service_Setting_Setting::instance()->getForSearch($aSkipModules);
		$this->template()->setHeader('<script>var admincpSettings = ' . json_encode($searchSettings) . ';</script>');

		if ($is_settings && in_array($app, $aSkipModules) && $app != 'user' && $app != 'feed') {
			$this->url()->send('admincp');
		}

		if ($app && Phpfox::isModule($app) && !in_array($app, $aSkipModules)) {
			$app = Phpfox_Module::instance()->get($app);

			$name = Phpfox_Locale::instance()->translate($app['module_id'], 'module');
			$sSectionTitle = $name;
			$menu = unserialize($app['menu']);
			$menus = [];
			$current = $this->url()->getUrl();
			$infoActive = false;

			if ($this->request()->get('req2') == 'app') {
				$infoActive = true;
			}

			if (Admincp_Service_Setting_Setting::instance()->moduleHasSettings($app['module_id'])) {
				$menus['Settings'] = [
					'is_active' => $is_settings,
					'url' => $this->url()->makeUrl('admincp.setting.edit', ['module-id' => $app['module_id']])
				];
			}

			if (is_array($menu) && count($menu)) {
				foreach ($menu as $key => $value) {
					$is_active = false;
					$url = 'admincp.' . implode('.', $value['url']);
					if ($current == str_replace('.', '/', $url)) {
						$is_active = true;
						if ($infoActive) {
							$menus['Info']['is_active'] = false;
						}
					}

					$menus[Phpfox::getPhrase($key)] = [
						'url' => $url,
						'is_active' => $is_active
					];
				}
			}

			$this->template()->assign([
				'aSectionAppMenus' => $menus,
				'ActiveApp' => (new Core\App())->get('__module_' . $app['module_id'])
			]);
		}

		$this->template()->assign(array(
						'sSectionTitle' => $sSectionTitle,
						'aModulesMenu' => $aModules,
						'aAdminMenus' => $aMenus,						
						'aUserDetails' => $aUser,
						'sPhpfoxVersion' => PhpFox::getVersion(),
						'sSiteTitle' => Phpfox::getParam('core.site_title')
					)
				)->setHeader(array(
					'menu.css' => 'style_css',
					'menu.js' => 'style_script',
					'admin.js' => 'static_script',
					'jquery/plugin/jquery.mosaicflow.min.js' => 'static_script'
				)
			)->setTitle(Phpfox::getPhrase('admincp.admin_cp'));


		if (in_array($app, ['plugin', 'module', 'component'])) {
			$this->template()->setSectionTitle('Techie: ' . ucwords($app));
			$this->template()->setActionMenu([
				'New ' . ucwords($app) => [
					'url' => $this->url()->makeUrl('admincp.' . $app . '.add'),
					'class' => 'popup'
				]
			]);
		}

		if ($bPass)
		{
			Phpfox_Module::instance()->setController($this->_sModule . '.' . $this->_sController);

			$sMenuController = str_replace(array('.index', '.phrase'), '', 'admincp.' . ($this->_sModule != 'admincp' ? $this->_sModule . '.' . str_replace('admincp.', '', $this->_sController) : $this->_sController));
			$aCachedSubMenus = array();
			$sActiveSideBar = '';
			
			if ($sMenuController == 'admincp.setting.edit')
			{
				$sMenuController = 'admincp.setting';
			}
			
			if ($this->_getMenuName() !== null)
			{
				$sMenuController = $this->_getMenuName();
			}			

			/*
			foreach ($aMenus as $sKey => $aSubMenus)
			{
				if (is_array($aSubMenus))
				{
					foreach ($aSubMenus as $sSubkey => $mSubMenus)
					{					
						if (is_array($mSubMenus))
						{
							foreach ($mSubMenus as $sSubkey2 => $mSubMenus2)
							{
								if ($sMenuController == $mSubMenus2)
								{
									$sActiveSideBar = $sSubkey;
									
									foreach ($aSubMenus as $sSubkey3 => $mSubMenus3)
									{
										if (is_array($mSubMenus3))
										{
											$aCachedSubMenus[$sSubkey3] = $mSubMenus3;
										}
										else 
										{
											$aCachedSubMenus[$sKey][$sSubkey3] = $mSubMenus3;
										}
									}
								}
							}
						}
						else 
						{
							if ($sMenuController == $mSubMenus)
							{
								$sActiveSideBar = $sKey;	
								
								foreach ($aSubMenus as $sSubkey3 => $mSubMenus3)
								{
									if (is_array($mSubMenus3))
									{
										$aCachedSubMenus[$sSubkey3] = $mSubMenus3;
									}
									else 
									{
										$aCachedSubMenus[$sKey][$sSubkey3] = $mSubMenus3;
									}
								}
							}
						}
					}
				}
			}				
			
			$bIsModuleConnection = false;
			if (!$aCachedSubMenus)
			{			
				$bIsModuleConnection = true;
				$sActiveSideBar = $this->_sModule;
				foreach ($aModules as $aModule)
				{
					if (!isset($aModule['module_id']))
					{
						continue;
					}
					
					if (!$aModule['is_menu'])
					{
						continue;
					}
					
					if (!is_array($aModule['menu']))
					{
						continue;
					}
					
					foreach ($aModule['menu'] as $sPhrase => $aLink)
					{
						$aCachedSubMenus[$aModule['module_id']][$sPhrase] = 'admincp.' . str_replace('/', '.', $aLink['url']);
					}				
				}			
			}
			*/
			
			$this->template()->assign(array(
					'aCachedSubMenus' => $aCachedSubMenus,
					'sActiveSideBar' => $sActiveSideBar,
					'bIsModuleConnection' => false,
					'sMenuController' => $sMenuController,
					'aActiveMenus' => ((false && isset($aCachedSubMenus[$sActiveSideBar])) ? $aCachedSubMenus[$sActiveSideBar] : array())
				)
			);				
		}
		else 
		{
			if ($this->_sModule != Phpfox::getParam('admincp.admin_cp'))
			{
				Phpfox_Module::instance()->setController('error.404');
			}
			else 
			{
				Phpfox::getService('admincp')->check();		
				/*
				define('PHPFOX_CAN_MOVE_BLOCKS', true);
				
				$this->template()->setHeader('cache', array(													
							'sort.js' => 'module_theme',
							'design.js' => 'module_theme',			
							'jquery/ui.js' => 'static_script',
						)
					)
					->setHeader(array(	
						'<script type="text/javascript">function designOnUpdate() { $Core.design.updateSorting(); }</script>',
						'<script type="text/javascript">$Core.design.init({type_id: \'admincp\'});</script>'
					)
				);						
				
				Phpfox_Module::instance()->setCacheBlockData(array(
						'table' => 'admincp_dashboard',
						'field' => 'user_id',
						'item_id' => Phpfox::getUserId(),
						'controller' => 'admincp.index'
					)
				);				
				 */
				
				$this->template()->setBreadcrumb(Phpfox::getPhrase('admincp.dashboard'))
					->setTitle(Phpfox::getPhrase('admincp.dashboard'))
					->assign(array(
						'bIsModuleConnection' => false,
						'bIsDashboard' => true,
						'aNewProducts' => Admincp_Service_Product_Product::instance()->getNewProductsForInstall()
					)
				);
			}
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>