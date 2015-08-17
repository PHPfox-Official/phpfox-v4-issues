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
<div class="block_search">
	<form action="{url link='admincp.user.spam'}" method="post" enctype="multipart/form-data">
		<div class="table_header">
			{phrase var='user.add_new_question'}
		</div>
		<div class="table">
			<div class="table_left">
				Image:
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
				Question:
			</div>
			<div class="table_right">
				<input type="text" name="val[question]" id="question_text" />
			</div>
		</div>
		<div class="table" id="div_add_answers">
			<div class="table_left">
				Answer(s):
			</div>
			<div class="table_right">
				<span id="div_add_answer" onclick="$Core.User.Spam.addAnswer();"><i class="fa fa-plus-circle"></i>{phrase var='user.add_more_answers'}</span>
				<div id="div_add_answer">
					{*<input type="button" value="{phrase var='user.add_more_answers'}" class="button" onclick="$Core.User.Spam.addAnswer();" />*}
				</div>
			</div>
		</div>
		<div class="table_clear">

			<input type="submit" value="{phrase var='user.add_question'}" id="btn_submit" class="button" />
		</div>
	</form>
</div>

<div class="block_content">
	<table id="tbl_questions">
		<tr class="tbl_questions_header">
			<th></th>
			<th>{phrase var='user.image'}</th>
			<th>{phrase var='user.question'}</th>
			<th>{phrase var='user.answers'}</th>
		</tr>
		<tr id="tpl_question_tr">
			<td class="question_actions">
				<i class="fa fa-remove img_delete_question" style="cursor:pointer; margin-right:5px;" onclick="$Core.User.Spam.deleteQuestion($(this).data('question_id'));"></i>
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
</div>

<div id="tpl_answer">
	<div class="valid_answer table">
		<div class="valid_answer_action table_left">
			<i class="fa fa-remove" onclick='$Core.User.Spam.deleteAnswer(this);'></i>
		</div>
		<div class="valid_answer_text table_right">
			<input type="text" name="val[answer][]" />
		</div>
	</div>
</div>