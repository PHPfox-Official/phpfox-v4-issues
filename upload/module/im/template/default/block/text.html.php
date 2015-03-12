<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: text.html.php 3296 2011-10-12 13:29:57Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="im_text{if $aMessage.user_id == Phpfox::getUserId()} im_text_actual_owner{/if}{if $aMessage.last_owner == $aMessage.user_id} im_text_not_owner{/if}{if isset($phpfox.iteration.messages) && $phpfox.iteration.messages == 1 && (!isset($bIsFirst) || $bIsFirst == true)} im_text_first{/if}{if isset($aMessage.is_today) && !$aMessage.is_today} extra_info{/if}{if isset($sClass) && !empty($sClass)} {$sClass}{/if}">
	<div class="im_date">
		{$aMessage.time_stamp|date:'im.im_time_stamp'}
		{*
		{if (isset($aMessage.is_today) && $aMessage.is_today) || (!isset($aMessage.is_today))}
			{$aMessage.time_stamp|date:'im.im_time_stamp'}
		{else}
			{$aMessage.time_stamp|date:'im.im_time_stamp_past'}
		{/if}
		*}
	</div>
	{if $aMessage.last_owner != $aMessage.user_id}
	<div class="im_chat_image{if $aMessage.user_id == Phpfox::getUserId()} im_chat_image_owner{/if}">	
		{img user=$aMessage suffix='_50_square' max_width=28 max_height=28}
	</div>
	{/if}
	<div class="im_message {if $aMessage.user_id == Phpfox::getUserId()} im_message_owner{/if}{if $aMessage.last_owner != $aMessage.user_id} im_message_no_height{/if}">
		{$aMessage.text|parse|split:30}
	</div>
</div>