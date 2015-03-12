{if !isset($aPoll.voted)}
	{if !PHPFOX_IS_AJAX}
<div id="vote_{$aPoll.poll_id}">
	{/if}
	<form method="post" action="{url link='current'}" id="js_poll_form_{$aPoll.poll_id}">
		<div><input type="hidden" name="val[poll_id]" value="{$aPoll.poll_id}" /></div>
		{if isset($aPoll.answer)}
		{foreach from=$aPoll.answer item=answer}
		{if !empty($answer.answer)}
		<div class="p_2">
			<label {if !isset($aPoll.poll_is_in_feed)}onclick="$('#js_submit_vote{if isset($iKey)}_{$iKey}{/if}').show(); $('.js_poll_answer{if isset($iKey)}_{$iKey}{/if}').attr('checked', false); $(this).find('.js_poll_answer{if isset($iKey)}_{$iKey}{/if}').attr('checked', true);"{/if}>
			{if !isset($aPoll.poll_is_in_feed)}<input class="checkbox js_poll_answer{if isset($iKey)}_{$iKey}{/if}" type="radio" name="val[answer]" value="{$answer.answer_id}" style="vertical-align:middle;" />{/if}
			<span title="{$answer.answer|clean}">{$answer.answer|clean|split:50|shorten:150:'...'}</span>
			</label>
		</div>
		{/if}
		{/foreach}
		{/if}
		<div class="p_4" id="js_submit_vote{if isset($iKey)}_{$iKey}{/if}" style="display:none;">
			{if isset($aPoll.view_id) && !isset($bDesign) && $aPoll.view_id == 1}
			<div class="extra_info js_moderation_off">
				{phrase var='poll.cannot_cast_a_vote_when_a_poll_is_pending_approval'}
			</div>
			{/if}
			<div {if !isset($aPoll.poll_is_in_feed) && (isset($aPoll.view_id) && !isset($bDesign) && $aPoll.view_id == 1)}style="display:none;" class="js_moderation_on"{/if}>
			<input type="button" value="{phrase var='poll.submit_your_vote'}" class="button" onclick="$(this).parent().hide(); $(this).parents('.p_4:first').find('.js_poll_image_ajax:first').show(); $('#js_poll_form_{$aPoll.poll_id}').ajaxCall('poll.addVote');return false;" />&nbsp;<input type="button" class="button button_off" onclick="$('#js_poll_form_{$aPoll.poll_id}')[0].reset(); $('#js_submit_vote{if isset($iKey)}_{$iKey}{/if}').hide();" value="{phrase var='poll.cancel_uppercase'}" />
		</div>
		<div class="js_poll_image_ajax" style="display:none;">
			{img theme='ajax/add.gif' class='v_middle'}
		</div>
</div>
</form>
{if !PHPFOX_IS_AJAX}
</div>
{/if}
{/if}

{if !isset($aPoll.poll_is_in_feed) && (((isset($aPoll.voted)) || (!Phpfox::getUserParam('poll.can_vote_in_own_poll') && ($aPoll.user_id == Phpfox::getUserId())) || Phpfox::getUserParam('poll.view_poll_results_before_vote') || (isset($bDesign) && $bDesign)))}
<div class="votes"{if !PHPFOX_IS_AJAX} id="vote_list_{$aPoll.poll_id}"{/if}>
	{foreach from=$aPoll.answer item=aAnswer}
	<div class="answers_container{if Phpfox::getUserParam('poll.highlight_answer_voted_by_viewer') && isset($aPoll.voted) && $aPoll.answer_id == $aAnswer.answer_id} user_answered_this{/if}">
		<div>{$aAnswer.answer}</div>
		{if ((isset($aPoll.user_voted_this_poll) &&
			(($aPoll.user_voted_this_poll == false && Phpfox::getUserParam('poll.view_poll_results_before_vote')) ||
			($aPoll.user_voted_this_poll == true && Phpfox::getUserParam('poll.view_poll_results_after_vote')))) ||
			(!isset($aPoll.user_voted_this_poll)))
			|| ((isset($bDesign) && $bDesign))
		}
		{if !isset($bDesign)}
		<div class="extra_info">
			{if isset($aAnswer.vote_percentage)}
				&nbsp;{$aAnswer.vote_percentage}% ({phrase var='poll.total_votes_votes' total_votes=$aAnswer.total_votes})
			{else}
				{phrase var='poll.votes_0'}
			{/if}
		</div>
		{/if}
		<div class="poll_answer_container js_sample_outer" style="border:1px solid #{if isset($aPoll.border) && ($aPoll.border != '')}{$aPoll.border}{else}000{/if}; background:{if isset($aPoll.background) && ($aPoll.background != '')}#{$aPoll.background}{else}b70000{/if};">
			<div class="poll_answer_percentage js_sample_percent percentage" style="background:{if isset($aPoll.percentage) && ($aPoll.percentage != '')}#{$aPoll.percentage}{else}#93D9FF{/if}; {if isset($bDesign) && $bDesign}width:40%;{else}{if isset($aAnswer.vote_percentage)}width:{$aAnswer.vote_percentage}{elseif !Phpfox::getUserParam('poll.can_vote_in_own_poll')}width:0{/if}%;{/if}">&nbsp;</div>
		</div>
		{/if}
	</div>
	{foreachelse}
			{phrase var='poll.no_answers_to_show'}
	{/foreach}
	
	{if isset($aPoll.answer) && count($aPoll.answer) && !isset($bDesign) && $aPoll.total_votes > 0 && ((Phpfox::getUserParam('poll.can_view_user_poll_results_own_poll') && $aPoll.user_id == Phpfox::getUserId()) || Phpfox::getUserParam('poll.can_view_user_poll_results_other_poll'))}
	<div class="poll_result_link">
		<a href="#" onclick="$Core.box('poll.pageVotes', 400, 'poll_id={$aPoll.poll_id}'); return false;">{phrase var='poll.view_results'}</a>
	</div>
	{/if}
</div>
{/if}