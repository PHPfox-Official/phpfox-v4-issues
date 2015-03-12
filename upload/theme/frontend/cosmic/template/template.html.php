<?php
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: template.html.php 2832 2011-08-15 17:36:44Z Raymond_Benc $
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
		{body}	
		{block location='9'}
		<div id="header">			
			<div class="holder">
				{block location='10'}
				<div id="header_holder" {if !Phpfox::isUser()} class="header_logo"{/if}>				
					<div id="header_left">
						{logo}
					</div>
					<div id="header_right">
						<div id="header_top">
							{if Phpfox::isUser()}
							<div id="holder_notify">																	
								{notification}
								<div class="clear"></div>
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
							{if Phpfox::isUser()}
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
						
			{if Phpfox::getParam('user.hide_main_menu') && !Phpfox::isUser()}
			
			{else}
			<div id="header_menu_page_holder">	
				<div class="holder">
					<div id="header_menu">
						{menu}
						<div class="clear"></div>
					</div>		
				</div>			
			</div>	
			{/if}					
		</div>
		
		<div id="{if Phpfox::isUser()}main_core_body_holder{else}main_core_body_holder{/if}">
		
			{block location='11'}		

			<div id="main_content_holder">
			{/if}
				<div class="holder">
					<div class="main_breadcrumb_holder">
						{foreach from=$aBreadCrumbs key=sLink item=sCrumb name=link}
						{if $phpfox.iteration.link == 1}
						<h1>{if !empty($sLink)}<a href="{$sLink}" class="ajax_link">{/if}{$sCrumb|clean}{if !empty($sLink)}</a>{/if}</h1>
						{/if}
						{/foreach}
						{if !defined('PHPFOX_IS_USER_PROFILE') && !defined('PHPFOX_IS_PAGES_VIEW')}
						{breadcrumb_menu}
						{/if}
					</div>
				</div>		

				<div {holder_name}>		
					<div {is_page_view} class="holder">	
						<div id="content_holder">		
							{block location='13'}
							{block location='7'}	
							
							{module name='profile.logo'}

							{if !$bUseFullSite && (count($aBlocks1) || count($aAdBlocks1)) || (isset($aFilterMenus) && is_array($aFilterMenus) && count($aFilterMenus))}					
							<div id="left" class="content_column">
								{menu_sub}
								{block location='1'}					
							</div>					
							{/if}

							<div id="main_content">
								{if !defined('PHPFOX_IS_USER_PROFILE') && !defined('PHPFOX_IS_PAGES_VIEW')}
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

										{if !$bUseFullSite && (count($aBlocks3) || count($aAdBlocks3))}
										<div id="right" class="content_column">								
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
					</div>							
				</div>	

				<div id="main_footer_holder">
					<div class="holder">				
						{breadcrumb_list}				
						<div id="footer">							

							{menu_footer}					
							<div id="copyright">
								{copyright}
							</div>
							<div class="clear"></div>				
							{block location='5'}
						</div>				
					</div>			
				</div>			

			{if !PHPFOX_IS_AJAX_PAGE}
			</div>
                        
			{footer}		
		</div>
	</body>
</html>
{/if}