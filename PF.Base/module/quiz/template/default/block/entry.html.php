<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Quiz
 * @version 		$Id: entry.html.php 3771 2011-12-13 11:41:30Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if isset($bIsViewingQuiz)}
    <div class="item_info">
		{$aQuiz.time_stamp|convert_time} {phrase var='quiz.by'} {$aQuiz|user}
    </div>
    
	{if (isset($aQuiz.view_id) && $aQuiz.view_id == 1)}
	<div class="message js_moderation_off" id="js_approve_message">
		{phrase var='quiz.this_quiz_is_awaiting_moderation'}
	</div>	
	{/if}			    

	{if Phpfox::getUserParam('quiz.can_approve_quizzes') 
		|| Phpfox::getUserParam('quiz.can_delete_others_quizzes')
		|| ( ($aQuiz.user_id == Phpfox::getUserId()) && Phpfox::getUserParam('quiz.can_delete_own_quiz') )
		|| ($aQuiz.user_id == Phpfox::getUserId())
		|| ( (Phpfox::getUserId() == $aQuiz.user_id && (Phpfox::getUserParam('quiz.can_edit_own_questions') || Phpfox::getUserParam('quiz.can_edit_own_title'))) || (Phpfox::getUserId() != $aQuiz.user_id && (Phpfox::getUserParam('quiz.can_edit_others_questions') || Phpfox::getUserParam('quiz.can_edit_others_title'))))
	}   
	<div class="item_bar">
		<div class="item_bar_action_holder">
			{if isset($aQuiz.view_id) && $aQuiz.view_id == 1 && Phpfox::getUserParam('quiz.can_approve_quizzes')}
				<a href="#" class="item_bar_approve item_bar_approve_image" onclick="return false;" style="display:none;" id="js_item_bar_approve_image">{img theme='ajax/add.gif'}</a>			
				<a href="#" class="item_bar_approve" onclick="$(this).hide(); $('#js_item_bar_approve_image').show(); $.ajaxCall('quiz.approve','iQuiz={$aQuiz.quiz_id}&amp;inline=true'); return false;">{phrase var='quiz.approve'}</a>
			{/if}			
			<a href="#" class="item_bar_action"><span>{phrase var='quiz.actions'}</span></a>		
			<ul>
				{template file='quiz.block.link'}
			</ul>			
		</div>
	</div>
	{/if}
{/if}
		
<div id="js_quiz_{$aQuiz.quiz_id}" class="{if isset($phpfox.iteration.quizzes)} {if is_int($phpfox.iteration.quizzes/2)}row1{else}row2{/if}{if $phpfox.iteration.quizzes == 1} row_first{/if}{/if}">

	<div id="js_message_{$aQuiz.quiz_id}" style="display: none;"></div>
	{if !isset($bIsViewingQuiz)}
		<div class="row_title">
		
			<div class="row_title_image">
				{img user=$aQuiz suffix='_50_square' max_width=50 max_height=50}
				{if Phpfox::getUserParam('quiz.can_approve_quizzes') 
					|| Phpfox::getUserParam('quiz.can_delete_others_quizzes')
					|| ( ($aQuiz.user_id == Phpfox::getUserId()) && Phpfox::getUserParam('quiz.can_delete_own_quiz') )
					|| ($aQuiz.user_id == Phpfox::getUserId())
					|| ( (Phpfox::getUserId() == $aQuiz.user_id && (Phpfox::getUserParam('quiz.can_edit_own_questions') || Phpfox::getUserParam('quiz.can_edit_own_title'))) || (Phpfox::getUserId() != $aQuiz.user_id && (Phpfox::getUserParam('quiz.can_edit_others_questions') || Phpfox::getUserParam('quiz.can_edit_others_title'))))
				}   		
				<div class="row_edit_bar_parent">
					<div class="row_edit_bar_holder">
						<ul>
							{template file='quiz.block.link'}
						</ul>			
					</div>
					<div class="row_edit_bar">				
						<a href="#" class="row_edit_bar_action"><span>{phrase var='quiz.actions'}</span></a>							
					</div>
				</div>		
				{/if}				
				{if Phpfox::getUserParam('quiz.can_approve_quizzes')}
				<a href="#{$aQuiz.quiz_id}" class="moderate_link" rel="quiz">{phrase var='quiz.moderate'}</a>
				{/if}
			</div>
			<div class="row_title_info">
				<a href="{permalink module='quiz' id=$aQuiz.quiz_id title=$aQuiz.title}" id="quiz_inner_title_{$aQuiz.quiz_id}" class="link" title="{$aQuiz.title|clean}">{$aQuiz.title|clean|shorten:75:'...'}</a>
				<div class="extra_info">
					{$aQuiz.time_stamp|convert_time} {phrase var='quiz.by'} {$aQuiz|user}
				</div>			
			
		
	{/if}		

		<div>
		{if isset($aQuiz.image_path) && $aQuiz.image_path != ''}
		<div class="item_image" style="width:{param var='quiz.quiz_max_image_pic_size'}px;">
			{img thickbox=true server_id=$aQuiz.server_id title=$aQuiz.title path='quiz.url_image' file=$aQuiz.image_path suffix=$sSuffix max_width='quiz.quiz_max_image_pic_size' max_height='quiz.quiz_max_image_pic_size'}
		</div>
		<div class="item_image_content" style="margin-left:{param var='quiz.quiz_max_image_pic_size'}px;">
		{/if}	
		
		{$aQuiz.description|parse|split:55}				

		{if isset($bShowResults) && $bShowResults}		
			{template file='quiz.block.result'}
		{elseif isset($bShowUsers) && $bShowUsers}
			<h3>{phrase var='quiz.users_results'}</h3>
			{foreach from=$aQuiz.aTakenBy name=users item=aUser}
			<div{if isset($phpfox.iteration.results)} class="{if is_int($phpfox.iteration.results/2)}row1{else}row2{/if}{if $phpfox.iteration.results == 1} row_first{/if}"{/if} style="position:relative;">
				<div style="width:55px; position:absolute;">
					{img user=$aUser.user_info suffix='_50' max_width=50 max_height=50}
				</div>
				<div class="p_2" style="margin-left:60px; height:55px;">
					<a href="{url link=""$aUser.user_info.user_name""}">{$aUser.user_info.full_name}</a> {if (Phpfox::getParam('quiz.show_percentage_in_results'))}{$aUser.iSuccessPercentage}%{else}{$aUser.total_correct}/{$aUser.iTotalCorrectAnswers}{/if}.
					<div class="t_right">
						<ul class="item_menu">
							<li><a href="{permalink module='quiz' id=$aQuiz.quiz_id title=$aQuiz.title}results/id_{$aUser.user_info.user_id}/" id="quiz_inner_title_{$aQuiz.quiz_id}">{phrase var='quiz.view_results'}</a></li>
						</ul>
					</div>
				</div>
			</div>
			{foreachelse}<div class="t_left">{phrase var='quiz.be_the_first_to_answer_this_quiz'}</div>
			{/foreach}
		{else}
			{if isset($bIsViewingQuiz)}
				{if isset($aQuiz.question)}
				<form name="js_form_answer" method="post" action="{permalink module='quiz' id=$aQuiz.quiz_id title=$aQuiz.title}answer/">
					<div class="p_4" style="margin-top:10px;">
						{foreach from=$aQuiz.question key=iQuestionId name=questions item=aQuestion}
							<b>{$phpfox.iteration.questions}.</b> {$aQuestion.question}
							<div class="p_4" style="margin-left:30px;">
								{foreach from=$aQuestion.answer key=iAnswerId name=answers item=sAnswer}
									<div class="p_2">
										<label><input class="checkbox" name="val[answer][{$iQuestionId}]" value="{$iAnswerId}" style="vertical-align: middle;" type="radio"> {$sAnswer}</label>
									</div>
								{/foreach}
							</div>
						{/foreach}
					</div>
					{if isset($aQuiz.view_id) && $aQuiz.view_id != 1}
						<input type="submit" value="{phrase var='quiz.submit_your_answers'}" class="button" />
					{/if}
				</form>
				{/if}
			{/if}
		{/if}

		{if isset($aQuiz.image_path) && $aQuiz.image_path != ''}
		</div>
		<div class="clear"></div>		
		{/if}
		
	{if !isset($bIsViewingQuiz) && isset($aQuiz.aFeed)}
	{module name='feed.comment' aFeed=$aQuiz.aFeed}
	{/if}			
		
		{if !isset($bIsViewingQuiz)}
			</div>		
		</div>
		{/if}
	</div>	
</div>