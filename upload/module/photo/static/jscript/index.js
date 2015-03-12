
$Behavior.showSpecialInfo = function()
{
    $('.photo_hover_info').hide();
    
    $('.photo_row')
    .hover(function()
	{
	    if ($(this).hasClass('photo_hover_info_shown'))
	    {
		return;
	    }	    

	    $(this).addClass('photo_hover_info_shown');		
	    $(this).find('.photo_hover_info').show().css('z-index', '199');
	}
	, function()
	{
	    $(this).find('.photo_hover_info').hide().css('z-index', '1');
	    $(this).removeClass('photo_hover_info_shown');
	});
	
    if (!isset($Core.Photo)) $Core.Photo = {};
    
    /*	item_id = photo_id
     *	counter_holder = the counter container, this is where ajax must update with the correct number
     *	action = the ajax function
     *	toggle = the css class that we need to toggle 
     **/
    $Core.Photo.inlineAction = function(item_id, counter_holder, action, toggle)
    {
		$('.' + toggle).toggle();
		$.ajaxCall('like.' + action, 'item_type_id=photo&module_name=photo&type_id=photo&item_id=' + item_id + '&counterholder=' + counter_holder + '&action_type_id=2');
    };
    
    $Core.Photo.albumInlineAction = function(item_id, counter_holder, action, toggle)
    {console.log(counter_holder);
		$('.' + toggle).toggle();
		$.ajaxCall('like.' + action, 'item_type_id=photo&module_name=photo&type_id=photo_album&item_id=' + item_id + '&counterholder=' + counter_holder + '&action_type_id=2');
    };
    
};

