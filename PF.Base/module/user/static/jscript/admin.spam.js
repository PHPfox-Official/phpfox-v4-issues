if (typeof $Core.User == 'undefined'){$Core.User = {Spam : {}};}

$Core.User.Spam.iTotalAnswers = 0;
$Core.User.Spam.addAnswer = function()
{
	$Core.User.Spam.iTotalAnswers++;
	var oTpl = $('#tpl_answer .valid_answer').clone();
	
	$('#div_add_answer').before(oTpl);
	$('.div_add_answers .valid_answer').show();
}

$Core.User.Spam.deleteAnswer = function(oObj)
{
	if (confirm('Are you sure?'))
	{
		$(oObj).parents('.valid_answer').remove();
	}
}

/* Called from the controller when adding a new question */
$Core.User.Spam.initAdd = function()
{
	$Core.User.Spam.addAnswer();
}

$Core.User.Spam.initPopulate = function(jObj)
{
	console.log(jObj);
	
	if ( typeof jObj['questions'] == 'object')
	{
		for (var i in jObj['questions'])
		{
			// get the question template
			var oTpl = $('#tpl_question_tr').clone();
			if (parseInt(i/2) == i/2)
			{
				$(oTpl).addClass('tr');
			}
			else
			{
				$(oTpl).addClass('checkRow');
			}
			
			
			// load the image if needed
			if (typeof jObj['questions'][i]['image_path'] != 'undefined' && jObj['questions'][i]['image_path'].length > 1)
			{
				$(oTpl).find('.question_image').html('<img src="' + oParams['sJsHome'] + 'file/pic/user/spam_question/' + jObj['questions'][i]['image_path'].replace('%s','') + '">');
			}
			
			// Do the question
			$(oTpl).find('.question_question').html(jObj['questions'][i]['question_phrase']);
			
			// Do the answers
			for (var j in jObj['questions'][i]['answers_phrases'])
			{
				var oTplAnswer = $('#tpl_answer .valid_answer').clone();
				$(oTplAnswer).find('input').val(jObj['questions'][i]['answers_phrases'][j]);
				$(oTplAnswer).find('.img_delete').remove();
				$(oTpl).find('.question_answers').append( $('<div>').html( $(oTplAnswer).find('input').val() )  );				
				$(oTpl).find('.valid_answer').show();
			}
			
			// fix the link to edit this question
			$(oTpl).find('.a_edit').attr('href', $(oTpl).find('.a_edit'). attr('href') + 'id_' + jObj['questions'][i]['question_id']);
			
			// fix the attr to call the delete question function
			$(oTpl).find('.img_delete_question').data('question_id', jObj['questions'][i]['question_id']).attr('id', 'img_delete_question_' + jObj['questions'][i]['question_id']);
			
			$(oTpl).find('.question_case').html( (jObj['questions'][i]['case_sensitive'] == 1) ? 'Yes' : 'No');
			$(oTpl).show();
			$(oTpl).attr('id', 'tr_new_question_' + jObj['questions'][i]['question_id']);
			$('.tbl_questions_header').after(oTpl);
			
			
		}
		
	}

	if ( typeof jObj['edit'] == 'object')
	{
		$('#question_text').val( jObj['edit']['question_phrase'] ).after('<input type="hidden" name="val[question_id]" value="' + jObj['edit']['question_id'] +'">');
		
		$('.valid_answer:first').remove();
		// now populate the answers
		for (var i in jObj['edit']['answers_phrases'])
		{
			var oTplAnswer = $('#tpl_answer .valid_answer').clone();
			$(oTplAnswer).find('input').val(jObj['edit']['answers_phrases'][i]);
			$('#div_add_answer').before( $(oTplAnswer) );				
			$('.valid_answer').show();
		}		
		
		//$('#radio_answers_case_' + (jObj['edit']['case_sensitive'] == '1' ? 'yes' : 'no')).attr('checked', 'checked');
		
		if (typeof jObj['edit']['image_path'] != 'undefined' && jObj['edit']['image_path'].length > 1)
		{
			$('#div_edit_image_imge').html( $('<img>').attr({
				'src': oParams['sJsHome'] + 'file/pic/user/spam_question/' + jObj['edit']['image_path'].replace('%s',''),
				'id' : 'img_previous_image'
				}));
			$('#div_edit_image').show();
		}
		else
		{
			$('#div_edit_image').html('').hide();
		}
		
		// Change the phrase in the submit button
		$('#btn_submit').attr('value', 'Edit Question');
		
		$('#input_file').val(jObj['edit']['image_path']);
	}
	
}

/* Sets a hidden input so the process service knows when to remove the previous image, this feature (deleting an image) may lead to the following situations
 * 	1- Admin deletes the image because he doesnt want any image to be shown
 * 	2- Admin deletes the image because he wants a new image to be shown (deletes then chooses a new one)
 * 	3- Admin chooses a new image but does not delete the previous image
 */
$Core.User.Spam.deleteImage = function()
{
	$('#div_edit_image').html('<p id="p_will_not_show_image">This question will not show an image</p>');
}

/* When editing a question the admin can choose to change the image for that question, this function couples deleteImage()
 */ 
$Core.User.Spam.fileChanged = function()
{
	if ( $('#img_previous_image').length > 0)
	{		
		/* Since the image has changed, let the admin know that he does not need to click the delete previous image button */
		$('#div_edit_image').html('Your previous image will be replaced with the one you have selected');
	}
	if ( $('#p_will_not_show_image').length > 0)
	{
		$('#div_edit_image').html('<p id="p_will_replace_image">This question will use the image you have just selected</p>');
	}
}

$Core.User.Spam.deleteQuestion = function(iQuestionId)
{
	if (confirm('Are you sure?'))
	{
		$.ajaxCall('user.deleteSpamQuestion', 'iQuestionId=' + iQuestionId);
		$('#img_delete_question_' + iQuestionId).attr({'onclick': '', 'src' : oJsImages['ajax_small']}).unbind('click');
	}
	
}
