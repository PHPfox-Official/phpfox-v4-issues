
$Behavior.imageCategoryListing = function()
{
	$('.js_mp_category_list').change(function()
	{
		var iParentId = parseInt(this.id.replace('js_mp_id_', ''));
		
		$('.js_mp_category_list').each(function()
		{
			if (parseInt(this.id.replace('js_mp_id_', '')) > iParentId)
			{
				$('#js_mp_holder_' + this.id.replace('js_mp_id_', '')).hide();				
				
				this.value = '';
			}
		});
		
		$('#js_mp_holder_' + $(this).val()).show();
	});
	
	$('.hover_action').each(function()
	{
		$(this).parents('.js_outer_video_div:first').css('width', this.width + 'px');
	});	
	
	$('.full_name a, .js_allow_video_click a').click(function(){
		window.location.href = $(this).attr('href');	
		return false;
	});
	
	$('.video_info_box').click(function()
	{	
		if (!$('.video_info_box').hasClass('video_info_box_is_clicked'))
		{
			$Core.processVideoInfo($('.video_info_toggle'));
		}
		
		/* return false;*/
	});
	
	$('.video_info_toggle').click(function()
	{		
		$Core.processVideoInfo(this);		
	
		return false;
	});			
	
	$('#js_block_border_video_related').find('#js_block_bottom_link_1').click(function(){
		
		$(this).parent().find('.ajax_image').show();
		$('#js_video_related_page_form').ajaxCall('video.getMoreRelated', '', false, 'GET');
		
		return false;
	});	
	
	$('.js_edit_video_form').keydown(function(){$Core.resizeTextarea($(this));});	
}

$Core.processVideoInfo = function($oObj)
{	
	if (!$($oObj).hasClass('is_already_clicked'))
	{	
		$($oObj).addClass('is_already_clicked');
		$('.video_info_box').addClass('video_info_box_is_clicked');
		$('.video_info_box_extra').show();
		$('.js_view_more_part').hide();
		$('.js_view_more_full').show();	
		$('.js_info_toggle_show_less').show();
		$('.js_info_toggle_show_more').hide();
	}
	else
	{
		$('.video_info_box').removeClass('video_info_box_is_clicked');
		$($oObj).removeClass('is_already_clicked');
		$('.video_info_box_extra').hide();
		$('.js_view_more_part').show();
		$('.js_view_more_full').hide();	
		$('.js_info_toggle_show_less').hide();
		$('.js_info_toggle_show_more').show();	
	}	
}

var $iTotalUserVideos = 0;
$Behavior.videoUserBrowser = function()
{
	var iUserVideoIteration = 1;	
	var iUserVideoPerView = 0;

	$('.video_user_bar_pager_menu ul li a').click(function() {

		iUserVideoPerView = ($iTotalUserVideos / 4);
		var iCurrentPageRel = $(this).attr('rel');
		
		$('.video_user_bar_pager_menu ul li a').removeClass('active');
		$(this).addClass('active');		
		
		var iNewLocation = ((iCurrentPageRel - 1) * (158 * 4));
		
		$('.video_user_more_holder').css({left: '-' + iNewLocation + 'px'});

		iUserVideoIteration = iCurrentPageRel;

		return false;
	});
	
	$('.video_user_bar_click').click(function() {
		
		var $sType = ($(this).attr('rel') == 'previous' ? '+' : '-');

		iUserVideoPerView = Math.ceil($iTotalUserVideos / 4);
		
		if ($(this).attr('rel') == 'previous' && iUserVideoIteration == 1)
		{		
			return false;
		}		
		
		if ($(this).attr('rel') == 'previous')
		{
			iUserVideoIteration--;
		}
		else
		{
			if (iUserVideoIteration >= iUserVideoPerView)
			{
				return false;
			}
		
			iUserVideoIteration++;		
		}

		$('.video_user_bar_pager_menu ul li a').removeClass('active');
		$('.video_user_bar_pager_menu ul li a[rel="' + iUserVideoIteration + '"]').addClass('active');
		
		$('.video_user_more_holder').animate({left: $sType + '=' + ($('.video_user_more_holder').width() + 2) + 'px'}, 'slow');

		return false;
	});	
	
	$('.video_user_link').click(function(){
		$('.video_user_bar').toggle();
		if ($('.video_user_bar_loader').length > 0)
		{
			$.ajaxCall('video.getUserVideos', 'user_id=' + $(this).attr('rel'), 'GET');
		}
		return false;
	});
	
	$('.video_view_embed').click(function(){
		$('.video_view_embed_holder').toggle();
		$('.video_view_embed_holder').find('input').select();
		return false;
	});
}