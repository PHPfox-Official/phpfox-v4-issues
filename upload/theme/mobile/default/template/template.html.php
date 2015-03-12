<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: template.html.php 1458 2010-01-29 19:28:49Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !PHPFOX_IS_AJAX_PAGE}
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN"
"http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$sLocaleDirection}" lang="{$sLocaleCode}">
	<head>
		<title>{title}</title>	
		{header}
	</head>
	<body>
		{plugin call='theme_template_body__start'}
		{if Phpfox::getParam('core.site_is_offline') && Phpfox::getUserParam('core.can_view_site_offline')}
			<div id="site_offline">
				{phrase var='core.the_site_is_currently_in_offline_mode'}
			</div>
		{/if}			
		<div id="mobile_holder">
			<div id="mobile_header">	
				{if Phpfox::getParam('core.site_is_offline') && !Phpfox::getUserParam('core.can_view_site_offline')}
				{else}
				<a href="{url link=''}" id="mobile_header_home">Home</a>
				{if Phpfox::isUser()}
				<a href="{url link='notification'}" id="mobile_header_notification" onclick="$('#js_total_new_notifications').html('0').hide();"><div class="holder"><div id="js_total_new_notifications">0</div><div class="inner">{phrase var='mobile.notifications'}</div></div></a>
				{/if}
				{/if}
				{param var='core.site_title'}
			</div>
			{if Phpfox::getParam('core.site_is_offline') && !Phpfox::getUserParam('core.can_view_site_offline')}
			{else}
			{if Phpfox::isUser()}
			<div id="mobile_search"{if isset($bIsMobileIndex)} style="display:block;"{/if}>
				<div id="header_search">	
					<div id="header_menu_space">
						<div id="header_sub_menu_search">
							<form method="post" id='header_search_form' action="{url link='search'}">																													
								<input type="text" name="q" value="{phrase var='core.mobile_search'}" id="header_sub_menu_search_input" autocomplete="off" class="js_temp_friend_search_input" />											
								<div id="div_header_sub_menu_search_input"></div>
								<a href="#" onclick='$("#header_search_form").submit(); return false;' id="header_search_button">{phrase var='core.search'}</a>
							</form>
						</div>
					</div><!-- // header_menu_space -->
				</div>	
			</div>			
			{/if}
			{/if}
			<div id="holder">
				<div id="main_content_holder">				
				{/if}			
						{if isset($aFilterMenus) && is_array($aFilterMenus) && count($aFilterMenus)}
						<a href="#" class="mobile_main_sub_menu" onclick="$('.sub_section_menu').toggle(); return false;">Menu</a>
						<div class="sub_section_menu">
							<ul>
							{foreach from=$aFilterMenus name=filtermenu item=aFilterMenu}
								{if !isset($aFilterMenu.name)}
								<li class="menu_line">&nbsp;</li>
								{else}
								<li class="{if $aFilterMenu.active}active{/if}"><a href="{$aFilterMenu.link}">{$aFilterMenu.name}</a></li>
								{/if}
							{/foreach}
							</ul>
						</div>
						{/if}				
				
					{breadcrumb}
					{if isset($aBreadCrumbTitle) && count($aBreadCrumbTitle)}
					<div id="mobile_h1_main">
						<h1><a href="{$aBreadCrumbTitle[1]}">{$aBreadCrumbTitle[0]|clean}</a></h1>
					</div>
					{/if}				
					<div id="content">
						{search}
						<div id="mobile_content">
							{error}				
							{if Phpfox::isUser() 
							|| (!Phpfox::isUser() && Phpfox::getLib('module')->getFullControllerName() == 'user.register') 
							|| (!Phpfox::isUser() && Phpfox::getLib('module')->getFullControllerName() == 'user.login')
							|| (!Phpfox::isUser() && Phpfox::getLib('module')->getFullControllerName() == 'user.password/request')
							|| (!Phpfox::isUser() && Phpfox::getLib('module')->getFullControllerName() == 'janrain.login')
							}			
							{if defined('PHPFOX_IS_USER_PROFILE') || defined('PHPFOX_IS_PAGES_VIEW')}
							{module name='profile.mobile'}
							{/if}
							{block location='2'}
							{content}
							{block location='4'}				
							{else}
							{module name='user.login-block'}
							{/if}
						</div>
					</div>
				{if !PHPFOX_IS_AJAX_PAGE}
				</div>
			</div>					
			<div id="mobile_footer">
				<ul>
					<li><a href="{url link='go-to-full-site'}" class="first">{phrase var='mobile.full_site'}</a></li>					
					<li>&middot;</li>			
					<li><a href="{url link='user.setting'}">{$sLocaleName}</a></li>					
					{if Phpfox::isUser()}
						<li>&middot;</li>			
						<li><a href="{url link='user.logout'}">{phrase var='mobile.logout'}</a></li>
					{/if}
				</ul>
			</div>		
		</div>
		{footer}
	</body>
</html>
{/if}
