<?php
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: template.html.php 6620 2013-09-11 12:10:20Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>{if !PHPFOX_IS_AJAX_PAGE}
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$sLocaleDirection}" lang="{$sLocaleCode}">
	<head>
		<title>{title}</title>	
		{header}
	</head>
	<body>
		<div{if !Phpfox::isUser()} id="nb_body_holder_guest"{elseif defined('PHPFOX_IN_DESIGN_MODE')} id="nb_in_design"{/if}>
			{body}	
			{block location='9'}
		
			<div id="header">
			
				{if !Phpfox::isUser()}
				{if Phpfox::getParam('user.hide_main_menu')}

				{else}
				<div id="nb_header_menu">
					<div class="holder">
						{menu}
						<div class="clear"></div>
					</div>
				</div>
				{/if}
				{/if}		
			
				<div class="holder">
						
					{block location='10'}
					<div id="header_holder" {if !Phpfox::isUser()} class="header_logo"{/if}>				
						<div id="header_left">
							{logo}
						</div>
						<div id="header_right">
							<div id="header_top">
								{if Phpfox::isUser() && !Phpfox::getUserBy('profile_page_id')}
								<div id="holder_notify">																	
									{notification}
									<div class="clear"></div>
								</div>
								{/if}
								{if Phpfox::isUser() && !Phpfox::getUserBy('profile_page_id')}
								<div id="nb_features">
									<a href="#" id="nb_features_link">Features</a>
									<div id="nb_features_holder">
										{assign var='bNoAppsMenu' value=true}									
										{menu}
									</div>								
								</div>
								{/if}
								<div id="header_menu_holder">
									{if Phpfox::isUser()}
									{menu_account}
									<div class="clear"></div>	
									{else}
									{module name='user.login-header'}
									{/if}							
								</div>							
								{if Phpfox::isUser() && !Phpfox::getUserBy('profile_page_id') && Phpfox::isModule('search')}
								<div id="header_search">	
									<div id="header_menu_space">
										<div id="header_sub_menu_search">
											<form method="post" id='header_search_form' action="{url link='search'}">																						
												<input type="text" name="q" value="{phrase var='core.search_dot'}" id="header_sub_menu_search_input" autocomplete="off" class="js_temp_friend_search_input" />											
												<div id="header_sub_menu_search_input"></div>
												<a href="#" onclick='$("#header_search_form").submit(); return false;' id="header_search_button">{phrase var='core.search'}</a>											
											</form>
										</div>
									</div>
								</div>	
								{/if}													
							</div>					
						</div>
						{block location='6'}
					</div>
				</div>		
			</div>
			
			<div id="nb_body">		
				<div id="{if Phpfox::isUser()}main_core_body_holder{else}main_core_body_holder_guest{/if}">		
					{block location='11'}
					<div id="main_content_holder">	
					{/if}
						<div {holder_name}>		
							<div {is_page_view} class="holder{if (defined('PHPFOX_IS_USER_PROFILE_INDEX') || defined('PHPFOX_IS_PAGES_IS_INDEX')) && Phpfox::getService('profile')->timeline()} js_is_profile_timeline{/if}">	
								
								{module name='profile.logo'}
								
								<div id="content_holder"{if isset($sMicroPropType)} itemscope itemtype="http://schema.org/{$sMicroPropType}"{/if}>
									{block location='13'}
									{block location='7'}				
									{if !defined('PHPFOX_IS_USER_PROFILE') && !defined('PHPFOX_IS_PAGES_VIEW')}
									
									{block location='12'}
									{/if}
		
									{if !$bUseFullSite}		
									{if defined('PHPFOX_IN_DESIGN_MODE') && Phpfox::getService('profile')->timeline()}
									
									{else}			
									<div id="left" class="content_column">
									
										{if defined('PHPFOX_IS_USER_PROFILE') || defined('PHPFOX_IS_PAGES_VIEW') || !Phpfox::isUser()}
										{menu_sub}
										{block location='1'}																
										{else}
										<div id="nb_name">
											<div class="nb_name_image">
												{$sUserProfileImage}
											</div>
											<div class="nb_name_info">
												<a href="{$sUserProfileUrl}" class="nb_name_link">{$sCurrentUserName}</a>
												<div class="nb_name_edit">
													<a href="{url link='user.profile'}">{phrase var='theme.edit_profile'}</a>
												</div>
											</div>
										</div>
										
										<div id="nb_favorites" class="block">
											<div class="title">
												<a href="#" class="nb_edit_block_title">{phrase var='theme.edit'}</a>
												{phrase var='theme.favorites'}
											</div>
											<div id="nb_main_menu">
												{assign var='iTotalHide' value=8}
												{menu}
											</div>		
										</div>
										
										{if Phpfox::getLib('module')->getFullControllerName() == 'core.index-member'}										
										{menu_sub}
										{block location='1'}
										
										<a href="{url link='core.index-member.customize'}" class="no_ajax_link nb_customize_dash">{phrase var='core.customize_dashboard'}</a>
										
										{/if}								
															
										{/if}
										
									</div>	
									{/if}				
									{/if}
		
									<div id="main_content">
												
										{if !defined('PHPFOX_IS_USER_PROFILE') && !defined('PHPFOX_IS_PAGES_VIEW')}
										{breadcrumb}
										{search}
										{/if}
										<div id="main_content_padding">
		
											{if defined('PHPFOX_IS_USER_PROFILE') || defined('PHPFOX_IS_PAGES_VIEW') || (isset($aPage) && isset($aPage.use_timeline) && $aPage.use_timeline)}
											    {if $bLoadedProfileHeader = true}{/if}
											    {module name='profile.header'}
											{/if}
											{if defined('PHPFOX_IS_PAGES_VIEW') && !isset($bLoadedProfileHeader)}
											    {block location='12'}
											    {module name='pages.header'}
											{/if}							
		
											<div id="content_load_data">
												{if isset($bIsAjaxLoader) || defined('PHPFOX_IS_USER_PROFILE') || defined('PHPFOX_IS_PAGES_VIEW')}
												{search}
												{/if}								
		
												{if isset($aBreadCrumbTitle) && count($aBreadCrumbTitle)}
												<h1><a href="{$aBreadCrumbTitle[1]}">{$aBreadCrumbTitle[0]|clean|split:30}</a></h1>
												{/if}
		
												<div id="content" {content_class}>
													
													{error}
													{block location='2'}
													{content}
													{block location='4'}
															
												</div>
		
												{if !$bUseFullSite}
												
												<div id="right" class="content_column">
													{if !Phpfox::isUser() || Phpfox::getLib('module')->getFullControllerName() == 'core.index-member' || defined('PHPFOX_IS_USER_PROFILE') || defined('PHPFOX_IS_PAGES_VIEW')}
													
													{else}
													{menu_sub}
													{block location='1'}
													{/if}						
													{unset var=$aMenu}	
													{block location='3'}
												</div>
												
												{/if}
		
												<div class="clear"></div>							
											</div>												
										</div>				
									</div>
									<div class="clear"></div>			
								</div>		
								{block location='8'}
								
								<div class="holder{if $bUseFullSite} nb_footer_full{else}{if defined('PHPFOX_IS_USER_PROFILE_INDEX') && Phpfox::getService('profile')->timeline()} js_is_profile_timeline{/if}{/if}">
									<div id="nb_footer">
									{menu_footer}					
									<div id="nb_copyright">
										{copyright}
									</div>				
									{block location='5'}
									</div>				
								</div>
							</div>							
						</div>			
					{if !PHPFOX_IS_AJAX_PAGE}
					</div>				
                                        
					{footer}		
				</div>		
			</div>		
		</div>		
	</body>
</html>
{/if}