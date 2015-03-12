$Core.Pages = {
	setAsCover : function(iPageId, iPhotoId)
	{
		$.ajaxCall('pages.setCoverPhoto', 'page_id=' + iPageId + '&photo_id=' + iPhotoId);
	},
	
	removeCover : function(iPageId)
	{
		if (confirm('Are you sure?'))
		{
			$.ajaxCall('pages.removeCoverPhoto', 'page_id=' + iPageId);
		}
	}
};
$Behavior.pagesBuilder = function(){
	var sHash = 'js_pages_block_' + window.location.hash.replace('#','');
	if (sHash.length > 0)
	{
	    $('.page_section_menu_header a').each(function()
	    {	    
		if ($(this).attr('rel') == sHash)
		{
		    var oObj = $(this);
		    setTimeout(function(){
			$('.active').removeClass('active');
			$(oObj).parent().addClass('active');
			$('.js_pages_block').hide();
			$('#' + sHash).show();
		    }, 600);
		}
	    });
	}
	
	
	// Creating/Editing pages
	if ($Core.exists('#js_pages_add_holder')){
		
		$('.pages_type_add_inner_link').click(function(){
			
			$('.pages_type_add_form').hide();
			$('.pages_type_add_inner_link').show();
			
			$(this).hide();
			$(this).parent().find('.pages_type_add_form').show();
			$(this).parent().find('.pages_type_add_input:first').focus();
			
			return false;
		});
		
		$('.pages_type_add_input').focus(function(){
			if (!$(this).hasClass('is_in_focus')){
				$(this).addClass('is_in_focus');
				$(this).val('');
			}
		})
		
		$('.pages_type_add_form_holder form').submit(function(){
			$Core.processForm('#js_pages_add_submit_button');
			$(this).ajaxCall('pages.add');
			return false;
		});
		
		$('.pages_add_category select').change(function(){
			$(this).parent().parent().find('.js_pages_add_sub_category').hide();
			$(this).parent().parent().find('#js_pages_add_sub_category_' + $(this).val()).show();			
			$('#js_category_pages_add_holder').val($(this).parent().parent().find('#js_pages_add_sub_category_' + $(this).val() + ' option:first').val());
		});
		
		$('.js_pages_add_sub_category select').change(function(){
			$('#js_category_pages_add_holder').val($(this).val());
		});
		
		$('#js_pages_add_change_photo').click(function(){
			$('#js_event_current_image').hide();
			$('#js_event_upload_image').show();
			$('#js_submit_upload_image').show();
			return false;
		});
	}
};

$Behavior.contentHeight = function()
{
	$('#content').height($('.main_timeline').height());
}

$Behavior.fixSizeTinymce = function()
{
	//The magic code to add show/hide custom event triggers
	(function ($) 
	{
		$.each(['show', 'hide'], function (i, ev)
		{
			var el = $.fn[ev];
			$.fn[ev] = function ()
			{
				this.trigger(ev);
				return el.apply(this, arguments);
			};
		});
	})(jQuery);
	
	$('#js_pages_block_info').on('show', function()
	{
		$('.mceIframeContainer.mceFirst.mceLast iframe').height('275px');
	});
};
