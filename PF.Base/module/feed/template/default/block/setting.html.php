<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: setting.html.php 1124 2009-10-02 14:07:30Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="#" onsubmit="$(this).ajaxCall('core.updateComponentSetting'); $(this).parents('.edit_bar:first').slideUp().html(''); return false;">
	<div><input type="hidden" name="val[var_name]" value="{$sSettingName}" /></div>
	<div><input type="hidden" name="val[load_block]" value="feed.display" /></div>
	<div><input type="hidden" name="val[block_id]" value="js_block_border_feed_display" /></div>
	{if $bIsProfile}
	<div><input type="hidden" name="profile_user_id" value="{$iProfileUserId}" /></div>
	{/if}
	{phrase var='feed.total_feeds_to_display'}:
	<select name="val[user_value]" class="v_middle">
		{foreach from=$aSettings item=iSetting}
			<option value="{$iSetting}"{if $iDefaultSetting == $iSetting} selected="selected"{/if}>{$iSetting}</option>
		{/foreach}
	</select>
	<input type="submit" value="{phrase var='feed.save'}" class="button v_middle" />
	<input type="button" value="{phrase var='feed.cancel_uppercase'}" class="button v_middle" onclick="$(this).parents('.edit_bar:first').slideUp().html('');" />
</form>