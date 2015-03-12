/**
 * This function replaces the text in the phrases for an input field so the user can edit their value
 * it shows an edit button to confirm the edit.
 */

var aEditing = {};
function showEdit(iVar)
{
	$('.tr_td_'+iVar).each(function(){

		if ($(this).attr('id') in aEditing)
		{
			return;
		}
		aEditing[$(this).attr('id')] = $(this).attr('id');
		var aClasses = $(this).attr('class').split(' ');
		
		var sLangVar = '';
		var oVar;
		for (var i in aClasses)
		{
			if (aClasses[i].match(/phraseid_/))
			{
				sLangVar = aClasses[i].replace('phraseid_','');
				oVar = sLangVar.split('_');

				debug (oVar);
			}
		}
		$('#dateStart_' + iVar + ', #dateEnd_' + iVar).show();
		$('#currentStart_' + iVar + ', #currentEnd_' + iVar).hide();
		$('#dateStart_' + iVar + ' #start_month').attr('name', 'val[dates]['+oVar[1]+'][start_month]');
		$('#dateStart_' + iVar + ' #start_day').attr('name', 'val[dates]['+oVar[1]+'][start_day]');
		$('#dateStart_' + iVar + ' #start_year').attr('name', 'val[dates]['+oVar[1]+'][start_year]');
		$('#dateEnd_' + iVar + ' #end_month').attr('name', 'val[dates]['+oVar[1]+'][end_month]');
		$('#dateEnd_' + iVar + ' #end_day').attr('name', 'val[dates]['+oVar[1]+'][end_day]');
		$('#dateEnd_' + iVar + ' #end_year').attr('name', 'val[dates]['+oVar[1]+'][end_year]');
		$('#doSchedule'+oVar[1]).removeAttr('disabled');
		
		$(this).html('<input type="text" value="' + $(this).html() + '" name="val[edit]['+oVar[0]+']['+oVar[1]+']">');
	});
	$('#edit_button').show();
}

$Behavior.fixDate= function()
{
	$('.js_date_picker').each(function(){		
		var sHiddenDate = $(this).parents('.time_holder').find('.time_hidden').text();		
		if (sHiddenDate.length > 2)
		{
			var oDate = new Date(parseInt(sHiddenDate*1000));
			$(this).datepicker('setDate', oDate).datepicker('enable').val((oDate.getMonth() +1) + '/' + oDate.getDate() +   '/' + oDate.getFullYear());
		}		
	});
	

};
