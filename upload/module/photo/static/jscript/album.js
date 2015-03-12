
$Behavior.photoUserBrowser = function()
{
	/*
	if (!empty(window.location.hash))
	{			
		$('#js_album_content').html($.ajaxProcess(oTranslations['language.loading'], 'large'));
			
		$.ajaxCall('photo.browseAlbum', $Core.parseUrlString(window.location.hash));	
	}
	*/
	
	$('#js_cancel_photo_edit').click(function()
	{
		$('#js_photo_edit_form_outer').hide();
		$('#js_album_outer_content').show();
		
		return false;
	});
	
	$('#js_cancel_photo_delete').click(function()
	{
		$('#js_album_delete_form').hide();
		$('#js_album_outer_content').show();
		
		return false;
	});	
	
	$('#js_delete_this_album').click(function()
	{
		$('#js_photo_edit_form_outer').hide();
		$('#js_album_outer_content').hide();
		$('#js_album_edit_form').hide();
		$('#js_album_delete_form').show();
		
		return false;
	});	
	
	$('#js_edit_this_album').click(function()
	{
		$('#js_photo_edit_form_outer').hide();
		$('#js_album_outer_content').hide();
		$('#js_album_delete_form').hide();
		$('#js_album_edit_form').show();
		
		return false;
	});
	
	$('#js_update_album_form').submit(function()
	{
		$('#js_updating_album').html($.ajaxProcess(oTranslations['photo.updating_album']));
		
		$(this).ajaxCall('photo.updateAlbum');
		
		$('#js_album_edit_form').hide();
		$('#js_album_outer_content').show();		

		return false;
	});
	
	$('#js_album_cancel_edit').click(function()
	{
		$('#js_album_edit_form').hide();
		$('#js_album_outer_content').show();
		
		return false;
	});	
	
	$('.js_photo_set_cover').click(function()
	{
		$('.js_photo_set_cover').each(function()
		{
			$(this).parent().show();
		});			
		
		$(this).parents('div:first').parent().find('.js_photo_set_cover_div').hide();

		$.ajaxCall('photo.setAlbumCover', $Core.getHashParam(this.href));
		
		return false;
	});
}

function plugin_addFriendToSelectList()
{
	$('#js_allow_list_input').show();
}