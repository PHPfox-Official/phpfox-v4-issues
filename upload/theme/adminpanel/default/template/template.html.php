<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: template.html.php 5581 2013-03-28 07:36:56Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$sLocaleDirection}" lang="{$sLocaleCode}">
	<head>
		<title>{title}</title>	
	{header}
	</head>
	<body>	
		<div id="global_ajax_message"></div>
		
		<div id="top_holder">
		
		<div id="main_top_fixed">
			<div id="main_top">
				<div class="main_holder">
					<div id="main_top_inner">
						<a href="{url link='admincp'}" id="logo">AdminCP</a>
						<div id="user_info_link">
							{phrase var='admincp.logged_in_as' user=$aUserDetails} <span class="separator">|</span> <a href="{url link=''}">{phrase var='admincp.view_site'}</a>					
						</div>
					</div>
				</div>
			</div>
		<div id="top">
		
			<div class="main_holder">
		
				<div id="top_right">
					
					

			
					<div id="admincp_search">
						<div id="admincp_search_inner">
							<div id="admincp_search_input_default_value">{phrase var='admincp.search'}</div>
							<input type="text" name="q" value="{phrase var='admincp.search'}" id="admincp_search_input" class="admincp_search_input" autocomplete="off" />
							<div id="admincp_search_input_results"></div>
						</div>
					</div>			
					
					
					<div class="main_menu_holder">
						<ul class="main_menu">
						{foreach from=$aAdminMenus key=sPhrase item=sLink}
							{if is_array($sLink)}
							{if count($sLink)}
							<li class="main_menu_link_li"><a class="main_menu_link" href="#">{phrase var=$sPhrase}</a>
								<div class="main_sub_menu">
								{foreach from=$sLink key=sPhrase2 item=sLink2}
									<div class="main_sub_menu_holder">
										{if is_array($sLink2)}
										{if count($sLink2)}
										<div class="main_sub_menu_holder_header">{phrase var=$sPhrase2}</div>
										<ul>
											{foreach from=$sLink2 key=sPhrase3 item=sLink3}
											<li><a href="{url link=""$sLink3""}">{phrase var=$sPhrase3}</a></li>
											{/foreach}	
										</ul>										
										{/if}
										{else}
										<ul>
											<li><a href="{url link=""$sLink2""}" class="group_menu_sub_clone">{phrase var=$sPhrase2}</a></li>
										</ul>
										{/if}
									</div>						
								{/foreach}
									<div class="clear"></div>
								</div>
							</li>
							{/if}
							{else}
							<li><a href="{url link=''$sLink''}" class="main_menu_link">{phrase var=$sPhrase}</a></li>
							{/if}
						{/foreach}
					{if is_array($aModulesMenu) && count($aModulesMenu)}	
							<li class="main_menu_link_li"><a class="main_menu_link" href="#">{phrase var='admincp.modules'}</a>
						<div class="main_sub_menu">	
					
						
							{foreach from=$aModulesMenu item=aModule}
							{if isset($aModule.module_id)}
							<div class="main_sub_menu_holder">
								<div class="main_sub_menu_holder_header">{if isset($aModule.module_image)}<img src="{$aModule.module_image}" /> {/if}{translate var=$aModule.module_id prefix='module'}</a></div>
								{if $aModule.menu}
								<ul>
								{foreach from=$aModule.menu key=sMenuName item=aMenu}
									<li><a href="{url link="admincp."$aMenu.url""}" class="group_menu_sub_clone">{phrase var=$sMenuName}</a></li>
								{/foreach}
								</ul>
								{/if}								
							</div>
							{/if}
							{/foreach}				
						
					
					</div>
						
							</li>					
					{/if}	
						</ul>				
						<div class="clear"></div>		
					</div>					
									
				</div>
				<div class="clear"></div>
			
			</div>
			
		</div>
		
		</div>
		
		</div>
		
		<div id="main_body_holder"></div>
			<div class="main_holder">					
				<div id="js_content_container">					
					<div id="main">						
						{if $iBreadTotal = count($aBreadCrumbs)}
						<div class="main_title_holder">
							
						{if count($aBreadCrumbs) == 1}
						<div id="main_title_holder">
							{foreach from=$aBreadCrumbs key=sLink item=sCrumb name=link}
								<h1>{if !empty($sLink)}<a href="{$sLink}" class="{if $phpfox.iteration.link == '1'} first{/if}">{/if}{$sCrumb|clean}{if !empty($sLink)}</a>{/if}</h1>								
							{/foreach}				
						</div>
						{else}
						{if $iBreadTotal = count($aBreadCrumbs)}{/if}		
						<div id="breadcrumb_list">
							<ul>
							{foreach from=$aBreadCrumbs key=sLink item=sCrumb name=link}
								<li><a href="{$sLink}" class="{if $phpfox.iteration.link == '1'} first{/if}">{$sCrumb|clean}</a></li>
								{if $iBreadTotal != $phpfox.iteration.link}<li>&raquo;</li>{/if}
							{/foreach}
							</ul>
							<div class="clear"></div>
						</div>
												
							
							<div id="main_title_holder">
									{if isset($aBreadCrumbTitle) && count($aBreadCrumbTitle)}
									<h1><a href="{$aBreadCrumbTitle[1]}">{$aBreadCrumbTitle[0]|clean}</a></h1>
									{/if}
							</div>
						
						{/if}
						
						</div>
						{/if}		
						
						
					{if isset($bIsModuleConnection) && $bIsModuleConnection && count($aActiveMenus)}
					<div id="breadcrumb_holder">
						<div id="breadcrumb_position">
							<ul id="breadcrumb_menu">
							{foreach from=$aActiveMenus key=sPhrase item=sLink}
								<li{if $sMenuController == $sLink} class="active"{/if}><a href="{url link=$sLink}">{phrase var=$sPhrase}</a></li>
							{/foreach}
							</ul>
						</div>
					</div>
					{/if}						
					{if isset($bIsModuleConnection) && $bIsModuleConnection && count($aActiveMenus)}
						<div id="breadcrumb_content_holder">
					{/if}
						{error}
						{content}
					{if isset($bIsModuleConnection) && $bIsModuleConnection && count($aActiveMenus)}
						</div>
					{/if}						
					</div>
				</div>		
				
				<div id="copyright">
					{param var='core.site_copyright'} {product_branding}
				</div>		
						
			</div>		
		{plugin call='theme_template_body__end'}	
        {loadjs}
	</body>
</html>