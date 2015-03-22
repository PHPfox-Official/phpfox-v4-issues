<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_User
 * @version 		$Id: status.html.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='current'}" onsubmit="$(this).ajaxCall('user.updateStatus'); return false;" id="js_user_status_form">
	<div id="header_top_notify" style="position:absolute;">
		<ul>		
		{if Phpfox::isModule('notification') && Phpfox::getParam('notification.notify_on_new_request')}
			{module name='notification.link'}						
		{else}
			<li><a href="{url link='user.photo'}">{$sUserGlobalImage}</a></li>
		{/if}
			<li class="status">
				<span id="js_current_user_status">
					<a href="#" title="{phrase var='user.click_to_change_your_status'}" class="status js_update_status">{phrase var='user.status'}:</a>	
					<a href="#" title="{phrase var='user.click_to_change_your_status'}" class="js_update_status js_actual_user_status_{$iCurrentUserId}">{if empty($sUserCurrentStatus)}{phrase var='user.none'}{else}{$sUserCurrentStatus|clean|shorten:80}{/if}</a>
				</span>
				<span style="display:none;" id="js_update_user_status">	
						<input type="text" name="status" value="{$sUserCurrentStatus|clean}" style="vertical-align:middle; padding:0px;" size="30" id="js_status_input" maxlength="160" onfocus="this.select();" />
						{phrase var='user.a_href_onclick_js_user_status_form_ajaxcall_user_updatestatus_return_false_save_a_or_a_href_class_js_update_status_cancel_a'}
				</span>	
			</li>
		</ul>
		<div class="clear"></div>
	</div>
</form>