
$Core.categorySort = 
{
	update: function()
	{
		var iCnt = 0;		
		$('.sortable .js_sortable_category').each(function()
		{
			iCnt++;			
			$(this).parents('li:first').find('input').val(iCnt);			
		});
	}
}

$Behavior.photo_sort_init = function()
{
	$('#js_all_photo_category').remove();	
	
	$('.sortable ul').sortable({
			axis: 'y',
			update: function(element, ui)
			{
				$Core.categorySort.update();
			},
			opacity: 0.4
		}
	);	
		
	var iCnt = 0;
	$('.sortable .js_photo_category').each(function()
	{
		iCnt++;
			
		$(this).removeClass('js_photo_category');
		$(this).addClass('js_sortable_category');
		$(this).parents('li:first').prepend('<input type="hidden" name="order[' + $(this).parents('li:first').find('span').get(0).id.replace('js_sortable_category_', '') + ']" value="' + iCnt + '" />');		
	});	

	$('.js_sortable_category').click(function()
	{
		$('#js_category_holder').hide();
		
		$.ajaxCall('photo.getCategoryForEdit', 'id=' + $(this).parents('li:first').find('span').get(0).id.replace('js_sortable_category_', ''));
		
		return false;
	});
};