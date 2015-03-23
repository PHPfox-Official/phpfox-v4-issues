<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aApps)}

	{foreach from=$aApps name=apps item=aApp}
	<div id="js_apps_{$aApp.app_id}" class="{if is_int($phpfox.iteration.apps/2)}row1{else}row2{/if}{if $phpfox.iteration.apps == 1 && !PHPFOX_IS_AJAX} row_first{/if}">		
		<div class="row_title">	
			<div class="row_title_image">
				<a href="{permalink module='apps' id=$aApp.app_id title=$aApp.app_title}">{img server_id=0 path='app.url_image' file=$aApp.image_path suffix='_square' max_width=50 max_height=50 title=$aApp.app_title}</a>
				
				{if Phpfox::getUserParam('apps.can_moderate_apps') || (isset($aApps.user_id) && $aApps.user_id == Phpfox::getUserId())}
				<div class="row_edit_bar_parent">
					<div class="row_edit_bar_holder">
						<ul>
							{template file='apps.block.link'}
						</ul>			
					</div>
					<div class="row_edit_bar">				
							<a href="#" class="row_edit_bar_action"><span>{phrase var='apps.actions'}</span></a>							
					</div>
				</div>
				{/if}
				
				{if Phpfox::getUserParam('apps.can_moderate_apps')}
				<a href="#{$aApp.app_id}" class="moderate_link" rel="apps">{phrase var='apps.moderate'}</a>
				{/if}
			</div>
			<div class="row_title_info">
				<a href="{permalink module='apps' id=$aApp.app_id title=$aApp.app_title}" class="link">{$aApp.app_title|clean|shorten:55:'...'|split:40}</a>			
				<div class="extra_info">
					<ul class="extra_info_middot">{if isset($aApp.category_name)}<li>{$aApp.category_name|convert}</li>{/if}</ul>
				</div>					
				<div class="item_content">
					{$aApp.app_description|clean}
				</div>
				{module name='feed.comment' aFeed=$aApp.aFeed}		
			</div>							
		</div>
	</div>
	{/foreach}
	
	{if Phpfox::getUserParam('apps.can_moderate_apps')}
	{moderation}
	{/if}
	
	{pager}
{else}
<div class="extra_info">
	{phrase var='apps.no_apps_found'}
</div>
{/if}