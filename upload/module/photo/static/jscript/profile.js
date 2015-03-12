
$Behavior.photoUserBrowser = function()
{
	if (!empty(window.location.hash))
	{			
		if (window.location.hash.match(/view_album/i))
		{			
			$('#js_user_photo_albums').html($.ajaxProcess(oTranslations['language.loading'], 'large'));
			
			$.ajaxCall('photo.browseUserAlbum', $Core.parseUrlString(window.location.hash));
		}
		else
		{
			$('#js_user_photos').html($.ajaxProcess(oTranslations['language.loading'], 'large'));
			
			$.ajaxCall('photo.browseUserPhotos', $Core.parseUrlString(window.location.hash));			
		}
	}	
	
	$('#js_photo_view_more_albums').click(function()
	{		
		$.ajaxCall('photo.browseUserAlbum', $Core.getRequests(this.href));
		
		window.location = '#' + $Core.getRequests(this.href, true);
				
		return false;
	});
}

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
}