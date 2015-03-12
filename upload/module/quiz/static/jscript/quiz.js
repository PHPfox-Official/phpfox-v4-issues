$Core.quiz_moderate =
{
	approve : function(iQuiz, iUser, sTitle)
	{
		// simple ajax call
		$('.moderation_block_' + iQuiz).ajaxCall('quiz.approve','iQuiz=' + iQuiz + '&iUser=' + iUser + '&sTitle=' + sTitle + '');		
		
		return false;
	},

	deleteQuiz : function(iQuiz, sType)
	{
		// confirm delete
		if (confirm(oTranslations['quiz.are_you_sure_you_want_to_delete_this_quiz']))
		{
			$('.moderation_block_' + iQuiz).ajaxCall('quiz.delete','iQuiz=' + iQuiz + '&type=' + sType);
		}
		
		return false;
	},

	decreaseCounters : function()
	{
		// this is just a visual tweak
		var iTotal = parseInt($('#js_pager_total').html());
		if (iTotal > 1)
		{
			// we decrease them
			$('#js_pager_total').html(parseInt(iTotal - 1));
			$('#js_pager_to').html(parseInt(iTotal - 1));
		}
		else
		{
			$('#js_pager_total').html('0');
			$('#js_pager_to').html('0');
		}
	}
}

