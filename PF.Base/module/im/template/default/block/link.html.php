<?php
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: link.html.php 7260 2014-04-09 13:49:44Z Fern $
 */
defined('PHPFOX') or exit('NO DICE!');
?>
<li class="js_cache_im_room js_cache_im_list{if isset($bIsNewRoom)} js_is_new_room{/if}" id="js_cache_im_room_{$aRoom.parent_id}">		
	<div id="js_messages_{$aRoom.parent_id}" class="js_messages"></div>
	<div id="js_link_{$aRoom.parent_id}" class="js_im_link">		
		<span title="{phrase var='im.close'}" class="im_delete_button">{img theme='layout/im_close.png' class='v_middle'}</span>
		<a href="#" onclick="$.ajaxCall('im.clickOnLink', 'parent_id={$aRoom.parent_id}'); return false;">
			<span class="im_ajax_button">{img theme='ajax/add.gif' class="ajax_add_gif"}</span>			
		   {if $aRoom.is_logged_in == 0}
				{img theme='misc/bullet_red.png' alt='user_is_offline' class='v_middle bullet_red'}
			{else}
				{if $aRoom.im_status == '1'}
					{img theme='misc/bullet_yellow.png' class='v_middle'}
				{else}
					{img theme='misc/bullet_green.png' alt='user_is_online' class='v_middle bullet_green'}
				{/if}
			{/if}
			{$aRoom.full_name|clean|shorten:15:'...'}		
		</a>
	</div>
</li>
