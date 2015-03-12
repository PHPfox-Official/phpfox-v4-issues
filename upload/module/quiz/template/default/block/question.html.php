<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Quiz
 * @version 		$Id: entry.html.php 290 2009-03-08 18:07:34Z Raymond_Benc $
 */

defined('PHPFOX') or exit('NO DICE!');

?>

<div class="table full_question_holder row1">
		<div class="table_left question_number_title">
				{if isset($phpfox.iteration.question) && $phpfox.iteration.question <= Phpfox::getUserParam('quiz.min_questions')}
					{required}
				{/if}
				{phrase var='quiz.question'} {if isset($phpfox.iteration.question)}{$phpfox.iteration.question}{/if}
		</div>
	<div class="table_right">
		{if (isset($phpfox.iteration.question) && $phpfox.iteration.question <= Phpfox::getUserParam('quiz.min_questions')) ||
		    (isset($Question.iQuestionIndex) && $Question.iQuestionIndex <= Phpfox::getUserParam('quiz.min_questions')) ||
			(!isset($phpfox.iteration.question) && !isset($Question.iQuestionIndex))}
		<div id="removeQuestion" style="display:none;float:right;">
		{else}
		<div id="removeQuestion" style="float:right;">
        {/if}
				<a href="#" onclick="return $Core.quiz.removeQuestion(this);">{img theme='misc/delete.png' alt=''}</a>			
			
		</div>
		
		
		<input type="text" class="question_title" name="val[q][{if isset($Question.question_id)}{$Question.question_id}{elseif isset($phpfox.iteration.question)}{$phpfox.iteration.question}{else}0{/if}][question]" value="{if isset($Question.question)}{$Question.question}{/if}" maxlength="200" size="30" />
		
		<div class="p_4">		
			{phrase var='quiz.answers'}:
			<div class="p_4 answer_holder answers_holder" id="">
				{if isset($Question.answers)}
					{foreach from=$Question.answers item=aAnswer name=iAnswer}					
						<div class="p_2 answer_parent {if isset($aAnswer.is_correct) && $aAnswer.is_correct == 1}correctAnswer{/if}">
						
							<input type="hidden" class="hdnCorrectAnswer" name="val[q][{if isset($Question.question_id)}{$Question.question_id}{elseif isset($phpfox.iteration.question)}{$phpfox.iteration.question}{else}0{/if}][answers][{if isset($aAnswer.answer_id) && $aAnswer.answer_id != ''}{$aAnswer.answer_id}{else}{$phpfox.iteration.iAnswer}{/if}][is_correct]" value="{if isset($aAnswer.is_correct)}{$aAnswer.is_correct}{else}found none{/if}">
							{if isset($aAnswer.answer_id)}
								{* On error when adding this should not be set but when editing yes *}
								<input type="hidden" name="val[q][{if isset($Question.question_id)}{$Question.question_id}{elseif isset($phpfox.iteration.question)}{$phpfox.iteration.question}{else}0{/if}][answers][{if isset($aAnswer.answer_id) && $aAnswer.answer_id != ''}{$aAnswer.answer_id}{else}{$phpfox.iteration.iAnswer}{/if}][answer_id]" class="hdnAnswerId"  value="{if !isset($bErrors) || $bErrors == false}{$aAnswer.answer_id}{/if}">
								<input type="hidden" name="val[q][{if isset($Question.question_id)}{$Question.question_id}{elseif isset($phpfox.iteration.question)}{$phpfox.iteration.question}{else}0{/if}][answers][{if isset($aAnswer.answer_id) && $aAnswer.answer_id != ''}{$aAnswer.answer_id}{else}{$phpfox.iteration.iAnswer}{/if}][question_id]" class="hdnQuestionId"  value="{if isset($aAnswer.question_id)}{$aAnswer.question_id}{/if}">
							{else}
								{* This happens when there is an error submitting (forgot to add a question title maybe) *}
							{/if}
							<input type="text" name="val[q][{if isset($Question.question_id)}{$Question.question_id}{elseif isset($phpfox.iteration.question)}{$phpfox.iteration.question}{else}0{/if}][answers][{if isset($aAnswer.answer_id) && $aAnswer.answer_id != ''}{$aAnswer.answer_id}{elseif isset($phpfox.iteration.iAnswer)}{$phpfox.iteration.iAnswer}{else}{$phpfox.iteration.iAnswer}{/if}][answer]" tabindex="" class="answer " value="{$aAnswer.answer}" maxlength="100" onblur="{literal}if(this.value == ''){ this.value = '{/literal}{$aAnswer.answer}{literal}';}{/literal}" onfocus="{literal}if ( (this.value.length == 'Answer X...'.length || this.value.length == 'Answer XY...'.length) && (this.value.substr(0,'Answer '.length) == 'Answer ') && (this.value.substr('Answer X'.length, 3) == '...')){this.value = '';}{/literal}" />
							<a href="#" class="a_addAnswer" onclick="return $Core.quiz.appendAnswer(this);">
								{img theme='misc/add.png' style='vertical-align:middle;' alt_phrase='quiz.add'}
							</a>
							<a href="#" class="a_removeAnswer_{$phpfox.iteration.iAnswer}" id="a_removeAnswer" onclick="return $Core.quiz.deleteAnswer(this);">
								{img theme='misc/delete.png' style='vertical-align:middle;' alt_phrase='quiz.delete'}
							</a>
							<a href="#" class="a_setCorrect_{$phpfox.iteration.iAnswer}" id="a_setCorrect" onclick="return $Core.quiz.setCorrect(this);">
								{img theme='misc/accept.png' style='vertical-align:middle;' alt_phrase='quiz.accept'}
							</a>
						</div>
					{/foreach}
				{else}
					{for $i=1; $i <= Phpfox::getParam('quiz.default_answers_count'); $i++}
						<div id="answer_[iQuestionId]_{$i}" class="p_2 answer_parent">
							<input name="val[q][{if isset($Question.question_id)}{$Question.question_id}{elseif isset($phpfox.iteration.question)}{$phpfox.iteration.question}{else}0{/if}][answers][{$i}][is_correct]" type="hidden" class="hdnCorrectAnswer" value="0">
							<input type="hidden" class="hdnAnswerId"  value="">
							<input type="hidden" class="hdnQuestionId"  value="">
							<input type="text" name="" tabindex="{$i}" class="answer answer_{$i}" value="" maxlength="100" />
							<a href="#" class="a_addAnswer" onclick="return $Core.quiz.appendAnswer(this);">
								{img theme='misc/add.png' style='vertical-align:middle;' alt_phrase='quiz.add'}
							</a>
							<a href="#" class="a_removeAnswer_{$i}" id="a_removeAnswer" onclick="return $Core.quiz.deleteAnswer(this);">
								{img theme='misc/delete.png' style='vertical-align:middle;' alt_phrase='quiz.delete'}
							</a>
							<a href="#" class="a_setCorrect_{$i}" id="a_setCorrect" onclick="return $Core.quiz.setCorrect(this);">
								{img theme='misc/accept.png' style='vertical-align:middle;' alt_phrase='quiz.accept'}
							</a>
						</div>
					{/for}
				{/if}
			</div>
		</div>
	</div>
</div>
