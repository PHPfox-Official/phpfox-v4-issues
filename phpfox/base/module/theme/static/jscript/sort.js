
var oCacheImageBlocks = {};

function makeSortable( sSelector, sConnectWith )
{
	$(sSelector).sortable({		
			items: '.js_sortable',
			update: function(element, ui)
			{			
				if (function_exists('designOnUpdate'))
				{
					designOnUpdate();
				}
			},
			start: function(element, ui)
			{			
				$('.js_temp_place_holder').removeClass('js_temp_place_holder_hide').addClass('js_sort_holder_active');
				$(ui.item).attr('id', 'clone_' + $(ui.item).attr('id'));
			},
			opacity: 0.4,
			helper: 'clone',
			handle: '.js_sortable_header',
			placeholder: 'js_sort_holder',
			cursor: 'move',
			axis: (oCore['core.can_move_on_a_y_and_x_axis'] ? false : 'y'),
			connectWith: sConnectWith
		}
	);	
}

$Behavior.sortBlocks = function()
{	
	$('.js_sortable_header').each(function()
	{
		if (!$(this).parent().hasClass('js_sortable'))
		{
			return;
		}
		
		if ($(this).hasClass('is_already_loaded'))
		{
			return;
		}
		
		$(this).addClass('is_already_loaded');
		
		this.style.cursor = 'move';		
		
		var sCacheHtml = '';
		$(this).find('.js_edit_header_bar').each(function()
		{
			sCacheHtml += '<div class="js_edit_header_bar' + ($(this).hasClass('js_edit_header_hover') ? ' js_edit_header_hover' : '') + '"' + ($(this).hasClass('js_edit_header_hover') ? ' style="display:none;"' : '') + '>' + $(this).html() + '</div>';
			
			$(this).remove();
		});

		$(this).prepend(sCacheHtml + '<div class="js_edit_header_bar js_edit_header_hover" style="display:none;"></div>');				
	});
	
	$('.js_sortable_header').dblclick(function()
	{
		if (!$(this).parent().hasClass('js_sortable'))
		{
			return;
		}		
		
		$(this).parent().find('.content:first').toggle();
		$(this).parent().find('.bottom:first').toggle();
	});
	
	$('.js_sortable_header').mouseover(function()
	{
		$(this).find('.js_edit_header_hover').show();
	}).mouseout(function()
	{
		$(this).find('.js_edit_header_hover').hide();
	});	
	
	if (typeof oCore['profile.user_id'] != 'undefined' && oCore['profile.user_id'] > 0 && oCore['core.can_move_on_a_y_and_x_axis'] != true)
	{
		makeSortable('#left', '#left');
		makeSortable('#right', '#right');
		makeSortable('#content', '#content');
	}
	else
	{
		makeSortable('body', '');
	}
	
	$('.js_temp_place_holder').remove();
	$('.js_content_parent').each(function()
	{
		// $(this).prepend('<div style="width:' + $(this).width() + 'px;" class="js_temp_place_holder_hide js_temp_place_holder"><div class="js_sortable"><div class="title js_sortable_header">&nbsp;</div></div></div>');
	});	
}
