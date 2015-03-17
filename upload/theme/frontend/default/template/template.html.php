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
							<div id="holder_notify">
								{notification}
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

			<div id="header_menu_page_holder">
				<div class="holder">
					<div id="header_menu">
						<nav>
							{menu}
						</nav>
					</div>
				</div>
			</div>
		</div>
		
		<div id="main_core_body_holder">

			<div id="top">
				{block location='11'}
				{block location='13'}
				{block location='7'}
				{breadcrumb}
			</div>

			<div id="main_content_holder">
			{/if}

				<div {holder_name}>



					<div {is_page_view} class="holder">

						{block location='12'}

						<div id="content_holder"{if isset($sMicroPropType)} itemscope itemtype="http://schema.org/{$sMicroPropType}"{/if}>		

							<div id="main_content">

								<div id="main_content_padding">

									<div id="content_load_data">
										{if isset($bIsAjaxLoader) || defined('PHPFOX_IS_USER_PROFILE') || defined('PHPFOX_IS_PAGES_VIEW')}
										{search}
										{/if}

										{if isset($aBreadCrumbTitle) && count($aBreadCrumbTitle)}
										<h1{if isset($sMicroPropType)} itemprop="name"{/if}><a href="{$aBreadCrumbTitle[1]}"{if isset($sMicroPropType)} itemprop="url"{/if}>{$aBreadCrumbTitle[0]|clean|split:30}</a></h1>
										{/if}

										<div id="content" {content_class}>
											{error}
											{block location='2'}
											{content}
											{block location='4'}
										</div>

									</div>												
								</div>				
							</div>

							<div id="panels">
								<div id="left" class="content_column">
									{menu_sub}
									{block location='1'}
								</div>

								<div id="right" class="content_column">
									{if !defined('PHPFOX_IS_USER_PROFILE') && !defined('PHPFOX_IS_PAGES_VIEW')}
									{search}
									{/if}
									{block location='3'}
								</div>
							</div>

						</div>		
						{block location='8'}
					</div>							
				</div>			
			{if !PHPFOX_IS_AJAX_PAGE}
			</div>		
			<div id="main_footer_holder">
				<div class="holder">
					<div id="footer">
						<footer>		
							<nav>
								{menu_footer}
							</nav>					
							<div id="copyright">
								{copyright}
							</div>
							<div class="clear"></div>				
							{block location='5'}
						</footer>
					</div>				
				</div>			
			</div>
                        
            {footer}
		</div>        
    </body>
</html>
{/if}