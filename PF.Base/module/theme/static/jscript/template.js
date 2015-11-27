
$Core.templateEditor =
{
	checkRevertChild: function()
	{
		$('.menu_parent').each(function()
		{
			if ($(this).hasClass('modified'))
			{
				var iRemove = 0;
				$(this).parent().find('ul li a').each(function()
				{
					if ($(this).hasClass('modified'))
					{
						iRemove++;
					}
				});
				
				if (iRemove === 0)
				{
					$(this).removeClass('modified');
				}
			}
		});
	},
	
	deleteItem: function()
	{
		if (confirm(oTranslations['core.are_you_sure']))
		{
			$Core.ajaxMessage();
			$('#js_template_form').ajaxCall('theme.deleteTemplate', 'global_ajax_message=true');						
		}
		
		return false;
	},	
	
	checkIfAnyOpen: function(sId)
	{
		$('#' + sId).remove();
		
		var iCnt = 0;
		$('.js_append_theme_layer').each(function()
		{
			iCnt++;
		});
		
		if (iCnt === 0)
		{
			$('#js_template_content_loader').show();
		}
	}	
};

$Behavior.templateEditor = function()
{
	$('.js_open_template_list').click(function()
	{		
		if ($(this).next('ul').get(0).style.display == 'none')
		{
			$(this).next('ul').show();
			$(this).parent().addClass('active');
		}
		else
		{
			$(this).next('ul').hide();
			$(this).parent().removeClass('active');
		}		
				
		return false;
	});
	
	$('.js_get_template_file').click(function()
	{
		aParams = $.getParams($(this).get(0).href);		
		
		$(this).find('div:first').show();
		$(this).addClass('js_link_cache_' + aParams['type'] + '_' + aParams['name'].replace(/\./g, '_').replace(/\//g, '_') + '_' + (isset(aParams['module']) ? aParams['module'] : ''));

		$.ajaxCall('theme.getTemplate', 'type=' + aParams['type'] + '&name=' + aParams['name'] + '&theme=' + aParams['theme'] + '&module=' + (isset(aParams['module']) ? aParams['module'] : ''), 'GET');
		
		return false;	
	});
	
	$('#js_update_template').click(function()
	{		
		$('#js_template_content_text').val(editAreaLoader.getValue('js_template_content'));		
		editAreaLoader.setFileEditedMode('js_template_content', $('#js_template_type').val() + '_' + $('#js_template_module').val() + '_' + $('#js_template_name').val().replace(/\./g, '_').replace(/\//g, '_'), false);	
		$('.js_link_cache_' + $('#js_template_type').val() + '_' + $('#js_template_name').val().replace(/\./g, '_').replace(/\//g, '_') + '_' + $('#js_template_module').val() + '').addClass('modified');		
		$Core.ajaxMessage();
		$('#js_template_form').ajaxCall('theme.updateTemplate', 'global_ajax_message=true');
	});	
	
	$('#js_revert').click(function()
	{
		if (confirm(oTranslations['core.are_you_sure']))
		{
			$Core.ajaxMessage();
			$('#js_template_form').ajaxCall('theme.revert', 'global_ajax_message=true');
		}
		
		return false;
	});
};

$Behavior.theme_template_set_dimension = function()
{
	$('#js_template_content').width(($('#content_editor_text').width() - 25));
	$('#js_template_content').height(($('#content_editor_menu').height() - 75));
	
	$('#js_template_content_loader').width($('#content_editor_text').width());
	$('#js_template_content_loader').height(($('#content_editor_text').height()));	
};