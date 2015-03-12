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
	 * Class process method wnich is used to execute this component.
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
			return Phpfox::getLib('module')->setController('error.404');	
		}
		
		if (!Phpfox::getService('user.auth')->isActiveAdminSession())
		{		
			return Phpfox::getLib('module')->setController('admincp.login');
		}	
		
		if ($this->request()->get('upgraded'))
		{
			Phpfox::getLib('cache')->remove();
			Phpfox::getLib('template.cache')->remove();
			
			$this->url()->send('admincp');
		}
		
		/*
		if (Phpfox::getParam('core.phpfox_is_hosted'))
		{
			$sMaxHistory = Phpfox::getParam('core.phpfox_total_users_online_history');
			if (!empty($sMaxHistory) && Phpfox::getLib('parse.format')->isSerialized($sMaxHistory))
			{
				$aMaxHistory = unserialize($sMaxHistory);
				$this->template()->assign(array(
						'aMaxHistory' => $aMaxHistory
					)
				);				
			}
		}
		*/
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
				
		// Get the menu we will used to display all the "Modules"
		$aModules = Phpfox::getService('admincp.module')->getAdminMenu();

		// Create AdminCP menu
		$aMenus = array(
			'admincp.dashboard' => 'admincp',
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
			'admincp.tools' => array(
				'admincp.general' => array(
					'core.site_statistics' => 'admincp.core.stat',
					'core.admincp_menu_system_overview' => 'admincp.core.system',
					'admincp.ip_address' => 'admincp.core.ip',
					'admincp.admincp_privacy' => 'admincp.privacy'
				),				
				'admincp.menu_site_stats' => array(
					'admincp.menu_manage_stats' => 'admincp.stat',
					'admincp.menu_create_new_stat' => 'admincp.stat.add'
				),
				'admincp.maintenance' => array(
					'admincp.menu_cache_manager' => 'admincp.maintain.cache',
					'admincp.admincp_menu_reparser' => 'admincp.maintain.reparser',
					'admincp.remove_duplicates' => 'admincp.maintain.duplicate',
					'admincp.counters' => 'admincp.maintain.counter',
					'admincp.check_modified_files' => 'admincp.checksum.modified',
					'admincp.check_unknown_files' => 'admincp.checksum.unknown'
				),
				'ban.ban_filters' => array(
					'ban.ban_filter_username' => 'admincp.ban.username',
					'ban.ban_filter_email' => 'admincp.ban.email',
					'ban.ban_filter_display_name' => 'admincp.ban.display',
					'ban.ban_filter_ip' => 'admincp.ban.ip',
					'ban.ban_filter_word' => 'admincp.ban.word'
				),
				'admincp.mail_messages' => array(
					'admincp.view_messages' => 'admincp.mail.private'
				),
				'core.admincp_menu_country' => array(
					'core.admincp_menu_country_manager' => 'admincp.core.country',
					'core.admincp_menu_country_add' => 'admincp.core.country.add',
					'core.admincp_menu_country_child_add' => 'admincp.core.country.child.add',
					'core.admincp_menu_country_import' => 'admincp.core.country.import'
				),
				'core.admincp_menu_online' => array(
					'core.admincp_menu_online_members' => 'admincp.user.browse.view_online',
					'core.admincp_menu_online_guests' => 'admincp.core.online-guest'
				),
				'admincp.sql' => array(
					'admincp.sql_maintenance' => 'admincp.sql',
					'admincp.sql_backup' => 'admincp.sql.backup',
					'admincp.alter_title_fields' => 'admincp.sql.title'
				),
				'core.currency' => array(
					'core.currency_manager' => 'admincp.core.currency',
					'core.add_currency' => 'admincp.core.currency.add'
				),
				'admincp.seo' => array(
					'admincp.custom_elements' => 'admincp.seo.meta',
					'admincp.nofollow_urls' => 'admincp.seo.nofollow',
					'admincp.rewrite_url' => 'admincp.seo.rewrite'
				)
			)
		);
		
		if (!Phpfox::isModule('mail'))
		{
			unset($aMenus['admincp.tools']['admincp.mail_messages']);
		}
		if (Phpfox::isModule('mail') != true || !Phpfox::getUserParam('mail.can_read_private_messages'))
		{
			unset($aMenus['admincp.tools']['admincp.mail_messages']['admincp.view_messages']);
			if (empty($aMenus['admincp.tools']['admincp.mail_messages']))
			{
				unset($aMenus['admincp.tools']['admincp.mail_messages']);
			}
		}
		
		if (!Phpfox::getUserParam('admincp.can_add_new_block'))
		{
			unset($aMenus['admincp.cms']['admincp.blocks']['admincp.add_new_block']);
		}				
		
		if (Phpfox::isModule('custom'))
		{
			$aMenus['admincp.users']['custom.admincp_custom_fields'] = array(
				'custom.admin_menu_add_custom_field' => 'admincp.custom.add',
				'custom.admin_menu_manage_custom_fields' => 'admincp.custom',
				'custom.admin_menu_add_custom_group' => 'admincp.custom.group.add',
				'custom.admin_menu_manage_relationships' => 'admincp.custom.relationships'
			);
		}

		if (Phpfox::isModule('emoticon'))
		{
			$aMenus['admincp.extensions']['emoticon.emoticons'] = array(
				'admincp.menu_tools_emoticon_package' => 'admincp.emoticon.package',
				'admincp.menu_tools_emoticon_package_add' => 'admincp.emoticon.package.add',
				'admincp.menu_tools_emoticon_add' => 'admincp.emoticon.add',
				'emoticon.import_export_emoticon' => 'admincp.emoticon.file'
			);				
		}
		
		if (Phpfox::isModule('attachment.admincp_attachment_menu'))
		{
			$aMenus['admincp.extensions']['attachment.admincp_attachment_menu'] = array(
				'attachment.admincp_menu_attachment_types' => 'admincp.attachment',
				'attachment.admincp_menu_attachment_add' => 'admincp.attachment.add'
			);
		}
		
		if (!Phpfox::getParam('core.branding') && !Phpfox::getParam('core.phpfox_is_hosted'))
		{
			$aMenus['admincp.settings']['core.phpfox_branding_removal'] = 'admincp.core.branding';	
		}
		
		if (Phpfox::getParam('core.phpfox_is_hosted'))
		{
			unset($aMenus['admincp.extensions']['admincp.module']);
			unset($aMenus['admincp.extensions']['admincp.products']['admincp.create_new_product']);
			unset($aMenus['admincp.extensions']['admincp.products']['admincp.import_export']);
			unset($aMenus['admincp.extensions']['admincp.plugin']);
			// unset($aMenus['admincp.extensions']['admincp.language']['language.import_language_pack']);
			unset($aMenus['admincp.extensions']['admincp.theme']['theme.create_a_new_template']);
			unset($aMenus['admincp.extensions']['admincp.theme']['theme.admincp_create_css_file']);
			// unset($aMenus['admincp.extensions']['admincp.theme']['theme.admincp_menu_import_themes']);
			unset($aMenus['admincp.extensions']['admincp.theme']['theme.admincp_menu_import_styles']);
			unset($aMenus['admincp.extensions']['emoticon.emoticons']['emoticon.import_export_emoticon']);
			unset($aMenus['admincp.settings']['admincp.system_settings_menu']['admincp.add_new_setting']);
			unset($aMenus['admincp.settings']['admincp.system_settings_menu']['admincp.add_new_setting_group']);
			unset($aMenus['admincp.settings']['admincp.payment_gateways_menu']);
		}		
		
		$aMenus = Phpfox::getService('admincp')->checkAdmincpPrivacy($aMenus);
		
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_index_process_menu')) ? eval($sPlugin) : false);
				
		$aUser = Phpfox::getUserBy();
		// $aUser['full_name'] = substr($aUser['full_name'], 0, Phpfox::getParam('user.maximum_length_for_full_name'));
		
		$this->template()->assign(array(
						'aModulesMenu' => $aModules,
						'aAdminMenus' => $aMenus,						
						'aUserDetails' => $aUser,
						'sPhpfoxVersion' => PhpFox::getVersion(),
						'sSiteTitle' => Phpfox::getParam('core.site_title')
					)
				)->setHeader(array(
					'menu.css' => 'style_css',		
					"<!--[if IE]\n\t\t\t<link rel=\"stylesheet\" href=\"" . $this->template()->getStyle('css') . "ie.css\">\n\t\t\t<script type=\"text/javascript\">\n\t\t\t\t window.mlrunShim = true;\n\t\t\t</script>\n\t\t<![endif]-->",
					'menu.js' => 'style_script',
					"<!--[if lt IE 7]>\n\t\t\t<link rel=\"stylesheet\" href=\"" . $this->template()->getStyle('css') . "ie6.css\">\n\t\t<![endif]-->",
					"<!--[if IE 6]>\n\t\t\t<script type=\"text/javascript\" src=\"" . Phpfox::getParam('core.url_static_script') . "admin_ie6.js\"></script>\n\t\t<![endif]-->",
					'admin.js' => 'static_script'
				)
			)->setTitle(Phpfox::getPhrase('admincp.admin_cp'));		
		
		if ($bPass)
		{		
			Phpfox::getLib('module')->setController($this->_sModule . '.' . $this->_sController);			
			
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
			
			$this->template()->assign(array(
					'aCachedSubMenus' => $aCachedSubMenus,
					'sActiveSideBar' => $sActiveSideBar,
					'bIsModuleConnection' => $bIsModuleConnection,
					'sMenuController' => $sMenuController,
					'aActiveMenus' => (($bIsModuleConnection && isset($aCachedSubMenus[$sActiveSideBar])) ? $aCachedSubMenus[$sActiveSideBar] : array())
				)
			);				
		}
		else 
		{
			if ($this->_sModule != Phpfox::getParam('admincp.admin_cp'))
			{
				Phpfox::getLib('module')->setController('error.404');		
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
				
				Phpfox::getLib('module')->setCacheBlockData(array(
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
						'bIsDashboard' => true
					)
				);
			}
		}	
		
		if (defined('PHPFOX_IS_HOSTED_SCRIPT') && !defined('PHPFOX_GROUPLY_TEST'))
		{
			$iTotalSpaceUsed = Phpfox::getLib('cdn')->getUsage();
			if ($iTotalSpaceUsed > Phpfox::getParam('core.phpfox_grouply_space'))
			{
				return Phpfox::getLib('module')->setController('admincp.limit');
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