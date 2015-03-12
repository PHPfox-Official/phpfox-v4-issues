<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: suggestion.html.php 3770 2011-12-13 11:34:29Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !PHPFOX_IS_AJAX}
<div id="js_friend_suggestion_loader" style="display:none;">{img theme='ajax/small.gif' class='v_middle'} {phrase var='friend.finding_another_suggestion'}</div>
<div id="js_friend_suggestion">
{/if}
{if isset($aSuggestion.user_id)}
	<div class="row1 row_first row_title hover_action">
		<div class="row_title_image">
			{img user=$aSuggestion suffix='_50_square' max_width=50 max_height=50}
		</div>
		<div class="row_title_info">	
			{$aSuggestion|user}
			<div class="extra_info">
				<a href="#?call=friend.request&amp;user_id={$aSuggestion.user_id}&amp;width=420&amp;height=250&amp;suggestion=true" class="inlinePopup" title="{phrase var='profile.add_to_friends'}">{phrase var='friend.add_to_friends'}</a>
				-
				<a href="#" onclick="$('#js_friend_suggestion').hide(); $('#js_friend_suggestion_loader').show(); $.ajaxCall('friend.removeSuggestion', 'user_id={$aSuggestion.user_id}&amp;load=true'); return false;" title="{phrase var='friend.hide_this_suggestion'}">{phrase var='friend.hide'}</a>
			</div>
		</div>
	</div>
{/if}
{if !PHPFOX_IS_AJAX}
</div>
{/if}