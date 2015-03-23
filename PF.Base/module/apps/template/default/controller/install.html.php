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
<div id="request_container">
	<div id="request_header">
		{phrase var='apps.install_this_app'}
	</div>
	<div id="app_request_holder">		
	
		<div id="app_request_perm_list">
			<div id="app_request_perm_info">
				{phrase var='apps.in_order_to_use_app_title' app_title=$aApp.app_title}:
			</div>
			{foreach from=$aPermissions key=sPhrase item=aPermission}
			<div class="permission">	
				<div class="permission_description">
					{$aPermission.sPhrase}
				</div>
				<div class="allow_or_not">
					<select class="select_allow" id="{$aPermission.sVariable}">
						<option value="1">{phrase var='apps.allow'}</option>
						<option value="2">{phrase var='apps.don_t_allow'}</option>
					</select>
				</div>
			</div>
			{/foreach}
	
		{if Phpfox::isModule('report')}		
			<div id="app_request_report">
				<a href="#?call=report.add&amp;height=210&amp;width=400&amp;type=apps&amp;id={$aApp.app_id}" class="inlinePopup" title="{phrase var='apps.report_this_app'}">
					{phrase var='apps.report_this_application'}
				</a>
			</div>	
		{/if}	
		</div>
		<div id="app_request_title">		
			<a href="{permalink module='pages' id=$aApp.page_id title=$aApp.app_title}" class="app_request_link">
				{$aApp.app_title|clean}
			</a>
			<div class="app_request_image">
				<a href="{permalink module='pages' id=$aApp.page_id title=$aApp.app_title}" class="app_request_link">{img server_id=0 path='app.url_image' file=$aApp.image_path suffix='_200' max_width=150 max_height=150 title=$aApp.app_title}</a>
			</div>
			<div class="app_request_developed">
				{phrase var='apps.developed_by_user' full_name=$aApp.full_name}
			</div>
			{if $aApp.total_like > 0}
			<div class="app_request_liked">
				<a href="#" onclick="$Core.box('like.browse', 300, 'type_id=pages&amp;item_id={$aApp.page_id}&amp;force_like=true'); return false;">
				{if $aApp.total_like == '1'}
				{phrase var='apps.1_like'}
				{else}
				{phrase var='apps.total_like_likes' total_like=$aApp.total_like|number_format}
				{/if}
				</a>
			</div>
			{/if}
		</div>	
	</div>
	<div id="confirmation">
		<div id="confirmation_buttons">
			<ul class="table_clear_button">
				<li><input type="button" class="button" value="{phrase var='apps.install'}" onclick="allowApp({$aApp.app_id});" /></li>
				<li><input type="button" class="button button_off" value="{phrase var='apps.don_t_install'}" onclick="window.location = oParams['sJsHome'];" /></li>
			</ul>
			<div class="clear"></div>
		</div>		
		{phrase var='apps.you_are_logged_in_as_full_name' full_name=$aUser.full_name}
	</div>
</div>