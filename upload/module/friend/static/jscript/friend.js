$Core.friend = {};
$Core.friend.addNewList = function(iListId, sName){	
	$('.friend_action_drop_down').each(function(){			
		var iFriendId = parseInt($(this).parents('.friend_row_holder:first').find('.js_friend_actual_user_id').val());
		$(this).append('<li><a href="#" rel="' + iListId + '|' + iFriendId + '"><span></span>' + sName + '</a></li>');
		$('.js_friend_action_edit_list').show();				
	});	
	$Core.loadInit();
}

$Core.friend.updateListTitle = function(sName){
	$('h1 a').html(sName);
	$('.sub_section_menu ul li.active a').html(sName);
	$('h1').css({
		'text-indent': '0px'			
	});	
	$('.friend_list_form').hide();
	$('.friend_list_edit_ajax').hide();
}

$Behavior.manageFriends = function(){
	
	$('body').click(function(){
		$('.friend_action_drop_down').each(function(){
			if ($(this).hasClass('is_active')){
				$(this).hide();
				$(this).removeClass('is_active');
				$(this).parent().find('.friend_action_edit_list').removeClass('friend_action_edit_list_active');
				$(this).parents('.friend_action_edit_list_holder:first').hide();
			}
		});
	});
	
	$('.friend_list_change_order').click(function(){
		if ($('.js_friend_edit_order_submit').hasClass('is_active')){
			$('.js_friend_edit_order').hide();
			$('.js_friend_edit_order_submit').removeClass('is_active');
			$('.friend_action_holder').show();			
		}
		else{
			$('.js_friend_edit_order').show();
			$('.js_friend_edit_order_submit').addClass('is_active');
			$('.friend_action_holder').hide();
			
			$('#js_friend_sort_holder').sortable({
				items: '.friend_row_holder',
				opacity: 0.4,
				cursor: 'move',
				helper: 'clone',
				handle: '.js_friend_sort_handler',
				axis: 'y'	
			});			
		}
		return false;
	});
	
	$('.friend_action_delete').click(function(){	
		if (confirm(oTranslations['core.are_you_sure'])){
			$.ajaxCall('friend.delete', 'id=' + $(this).attr('rel'));
		}		
		return false;
	});
	
	$('#js_friend_list_order_form').submit(function(){
		$Core.processForm(this);
		$(this).ajaxCall('friend.updateListOrder');		
		return false;
	});
	
	$('.friend_list_display_profile').click(function(){
		$.ajaxCall('friend.setProfileList', 'list_id=' + $(this).attr('rel') + '&type=add', 'GET');
		return false;
	});
	
	$('.friend_list_remove_profile').click(function(){
		$.ajaxCall('friend.setProfileList', 'list_id=' + $(this).attr('rel') + '&type=remove', 'GET');
		return false;
	});	
	
	$('.friend_list_edit_name').click(function(){
		$('h1').css({
			'text-indent': '-1000px',
			'overflow': 'hidden'
		});		
		$('.friend_list_form').show();
		$('.friend_list_form_input').select();
		
		return false;
	});
	
	$('.friend_list_form_input').blur(function(){
		if ($('.friend_list_form_input').val() != $('.friend_list_form_post_old').val()){
			$('.friend_list_edit_ajax').show();
			$('.friend_list_form_post').ajaxCall('friend.updateList');			
		}
		else{
			$('h1').css({
				'text-indent': '0px'			
			});	
			$('.friend_list_form').hide();			
		}
	});
	
	$('.friend_row_holder').mouseover(function(){
		var bShow = true;
		$('.friend_action_edit_list').each(function(){
			if ($(this).hasClass('friend_action_edit_list_active')){
				bShow = false;
				return false;
			}
		});
		
		if (bShow){
			$(this).find('.friend_action_edit_list_holder').show();
		}		
	});
	
	$('.friend_row_holder').mouseout(function(){		
		var bHide = true;
		$('.friend_action_edit_list').each(function(){
			if ($(this).hasClass('friend_action_edit_list_active')){
				bHide = false;
				return false;
			}
		});
		
		if (bHide) {
			$(this).find('.friend_action_edit_list_holder').hide();
		}
	});
	
	$('.js_core_menu_friend_add_list').click(function(){
		
		$Core.box('friend.addNewList', 400);
		
		return false;
	});
	
	$('.friend_action_edit_list').click(function(){
		var bShow = true;
		if ($(this).hasClass('friend_action_edit_list_active')) {
			bShow = false;
		}
		
		$('.friend_action_drop_down').hide();
		$('.friend_action_edit_list').removeClass('friend_action_edit_list_active');
		if (bShow) {
			$(this).parent().find('.friend_action_drop_down:first').show().addClass('is_active');
			$(this).addClass('friend_action_edit_list_active');	
		}
		
		return false;
	});
	
	$('.friend_action_drop_down li a').click(function(){
		
		var sRel = $(this).attr('rel');
		var sType = '';
		var aParts = explode('|', sRel);
		
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
			sType = 'remove';
		}
		else {
			$(this).addClass('active');
			sType = 'add';
		}
		
		$.ajaxCall('friend.manageList', 'list_id=' + aParts[0] + '&friend_id=' + aParts[1] + '&type=' + sType, 'GET');
		
		return false;
	});
}