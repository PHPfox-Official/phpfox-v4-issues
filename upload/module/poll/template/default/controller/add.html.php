<?php 
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Poll
 * @version 		$Id: add.html.php 7078 2014-01-29 15:26:30Z Fern $
 */

defined('PHPFOX') or exit('NO DICE!'); 

?>
{if isset($aForms.poll_id)}
<div class="view_item_link">
	<a href="{permalink module='poll' id=$aForms.poll_id title=$aForms.question}">{phrase var='poll.view_poll'}</a>
</div>
{/if}

<script type="text/javascript">
	{literal}
	function plugin_addFriendToSelectList()
	{
		$('#js_allow_list_input').show();
	}
	{/literal}
</script>
{$sCreateJs}
<div class="main_break"></div>
<div style="display:none;" class="placeholder">
	<div style="padding-top:6px;" class="js_prev_block">
		<span>
			{img theme='misc/arrow_up_down.png' height="18px" style="cursor:move; vertical-align:middle;"} 
		</span>
		<span class="class_answer">
			<input type="text" name="val[answer][][answer]" value="" size="30" class="js_answers v_middle" />
		</span>
		<a href="#" onclick="return appendAnswer(this);">
			{img theme='misc/add.png' class='v_middle'}
		</a>
		<a href="#" onclick="return removeAnswer(this);">
			{img theme='misc/delete.png' class='v_middle'}
		</a>
	</div>
</div>


<form method="post" action="{if $bIsCustom}#{else}{url link='poll.add'}{if isset($aForms.poll_id)}id_{$aForms.poll_id}{/if}{/if}" name="js_poll_form" id="js_poll_form" onsubmit="{if $bIsCustom}if ({$sGetJsForm}) {left_curly} $(this).ajaxCall('poll.addCustom'); {right_curly} return false;{else}{$sGetJsForm}{/if}" {if Phpfox::getUserParam('poll.poll_can_upload_image')}enctype="multipart/form-data"{/if}>
	<div id="js_custom_privacy_input_holder">
	{if $bIsEdit}
		{module name='privacy.build' privacy_item_id=$aForms.poll_id privacy_module_id='poll'}	
	{/if}
	</div>	

	{if isset($aForms.poll_id) && isset($aForms.user_id)}
	<div><input type="hidden" name="val[poll_id]" value="{$aForms.poll_id}"></div>
	<div><input type="hidden" name="val[user_id]" value="{$aForms.user_id}"></div>
	{/if}
	{if $bIsCustom}	
	<div><input type="hidden" name="val[module_id]" value="{$sModuleId}"></div>
	{/if}
	
	{* Check if user is editing and has permissions to edit the questions *}
	{if $bIsEdit && !$bCanEditTitle}
	<div style="display:none;">
		{/if}
		<div class="table">
			<div class="table_left">
				{required}{phrase var='poll.question'}:
			</div>
			<div class="table_right">
				<input tabindex="1" type="text" name="val[question]" id="question" value="{value type='input' id='question'}" size="40" />
			</div>
		</div>
		{* Check if user is editing and has permissions to edit the questions *}
		{if $bIsEdit && !$bCanEditTitle}
	</div>
	{/if}
	{* Check if user is editing and has permissions to edit the questions *}
	{if $bIsEdit && !$bCanEditQuestion}
	<div style="display:none;">
		{/if}
		<div class="table">
			<div class="table_left">
				{required}{phrase var='poll.answers'}:
			</div>
			<div class="table_right">
				<div class="sortable">
					{if isset($aForms.answer) && count($aForms.answer)}
					{foreach from=$aForms.answer item=aAnswer name=iAnswer}
					<div class="placeholder sortable_item_{$phpfox.iteration.iAnswer}" id="sortable_item_{$phpfox.iteration.iAnswer}">
						<div style="padding-top:6px;" class="js_prev_block">
							<span class="js_arrow_up_down">
								{img theme='misc/arrow_up_down.png' height="18px" style="cursor:move; vertical-align:middle;"}
							</span>
							<input type="text" name="val[answer][{$phpfox.iteration.iAnswer}][answer]" value="{$aAnswer.answer|clean}" size="30" class="js_answers v_middle" />
							{if isset($aAnswer.answer_id)}
								   <input type="hidden" name="val[answer][{$phpfox.iteration.iAnswer}][answer_id]" class="hdnAnswerId" value="{$aAnswer.answer_id}">
							{/if}
							<a href="#" onclick="return appendAnswer(this);">
								{img theme='misc/add.png' class='v_middle'}
							</a>
							<a href="#" onclick="return removeAnswer(this);">
								{img theme='misc/delete.png' class='v_middle'}
							</a>
						</div>
						<div class="js_next_block"></div>
					</div>
					{/foreach}
					{else}
					{for $i = 1; $i <= $iTotalAnswers; $i++}
					<div class="placeholder sortable_item_{$i}" id="sortable_item_{$i}">
						<div style="padding-top:6px;" class="js_prev_block">
							<span class="js_arrow_up_down">
								{img theme='misc/arrow_up_down.png' class="sortingArrows" height="18px"}
							</span>
							<input type="text" tabindex="{$i + 1}" name="val[answer][{$i}][answer]" value="" size="30" class="js_answers v_middle" />
							<a href="#" onclick="if(iMaxAnswers == 0) {l} iMaxAnswers = {$iMaxAnswers}; {r} return appendAnswer(this);" >
								{img theme='misc/add.png' class='v_middle'}
							</a>
							<a href="#" onclick="if(iMinAnswers == 0) {l} iMinAnswers = {$iMin}; {r} return removeAnswer(this);">
								{img theme='misc/delete.png' class='v_middle'}
							</a>
						</div>
						<div class="js_next_block"></div>
					</div>
					{/for}
					{/if}
				</div>
			</div>
		</div>
		{if $bIsEdit && !$bCanEditQuestion}
	</div>
	{/if}
	
	{if $bIsCustom}
		<div class="table">
			<div class="table_left">
				{phrase var='poll.public_votes'}:
			</div>
			<div class="table_right">				
				<div class="item_is_active_holder">		
					<span class="js_item_active item_is_active"><input type="radio" name="val[hide_vote]" value="0" class="checkbox" style="vertical-align:middle;"{value type='checkbox' id='hide_vote' default='0' selected=true}/> {phrase var='poll.yes'}</span>
					<span class="js_item_active item_is_not_active"><input type="radio" name="val[hide_vote]" value="1" class="checkbox" style="vertical-align:middle;"{value type='checkbox' id='hide_vote' default='1'}/> {phrase var='poll.no'}</span>
				</div>		
				<div class="extra_info">
					{phrase var='poll.displays_all_users_who_voted_and_what_choice_they_voted_for'}
				</div>	
			</div>
		</div>		
	{/if}
	
	{if $bIsEdit && !$bCanEditTitle}
	<div id="hideChoices" style="display:none;">
		{/if}
		{if Phpfox::getUserParam('poll.poll_can_upload_image') && !$bIsCustom}		
		<div class="table"{if Phpfox::isMobile()} style="display:none;"{/if}>
			<div class="table_left">
				{if Phpfox::getParam('poll.is_image_required')}{required}{/if}{phrase var='poll.image'}:
			</div>
			<div class="table_right" id="js_submit_upload_image" {if isset($aForms.image_path)}style="display: none;"{/if}>
				 <input type="file" id='image' name="image" />
				<div class="extra_info">
					{phrase var='poll.you_can_upload_a_jpg_gif_or_png_file'}
				</div>
			</div>
			<div class="table_right" id="js_event_current_image" {if !isset($aForms.image_path) || $aForms.image_path == ''} style="display: none;"{/if}>
				 {if isset($aForms.image_path)}
				 <div class="p_4">
					{img thickbox=true title=$aForms.question path='poll.url_image' file=$aForms.image_path suffix=$sSuffix max_width='poll.poll_max_image_pic_size' max_height='poll.poll_max_image_pic_size'}
					<br />
					<a href="#" onclick="$Core.poll.deleteImage({$aForms.poll_id}); return false;">{phrase var='poll.click_here_to_delete_this_image_and_upload_a_new_one_in_its_place'}</a>
				</div>
				{/if}
			</div>
		</div>
		{/if}
		{if !$bIsCustom && Phpfox::isModule('privacy')}
		<div class="table">
			<div class="table_left">
				{phrase var='poll.privacy'}:
			</div>
			<div class="table_right">	
				{module name='privacy.form' privacy_name='privacy' privacy_info='poll.control_who_can_see_this_poll' default_privacy='poll.default_privacy_setting'}
			</div>			
		</div>
		{if Phpfox::isModule('comment')}
		<div class="table">
			<div class="table_left">
				{phrase var='poll.comment_privacy'}:
			</div>
			<div class="table_right">	
				{module name='privacy.form' privacy_name='privacy_comment' privacy_info='poll.control_who_can_comment_on_this_poll' privacy_no_custom=true}
			</div>			
		</div>
		{/if}		
		{/if}	

		<div class="table_clear">
			<ul class="table_clear_button">
				<li><input type="submit" name="submit_poll" value="{if isset($aForms.poll_id)}{phrase var='poll.update'}{else}{phrase var='poll.submit'}{/if}" class="button" name="submit" /></li>
				{if Phpfox::getUserParam('poll.poll_can_edit_own_polls') && Phpfox::getUserParam('poll.can_edit_title') && !$bIsCustom && !Phpfox::isMobile()}
				<li><input type="submit" name="submit_design" value="{phrase var='poll.save_and_design_this_poll'}" class="button button_off" name="design" /></li>
				{if isset($aForms.poll_id)}
				<li><input type="button" value="{phrase var='poll.skip_and_design_this_poll'}" onclick="window.location.href = '{url link='poll.design' id=$aForms.poll_id}';" class="button button_off" /></li>
				{/if}
				{/if}
			</ul>
			<div class="clear"></div>
		</div>
		{if !$bIsCustom}
		<h3>{phrase var='poll.additional_options'}</h3>
		<div class="table">
			<div class="table_left">
				{phrase var='poll.public_votes'}:
			</div>
			<div class="table_right">				
				<div class="item_is_active_holder">		
					<span class="js_item_active item_is_active"><input type="radio" name="val[hide_vote]" value="0" class="checkbox" style="vertical-align:middle;"{value type='checkbox' id='hide_vote' default='0' selected=true}/> {phrase var='poll.yes'}</span>
					<span class="js_item_active item_is_not_active"><input type="radio" name="val[hide_vote]" value="1" class="checkbox" style="vertical-align:middle;"{value type='checkbox' id='hide_vote' default='1'}/> {phrase var='poll.no'}</span>
				</div>		
				<div class="extra_info">
					{phrase var='poll.displays_all_users_who_voted_and_what_choice_they_voted_for'}
				</div>	
			</div>
		</div>		
		<div class="table">
			<div class="table_left">
				{phrase var='poll.randomize_answers'}:
			</div>
			<div class="table_right">				
				<div class="item_is_active_holder">		
					<span class="js_item_active item_is_active">
						<input type="radio" name="val[randomize]" value="1" class="checkbox" onclick="$('.js_arrow_up_down').hide();" style="vertical-align:middle;"{value type='checkbox' id='randomize' default='1'}/> 
						{phrase var='poll.yes'}
					</span>
					<span class="js_item_active item_is_not_active">
						<input type="radio" name="val[randomize]" value="0" class="checkbox" onclick="$('.js_arrow_up_down').show();" style="vertical-align:middle;"{value type='checkbox' id='randomize' default='0'}/> 
						{phrase var='poll.no'}
					</span>
				</div>			
			</div>
		</div>	
		
		{if Phpfox::isModule('captcha') && Phpfox::getUserParam('poll.poll_require_captcha_challenge')}
		{module name='captcha.form' sType=poll}
		{/if}
		{plugin call='poll.template_controller_add_end'}
		{if $bIsEdit && !$bCanEditTitle}
	</div>
	{/if}
		<div class="table_clear">
			<ul class="table_clear_button">
				<li><input type="submit" name="submit_poll" value="{if isset($aForms.poll_id)}{phrase var='poll.update'}{else}{phrase var='poll.submit'}{/if}" class="button" name="submit" /></li>
				{if Phpfox::getUserParam('poll.poll_can_edit_own_polls') && Phpfox::getUserParam('poll.can_edit_title') && !$bIsCustom && !Phpfox::isMobile()}
				<li><input type="submit" name="submit_design" value="{phrase var='poll.save_and_design_this_poll'}" class="button button_off" name="design" /></li>
				{if isset($aForms.poll_id)}
				<li><input type="button" value="{phrase var='poll.skip_and_design_this_poll'}" onclick="window.location.href = '{url link='poll.design' id=$aForms.poll_id}';" class="button button_off" /></li>
				{/if}
				{/if}
			</ul>
			<div class="clear"></div>
		</div>
	{/if}
</form>
