$Behavior.photoCategoryDropDown = function()
{
	$('.js_photo_category').click(function()
	{
		var iId = this.id.replace('js_photo_category_', '');
		var iItemId = $(this).parents('div:first').parent().parent().parent().find('.js_photo_item_id').html();
		var sValue = $(this).html();
		
		$('#js_photo_category_id_' + iItemId + iId).remove();
		$(this).prepend('<div id="js_photo_category_id_' + iItemId + iId + '"><input type="hidden" name="val[category_id]" value="' + iId + '" /></div>');
	
		$('.js_photo_category').removeClass('selected');
		$(this).addClass('selected');
		$('.select_clone').hide();
		$('.select_clone_select').html(sValue);
		
		return false;
	});
	
	$('.js_photo_category_done').click(function()
	{
		$('.select_clone').hide();
		
		return false;			
	});
	
	$('.select_clone_select').click(function()
	{
		$(this).next('.select_clone').toggle();	
		
		return false;	
	});
	
	$(document).click(function()
	{
		$('.select_clone').hide();
	});	
	
	if (trim($('.select_clone_inner').html()) == '<ul></ul>')
	{
		$('#js_photo_parent').remove();
		$('#js_category_holder').remove();
	}
}