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
{if !Phpfox::getParam('apps.enable_api_support')}
<div class="message">
	{phrase var='apps.api_support_is_disabled_at_the_moment'}
</div>
{else}
{if Phpfox::getUserParam('apps.can_moderate_apps') && !$aApp.view_id}

{/if}
{if $aApp.user_id == Phpfox::getUserId()}
	<div class="item_bar">
		<div class="item_bar_action_holder">
			<a href="#" class="item_bar_action"><span>{phrase var='apps.actions'}</span></a>		
			<ul>
				<li><a href="{url link='apps.add' id=$aApp.app_id}">{phrase var='apps.manage'}</a></li>
			</ul>			
		</div>		
	</div>
{/if}

{if empty($aApp.app_url)}
<div class="extra_info">
	{if $aApp.user_id == Phpfox::getUserId()}
	{phrase var='apps.this_app_currently_does_not_have_a_call_home_url_set'}
	{else}
	{phrase var='apps.this_app_is_still_under_development'}
	{/if}
</div>
{else}
<div><input type="hidden" name="app_id" value="{$aApp.app_id}" id="js_apps_view_id" /></div>
<iframe class="app_iframe" src="{$sFrameUrl}" name="apps_iframe" id="apps_iframe" scrolling="no" frameborder="0"></iframe>
{/if}
<div class="app_footer">
	<ul class="extra_info_middot">
		<li><a href="{permalink module='pages' id=$aApp.page_id title=$aApp.app_title}">{$aApp.app_title}</a><li>	
	{if Phpfox::isModule('report')}		
		<li>&middot;</li>
		<li><a href="#?call=report.add&amp;height=210&amp;width=400&amp;type=apps&amp;id={$aApp.app_id}" class="inlinePopup">{phrase var='apps.report_this_app'}</a></li>
	{/if}	
		<li>&middot;</li>
		<li><a href="#" onclick="$Core.composeMessage({l}user_id: {$aApp.user_id}{r}); return false;">{phrase var='apps.contact_the_developer'}</a></li>
		<li>&middot;</li>
		<li>
			<a href="{url link='apps' uninstall=$aApp.app_id}" class="no_ajax_link" onclick="if (!confirm(oTranslations['core.are_you_sure'])) {l} return false; {r}">
				{phrase var='apps.un_install_this_app'}
			</a>
		</li>
	</ul>
</div>
{/if}