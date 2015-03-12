$Behavior.video_edit = function()
{
	$('.js_video_change_group').click(function()
	{
		if ($(this).parent().hasClass('locked'))
		{
			return false;
		}
		
		aParts = explode('#', this.href);
		
		$('.js_video_block').hide();
		$('#js_video_block_' + aParts[1]).show();
		$(this).parents('.header_bar_menu:first').find('li').removeClass('active');
		$(this).parent().addClass('active');
		$('#js_video_add_action').val(aParts[1]);
	});
};