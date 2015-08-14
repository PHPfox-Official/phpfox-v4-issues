var $sFormAjaxRequest = null;
var $bButtonSubmitActive = true;
var $ActivityFeedCompleted = {};
var $sCurrentSectionDefaultPhrase = null;
var $sCssHeight = '40px';	
var $sCustomPhrase = null;
var $sCurrentForm = null;
var $sStatusUpdateValue = null;
var $iReloadIteration = 0;
var $oLastFormSubmit = null;
var bCheckUrlCheck = false;
var bCheckUrlForceAdd = false;

$Core.Like = {};
$Core.Like.Actions = {
	doLike : function(bIsCustom, sItemTypeId, iItemId, iParentId, oObj) {
		if ($(oObj).closest('.comment_mini_link_like').find('.like_action_unmarked').is(':visible'))
		{
			$('#dislike_remove_' + iItemId).hide();
			$(oObj).closest('.comment_mini_link_like').find('.like_action_marked').show();
			$(oObj).closest('.comment_mini_link_like').find('.like_action_unmarked').hide();
		}
		$(oObj).parent().find('.js_like_link_unlike:first').show();
		$(oObj).hide();
		$.ajaxCall('like.add', 'type_id=' + sItemTypeId + '&item_id=' + iItemId + '&parent_id=' +iParentId + '&custom_inline=' + bIsCustom, 'GET');
	}
};

$Core.isInView = function(elem, item)
{
    if (!$Core.exists(elem)){
		return false;
	}
	
	var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();

    var elemTop = $(elem).offset().top;
    var elemBottom = (elemTop + $(elem).height());
	if (item) {
		elemBottom = (elemBottom - parseInt(item));
	}

	return ((docViewTop < elemTop) && (docViewBottom > elemBottom));
}
	
$Core.resetActivityFeedForm = function()
{
	$('._load_is_feed').removeClass('active');
	$('#panel').hide();
	$('body').removeClass('panel_is_active');

	$('.activity_feed_form_attach li a').removeClass('active');
	$('.activity_feed_form_attach li a:first').addClass('active');	
	$('.global_attachment_holder_section').hide();
	$('#global_attachment_status').show();		
	$('.global_attachment_holder_section textarea').val('').css({height: $sCssHeight});
		
	$('.activity_feed_form_button_status_info').hide();
	$('.activity_feed_form_button_status_info textarea').val('');	
	
	$Core.resetActivityFeedErrorMessage();

	$sFormAjaxRequest = $('.activity_feed_form_attach li a.active').find('.activity_feed_link_form_ajax').html();
		
	$Core.activityFeedProcess(false);
	
	$('.js_share_connection').val('0');
	$('.feed_share_on_item a').removeClass('active');
		
	$.each($ActivityFeedCompleted, function()
	{
		this(this);
	});
	
	$('#js_add_location, #js_location_input, #js_location_feedback').hide();
	$('.activity_feed_form_button_position').show();
	$('#hdn_location_name, #val_location_name ,#val_location_latlng').val('');
	$('#btn_display_check_in').removeClass('is_active');
}

$Core.resetActivityFeedErrorMessage = function()
{
	$('#activity_feed_upload_error').hide();
	$('#activity_feed_upload_error_message').html('');	
}

$Core.resetActivityFeedError = function(sMsg)
{
	$('.activity_feed_form_share_process').hide();
	$('.activity_feed_form_button .button').removeClass('button_not_active');
	$bButtonSubmitActive = true;
	$('#activity_feed_upload_error').show();
	$('#activity_feed_upload_error_message').html(sMsg);
}
	
$Core.activityFeedProcess = function($bShow)
{
	if ($bShow)
	{
		$bButtonSubmitActive = false;
		$('.activity_feed_form_share_process').show();
		$('.activity_feed_form_button .button').addClass('button_not_active');
	}
	else
	{
		$bButtonSubmitActive = true;
		$('.activity_feed_form_share_process').hide();
		$('.activity_feed_form_button .button').removeClass('button_not_active');
		$('.egift_wrapper').hide();			
	}
}

$Core.addNewPollOption = function(iMaxAnswers, sLimitReached)
{
	if(iMaxAnswers >= ($('#js_poll_feed_answer li').length + 1))
	{
		$('.js_poll_feed_answer').append('<li><input type="text" name="val[answer][][answer]" value="" size="30" class="js_feed_poll_answer v_middle" /></li>');
	}
	else
	{
		alert(oTranslations['poll.you_have_reached_your_limit']);
	}
	
	return false;
}

/*

$(function()
{

	$('body').click(function()
	{		
		$('.js_comment_feed_textarea').each(function()
		{
			if ($(this).hasClass('is_focus'))
			{
				$(this).removeClass('is_focus');
			}
			else
			{			
				if (empty($(this).val()))
				{
					$(this).removeClass('js_comment_feed_textarea_focus');
					$(this).val($('.js_comment_feed_value').html());
					if (!$(this).parents('.comment_mini:first').hasClass('feed_item_view'))
					{
						$(this).parents('.comment_mini:first').find('.comment_mini_textarea_holder').removeClass('comment_mini_content');
						$(this).parents('.comment_mini:first').find('.comment_mini_image').hide();					
					}
				}			

				$(this).parents('.comment_mini').find('.feed_comment_buttons_wrap').hide();
			}
		});		
	});	
});

*/

$Core.forceLoadOnFeed = function()
{
	if ($iReloadIteration >= 2){
		return;
	}

    if (!$Core.exists('#js_feed_pass_info')){
        return;
    }
	
	$iReloadIteration++;
	$('#feed_view_more_loader').show();
	$('.global_view_more').hide();

	setTimeout("$.ajaxCall('feed.viewMore', $('#js_feed_pass_info').html().replace(/&amp;/g, '&') + '&iteration=" + $iReloadIteration + "', 'GET');", 1000);
}

var postingFeedUrl = false;
$Core.handlePasteInFeed = function(oObj)
{
	if (postingFeedUrl) {
		return;
	}

	if ((substr($(oObj).val(), 0, 7) == 'http://' || substr($(oObj).val(), 0, 8) == 'https://' || (substr($(oObj).val(), 0, 4) == 'www.')))
	{
		bCheckUrlCheck = true;
		postingFeedUrl = true;
		
		$('#activity_feed_submit').attr("disabled","disabled");

		$('.activity_feed_form_share_process').show();
		$(oObj).parent().append('<div id="js_preview_link_attachment_custom_form_sub" class="js_preview_link_attachment_custom_form" style="margin-top:5px;"></div>');
		$Core.ajax('link.preview',{		
			type: 'POST',
			params:{				
				'no_page_update': '1',
				value: $(oObj).val()
			},
			success: function($sOutput) {
				postingFeedUrl = false;
				$('.activity_feed_form_share_process').hide();
				if (substr($sOutput, 0, 1) == '{'){
					
					
				}
				else{
					$('#js_global_attach_value').val($(oObj).val());
					bCheckUrlForceAdd = true;	
					/* bCheckUrlCheck = false; */
					$('#js_preview_link_attachment_custom_form_sub').html($sOutput);
				}
			}
		});		
	}
}

/**
* Editor on comments
 */
$Core.loadCommentButton = function()
{
	$('.feed_comment_buttons_wrap div input.button_set_off').show().removeClass('button_set_off');
};

var __ = function(e) {
	$('.feed_stream[data-feed-url="' + e.url + '"]').replaceWith(e.content);
	$Core.loadInit();
};

$Core.resetFeedForm = function(f) {
	f.get()[0].reset();
	$('.feed_form_share').removeClass('.active');
	$('.feed_form_textarea textarea').removeClass('dont-unbind');
};

window.onerror = function(e) {
	var l = $('.feed_stream:not(.built)').length;
	if (l) {
		$('.feed_stream.built').each(function() {
			if ($(this).data('feed-url')) {
				$(this).replaceWith('<div class="error_message">' + e + '</div>');
				$Core.loadInit();
			}
		});
	}
};

$Behavior.activityFeedProcess = function() {

	$('.comment-limit:not(.is_checked)').each(function() {
		var t = $(this);
		t.addClass('is_checked');
		var total = t.find('.js_mini_feed_comment').length;
		var limit = t.data('limit');
		var iteration = total;
		var totalHidden = 0;
		t.find('.js_mini_feed_comment').each(function() {
			var l = $(this);
			iteration--;
			if (iteration < limit) {
				return false;
			}

			totalHidden++;
			l.hide();
		});

		if (totalHidden) {
			var cHolder = t.parent().find('.comment_pager_holder:first');
			cHolder.hide();
			var viewMore = $('<a href="#" class="load_more_comments dont-unbind">View Previous Comments</a>');
			cHolder.before(viewMore);
			viewMore.click(function() {
				t.find('.js_mini_feed_comment').show();
				$(this).remove();
				cHolder.show();
				return false;
			});
		}
	});

	$('.activity_feed_content_display:not(.is_built)').each(function() {
		var t = $(this);

		t.addClass('is_built');
		if (t.outerHeight() > 300) {
			t.css('position', 'relative');
			t.prepend('<a href="#" class="feed_show_more_content no_ajax" onclick="$(this).parent().css(\'max-height\', \'none\'); $(this).remove(); return false;">Show More</a>');
		}
	});

	/*
	$('.load_more_comments').click(function() {
		$.ajax({
			url: getParam('sJsAjax'),
			data: 'core[call]=comment.viewMoreFeed',
			success: function(e) {
				p(e);
			}
		});

		return false;
	});
	*/

	$('.feed_stream:not(.built)').each(function() {
		var t = $(this);

		t.addClass('built');

		var s = document.createElement('script');
		s.type = 'application/javascript';
		s.src = t.data('feed-url');
		document.head.appendChild(s);

		/*
		$.ajax({
			url: t.data('feed-url'),
			complete: function(e) {
				e = $.parseJSON(e.responseText);

				t.replaceWith(e.content);
				$Core.loadInit();
			}
		});
		*/


		return false;
	});

	$('.feed_options').click(function() {
		var t = $(this);

		t.next().toggleClass('active');

		return false;
	});

		if (!$Core.exists('#js_feed_content')){
			// $iReloadIteration = 0;
			// return;
		}	
		
		if ($Core.exists('.global_view_more')){
			if ($Core.isInView('.global_view_more')){
				$Core.forceLoadOnFeed();
			}

			$(window).scroll(function(){
				if ($Core.isInView('.global_view_more')){
					$Core.forceLoadOnFeed();
				}			
			});							
		}	
		
		$('.like_count_link').each(function(){
			var sHtml = $(this).parent().find('.like_count_link_holder:first').html();
			/*
			if (empty(sHtml)){
				 $(this).parents('.activity_like_holder:first').hide();
			}
			*/
		});
		
		$sFormAjaxRequest = $('.activity_feed_form_attach li a.active').find('.activity_feed_link_form_ajax').html();
		if (typeof Plugin_sFormAjaxRequest == 'function')
		{
			Plugin_sFormAjaxRequest();
		}
				
		if ($Core.exists('.profile_timeline_header')){
			$(window).scroll(function(){
				if (isScrolledIntoView('.profile_timeline_header')){
					$('.timeline_main_menu').removeClass('timeline_main_menu_fixed');
					$('#timeline_dates').removeClass('timeline_dates_fixed');
				}
				else{
					if (!$('.timeline_main_menu').hasClass('timeline_main_menu_fixed')){
						$('.timeline_main_menu').addClass('timeline_main_menu_fixed');

						if ($('#content').height() > 600){
							$('#timeline_dates').addClass('timeline_dates_fixed');
						}						
					}					
				}
			});				
		}				
				
		$('#global_attachment_status textarea').keyup(function(){
			$Core.handlePasteInFeed($(this));}).bind('paste', function()
			{
				var that = this;
				setTimeout(function(){					
					$Core.handlePasteInFeed(that);
				}, 0);
				
			});
		
		$('#global_attachment_status textarea').keydown(function(){
			$Core.resizeTextarea($(this));
		});
		
		$('.activity_feed_form_button_status_info textarea').keydown(function(){$Core.resizeTextarea($(this));});
		
		$('#global_attachment_status textarea').focus(function()
		{
			var t = $(this);
			if (t.hasClass('_is_set')) {
				return;
			}
			// if ($(this).val() == $('#global_attachment_status_value').html())
			{
				t.addClass('_is_set');
				// $(this).val('');
				$(this).css({height: '50px'});
				$('.activity_feed_form_button').show();
				$(this).addClass('focus');
				$('.activity_feed_form_button_status_info textarea').addClass('focus');
			}
		});
		
		$('.activity_feed_form_button_status_info textarea').focus(function()
		{				
			var $sDefaultValue = $(this).val();
			var $bIsDefault = true;			
			
			$('.activity_feed_extra_info').each(function()
			{
				if ($(this).html() == $sDefaultValue)
				{
					$bIsDefault = false;	
					
					return false;
				}
			});
			
			if (($('#global_attachment_status textarea').val() == $('#global_attachment_status_value').html() && empty($sDefaultValue)) || !$bIsDefault)
			{
				// $(this).val('');
				$(this).css({height: '50px'});
				
				$(this).addClass('focus');
				$('#global_attachment_status textarea').addClass('focus');				
			}
		});
		
		$('#js_activity_feed_form').submit(function()
		{		
			if ($sCurrentForm == 'global_attachment_status'){
				var oStatusUpdateTextareaFilled = $('#global_attachment_status textarea');
				
				if ($sStatusUpdateValue == oStatusUpdateTextareaFilled.val()){
					// oStatusUpdateTextareaFilled.val('');
				}
			}
			else{
				var oCustomTextareaFilled = $('.activity_feed_form_button_status_info textarea');
			
				if ($sCustomPhrase == oCustomTextareaFilled.val()){
					// oCustomTextareaFilled.val('');
				}				
			}			
			
			if ($bButtonSubmitActive === false)
			{
				return false;
			}
			
			$Core.activityFeedProcess(true);
			
			if ($sFormAjaxRequest === null)
			{
				return true;
			}
			
			$('.js_no_feed_to_show').remove();
			
			if (bCheckUrlForceAdd){				
				$('.activity_feed_form_button_status_info textarea').val($('#global_attachment_status textarea').val());
				$sFormAjaxRequest = 'link.addViaStatusUpdate';				
			}
			
			$(this).ajaxCall($sFormAjaxRequest);
			
			if (bCheckUrlForceAdd){
				$('#js_preview_link_attachment_custom_form_sub').remove();
			}
			
			return false;
		});


		$('.activity_feed_form_attach li a').click(function()
		{			
			$sCurrentForm = $(this).attr('rel');

			if ($sCurrentForm == 'view_more_link'){
				
				$('.view_more_drop').toggle();
				
				return false;
			}
			else{
				$('.view_more_drop').hide();
			}
			
			if ($sCurrentForm == 'global_attachment_status'){
				$('#btn_display_check_in').show();
			} else {
				$('#btn_display_check_in').hide();
				$('#hdn_location_name, #val_location_name ,#val_location_latlng').val('');
				$('#btn_display_check_in').removeClass('is_active');				
			}			

			$('#js_preview_link_attachment_custom_form_sub').remove();
			$('#activity_feed_upload_error').hide();
			
			$('.global_attachment_holder_section').hide();
			$('.activity_feed_form_attach li a').removeClass('active');
			$(this).addClass('active');
			
			if ($(this).find('.activity_feed_link_form').length > 0)
			{
				$('#js_activity_feed_form').attr('action', $(this).find('.activity_feed_link_form').html()).attr('target', 'js_activity_feed_iframe_loader');
				$sFormAjaxRequest = null;
				if (empty($('.activity_feed_form_iframe').html()))
				{
					$('.activity_feed_form_iframe').html('<iframe id="js_activity_feed_iframe_loader" name="js_activity_feed_iframe_loader" height="200" width="500" frameborder="1" style="display:none;"></iframe>');
				}				
			}
			else
			{
				$sFormAjaxRequest = $(this).find('.activity_feed_link_form_ajax').html();	
			}			
			
			$('#' + $(this).attr('rel')).show();
			$('.activity_feed_form_holder_attach').show();
			$('.activity_feed_form_button').show();			
			
			var $oStatusUpdateTextarea = $('#global_attachment_status textarea');
			var $sStatusUpdateTextarea = $oStatusUpdateTextarea.val();
			$sStatusUpdateValue = $('#global_attachment_status_value').html();
			
			var $oCustomTextarea = $('.activity_feed_form_button_status_info textarea');
			var $sCustomTextarea = $oCustomTextarea.val();
			
			$sCustomPhrase = $(this).find('.activity_feed_extra_info').html();
			
			var $bHasDefaultValue = false;
			$('.activity_feed_extra_info').each(function()
			{
				if ($(this).html() == $sCustomTextarea)
				{
					$bHasDefaultValue = true;	
						
					return false;
				}
			});				
			
			if ($(this).attr('rel') != 'global_attachment_status')
			{
				$('.activity_feed_form_button_status_info').show();				
				
				if ((empty($sCustomTextarea) && ($sStatusUpdateTextarea == $sStatusUpdateValue 
					|| empty($sStatusUpdateTextarea))) 
					|| ($sStatusUpdateTextarea == $sStatusUpdateValue && $bHasDefaultValue)
					|| (!$bButtonSubmitActive && $bHasDefaultValue)
				)
				{
					$oCustomTextarea.attr('placeholder', $sCustomPhrase).css({height: $sCssHeight});
				}
				else if ($sStatusUpdateTextarea != $sStatusUpdateValue && $bButtonSubmitActive && !empty($sStatusUpdateTextarea))
				{
					$oCustomTextarea.attr('placeholder', $sStatusUpdateTextarea);
				}								
				
				$('.activity_feed_form_button .button').addClass('button_not_active');
				$bButtonSubmitActive = false;				
			}
			else
			{
				$('.activity_feed_form_button_status_info').hide();
				$('.activity_feed_form_button .button').removeClass('button_not_active');
				
				if (!$bHasDefaultValue && !empty($sCustomTextarea))
				{
					$oStatusUpdateTextarea.val($sCustomTextarea);
				}
				else if ($bHasDefaultValue && empty($sStatusUpdateTextarea))
				{
					$oStatusUpdateTextarea.val($sStatusUpdateValue).css({height: $sCssHeight});
				}				
							
				$bButtonSubmitActive = true;
			}
			
			if ($(this).hasClass('no_text_input'))
			{
				$('.activity_feed_form_button_status_info').hide();
			}		
					
			$('.activity_feed_form_button .button').show();
			$('#js_piccup_upload').hide();
			
			return false;
		});		
	}

$Behavior.activityFeedLoader = function()
{
	if (empty($('.view_more_drop').html())){
		$('.timeline_view_more').parent().hide();
	}	
	
	/**
	 * Click on adding a new comment link.
	 */
	$('.js_feed_entry_add_comment').click(function()
	{			
		$('.js_comment_feed_textarea').each(function()
		{
			if ($(this).val() == $('.js_comment_feed_value').html())
			{
				$(this).removeClass('js_comment_feed_textarea_focus');
				$(this).val($('.js_comment_feed_value').html());
			}			

			$(this).parents('.comment_mini').find('.feed_comment_buttons_wrap').hide();
		});				
		
		$(this).parents('.js_parent_feed_entry:first').find('.comment_mini_content_holder').show();
		$(this).parents('.js_parent_feed_entry:first').find('.feed_comment_buttons_wrap').show();
			
		if ($(this).parents('.js_parent_feed_entry:first').find('.js_comment_feed_textarea').val() == $('.js_comment_feed_value').html())
		{
			$(this).parents('.js_parent_feed_entry:first').find('.js_comment_feed_textarea').val('');
		}		
		$(this).parents('.js_parent_feed_entry:first').find('.js_comment_feed_textarea').focus().addClass('js_comment_feed_textarea_focus');
		$(this).parents('.js_parent_feed_entry:first').find('.comment_mini_textarea_holder').addClass('comment_mini_content');
		$(this).parents('.js_parent_feed_entry:first').find('.js_feed_comment_form').find('.comment_mini_image').show();
			
		var iTotalComments = 0;
		$(this).parents('.js_parent_feed_entry:first').find('.js_mini_feed_comment').each(function()
		{
			iTotalComments++;
		});
			
		if (iTotalComments > 2)
		{
			$.scrollTo($(this).parents('.js_parent_feed_entry:first').find('.js_comment_feed_textarea_browse:first'), 340);
		}
			
		return false;
	});	
	
	/**
	 * Comment textarea on focus.
	 */
	$('.js_comment_feed_textarea').focus(function()
	{
		$Core.commentFeedTextareaClick(this);
	});		
	
	$('#js_captcha_load_for_check_submit').submit(function(){
		
		if (function_exists('' + Editor.sEditor + '_wysiwyg_feed_comment_form')) 
		{
			eval('' + Editor.sEditor + '_wysiwyg_feed_comment_form(this);');
		}	
		
		$oLastFormSubmit.parent().parent().find('.js_feed_comment_process_form:first').show(); 
		$(this).ajaxCall('comment.add', $oLastFormSubmit.getForm()); 		
		
		return false;
	});
	
	$('.js_comment_feed_form').submit(function()
	{
		var t = $(this);

		if (t.hasClass('in_process')) {
		//	p('is in process...');
		//	return false;
		}
		t.addClass('in_process');

		if ($Core.exists('#js_captcha_load_for_check')){
			$('#js_captcha_load_for_check').css({
				top: getPageScroll()[1] + (getPageHeight() / 5),
				left: '50%',
				'margin-left': '-' + (($('#js_captcha_load_for_check').width() / 2) + 12) + 'px',
				display: 'block'
			});		

			$oLastFormSubmit = $(this);

			return false;			
		}
		
		if (function_exists('' + Editor.sEditor + '_wysiwyg_feed_comment_form')) 
		{
			eval('' + Editor.sEditor + '_wysiwyg_feed_comment_form(this);');
		}		
		
		$(this).parent().parent().find('.js_feed_comment_process_form:first').show(); 
		$(this).ajaxCall('comment.add', null, null, null, function(e, self) {
			$(self).find('textarea').blur();
			isAddingComment = false;
		});

		$(this).find('.error_message').remove();
		$(this).find('textarea:first').removeClass('dont-unbind');
			
		return false;		
	});
	
	$('.js_comment_feed_new_reply').click(function(){
		
		var oParent = $(this).parents('.js_mini_feed_comment:first').find('.js_comment_form_holder:first');
		if ((Editor.sEditor == 'tiny_mce' || Editor.sEditor == 'tinymce') && isset(tinyMCE) && isset(tinyMCE.activeEditor)){
			$('.js_comment_feed_form').find('.js_feed_comment_parent_id:first').val($(this).attr('rel'));
			tinyMCE.activeEditor.focus();			
			if (typeof($.scrollTo) == 'function'){
				$.scrollTo('.js_comment_feed_form', 800);
			}			
			return false;
		}				
		
		var sCommentForm = $(this).parents('.js_feed_comment_border:first').find('.js_feed_comment_form:first').html();
		oParent.html(sCommentForm);
		oParent.find('.js_feed_comment_parent_id:first').val($(this).attr('rel'));

		oParent.find('.js_comment_feed_textarea:first').focus();
		$Core.commentFeedTextareaClick(oParent.find('.js_comment_feed_textarea:first'));
		
		$('.js_feed_add_comment_button .error_message').remove();
		
		oParent.find('.button_set_off:first').show().removeClass('button_set_off');
		
		$Core.loadInit();
		/*$Behavior.activityFeedLoader();*/
		
		return false;
	});
	
	$('.comment_mini').hover(function(){
		
		$('.feed_comment_delete_link').hide();
		$(this).find('.feed_comment_delete_link:first').show();
		
	}, function(){
		
		$('.feed_comment_delete_link').hide();
		
	});
	
	
}

var isAddingComment = false;
$Core.commentFeedTextareaClick = function($oObj)
{
	$($oObj).addClass('dont-unbind');
	$($oObj).blur(function() {
		$(this).removeClass('dont-unbind');
	});
	$($oObj).keydown(function(e)
	{
		if (isAddingComment) {
			p('adding comment. Please wait...');
			return false;
		}
		if (e.which == 13) {

			e.preventDefault();
			$($oObj).parents('form:first').trigger('submit');
			$($oObj).removeClass('dont-unbind');
			// $($oObj).unbind();
			$Core.loadInit();
			p('is added...');
			isAddingComment = true;

			return false;
		}

		if ($(this).hasClass('no_resize_textarea')) {
			return null;
		}
		$Core.resizeTextarea($(this));
	});
		
	if ($($oObj).val() == $('.js_comment_feed_value').html())
	{
		// $($oObj).val('');
	}
	
	$($oObj).addClass('js_comment_feed_textarea_focus').addClass('is_focus');
	$($oObj).parents('.comment_mini').find('.feed_comment_buttons_wrap:first').show();	
			
	$($oObj).parent().parent().find('.comment_mini_textarea_holder:first').addClass('comment_mini_content');
	$($oObj).parent().parent().find('.comment_mini_image:first').show();	
	/*p($($oObj).parent().parent().html());*/
}
						
$Behavior.activityFeedAttachLink = function()
{	
	$('#js_global_attach_link').click(function()
	{	
		$Core.activityFeedProcess(true);
		
		$Core.ajax('link.preview', 
		{		
			params: 
			{				
				'no_page_update': '1',
				value: $('#js_global_attach_value').val()
			},
			type: 'POST',
			success: function($sOutput)
			{
				$('#js_global_attachment_link_cancel').show();
				
				if (substr($sOutput, 0, 1) == '{'){					
					var $oOutput = $.parseJSON($sOutput);
					$Core.resetActivityFeedError($oOutput['error']);
					$bButtonSubmitActive = false;
					$('.activity_feed_form_button .button').addClass('button_not_active');
				}
				else{
					$Core.activityFeedProcess(false);

					$('#js_preview_link_attachment').html($sOutput);
					$('#global_attachment_link_holder').hide();				
				}
			}
		});
	});
	
	$('#js_global_attachment_link_cancel').click(function()
	{
		$('#js_global_attachment_link_cancel').hide();
	});
}

$ActivityFeedCompleted.link = function()
{
	$bButtonSubmitActive = true;
	
	$('#global_attachment_link_holder').show();	
	$('.activity_feed_form_button .button').removeClass('button_not_active');	
	$('#js_preview_link_attachment').html('');			
	$('#js_global_attach_value').val('http://');
}

$ActivityFeedCompleted.photo = function()
{
	$bButtonSubmitActive = true;
	
	$('#global_attachment_photo_file_input').val('');
}

var sToReplace = '', buildingCache = false;
function attachFunctionTagger(sSelector)
{
	if ($(sSelector).length && !buildingCache && (typeof $Cache == 'undefined' || typeof $Cache.friends == 'undefined')) {
		buildingCache = true;
		$.ajaxCall('friend.buildCache','','GET');
	}

	var customSelector = function () {
		return '_' + Math.random().toString(36).substr(2, 9);
	};
	var increment = 0;
	$(sSelector).each(function() {
		increment++;
		var t = $(this), selector = '_custom_' + customSelector() + '_' + increment;
		if (t.data('selector')) {
			t.removeClass(t.data('selector').replace('.', ''));
		}
		t.addClass(selector);
		t.data('selector', '.' + selector);
	});

	$(sSelector).keyup(function() {
		/*
		increment++;
		var t = $(this), selector = '_custom_' + customSelector() + '_' + increment;
		if (t.data('selector')) {
			t.removeClass(t.data('selector').replace('.', ''));
		}

		t.addClass(selector);
		*/
		var t = $(this);
		var sInput = t.val();
		var iInputLength = sInput.length;
		var iAtSymbol = sInput.lastIndexOf('@');
				if (sInput == '@' || empty(sInput) || iAtSymbol < 0 || iAtSymbol == (iInputLength-1))
				{
					$($(this).data('selector')).siblings('.chooseFriend').hide(function(){$(this).remove();});
					return;
				}
				
				var sNameToFind = sInput.substring(iAtSymbol+1, iInputLength);				
				
				/* loop through friends */
				var aFoundFriends = [], sOut = '';
				for (var i in $Cache.friends)
				{
					if ($Cache.friends[i]['full_name'].toLowerCase().indexOf(sNameToFind.toLowerCase()) >= 0)
					{
						var sNewInput = sInput.substr(0, iAtSymbol).replace(/\'/g,'&#39;').replace(/\"/g,'&#34;');
						sToReplace = sNewInput;
						aFoundFriends.push({user_id: $Cache.friends[i]['user_id'], full_name: $Cache.friends[i]['full_name'], user_image: $Cache.friends[i]['user_image']});
						if ($Cache.friends[i]['user_image'].substr(0, 5) == 'http:') {
							PF.event.trigger('urer_image_url', $Cache.friends[i]);

							// p($Cache.friends[i]['user_image']);

							$Cache.friends[i]['user_image'] = '<img src="' + $Cache.friends[i]['user_image'] + '" class="_image_32 image_deferred">';
						}

						sOut += '<div class="tagFriendChooser" onclick="$(\''+ $(this).data('selector') +'\').val(sToReplace + \'\' + (true ? \'@' + $Cache.friends[i]['user_name'] + '\' : \'[x=' + $Cache.friends[i]['user_id'] + ']' + $Cache.friends[i]['full_name'].replace(/\&#039;/g,'\\\'') +'[/x]\') + \' \').putCursorAtEnd();$(\''+$(this).data('selector')+'\').siblings(\'.chooseFriend\').remove();"><div class="tagFriendChooserImage">' + $Cache.friends[i]['user_image'] + '</div><span>' + (($Cache.friends[i]['full_name'].length > 25) ?($Cache.friends[i]['full_name'].substr(0,25) + '...') : $Cache.friends[i]['full_name']) + '</span></div>';
						/* just delete the fancy choose your friend and recreate it */
						sOut = sOut.replace("\n", '').replace("\r", '');						
					}
				}

				$($(this).data('selector')).siblings('.chooseFriend').remove();
				if (!empty(sOut)){
					$($(this).data('selector')).after('<div class="chooseFriend" style="width: '+ $(this).parent().width()+'px;">'+sOut+'</div>');
				}
			});
}


$Behavior.tagger = function()
{		
	var selectors = '#js_activity_feed_form > .activity_feed_form_holder > #global_attachment_status > textarea, .js_comment_feed_textarea, .js_comment_feed_textarea_focus';
	attachFunctionTagger(selectors);
	/*
	for (var i in aSelectors)
	{
		if ( $(aSelectors[i]).length >= 1)
		{			
			var bChanged = false;
			$.each($(aSelectors[i]), function(key, value)
			{				
				
				if ($(value).attr('id') != undefined)
				{
					aSelectors.push('#' + $(value).attr('id'));
					bChanged = true;
				}					
			});
			if (bChanged)
			{
				aSelectors.splice(i,1);
			}
		}
	}
	
	for (var i in aSelectors)
	{
		var sSelector = aSelectors[i];

		if (sSelector == '#pageFeedTextarea' || sSelector == '#eventFeedTextarea'  || sSelector == '#profileFeedTextarea') 
		{
			continue;
		}
		
		
		if ($(sSelector).length > 1)
		{
			$.each($(sSelector), function(key, value)
			{
				attachFunctionTagger($(this));
			});
		}
		attachFunctionTagger(sSelector);
	}
	*/
};
