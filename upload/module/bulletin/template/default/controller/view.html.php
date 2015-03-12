<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_Bulletin
 * @version 		$Id: view.html.php 2298 2011-02-07 15:41:02Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	<div class="item_view_photo">
		{img user=$aBulletin suffix='_75' max_width=75 max_height=75}
	</div>
	<div>
	<div class="item_info">
		{$aBulletin.posted_on}		
	</div>		
	
	{if $aBulletin.view_id == '1'}
	<div class="message">
		{phrase var='bulletin.bulletin_is_pending_an_admins_approval'}
	</div>
	<form method="post" action="{url link='bulletin.view' id=$aBulletin.bulletin_id}">
		<div><input type="hidden" name="approve" value="1" /></div>
		<input type="submit" value="{phrase var='bulletin.approve_bulletin'}" class="button" />
	</form>
	{/if}	
	
	{$aBulletin.text|parse}		
	<br />

		<div class="t_right">
			<ul class="item_menu">
			{if Phpfox::isModule('report')}
				{if $aBulletin.user_id != Phpfox::getUserId()}<li><a href="#?call=report.add&amp;height=210&amp;width=400&amp;type=bulletin&amp;id={$aBulletin.bulletin_id}" class="inlinePopup" title="{phrase var='bulletin.report_a_bulletin'}">{phrase var='bulletin.report'}</a></li>{/if}
			{/if}				
			{if Phpfox::getUserId() != $aBulletin.user_id}
				<li><a href="#" onclick="$('#js_add_new_reply').slideDown(); {plugin call='bulletin.template_default_controller_view_reply_link'} return false;">{phrase var='bulletin.private_reply'}</a></li>
			{/if}			
			{if ((Phpfox::getUserParam('bulletin.bulletin_edit_own') && Phpfox::getUserId() == $aBulletin.user_id) || 
				Phpfox::getUserParam('bulletin.bulletin_can_edit_others'))}
				<li><a href="{url link='bulletin.add' id={$aBulletin.bulletin_id}">{phrase var='bulletin.edit'}</a></li>
			{/if}		
			{if ((Phpfox::getUserParam('bulletin.bulletin_can_delete_own') && Phpfox::getUserId() == $aBulletin.user_id) || Phpfox::getUserParam('bulletin.bulletin_can_delete_others'))}	
				<li><a href="{url link='bulletin' delete=$aBulletin.bulletin_id}" class="sJsConfirm">{phrase var='bulletin.delete'}</a></li>
			{/if}						
			</ul>
		</div>

		{if Phpfox::getUserId() != $aBulletin.user_id}
		{$sCreateJs}
		<div id="js_add_new_reply" style="display:none;">
			<div class="main_break"></div>
			<form method="post" action="{url link='bulletin.view' id=$aBulletin.bulletin_id}" id="js_form" name="js_form" onsubmit="{$sGetJsForm}">
				<div class="table">
					<div class="table_left">
						<label for="message">{phrase var='bulletin.reply'}:</label>
					</div>
					<div class="table_right">
						{editor id='message' rows='5'}
						<div class="extra_info">
							{phrase var='bulletin.this_message_will_be_sent_as_a_private_message_to_user_link' user=$aBulletin}
						</div>			
					</div>
				</div>
				<div class="table_clear">
					<input type="submit" value="{phrase var='bulletin.reply'}" class="button" id="js_bulletin_reply" /> - <a href="#" onclick="$('#js_add_new_reply').slideUp(); return false;">{phrase var='bulletin.cancel'}</a>				
				</div>			
			</form>	
		</div>
		{/if}
		
		{if isset($aAttachments)}
			{module name='attachment.list' sType='bulletin' attachments=$aAttachments}
		{/if}		
		
		{if Phpfox::isModule('comment') && Phpfox::getParam('bulletin.can_post_comments_on_bulletin') && $aBulletin.allow_comment != 0}
		<div id="js_comment_module">
			{module name='comment.display' sItemUserName=$aBulletin.user_name sType='bulletin' iTotal=$aBulletin.total_comment iItemId=$aBulletin.bulletin_id iItemUser=$aBulletin.user_id}
		</div>
		{/if}		
	</div>