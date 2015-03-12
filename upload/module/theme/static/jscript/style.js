
$Core.cssEditor =
{
	openFile: function(oObj, iStyleId, sName, sModule)
	{
		$(oObj).find('div:first').show().addClass('js_css_ajax_' + sName.replace(/\./g, '_'));
		$(oObj).addClass('js_link_cache_' + iStyleId + '_' + sName.replace(/\./g, '_') + '_' + sModule);
		
		$.ajaxCall('theme.getCssFile', 'style_id=' + iStyleId + '&file_name=' + sName + '&module_id=' + sModule);
		
		return false;
	},
	
	save: function(oObj)
	{
		$('#js_template_content_text').val(editAreaLoader.getValue('js_template_content'));		
		editAreaLoader.setFileEditedMode('js_template_content', $('#js_css_style_id').val() + '_' + $('#js_css_file').val().replace(/\./g, '_') + '_' + $('#js_css_module').val(), false);	
		$('.js_link_cache_' + $('#js_css_style_id').val() + '_' + $('#js_css_file').val().replace(/\./g, '_') + '_' + $('#js_css_module').val()).addClass('modified');		
		
		$Core.ajaxMessage();
		
		$(oObj).ajaxCall('theme.saveCssFile', 'global_ajax_message=true');
		
		return false;
	},
	
	revert: function()
	{
		if (confirm(oTranslations['core.are_you_sure']))
		{
			$Core.ajaxMessage();
			$('#js_template_form').ajaxCall('theme.revertCss', 'global_ajax_message=true');			
		}
		
		return false;
	},
	
	deleteItem: function()
	{
		if (confirm(oTranslations['core.are_you_sure']))
		{
			$Core.ajaxMessage();
			$('#js_template_form').ajaxCall('theme.deleteCss', 'global_ajax_message=true');						
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
}

$Behavior.theme_style_init_2 = function()
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
	
	$('#js_template_content').width(($('#content_editor_text').width() - 25));
	$('#js_template_content').height(($('#content_editor_menu').height() - 75));
	
	$('#js_template_content_loader').width($('#content_editor_text').width());
	$('#js_template_content_loader').height(($('#content_editor_text').height()));	
};