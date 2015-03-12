<?php
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_User
 * @version 		$Id: browse.html.php 2137 2010-11-15 13:37:06Z Raymond_Benc $
 * {* *}
 */
defined('PHPFOX') or exit('NO DICE!');
?>

<div class="message">
	<ol>
		<li>
			{phrase var='user.if_your_site_uses_multiple_languages' sSiteUsePhrase=$sSiteUsePhrase}
		</li>		
	</ol>
</div>

<form action="{url link='admincp.user.spam'}" method="post" enctype="multipart/form-data">
	<div class="table_header">
		{phrase var='user.add_new_question'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='user.you_can_add_an_image_if_you_like'}:
		</div>
		<div class="table_right">
			<input type="file" name="file" id="input_file" onchange="$Core.User.Spam.fileChanged();" />
			<div id="div_edit_image">
				<div id="div_edit_image_imge"></div>
				<input type="hidden" name="val[preserve_image]" value="1" />
				<input type="button" class="button" id="btn_edit_remove_image" value="{phrase var='user.delete_image'}" onclick="$Core.User.Spam.deleteImage();" />
			</div>
		</div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='user.you_can_add_your_question_here'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[question]" id="question_text" />
			<div class="extra_info">
				{phrase var='user.you_can_enter_the_html_code_for_a_language_phrase_for_example'}: <br />{l}phrase var='core.yes'{r}
			</div>
		</div>
	</div>
	<div class="table" id="div_add_answers">
		<div class="table_left">
			{phrase var='user.now_add_at_least_one_valid_answer'}:
		</div>
		<div class="table_right">
			
			<div id="div_add_answer">
				<input type="button" value="{phrase var='user.add_more_answers'}" class="button" onclick="$Core.User.Spam.addAnswer();" />
			</div>
			<div class="extra_info">
				{phrase var='user.you_can_use_html_code_for_language_phrases_for_example'}: <br />{l}phrase var='core.yes'{r}
			</div>
		</div>
	</div>	
	<div class="table_bottom">
		<input type="submit" value="{phrase var='user.add_question'}" id="btn_submit" class="button" />
	</div>
</form>

<div class="table_header" style="margin-top:20px;">
	{phrase var='user.current_questions'}
</div>
<table id="tbl_questions">
	<tr class="tbl_questions_header">
		<th></th>
		<th>{phrase var='user.image'}</th>
		<th>{phrase var='user.question'}</th>
		<th>{phrase var='user.answers'}</th>
	</tr>
	<tr id="tpl_question_tr">
		<td class="question_actions">
			{img theme='misc/delete.png' class='img_delete_question' onclick='$Core.User.Spam.deleteQuestion( $(this).data('question_id').question_id );'}
			<a href="{url link='admincp.user.spam'}" class="a_edit">{phrase var='user.edit'}</a>
		</td>
		<td class="question_image">
		</td>
		<td class="question_question">
			
		</td>
		<td class="question_answers">
			
		</td>	
	</tr>
</table>

<div id="tpl_answer">
	<div class="valid_answer">
		<div class="valid_answer_action">
			{img theme='misc/delete.png' class='img_delete' onclick='$Core.User.Spam.deleteAnswer(this);'}
		</div>
		<div class="valid_answer_text">
			<input type="text" name="val[answer][]" />
		</div>
	</div>
</div>