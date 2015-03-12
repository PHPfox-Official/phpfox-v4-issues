
$Behavior.quizAddQuestionClick = function()
{
	$('#js_add_question').click(function()
	{
		$Core.quiz.addQuestion();
		
		return false;
	});
	
	$('.add_class').click(function()
	{
		/* $(this).parents('.answer_holder:first .answer_parent').each(function()		{}); */

		var iCnt = 0;
		$('.answer_holder:first .answer_parent').each(function()
		{
			iCnt++;
		});

		$(this).parents('.answer_holder:first').append('<div class="answer_parent"><input type="text" class="answer" value="' + oTranslations['quiz.answer'] + ' ' + (iCnt + 1) + '..." /> <a href="#" class="remove_class">' + oTranslations['quiz.delete'] + '</a></div>');

		return false;
	});

	$('.remove_class').click(function()
	{
		$(this).parents('.answer_parent:first').remove();

		var iCnt = 0;
		$('.answer_holder:first .answer_parent').each(function()
		{
			iCnt++;
			$(this).find('.answer').val('' + oTranslations['quiz.answer'] + ' ' + iCnt + '...');
		});

		return false;
	});	
}

$Core.quiz =
{
	aParams: {},
	iTotalQuestions : 1,

	init: function(aParams)
	{
		this.aParams = aParams;		
		if ($Core.quiz.aParams.isAdd == true)
		{
			$(document).ready(function()
			{
				if ($Core.quiz.aParams.bErrors == false)
				{
					for (i = 0; i < $Core.quiz.aParams.iMinQuestions; i++)
					{
						$Core.quiz.addQuestion();
					}					
				}				
			});
		}
	},

	build: function()
	{

	},

	addQuestion: function()
	{
		var iCntQuestions = 0;
		$('.full_question_holder').each(function(){
			iCntQuestions++;
		});
		/* this conter has to be fixed in account of the hidden full_question_holder */
		iCntQuestions = iCntQuestions - 1;
		if (iCntQuestions >= $Core.quiz.aParams.iMaxQuestions)
		{
			alert(oTranslations['quiz.you_have_reached_the_maximum_questions_allowed_per_quiz']);
			return false;
		}

		/* append the full question */
		$('#hiddenQuestion').find(':text').each(function(){
			$(this).val('');
		});

		$('#js_quiz_container').append('' + $('#hiddenQuestion').html() + '');

		$Core.quiz.fixQuestionsIndexes();
		
		$('.full_question_holder:last').find('.hdnCorrectAnswer:first').val('1');
		$('.full_question_holder:last').find('.p_2:first').addClass('correctAnswer');			
		

		return false;
	},

	submitForm : function()
	{
		$('#js_quiz_layout_default').html('');
		return true;
	},

	fixQuestionsIndexes : function()
	{
		var iCntQuestions = 1;
		/*
		 * When editing a quiz, if you add another question this function breaks the
		 * relation between the question id and the question text
		 **/
		 var oDate = new Date();
		 // loop through every question:
		$('#js_quiz_container').find('.full_question_holder').each(function(){
			/* Count the answers inside this question */
			var iCntAnswers = 0;

			/* change the name of the question input */
			$(this).find('.question_title').attr('name', 'val[q][' + (iCntQuestions) + '][question]');

			/* Fix values inside each answer */
			$(this).find('.answer_parent').each(function()
			{
				// set the name of the text input="text" properly				
				$(this).find('.answer').attr('name', 'val[q][' + (iCntQuestions) + '][answers]['+iCntAnswers+'][answer]');
				$(this).find('.hdnCorrectAnswer').attr('name', 'val[q][' + iCntQuestions + '][answers][' + iCntAnswers + '][is_correct]');
				$(this).find('.answer').attr('name', 'val[q]['+iCntQuestions+'][answers]['+iCntAnswers+'][answer]');
				$(this).find('.hdnAnswerId').attr('name', 'val[q]['+iCntQuestions+'][answers]['+iCntAnswers+'][answer_id]');
				$(this).find('.hdnQuestionId').attr('name', 'val[q]['+iCntQuestions+'][answers]['+iCntAnswers+'][question_id]');
				if ($(this).find('.hdnQuestionId').val() == undefined)
				{
					$(this).find('.hdnQuestionId').val(iCntQuestions + iCntAnswers + '123321');
				}
				iCntAnswers++;
			});
			/* fix the name for the title */
			$(this).find('.question_title').attr('name', 'val[q]['+iCntQuestions+'][question]');
			/* change the Question # for the current question number:
			 this has to be after the increment of the questions counter*/
			if (iCntQuestions <= $Core.quiz.aParams.iMinQuestions)
			{
				$(this).find('.question_number_title').html($Core.quiz.aParams.sRequired + oTranslations['quiz.question_count'].replace('{count}', iCntQuestions));
			}
			else
			{
				$(this).find('.question_number_title').html(oTranslations['quiz.question_count'].replace('{count}', iCntQuestions));				
				$(this).find("#removeQuestion").show();
			}
			/* increase the counter for the questions*/
			iCntQuestions++;
		}); /* end of looping through questions*/
		/* Set the tab index properly*/
		var tabIndex = 1;
		$('.full_question_holder').each(function() {
			$(':input',this).not('input[type=hidden]').each(function() {
				if ($(this).attr('type') == 'text' || $(this).attr('type') == 'textarea')
				{
					$(this).attr('tabindex', tabIndex);
					tabIndex++;
				}
			});
		});
		
		
	},
	removeQuestion: function(oObj)
	{

		var iCntQuestions = 0;
		$('.full_question_holder').each(function(){
			iCntQuestions++;
		});
		
		/* this counter is tweaked because there is a hidden full_question_holder: */
		iCntQuestions = iCntQuestions - 1;
		if (iCntQuestions <= $Core.quiz.aParams.iMinQuestions)
		{
			var sAlert = '<div>' + oTranslations['quiz.you_are_required_a_minimum_of_total_questions'].replace('{total}', $Core.quiz.aParams.iMinQuestions)+ '</div>';
			sAlert =  $(sAlert).text();
			alert(sAlert);
			return false;
		}
		$Core.quiz.iTotalQuestions = iCntQuestions;

		$(oObj).parents('.full_question_holder:first').remove();
		$Core.quiz.fixQuestionsIndexes();
		return false;
	},

	appendAnswer: function(oObj)
	{
		var iCnt = 0;
		var iTime = new Date();
		$(oObj).parent('.answer_parent').parent('.answer_holder').find('.answer_parent').each(function(){
			iCnt++;
		});
		if (iCnt >= $Core.quiz.aParams.iMaxAnswers)
		{
			alert(oTranslations['quiz.you_have_reached_the_maximum_answers_allowed_per_question']);
			return false;
		}
		
		var parentLast = $(oObj).parents('.answers_holder').find('.answer_parent:first').clone();
		if (true)
		{
			/* now we re-set the info for the new answer */
			var iQuestionId = parentLast.find('.hdnQuestionId').val();			
			var iNextAnswer = iQuestionId + parentLast.find('.hdnAnswerId').val() + '' + 123 + '' + iTime.getMilliseconds();
			
			parentLast.find('.hdnAnswerId').attr('name', 'val[q][' + iQuestionId + '][answers]['+iNextAnswer+'][answer_id]');
			parentLast.find('.answer').attr('name', 'val[q][' + iQuestionId + '][answers]['+iNextAnswer+'][answer]');
			var sAnswerValue = parentLast.find('.answer').val();
			parentLast.find('.answer').val(' ');
			parentLast.find('.hdnQuestionId').attr('name', 'val[q][' + iQuestionId + '][answers]['+iNextAnswer+'][question_id]');
			parentLast.find('.hdnCorrectAnswer').attr('name', 'val[q][' + iQuestionId + '][answers]['+iNextAnswer+'][is_correct]');
			parentLast.find('.hdnAnswerId').remove();
			parentLast.find('.hdnCorrectAnswer').val('0');
		}

		parentLast = parentLast.html();
		if ($Core.quiz.aParams.isAdd == false)
		{
			parentLast.replace('"'+sAnswerValue+'"', '');
		}
		iCnt++;		
		$(oObj).parent('.answer_parent').after('<div class="p_2 answer_parent" id="sample_' + iNextAnswer + '">' + parentLast + '</div>');
		$('#sample_' + iNextAnswer).find('.answer').val(' ');
		this.fixQuestionsIndexes();
		return false;
	},

	deleteAnswer: function(oObj)
	{
		var iCnt = 0;

		$(oObj).parent('.answer_parent').parent('.answer_holder').find('.answer_parent').each(function(){
			iCnt++;
		});

		if (iCnt <= $Core.quiz.aParams.iMinAnswers)
		{
			var sAlert = '<div>' + oTranslations['quiz.you_are_required_a_minimum_of_total_answers_per_question'].replace('{total}', $Core.quiz.aParams.iMinAnswers) + '</div>';
			sAlert =  $(sAlert).text();
			alert(sAlert);
			return false;
		}
		$(oObj).parents('.answer_parent:first').remove();
		return false;
	},

	setCorrect: function(oObj)
	{
		$(oObj).parent('.answer_parent').parent('.answer_holder').find('.answer_parent').each(function(){
			$(this).removeClass('correctAnswer');
			$(this).find('.hdnCorrectAnswer').attr('value', 0);
		});


		$(oObj).parent('.answer_parent').find('.hdnCorrectAnswer').val(1);
		$(oObj).parent('.answer_parent').addClass('correctAnswer');

		return false;
	},

	checkGetFriends : function(oObj)
	{
		
		if ($('#privacy').val() == 4)
		{
			$Core.getFriends({
				input: 'allow_list'
			});
		}
	},

	deleteImage : function(iQuiz)
	{
		if (confirm(oTranslations['quiz.are_you_sure']))
		{
			$.ajaxCall('quiz.deleteImage', 'iQuiz=' + iQuiz);
		}
		return false;
	}
}

function plugin_addFriendToSelectList()
{
	$('#js_allow_list_input').show();
}