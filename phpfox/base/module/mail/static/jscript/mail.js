
$Behavior.mailView = function()
{
	if ($Core.exists('#js_mail_textarea')){
		$('#js_mail_textarea #message').keydown(function(){$Core.resizeTextarea($(this));});
	}	
	
	if ($Core.exists('.mail_thread_form_holder')){
		$('.mail_thread_form_holder').width($('#site_content').width());
	}		

	if ($Core.exists('#js_mail_thread_view_more')){
		$(window).scroll(function(){
			if (isScrolledIntoView('#mail_threaded_new_message_scroll')){
				$('.mail_thread_form_holder').addClass('not_fixed');
			}
			else {
				$('.mail_thread_form_holder').removeClass('not_fixed');
			}
		});		
		
		$.scrollTo('.is_last_message', 800);
	}	
	
	$('#js_mail_thread_view_more').click(function(){
		$(this).hide();
		$('.mail_thread_holder').removeClass('is_last_message');
		$('#feed_view_more_loader').show();
		$.ajaxCall('mail.viewMoreThreadMail', 'page=' + $('#js_mail_thread_current_cnt').html() + '&thread_id=' + $(this).attr('rel'), 'GET');
		return false;
	});
}

$Core.addThreadMail = function(oObj){
	var sContent = Editor.getContent();
	Editor.setContent('');
	$(oObj).ajaxCall('mail.addThreadMail', 'val[message]=' + encodeURIComponent(sContent));
	$(oObj).find('.js_attachment_list').hide();
	$(oObj).find('.js_attachment:first').val('');	
}

$Core.mailThreadReset = function(){	
	$('#feed_view_more_loader').hide();
	$('#js_mail_thread_view_more').show();
	var iTotal = parseInt($('#js_mail_thread_current_cnt').html());
	$('#js_mail_thread_current_cnt').html(iTotal + 1);
	$.scrollTo('.is_last_message:first');
}