<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: view-mobile.html.php 1491 2010-03-03 15:34:04Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<h1>{$aMail.subject|clean}</h1>
<div class="item">
	<div class="item_image">
		{if $aMail.owner_user_id == Phpfox::getUserId()}
			{img user=$aMail user_suffix='viewer_' suffix='_50_square' max_width=35 max_height=35}
		{else}
			{img user=$aMail user_suffix='owner_' suffix='_50_square' max_width=35 max_height=35}
		{/if}
	</div>	
	<div class="item_content">
		{if $aMail.owner_user_id == Phpfox::getUserId()}
			{if $aMail.owner_user_id == $aMail.viewer_user_id && $aMail.owner_user_id == Phpfox::getUserId()}
			{phrase var='mail.you_wrote_to_yourself_at_time_stamp' time_stamp=$aMail.time_stamp|date:'mail.mail_time_stamp'}
			{else}
			{phrase var='mail.you_wrote_to_user_name_at_time_stamp' user_name=$aMail|user:'viewer_' time_stamp=$aMail.time_stamp|date:'mail.mail_time_stamp'}
			{/if}	
		{elseif $aMail.owner_user_id != 0}
			{phrase var='mail.user_name_wrote_at_time_stamp' user_name=$aMail|user:'owner_' time_stamp=$aMail.time_stamp|date:'mail.mail_time_stamp'}
		{else}
			{phrase var='mail.site_sent_you_a_message' site=$sSite}
		{/if}
		<div style="margin-top:6px;">
			{$aMail.text|parse|split:100}
			{if $aMail.parent_id && $aMail.text_reply}
			<div class="quote">
				<div class="quote_body">
					{$aMail.text_reply|parse|split:80}
				</div>
			</div>
			{/if}			
		</div>
	</div>
	<div class="clear"></div>
</div>

<h2>Reply</h2>
<div class="comment_mini comment_mini_form">
	<form method="post" action="{url link='mail.view' id=$aMail.mail_id}">			
		<div><input type="hidden" name="val[parent_id]" value="{$aMail.mail_id}" /></div>
		<textarea cols="60" rows="6" name="val[message]" style="width:100%;"></textarea>
		<div class="t_right">
			<input type="submit" value="{phrase var='feed.post'}" class="button" />
		</div>
	</form>
</div>