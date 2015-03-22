$Core.Newsletter = {
	showPlain : function()
	{		
		var sText = Editor.getContent();
		
		$.ajaxCall('newsletter.showPlain', 'sText='+sText);
	},
	toggleType : function(iType)
	{
		if (iType == 1)
		{
			$('.js_txtPlain').hide();
			$('#lbl_html_text').html('Text:');
			$('#js_privacy').hide();
		}
		else
		{
			$('.js_txtPlain').show();
			$('#lbl_html_text').html('HTML Text:');
			$('#js_privacy').show();
		}
	},
	checkText : function()
	{
		if ( $('textarea#text').val().length < 1 && $('textarea#txtPlain').val().length > 0)
		{
			$('textarea#text').val( $('textarea#txtPlain').val() );
		}
		$('#frmNewsletter').submit();
	}
}

$Behavior.newsletter_add_init = function()
{	
	$('.end_option').change(function()
	{
		if (this.value == 1)
		{
			$('#js_end_option').show();			
		}
		else
		{
			$('#js_end_option').hide();
		}
		
		return true;
	});
	
	$('#view_unlimited').change(function()
	{
		if (this.checked)
		{
			$('#total_view').attr('disabled', true).addClass('disabled');
		}
		else
		{
			$('#total_view').attr('disabled', false).removeClass('disabled').focus();
		}
	});
	
	$('#click_unlimited').change(function()
	{
		if (this.checked)
		{
			$('#total_click').attr('disabled', true).addClass('disabled');
		}
		else
		{
			$('#total_click').attr('disabled', false).removeClass('disabled').focus();
		}
	});	

	$('#age_from').change(function()
	{
		if (!empty(this.value) && $('#age_to option:selected').val() != '' && this.value > $('#age_to option:selected').val())
		{
			alert(oTranslations['newsletter.min_age_cannot_be_higher_than_max_age']);
			$(this).val('');
		}
	});

	$('#age_to').change(function(){
		if (!empty(this.value) && $('#age_from option:selected').val() && $(this).val() < $('#age_from option:selected').val())
		{
			alert(oTranslations['newsletter.max_age_cannot_be_lower_than_the_min_age']);
			$(this).val('');
		}
	});
	
	$('#type_id').change(function()
	{
		$('.js_add_hidden').hide();
		
		if (this.value == 1)
		{
			$('#js_type_image').show();
			$('#js_total_click').show();
			$('#js_type_image_link').show();
		}
		else if (this.value == 2)
		{
			$('#js_type_html').show();
			$('#js_total_click').hide();
			$('#js_type_image_link').hide();
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
	
	$('.end_option').each(function()
	{
		if (this.value == 1 && this.checked === true)
		{
			$('#js_end_option').show();
		}
	});
	
	if ($('#type_id').val() == 1)
	{
		$('#js_type_image').show();
		$('#js_total_click').show();
		$('#js_type_image_link').show();		
	}
	else if ($('#type_id').val() == 2)
	{
		$('#js_type_html').show();
		$('#js_total_click').hide();
		$('#js_type_image_link').hide();		
	}
	
	if ($('#js_is_user_group').val() == 2)
	{
		$('#js_user_group').show();
	}
	
		
};