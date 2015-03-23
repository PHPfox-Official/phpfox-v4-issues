
/* $Core.loadStaticFile(getParam('sJsStatic') + 'jscript/colorpicker/css/colorpicker.css'); */
/* $Core.loadStaticFile(getParam('sJsStatic') + 'jscript/colorpicker/js/colorpicker.js');*/

$Behavior.designProfilePage = function()
{	
	var aCachePicker = Array();
	
	$('body').append('<div id=\"js_colorpicker_selector\" style=\"display:none; position:absolute; z-index:1009; overflow:visible;\"></div>');
	
	$('#js_colorpicker_selector').ColorPicker(
	{
		flat: true,
		onSubmit: function (hsb, hex, rgb) 
		{			
			if (isset(aCachePicker['class']))
			{
				$('.' + aCachePicker['class']).css(aCachePicker['var'], '#' + hex);
			}			
				
			$(aCachePicker['object']).css('backgroundColor', (hex != 'transparent' ? '#' : '') + hex);			
			
			$('#js_colorpicker_selector').hide();			
			
			if (isset(aCachePicker['id']))
			{
				$('#' + aCachePicker['id']).val(hex);
			}
			else
			{
				$(aCachePicker['object']).parent().find('.js_colorpicker_div:first').val((hex != 'transparent' ? '#' : '')  + hex);	
			}			
			
			if (function_exists('on_change_color'))
			{
				on_change_color(aCachePicker, hex);
			}
		}
	});
	
	$('.colorpicker_select').click(function(e)
	{		
		console.log('Check 43');
		var aArgsFinal = this.href.split('#?');	
		var aFinal = aArgsFinal[1].split('&');
		
		for (var i = 0; i < aFinal.length; i++)
		{
			var aArg = aFinal[i].split('=');	
			
			aCachePicker[aArg[0]] = aArg[1];
		}		
		
		aCachePicker['object'] = this;	
		
		$('#js_colorpicker_selector').show();
		$('.colorpicker').show();
		$('#js_colorpicker_selector').css('left', '' + e.pageX + 'px');
		$('#js_colorpicker_selector').css('top', '' + e.pageY + 'px');
		
		return false;
	});	
	
    $('.colorpicker').click(function()
    {
    	return false;
    });
    
    $(document).click(function()
    {
    	$('.colorpicker').hide();
    });	
};