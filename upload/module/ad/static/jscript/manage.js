
$Behavior.ad_manage_init = function()
{
    $('.js_item_active_link').click(function()
    {
    	aParams = $.getParams(this.href);
    	var sParams = '';
		for (sVar in aParams)
		{			
			sParams += '&' + sVar + '=' + aParams[sVar] + '';
		}
		sParams = sParams.substr(1, sParams.length);
		
		if ($(this).hasClass('js_remove_default'))
		{
			$('.js_remove_default').each(function()
			{
				$(this).parent().parent().find('.js_item_is_active:first').hide();
				$(this).parent().parent().find('.js_item_is_not_active:first').show();
			});
		}		
		
		if (aParams['active'] == '1')
		{
			$(this).parent().parent().find('.js_item_is_not_active:first').hide();
			$(this).parent().parent().find('.js_item_is_active:first').show();
		}
		else
		{
			$(this).parent().parent().find('.js_item_is_active:first').hide();
			$(this).parent().parent().find('.js_item_is_not_active:first').show();
		}
				
		$.ajaxCall(aParams['call'], sParams + '&global_ajax_message=true');
    	
    	return false;
    });
};