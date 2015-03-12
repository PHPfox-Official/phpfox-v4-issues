
$Behavior.photoView = function()
{	
	$('#js_update_photo_form').submit(function()
	{
		$('#js_updating_photo').html($.ajaxProcess(oTranslations['photo.updating_photo']));
		
		$(this).ajaxCall('photo.updatePhoto');
		
		$('#js_photo_edit_form').hide();
		$('#js_photo_outer_content').show();		

		return false;
	});
	
	$('#js_photo_cancel_edit').click(function()
	{
		$('#js_photo_edit_form').hide();
		$('#js_photo_outer_content').show();
		
		return false;
	});		
}
var bLoadedKeyBrowser = false;
var bByPassLoadedKeyBrowser = false;
$Behavior.eventKeyboard = function()
{
	$('.comment_mini_end textarea').focus(function(){
		bByPassLoadedKeyBrowser = true;		
	});
	
	$('.comment_mini_end textarea').blur(function(){
		bByPassLoadedKeyBrowser = false;
	});		
	
	if (bLoadedKeyBrowser == true)
	{
		return;
	}	
	
	/*
	37 => left
	38 => up
	39 => right 
	40 => down
	*/
	$(document).keydown(function(e){
		if (!bByPassLoadedKeyBrowser){
			if (e.keyCode == 37)
			{
				$('#photo_view_theater_mode .previous a:first').click();
			}
			else if (e.keyCode == 39)
			{
				$('#photo_view_theater_mode .next a:first').click();
			}				
		}
	});
	bLoadedKeyBrowser = true;
}