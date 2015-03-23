
$(function()
{
	$('.content').each(function()
	{
		if (empty($(this).html()))
		{			
			$(this).parents('.block:first').remove();
		}
	});
});