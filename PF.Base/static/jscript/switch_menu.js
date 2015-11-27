
$Behavior.switchLabelMenu = function()
{
	$('.label_flow_menu a').click(function()
	{
		$(this).blur();
		if ($(this).parent().hasClass('label_flow_menu_active'))
		{
			return false;
		}
		var aArgs = $(this).get(0).href.split('#');
		var aArgsFinal = aArgs[1].split('?');

	//	$('body').prepend('here' + $('#swfuContainer').html());

		$(this).switchMenu('label_flow_menu_active', aArgsFinal[0], aArgsFinal[1]);		
		return false;
	});
};

$.fn.switchMenu = function(sMenu, sAjaxCall, sParams)
{
	$(this).parent().parent().find('li').removeClass(sMenu);
	$(this).parent().addClass(sMenu);

	

	$(this).parents().next('.labelFlowContent').html('<div class="label_flow" style="height:' + ($(this).parents().next('.labelFlowContent').height()) + 'px; text-align:center;"><img src="' + oJsImages['ajax_large'] + '" alt="" style="vertical-align:middle;" /></div>');
	
	if (sAjaxCall)
	{
		this.ajaxCall(sAjaxCall, sParams, null, 'GET');
	}
	
	return this;
};