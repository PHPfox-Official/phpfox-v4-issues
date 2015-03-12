<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Privacy
 * @version 		$Id: list.html.php 2197 2010-11-22 15:26:08Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="label_flow" style="height:100px;" id="js_selected_friends">
{foreach from=$aPrivacyUsers item=aPrivacyUser name=privacy_user}
	<div class="js_cached_friend_name row1 js_cached_friend_id_{$aPrivacyUser.user_id}{if $phpfox.iteration.privacy_user == 1} row_first{/if}"><span style="display:none;">{$aPrivacyUser.user_id}</span><input type="hidden" name="val[{$sPrivacyInputName}][]" value="{$aPrivacyUser.user_id}" /><a href="#" onclick="$('.js_cached_friend_id_{$aPrivacyUser.user_id}').remove(); return false;">{img theme='misc/delete.gif' class='delete_hover' style='vertical-align:middle;'}</a> {$aPrivacyUser|user}</div>
{/foreach}
</div>
<div class="t_right p_4">
	<a href="#" onclick="$Core.getFriends({literal}{{/literal}input : 'allow_list'{literal}}{/literal}); return false;">{phrase var='privacy.update_preferred_list'}</a>
</div>