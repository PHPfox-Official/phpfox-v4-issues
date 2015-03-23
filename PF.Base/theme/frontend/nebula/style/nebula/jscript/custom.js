
$Behavior.customNebula = function(){
	
	$('#nb_features_link').click(function(){
		
		if ($(this).hasClass('nb_is_clicked')){
			$(this).removeClass('nb_is_clicked');
			$('#nb_features_holder').slideUp('fast');
		}else{
			$(this).addClass('nb_is_clicked');
			$('#nb_features_holder').slideDown('fast');
		}
		
		return false;
	});
	
	$('.js_view_more_features').click(function(){
		
		if ($(this).attr('rel') == 'more'){
			$('#nb_main_menu ul li').each(function(){
				if ($(this).is(':hidden') && !$(this).hasClass('is_force_hidden')){
					$(this).show().addClass('was_hidden');
				}
			});
			$(this).hide();
			$('.js_view_less').show();
		}else{
			$('#nb_main_menu ul li.was_hidden').hide();
			$(this).hide();
			$('.js_view_more').show();			
		}
		
		
		return false;
	});	
	
	$('.nb_edit_block_title').click(function(){
		
		$('#nb_main_menu ul li').each(function(){
			if ($(this).is(':hidden') && !$(this).hasClass('is_force_hidden')){
				$(this).show().addClass('was_hidden');							
			}
			
			if ($(this).hasClass('is_force_hidden')){
				$(this).find('a:first').append('<span class="nb_menu_add">Add</span>');
			}else{
				$(this).find('a:first').append('<span class="nb_menu_remove">Delete</span>');	
			}
			
			$(this).addClass('is_edit_mode');
			
		});		
		
		$('.js_done_edit_mode').show();
		$('.js_view_more_features').hide();
		if ($('.is_force_hidden').length > 0)
		{
			$('.js_add_more_menus').show();
		}
		$('.js_add_more_menus').click(function(){
			$('.is_force_hidden').show();
			return false;
		});
		
		$('.is_edit_mode a').click(function(){			
			return false;
		});
		
		$('.nb_menu_remove').click(function(){
			
			$.ajaxCall('theme.deleteMenu', 'id=' + $(this).parents('li:first').attr('rel').replace('menu', ''), 'GET');
			$(this).parents('li:first').remove();
			
			return false;
		});	

		$('.nb_menu_add').click(function(){
			
			$.ajaxCall('theme.deleteMenu', 'add=true&id=' + $(this).parents('li:first').attr('rel').replace('menu', ''), 'GET');
			$(this).parents('li:first').removeClass('is_force_hidden');
			
			return false;
		});			
		
		return false;
	});
	
	$('.js_done_edit_mode').click(function(){

		$(this).hide();
		$('.js_done_edit_mode').hide();
		$('.js_view_more_features').hide();
		$('.js_add_more_menus').hide();		
		$('.js_view_more').show();
		$('#nb_main_menu ul li.was_hidden').hide();
		$('#nb_main_menu ul li.is_force_hidden').hide();
		$('.nb_menu_remove').remove();
		$('.nb_menu_add').remove();
		$('.is_edit_mode a').click(function(){
			window.location.href = $(this).attr('href');
			return true;
		});		
		$('#nb_main_menu li').removeClass('is_edit_mode');
		
		return false;
	});
	
	$('.js_comment_feed_textarea').focus(function(){
		$(this).parents('.comment_mini:first').find('.button_set_off:first').removeClass('button_set_off');
	});
	
	fixHeightForFooter();
	/* Ads still broke the layout for me*/
	setTimeout(fixHeightForFooter, 1000);
};

function fixHeightForFooter()
{
	$('#main_content_padding').ready(function(){
        $('#main_content_padding').css('min-height', $('#left').height());
	});
}