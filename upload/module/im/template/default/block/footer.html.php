<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: footer.html.php 6517 2013-08-28 11:12:43Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if Phpfox::getParam('im.enable_im_in_footer_bar') && Phpfox::isUser()}
	<div id="im_footer_wrapper">
		<ul id="im_footer_bar">
			<li id="im_chats_lists">
				{if Phpfox::getUserBy('im_hide') != '1'}
					{module name='im.user'}
				{/if}
			</li>
			<li id="js_im_holder">
				<div id="main_messenger_holder"> </div>
				<div id="main_messenger_link" onclick="if (typeof $Core.im != 'undefined'){l}$Core.im.toggleMessengerLink();{r} return false;">
				{if Phpfox::getUserBy('is_invisible')}
					<a href="{url link='user.privacy' enable='chat'}" title="{phrase var='im.instant_messenger'}">
				{else}
					<a href="#" title="{phrase var='im.instant_messenger'}" id="js_instant_messenger_link">
				{/if}
						<span id="js_im_status_offline" class="im_status_image"{if Phpfox::getUserBy('im_status') != '2' && Phpfox::getUserBy('im_hide') != '1'} style="display:none;"{/if}>{img theme='misc/status_offline.png' class='v_middle'}</span>		
						<span id="js_im_status_away" class="im_status_image"{if Phpfox::getUserBy('im_status') != '1' || Phpfox::getUserBy('im_hide') == '1'} style="display:none;"{/if}>{img theme='misc/status_away.png' class='v_middle'}</span>
						<span id="js_im_status_online" class="im_status_image"{if Phpfox::getUserBy('im_status') != '0' || Phpfox::getUserBy('im_hide') == '1'} style="display:none;"{/if}>{img theme='misc/status_online.png' class='v_middle'}</span>		

						<span id="js_im_display_offline" class="im_status_display"{if Phpfox::getUserBy('im_hide') != '1'} style="display:none;"{/if}>{phrase var='im.chat'} ({phrase var='im.offline'})</span>
						<span id="js_im_display_online" class="im_status_display"{if Phpfox::getUserBy('im_hide') == '1'} style="display:none;"{/if}>{phrase var='im.chat'} (<span id="js_im_total_friend_count">{$iTotalFriendsOnline}</span>)</span>
					</a>
				{if Phpfox::getUserBy('im_hide') != '1' && Phpfox::getUserBy('footer_bar') != '1'}
				<script type="text/javascript">
				{if PHPFOX_IS_AJAX}
					{if $sLastOpenWindow == 'messenger'}
						$.ajaxCall('im.load','','GET');  
					{elseif $sLastOpenWindow == 'chat'}
						$.ajaxCall('im.open', 'id={$sLastWindowParam}');  
					{else}
						{* $.ajaxCall('im.getRooms','','GET');   *}
					{/if}	
					{else}
					{if $sLastOpenWindow == 'messenger'}
						setTimeout("$.ajaxCall('im.load','','GET');", 2000);  
					{elseif $sLastOpenWindow == 'chat'}
						setTimeout("$.ajaxCall('im.open', 'id={$sLastWindowParam}');", 2000);
					{/if}
				{/if}
				</script>
				{/if}	
				</div>				
			</li>	
		</ul>
	</div>
{/if}