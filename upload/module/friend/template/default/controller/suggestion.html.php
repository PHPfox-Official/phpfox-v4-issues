<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: suggestion.html.php 1320 2009-12-15 14:29:49Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !count($aSuggestions)}
<div class="extra_info">
	{phrase var='friend.we_are_unable_to_find_any_friends_to_suggest_at_this_time_once_we_do_you_will_be_notified_within_our_dashboard'}
</div>
{else}
<div class="main_break"></div>
{foreach from=$aSuggestions name=suggestion item=aSuggestion}
<div class="go_left t_center js_suggestion_parent" style="width:30%; padding:4px;" id="js_suggestion_parent_{$aSuggestion.user_id}">
	<div class="p_4">
		<a href="#" onclick="$(this).parents('.js_suggestion_parent:first').hide(); $.ajaxCall('friend.removeSuggestion', 'user_id={$aSuggestion.user_id}'); return false;" title="{phrase var='friend.hide_this_suggestion'}">{img theme='misc/delete.gif' class='delete_hover' style='vertical-align:middle;'}</a>
		{$aSuggestion|user}
	</div>
	{img user=$aSuggestion suffix='_50' max_width=50 max_height=50}
	<div class="p_4">
		<a href="#?call=friend.request&amp;user_id={$aSuggestion.user_id}&amp;width=420&amp;height=250&amp;suggestion_page=true" class="inlinePopup" title="{phrase var='profile.add_to_friends'}">{phrase var='friend.add_to_friends'}</a>
	</div>
</div>
{if is_int($phpfox.iteration.suggestion / 3)}
<div class="clear"></div>
{/if}
{/foreach}
<div class="clear"></div>
{/if}