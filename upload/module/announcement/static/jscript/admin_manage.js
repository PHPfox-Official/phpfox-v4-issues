
$Behavior.announcement_admin_manage_init = function()
{
	$('#age_from').change(function()
	{
		if (!empty(this.value) && $('#age_to option:selected').val() != '' && this.value > $('#age_to option:selected').val())
		{
			alert(oTranslations['announcement.min_age_cannot_be_higher_than_max_age']);
			$(this).val('');
		}
	});

	$('#age_to').change(function(){
		if (!empty(this.value) && $('#age_from option:selected').val() && $(this).val() < $('#age_from option:selected').val())
		{
			alert(oTranslations['announcement.max_age_cannot_be_lower_than_the_min_age']);
			$(this).val('');
		}
	});

	$('#js_is_user_group').change(function()
	{
		if (this.value == 1)
		{
			$('#js_user_group').hide();
		}
		else if (this.value == 2)
		{
			$('#js_user_group').show();
		}
	});

	if ($('#js_is_user_group').val() == 2)
	{
		$('#js_user_group').show();
	}

};