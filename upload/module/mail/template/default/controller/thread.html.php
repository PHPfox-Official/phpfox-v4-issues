<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Mail
 * @version 		$Id: view.html.php 3369 2011-10-28 16:04:06Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="js_main_mail_thread_holder">
	
	<div class="item_bar">
		<div class="item_bar_action_holder">
			<a href="#" class="item_bar_action"><span>{phrase var='mail.actions'}</span></a>	
			<ul>				
				{if Phpfox::isModule('report')}
				<li><a href="#?call=report.add&amp;height=210&amp;width=400&amp;type=mail&amp;id={$aThread.thread_id}" class="inlinePopup" title="{phrase var='mail.report_this_message'}">{phrase var='mail.report'}</a></li>
				{/if}			
				{if isset($aThread.user_is_archive) && $aThread.user_is_archive}				
				<li class="item_delete"><a href="{url link='mail' action='unarchive' id=$aThread.thread_id}" onclick="return confirm('{phrase var='mail.are_you_sure' phpfox_squote=true}')">{phrase var='mail.unarchive'}</a></li>				
				{else}
				<li class="item_delete"><a href="{url link='mail' action='archive' id=$aThread.thread_id}" onclick="return confirm('{phrase var='mail.are_you_sure' phpfox_squote=true}')">{phrase var='mail.archive'}</a></li>
				{/if}
				<li class="item_delete"><a href="{url link='mail' action='forcedelete' id=$aThread.thread_id}" onclick="return confirm('{phrase var='mail.are_you_sure' phpfox_squote=true}')">{phrase var='mail.delete_conversation'}</a></li>
			</ul>				
		</div>		
	</div>	
	
	<div id="js_mail_thread_current_cnt">{$sCurrentPageCnt}</div><br />
	<div id="feed_view_more_loader">
		{img theme='ajax/add.gif'}
	</div>	
	{if count($aMessages) >= 10}
	<a href="#" id="js_mail_thread_view_more" class="global_view_more no_ajax_link" rel="{$aThread.thread_id}">{phrase var='mail.view_more'}</a>
	{/if}
	<div id="mail_threaded_view_more_messages"></div>
	{foreach from=$aMessages name=messages item=aMail}
	{template file='mail.block.entry'}
	{/foreach}
	<div id="mail_threaded_new_message"></div>
	<div id="mail_threaded_new_message_scroll"></div>
	<div class="mail_thread_form_holder">
		<div class="mail_thread_form_holder_inner">		
			{$sCreateJs}
			<form method="post" action="{url link='mail.thread' id=$aThread.thread_id}" id="js_form_mail" onsubmit="if ({$sGetJsForm}) {l} $Core.addThreadMail(this); {r} return false;">
				<div><input type="hidden" name="val[thread_id]" value="{$aThread.thread_id}" /></div>
				<div><input type="hidden" name="val[attachment]" class="js_attachment" value="{value type='input' id='attachment'}" /></div>
				<div class="table" id="js_mail_textarea">
					{editor id='message' rows='8'}
				</div>
				<div class="table_clear">
					<input type="submit" value="{phrase var='mail.send'}" class="button" id="js_mail_submit" />
				</div>
			</form>
		</div>
	</div>	
	
	{moderation}
	
</div>