<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: chat.html.php 4156 2012-05-08 14:12:50Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<script type="text/javascript">var bChatImIsClicked = false;</script>
<div class="im_holder js_footer_holder js_im_room_holder" id="js_chat_room_{$aChat.parent_id}">
	<div class="im_header" onclick="if (bChatImIsClicked === false) {l} minimizeChat({$aChat.parent_id}); {r}">
		<div class="im_in_chat_menu">
			<div class="im_in_chat_menu_holder">
				<a href="#" onclick="bChatImIsClicked = true; $(this).parents('.im_header').find('.im_in_chat_menu_bar:first').slideToggle('fast', function(){l} bChatImIsClicked = false; {r}); return false;">{img theme='layout/im_option.png' class='v_middle'}</a>
				<a href="#" onclick="closeChat({$aChat.parent_id}); return false;">{img theme='layout/im_close.png' class='v_middle'}</a>
				<div class="clear"></div>
			</div>
		</div>		
		{$aChat.full_name|clean|shorten:15:'...'}
		<div class="im_in_chat_menu_bar">		
			<a class="first" href="#" onclick="tb_show('{phrase var='im.report_this_user' phpfox_squote=true}', $.ajaxBox('report.add', 'height=210&width=400&type=user&id={$aChat.user_id}')); return false;">{phrase var='im.report_this_user'}</a>
			<a href="#" onclick="return $Core.im.block('{$aChat.parent_id}');">{phrase var='im.block_this_user'}</a>						
			<a href="#" onclick="var e = arguments[0] || window.event; $Core.im.clearConversation('{$aChat.parent_id}'); e.cancelBubble = true; e.stopPropagation(); return false;">{phrase var='im.clear_this_conversation'}</a>
		</div>		
	</div>
	<div id="js_im_content">
		<div id="js_im_messages_{$aChat.parent_id}" style="padding:4px;">
			{module name='im.message'}
		</div>
	</div>
	<div class="im_text_form">		
		<div class="im_text_form_img">{img theme='layout/im_chat_textarea.png'}</div>
		<form method="post" action="#" id="js_im_temp_form">
			<div><input type="hidden" name="val[parent_id]" value="{$aChat.parent_id}" /></div>
			<textarea cols="20" rows="4" name="val[text]" id="js_im_text" onkeyup="$Core.im.onKeyUp(event);"></textarea>			
		</form>
	</div>	
</div>