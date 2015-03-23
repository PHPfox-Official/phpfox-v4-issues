<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Display the image details when viewing an image.
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_Friend
 * @version 		$Id: detail.class.php 254 2009-02-23 12:36:20Z Miguel_Espinoza $
 */
?>
{foreach from=$aMessages item=aMessage name=iMessages}
	<div class="birthday {if is_int($phpfox.iteration.iMessages/2)}row1{else}row2{/if}{if $phpfox.iteration.iMessages == 1} row_first{/if}" style="position:relative; margin-top:10px;">
		<span>{img user=$aMessage suffix='_50' max_width=50 max_height=50}</span>
		<span style="position:absolute; top:10px; left:60px;">
			<div>{phrase var='friend.user_link_wished_you_a_happy_birthday' user=$aMessage}{if !empty($aMessage.birthday_message)}:{/if} </div>
			<span class="extra_info" style="position:relative; left:25px; top:5px;">
				{$aMessage.birthday_message|parse}
			</span>
		</span>
		<div class="clear"></div>
		{if !empty($aMessage.file_path)}
		<span style="margin-left:110px;">
			{img id='js_photo_view_image' thickbox=true path='egift.url_egift' file=$aMessage.file_path suffix='_120' max_width=120 max_height=120 title=$aMessage.title time_stamp=true}
		</span>
		{/if}
	</div>
	<div class="clear"></div>
{foreachelse}
	<div class="extra_info">
		{phrase var='friend.no_birthday_messages_found'}
	</div>
{/foreach}