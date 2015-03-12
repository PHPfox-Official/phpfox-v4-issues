

$Behavior.theme_select = function()
{
	$('.style_box').hover(function()
	{
		$(this).addClass('style_box_hover');
	},
	function()
	{
		$(this).removeClass('style_box_hover');
	});		
	
	$('#js_designer_full_screen').click(function()
	{		
		if ($(this).hasClass('is_at_full_screen'))
		{
			$('div.style_content_middle').height(170);
			$('div.style_separate').height(170);
			$('div.style_content_right div.style_main_content').height(137);
			
			$(this).removeClass('is_at_full_screen');			
		}
		else
		{		
			iHeight = (getResizedWindow() - 40);
			
			$('div.style_content_middle').height(iHeight - 30);
			$('div.style_separate').height(iHeight - 30);
			$('div.style_content_right div.style_main_content').height(iHeight - 100);
			
			$(this).addClass('is_at_full_screen');			
		}
		
		full_height_textarea();
		
		return false;
	});
	
	$('#js_toggle_blocks').click(function()
	{
		$('.js_sortable_header').each(function()
		{
			$(this).parent().find('.content:first').toggle();
			$(this).parent().find('.bottom:first').toggle();			
		});
		
		return false;
	});
	
	$('#js_toggle_designer_content').click(function()
	{		
		if ($('#js_designer_content').hasClass('is_closed'))
		{
			$('#js_designer_content').show().removeClass('is_closed');			
			$('body').css('margin-top', '210px');
		}
		else
		{
			$('#js_designer_content').hide().addClass('is_closed');		
			$('body').css('margin-top', '30px');
		}
		
		return false;
	});
	
	$('#js_toggle_designer').click(function()
	{
		$('#js_designer_content').toggle();
		$('#js_designer_content').remove();
		$('#js_theme_select_iframe').height((getResizedWindow() - ($('#js_style_holder').outerHeight() + 20)));
		
		return false;
	});	
	
	$('.style_content_middle ul li a').click(function()
	{		
		$('.style_content_middle ul li a').removeClass('active');
		$(this).addClass('active');
		$('.js_designer_child_section').hide();
		$('#js_designer_child_' + $(this).attr('href').replace('#', '')).show();
		$('.style_main_content').scrollTop(0);
		$('#js_reset_group').val($(this).attr('href').replace('#', ''));
		
		return false;
	});	
	
	$('.style_content_left ul li a').click(function()
	{		
		$('.style_content_left ul li a').removeClass('active');
		$(this).addClass('active');
		$('.js_designer_section').hide();
		$('.style_content_left ul li ul').hide();
		$('#js_designer_' + $(this).attr('href').replace('#', '')).show();
		
		if ($(this).attr('href').replace('#', '') == 'advanced')
		{
			$('.style_content_middle').show();
			$('.style_content_right').css('margin-left', '310px');
			$('#js_designer_' + $(this).attr('href').replace('#', '')).find('.js_designer_child_section:first').show();
		}
		else
		{
			$('.style_content_middle').hide();
			$('.style_content_right').css('margin-left', '160px');			
		}
			
		return false;
	});
	
	$('.style_content_middle ul li a').mouseover(function(){
		$($(this).parent().find('span:first').html()).css({'background': 'url(\'' + oJsImages['css_edit_background'] + '\')'});
	});
	
	$('.style_content_middle ul li a').mouseout(function(){
		$($(this).parent().find('span:first').html()).css({'background': ''});
	});	
	
	$('.js_design_reset').click(function()
	{		
		if (!confirm(oTranslations['core.are_you_sure']))
		{
			return false;
		}
				
		$(this).parents('.js_designer_child_section:first').find('.js_form_value').each(function()
		{
			if (!$(this).hasClass('js_design_reset'))
			{
				var aMatches = $(this).attr('name').match(/css\[(.*?)\]\[(.*?)\]/i);
				
				if ($(this).hasClass('js_colorpicker_div'))
				{
					$(this).parent().parent().find('.colorpicker_select:first').css('background-color', '');					
				}
				
				$('#js_cache_form_css').append('<div><input type="hidden" name="' + $(this).attr('name') + '" value="' + $(this).val() + '" /></div>');
				
				this.value = '';
			}
		});
		
		$('#js_cache_form_css').submit();
		
		return false;
	});
};

function full_height_textarea()
{
	$('#js_css_code_editor').height($('div.style_content_middle').innerHeight() - 50);	
}

function rebuilt_menu_design(sHash)
{
	// $('.style_submit_box').hide();
	$('.style_content_left ul li a').removeClass('active');
	$('.style_content_left ul li a').each(function()
	{		
		if ($(this).attr('href') == '#advanced')
		{
			$(this).addClass('active');
		}
	});
	$('.style_content_middle').show();
	$('.style_content_middle ul li a').removeClass('active');
	$('.style_content_middle ul li a').each(function()
	{
		if ($(this).attr('href') == sHash)
		{
			$(this).addClass('active');
		}
	});
	$('.js_designer_section').hide();
	$('#js_designer_advanced').show();
	$('.js_designer_child_section').hide();
	$('#js_designer_child_' + sHash.replace('#', '')).show();
	$('#js_reset_group').val(sHash.replace('#', ''));
}