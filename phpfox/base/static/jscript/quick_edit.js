
$Behavior.quickEdit = function()
{	
	$('.sJsQuickEdit').dblclick(function()
	{		
		$(this).createQuickEditForm($(this).find('.quickEdit').get(0).href);	
		return false;
	});
	
	$('.quickEdit').click(function()
	{
		$(this).createQuickEditForm($(this).get(0).href);	
		return false;
	});	
};

$.fn.createQuickEditForm = function(sUrl)
{
	$aParams = $.getParams(sUrl);		
	
	eval('var sTempVar = \'js_cache_quick_edit' + $aParams['id'] + '\';');
	
	$(this).blur();
	
	if (document.getElementById(sTempVar))
	{			
		return;
	}
	
	var sParams = '';
	for (sVar in $aParams)
	{			
		sParams += '&' + sVar + '=' + $aParams[sVar] + '';
	}
	sParams = sParams.substr(1, sParams.length);
	
	var sProcessing = '<span style="margin-left:4px; margin-right:4px; display:none; font-size:9pt; font-weight:normal;" id="js_quick_edit_processing' + $aParams['id'] + '">' + getPhrase('core.processing') + '...</span>';
		
	switch($aParams['type'])
	{
		case 'input':			
			$('body').append('<div id="js_cache_quick_edit' + $aParams['id'] + '" style="display:none;">' + $('#' + $aParams['id']).html(sHtml) + '</div>');			
			var sValue = $('#' + $aParams['content']).html();			
			sValue = sValue.replace(/"/g, "&quot;").replace(/'/g, "&#039;");
			var sHtml;
			sHtml = ' <input style="vertical-align:middle;" size="20" type="text" name="quick_edit_input" value="' + sValue + '" id="js_quick_edit' + $aParams['id'] + '" /> ';						
			sHtml += ' <input style="vertical-align:middle;" type="button" value="' + getPhrase('core.save') + '" class="button" onclick="$(\'#js_quick_edit_processing' + $aParams['id'] + '\').show(); $(\'#js_cache_quick_edit' + $aParams['id'] + '\').remove(); $(\'#js_quick_edit' + $aParams['id'] + '\').ajaxCall(\'' + $aParams['call'] + '\', \'' + sParams + '\');" /> ';
			sHtml += ' <input style="vertical-align:middle;" type="button" value="' + getPhrase('core.cancel') + '" class="button button_off" onclick="$(\'#' + $aParams['id'] + '\').html($(\'#js_cache_quick_edit' + $aParams['id'] + '\').html()); $(\'#js_cache_quick_edit' + $aParams['id'] + '\').remove(); $Core.loadInit();" /> ';			
			sHtml += sProcessing;
			$('#' + $aParams['id']).html(sHtml);
			$('#js_quick_edit' + $aParams['id']).focus();			
			break;
		case 'text':			
			$('#' + $aParams['id']).hide();
			$('body').append('<div id="js_cache_quick_edit' + $aParams['id'] + '" style="display:none;">' + $('#' + $aParams['id']).html(sHtml) + '</div>');							
			var sHtml;			
			$.ajaxCall($aParams['data'], '' + sParams + '');			
			sHtml = '<div id="js_quick_edit_id' + $aParams['id'] + '">' + $.ajaxProcess(getPhrase('core.loading_text_editor')) + '</div>';
			sHtml += '<div class="t_right" style="padding:4px 0 4px 0;">';			
			sHtml += sProcessing;
			
			sHtml += ' <input type="button" value="' + getPhrase('core.save') + '" class="button" onclick="if (function_exists(\'js_quick_edit_callback\')){js_quick_edit_callback();} $(\'#js_quick_edit_processing' + $aParams['id'] + '\').show(); $(\'#js_cache_quick_edit' + $aParams['id'] + '\').remove(); $(\'#js_quick_edit' + $aParams['id'] + '\').ajaxCall(\'' + $aParams['call'] + '\', \'' + sParams + '\');" /> ';
			sHtml += ' <input type="button" value="' + getPhrase('core.cancel') + '" class="button button_off" onclick="$(\'#' + $aParams['id'] + '\').html($(\'#js_cache_quick_edit' + $aParams['id'] + '\').html()); $(\'#js_cache_quick_edit' + $aParams['id'] + '\').remove()" /> ';
			if (isset($aParams['main_url']))
			{
				if (function_exists('quickSubmit'))
				{
					sHtml += ' <input type="button" onclick="quickSubmit(\'' + $aParams['id'] + '\', \''+$aParams['main_url']+'\')" value="' + getPhrase('core.go_advanced') + '" class="button button_off" /> ';
				}
				else
				{
					sHtml += ' <input type="button" value="' + getPhrase('core.go_advanced') + '" class="button button_off" onclick="window.location.href=\'' + $aParams['main_url'] + '\';" /> ';
				}
			}
			
			sHtml += '</div>';	
			$('#' + $aParams['id']).html(sHtml);
			$('#' + $aParams['id']).show();
			$('#js_quick_edit' + $aParams['id']).focus();
			break;
	}	
};