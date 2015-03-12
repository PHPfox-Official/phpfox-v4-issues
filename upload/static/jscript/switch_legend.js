
$Behavior.switchLegends = function()
{
	$('.legend').click(function()
	{		
		var sNextDisplay = $(this).next().get(0).style.display;
		var sId = $(this).get(0).id;
		if (sNextDisplay == '' || sNextDisplay == 'block')
		{		
			$($(this).next()).hide('fast');
			$(this).addClass('legendClosed');
			if (!getCookie(sId))
			{
				setCookie(sId, true, 365);
			}
		}
		else
		{
			$($(this).next()).show('fast');
			$(this).removeClass('legendClosed');
			deleteCookie(sId);
		}
	});
	
	$('.legend').each(function()
	{
		if (getCookie($(this).get(0).id))
		{
			$(this).addClass('legendClosed');
			$(this).next().hide();
		}
	});	
};