<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: setting.html.php 1268 2009-11-23 20:45:36Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="#" onsubmit="$(this).ajaxCall('core.updateComponentSetting'); $(this).parents('.edit_bar:first').slideUp().html(''); return false;">
	<div><input type="hidden" name="val[var_name]" value="{$sSettingName}" /></div>
	<div><input type="hidden" name="val[load_block]" value="{if $bIsEditTop}friend.top{else}{if $bIsProfile}friend.profile.small{else}friend.mini{/if}{/if}" /></div>
	<div><input type="hidden" name="val[block_id]" value="{if $bIsEditTop}js_block_border_friend_top{else}{if $bIsProfile}js_block_border_friend_profile_small{else}js_block_border_friend_mini{/if}{/if}" /></div>
	{if $bIsEditTop}
	<div><input type="hidden" name="val[load_init]" value="true" /></div>
	{/if}
	{phrase var='friend.total_friends_block'}:
	<select name="val[user_value]" class="v_middle">
		{foreach from=$aSettings item=iSetting}
			<option value="{$iSetting}"{if $iDefaultSetting == $iSetting} selected="selected"{/if}>{$iSetting}</option>
		{/foreach}
	</select>
	<input type="submit" value="{phrase var='friend.save'}" class="button v_middle" />
	<input type="button" value="{phrase var='friend.cancel'}" class="button v_middle" onclick="$(this).parents('.edit_bar:first').slideUp().html('');" />
</form>