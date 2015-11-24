
var $aMailOldHistory = {};
var $aNotificationOldHistory = {};
var $bNoCloseNotify = false;
var bCloseShareHolder = true;
var bCloseChangeCover = true;
var bCloseViewMoreFeed = true;

$Behavior.globalThemeInit = function()
{
	p($(window).width());

	/**
	* ###############################
	* Global functions
	* ###############################
	*/		
	$('#holder_notify ul li').click(function()
	{
		$bNoCloseNotify = true;			
	});	
	
	$('.feed_share_on_item a').click(function()
	{
		bCloseShareHolder = false;		
	});
	
	$('#js_change_cover_photo').click(function(){
		bCloseChangeCover = false;
	});
	
	// body clicks
	$((getParam('bJsIsMobile') ? '#content' : 'body')).click(function()
	{
		$('.action_drop_holder').hide();
		$('.header_bar_drop').removeClass('is_clicked');
		$('.header_bar_float').removeClass('active');
		/*
		if (bCloseShareHolder){
			$('.feed_share_on_holder').hide();
		}		
		*/
		$('.item_bar_action').parent().find('ul:first').hide();
		$('.item_bar_action').removeClass('item_bar_action_clicked');
		$('.row_edit_bar_holder').hide();
		$('.row_edit_bar_action').removeClass('row_edit_bar_action_clicked');
		
		$('#header_menu_holder ul li ul').removeClass('active');
		$('#header_menu_holder ul li a').removeClass('active');		
		
		if (!$bNoCloseNotify)
		{
			$('#holder_notify ul li').removeClass('is_active');
			$('#holder_notify ul li').find('.holder_notify_drop').hide();		
		}
		
		$bNoCloseNotify = false;
		bCloseShareHolder = true;
		
		$('#section_menu_drop').hide();
		
		$('.welcome_info_holder').hide();
		$('.welcome_quick_link ul li a').removeClass('is_active');
		
		$('.moderation_drop').removeClass('is_clicked');
		$('.moderation_holder ul').hide();
		
		$('#header_sub_menu_search_input').parent().find('.js_temp_friend_search_form:first').hide();		
		
		$('.feed_sort_holder').hide();
		
		if (bCloseChangeCover){
			$('#cover_section_menu_drop').hide();
		}
		
		if (bCloseViewMoreFeed){
			$('.view_more_drop').hide();
		}
		
		bCloseChangeCover = true;
		bCloseViewMoreFeed = true;
	});		
	
	$('.feed_sort_order_link').click(function(){
		
		$('.feed_sort_holder').toggle();
		
		return false;
	});
	
	$('.feed_sort_holder ul li a').click(function(){
		
		$('.feed_sort_holder ul li a').removeClass('active');
		$('.feed_sort_holder ul li a').removeClass('process');
		$(this).addClass('active');
		$(this).addClass('process');		
		$.ajaxCall('user.updateFeedSort', 'order=' + $(this).attr('rel'));
		
		return false;
	});
	
	$('.activity_feed_share_this_one_link').click(function(){
		
		var sRel = $(this).attr('rel');
		
		if ($(this).hasClass('is_active')){
			$('.' + sRel).hide();
			$(this).removeClass('is_active');			
		}
		else
		{
			$('.timeline_date_holder').hide();
			$('.activity_feed_share_this_one_link').removeClass('is_active');
			$('.' + sRel).show();
			$(this).addClass('is_active');						
		}		
		
		if (sRel == 'timeline_date_holder_share'){
			$.ajaxCall('feed.loadDropDates', '', 'GET');
		}
		
		return false;
	});
	
	$('#header_menu_holder li a.has_drop_down').click(function()
	{		
		$('#holder_notify ul li').removeClass('is_active');
		$('#holder_notify ul li').find('.holder_notify_drop').hide();		
		
		if ($(this).hasClass('active'))
		{
			$(this).parent().find('ul').removeClass('active'); 
			$(this).removeClass('active');			
		}
		else
		{
			$('#header_menu_holder').find('ul').removeClass('active'); 
			$('#header_menu_holder').find('ul li a').removeClass('active');
			
			$(this).parent().find('ul').addClass('active'); 
			$(this).addClass('active'); 
		}
		
		return false;
	});
	
	$('#header_menu_holder ul li ul li a').click(function()
	{
		$('#header_menu_holder ul li ul').removeClass('active');
		$('#header_menu_holder ul li a').removeClass('active');	
	});

    if (oCore['core.site_wide_ajax_browsing'])
    {
        $('.holder_notify_drop_link').click(function()
        {
            $(this).parents('.holder_notify_drop:first').hide();
            $(this).parents('.is_active:first').removeClass('is_active');

            return true;
        });
    }

	$('#holder_notify > ul > li > a').click(function()
	{
		if($(this).attr('rel') == undefined)
		{
			return false;
		}
		
		var $oParent = $(this).parent();
		var $oChild = $oParent.find('.holder_notify_drop');
		
		$('#header_menu_holder ul li ul').removeClass('active');
		$('#header_menu_holder ul li a').removeClass('active');		
		
		if ($oParent.hasClass('is_active'))
		{
			$oParent.removeClass('is_active');
			$oChild.hide();
		}
		else
		{
			$('#holder_notify ul li').removeClass('is_active');
			$('#holder_notify ul li').find('.holder_notify_drop').hide();
			
			$oParent.addClass('is_active');
			$oChild.show();
			if ($(this).attr('rel') == '_show') {
				return false;
			}
			/*
			if ($oChild.find('.holder_notify_drop_data').find('.holder_notify_drop_loader').length > 0)
			{
			*/
				$Core.ajax($(this).attr('rel'), 
				{
					params: 
					{					
						'no_page_update': true	
					},
					success: function($sData)			
					{
						$oChild.find('.holder_notify_drop_data').html($sData);
                        if (oCore['core.site_wide_ajax_browsing'])
                        {
                            $Core.loadInit();
                        }
					}
				});
			/*
			}
			else
			{
				if ($(this).attr('rel') == 'mail.getLatest')
				{
					if (isset($aMailOldHistory))
					{
						for ($iKey in $aMailOldHistory)
						{
							$('#js_mail_read_' + $iKey).find('a:first').removeClass('is_new');
						}
					}
				}
				else if ($(this).attr('rel') == 'notification.getAll')
				{
					if (isset($aNotificationOldHistory))
					{
						for ($iKey in $aNotificationOldHistory)
						{
							$('#js_notification_read_' + $iKey).find('a:first').removeClass('is_new');
						}
					}					
				}
			}
			*/
		}
		
		return false;
	});

	$('#section_menu_more').click(function()
	{
		$('#section_menu_drop').toggle();
		
		return false;
	});	
	
	/**
	* ###############################
	* Global site search
	* ###############################
	*/		
   // $('#header_sub_menu_search_input').before('<div id="header_sub_menu_search_input_value" style="display:none;">' + $('#header_sub_menu_search_input').val() + '</div>');

	$('#header_sub_menu_search_input, #header_sub_menu_search_input_xs').focus(function() {

		$(this).parents('form:first').addClass('active');
		$(this).parent().find('#header_sub_menu_search_input').addClass('focus');
		// if ($(this).val() == $('#header_sub_menu_search_input_value').html()){
			$(this).val('');
			// if ((isset(oModules['friend']) ))
		// {
				$Core.searchFriendsInput.init({
					'id': 'header_sub_menu_search',
					'max_search': (getParam('bJsIsMobile') ? 5 : 10),
					'no_build': true,
					'global_search': true,
					'allow_custom': true,
					'panel_mode': true
				});
				$Core.searchFriendsInput.buildFriends(this);
			// }
		// }
	});	
	
	$('#header_sub_menu_search_input').blur(function(){
		$(this).parents('form:first').removeClass('active');
		$(this).parent().find('#header_sub_menu_search_input').removeClass('focus');
	});		
	if ((isset(oModules['friend']) ))
	{
		$('#header_sub_menu_search_input').keyup(function(){
			$Core.searchFriendsInput.getFriends(this);
		});
    $('#header_sub_menu_search_input_xs').keyup(function(){
			$Core.searchFriendsInput.getFriends(this);
		});
	}	
	/**
	* ###############################
	* Global section search tool
	* ###############################
	*/
	var v = window.location;
	if ($('.header_bar_menu').length && typeof(v.search) == 'string' && v.search.substring(0, 4) == '?s=1') {
		$('.header_bar_menu:first').addClass('focus');
	}
	$('.header_bar_search .txt_input').focus(function()
	{
		$(this).parents('.header_bar_menu:first').addClass('focus');
		$(this).addClass('input_focus');
		
		if ($('.header_bar_search_default').html() == $(this).val())
		{
			$(this).val('');			
		}
	}).blur(function()
	{
		// $(this).parent().find('.header_bar_search_input').removeClass('focus');
		if (empty($(this).val()))
		{
			$(this).val($('.header_bar_search_default').html());
			$(this).removeClass('input_focus');
		}
	});	
	
	$('.header_bar_drop').click(function()
	{
		$('.header_bar_float.active').removeClass('active');
		$('.header_bar_drop').each(function()
		{
			if (!$(this).hasClass('is_clicked'))
			{
				$(this).parents('.header_bar_drop_holder').find('.action_drop_holder').hide();				
			}
		});
		
		if ($(this).hasClass('is_clicked'))
		{
			$(this).parents('.header_bar_drop_holder').find('.action_drop_holder').hide();	
			$(this).removeClass('is_clicked');
		}
		else
		{
			$(this).parents('.header_bar_float:first').addClass('active');
			$(this).parents('.header_bar_drop_holder').find('.action_drop_holder').show();
			$('.header_bar_drop').removeClass('is_clicked');
			$(this).addClass('is_clicked');
		}
		
		return false;	
	});		
	
	$('.item_bar_action').click(function()
	{
		$(this).parent().find('ul:first').addClass('dropdown-menu').toggle();
		$(this).blur();
		if ($(this).hasClass('item_bar_action_clicked'))
		{
			$(this).removeClass('item_bar_action_clicked');
		}
		else
		{
			$(this).addClass('item_bar_action_clicked');
		}		
		
		return false;
	});
	
	$('.row_edit_bar_action').click(function()
	{
		var _parent  = $(this).parents('.row_edit_bar_parent:first');
			$('.row_edit_bar_holder:first', _parent).addClass('open').toggle();
			$('.row_edit_bar_holder:first ul', _parent).addClass('dropdown-menu dropdown-menu-right');

		$(this).blur();

		if ($(this).hasClass('row_edit_bar_action_clicked'))
		{
			$(this).removeClass('row_edit_bar_action_clicked');
		}
		else
		{
			$(this).addClass('row_edit_bar_action_clicked');
		}
		
		return false;
	});	
	
	$('#js_comment_form_holder #text').keydown(function(){$Core.resizeTextarea($(this));});
	$('#js_compose_new_message #message').keydown(function(){$Core.resizeTextarea($(this));});
	
	$('.welcome_quick_link ul li a').click(function(e)
	{
		if ($(this).hasClass('is_active'))
		{
			$(this).parent().find('.welcome_info_holder:first').hide();
			$(this).removeClass('is_active');			
			
			return false;
		}

		if (oCore['core.site_wide_ajax_browsing'] == false)
		{
			if (this.href.indexOf('#') < 0)
			{
				window.location = this.href;
				return false;
			}
			else
			{				
			}
		}
		else
		{
			if (this.href.indexOf('#') > (-1))
			{
			}
			else
			{
				return false;
			}
		}
		var aParts = explode('#', this.href);
		var sTempCacheId = aParts[1].replace('.', '_');
		
		$('.welcome_info_holder').hide();
		$('.welcome_quick_link ul li a').removeClass('is_active');
				
		$(this).addClass('is_active');
		/*
		if ($(this).hasClass('is_cached'))
		{
			$(this).parent().find('.welcome_info_holder:first').show();
			
			return false;
		}
		*/
		$(this).addClass('is_cached');
		
		var sRel = $(this).attr('rel');
		sCustomClass= '';
		if (!empty(sRel)){
			sCustomClass = ' welcome_info_holder_custom';
		}
		
		$(this).parent().append('<div class="welcome_info_holder' + sCustomClass + '"><div class="welcome_info" id="' + sTempCacheId + '"></div></div>');
		
		$.ajaxCall(aParts[1], 'temp_id=' + sTempCacheId, 'GET');
		
		return false;
	});
	
	$('.profile_image').mouseover(function()
	{
		$(this).find('.p_4:first').show();
	});
	
	$('.profile_image').mouseout(function()
	{
		$(this).find('.p_4:first').hide();
	});		
};

$Behavior.repositionCoverPhoto = function(){
	function repositionCoverPhoto(sModule, iId){
		$('.pages_header_cover img').draggable({
			axis: 'y',
			stop: function(evt,ui){
				$.ajaxCall('pages.repositionCoverPhoto', 'page_id='+iId + '&position=' + ui.position.top);
			}
		});
	}

	window.repositionCoverPhoto  = repositionCoverPhoto;
}