
function photoLoaderImage()
{
	$('#site_content').html($.ajaxProcess(oTranslations['photo.loading'], 'large'));		
}

$Behavior.photo_browse = function()
{
	/*
	if (!empty(window.location.hash))
	{
		photoLoaderImage();
		
		$.ajaxCall('core.page', 'module=photo.index' + $Core.parseUrlString(window.location.hash));
	}
	else
	{
		$('#js_actual_photo_content').show();
	}
	
	$('.js_photo_category').click(function()
	{		
		photoLoaderImage();

		$.ajaxCall('core.page', 'module=photo.index' + $Core.getRequests(this.href));		
		
		window.location = '#' + $Core.getRequests(this.href, true);
		
		$.scrollTo('#site_content', 340);
		
		return false;
	});		
	
	$('#js_photo_form').submit(function()
	{
		photoLoaderImage();

		$.ajaxCall('core.page', 'module=photo.index' + $Core.getRequests(this.action) + $Core.parseUrlString(window.location.hash) + $(this).getForm());		
		
		$.scrollTo('#site_content', 340);
		
		window.location = '#' + $Core.reverseUrl($(this).getForm(), new Array('submit'));

		return false;
	});
	*/
};

$Behavior.photoCategoryDropDown = function()
{
	if (!empty($('.js_photo_active_items').html()))
	{
		var aParts = explode(',', $('.js_photo_active_items').html());
		for (i in aParts)
		{			
			if (empty(aParts[i]))
			{
				continue;
			}		
			
			$('#js_photo_category_' + aParts[i]).attr('selected', true);
		}
	}
};