
$Behavior.ie7FixZindex = function()
{
	var zIndexNumber = 100000;
	$('div').each(function() 
	{
		$(this).css('zIndex', zIndexNumber);
		zIndexNumber -= 10;
	});
}