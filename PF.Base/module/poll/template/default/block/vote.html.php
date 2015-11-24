
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
		<div class="poll_answer_container js_sample_outer">
			<div class="poll_answer_percentage js_sample_percent percentage" style="{if isset($bDesign) && $bDesign}width:40%;{else}{if isset($aAnswer.vote_percentage)}width:{$aAnswer.vote_percentage}{elseif !Phpfox::getUserParam('poll.can_vote_in_own_poll')}width:0{/if}%;{/if}">&nbsp;</div>
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

{if !isset($aPoll.voted)}
{if !PHPFOX_IS_AJAX}
<div id="vote_{$aPoll.poll_id}">
	{/if}
	<form class="poll_form" method="post" action="{url link='current'}" id="js_poll_form_{$aPoll.poll_id}">
		<div><input type="hidden" name="val[poll_id]" value="{$aPoll.poll_id}" /></div>
		<div class="poll_question">
			{if isset($aPoll.answer)}
			{foreach from=$aPoll.answer item=answer}
			{if !empty($answer.answer)}
			<div class="p_bottom_15 radio">
				<label {if !isset($aPoll.poll_is_in_feed)}onclick="$('#js_submit_vote{if isset($iKey)}_{$iKey}{/if}').show(); $('.js_poll_answer{if isset($iKey)}_{$iKey}{/if}').prop('checked', false); $(this).find('.js_poll_answer{if isset($iKey)}_{$iKey}{/if}').prop('checked', true);"{/if}>
				{if !isset($aPoll.poll_is_in_feed)}<input class="checkbox js_poll_answer{if isset($iKey)}_{$iKey}{/if}" type="radio" name="val[answer]" value="{$answer.answer_id}" style="vertical-align:middle;" />{/if}
				<span title="{$answer.answer|clean}">{$answer.answer|clean|split:50|shorten:150:'...'}</span>
				</label>
			</div>
			{/if}
			{/foreach}
			{/if}
		</div>
		<div><input class="button btn-sm btn-primary" type="button" value="{phrase var='poll.submit_your_vote'}" class="button_link" onclick="$(this).parent().hide(); $(this).parents('.p_4:first').find('.js_poll_image_ajax:first').show(); $('#js_poll_form_{$aPoll.poll_id}').ajaxCall('poll.addVote');return false;" /></div>
		<div class="js_poll_image_ajax" style="display:none;">
			{img theme='ajax/add.gif' class='v_middle'}
		</div>
	</form>
{if !PHPFOX_IS_AJAX}
</div>
{/if}
{/if}