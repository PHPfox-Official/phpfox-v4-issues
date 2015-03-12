
$Behavior.datePicker = function()
{
	$('.js_date_picker').datepicker({			
		onSelect: function(dateText, inst) 
		{
			var aParts = explode('/', dateText);
			var sMonth = ltrim(aParts[0], '0');
			var sDay = ltrim(aParts[1], '0');
				
			$(this).parents('.js_datepicker_holder:first').find('.js_datepicker_month').val(sMonth);
			$(this).parents('.js_datepicker_holder:first').find('.js_datepicker_day').val(sDay);
			$(this).parents('.js_datepicker_holder:first').find('.js_datepicker_year').val(aParts[2]);
		}
	});	
}