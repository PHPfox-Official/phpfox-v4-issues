
var sCurrentAjaxSection = 'profile';

$Core.loadProfileInfo = function()
{
	$('#content .block').each(function()
	{
		if ($(this).css('display') == 'block')
		{
			$(this).addClass('js_profile_main_block');
			$(this).hide();
		}
	});		
	
	// $('.js_profile_block_view_data').hide();		
	$('.js_custom_block_entry').show();	
	$('#js_block_border_profile_info').show();		
};

$Core.profileAjaxSection = function(sBlockName)
{
	p('Current Section: ' + sCurrentAjaxSection);
	p('Profile Section: ' + sBlockName);
	
	if (sCurrentAjaxSection == 'profile' && sBlockName == 'profile_info')
	{
		$('#content .block').each(function()
		{
			if ($(this).css('display') == 'block')
			{
				$(this).addClass('js_profile_main_block');
			}
		});		
		
		$('#content .block').hide();
		$('.js_profile_block_view_data').hide();		
		$('.js_custom_block_entry').show();	
		$('#js_block_border_' + sBlockName).show();	
	}	
	else if (sCurrentAjaxSection == 'profile_info' && sBlockName == 'profile')
	{
		$('#content .block').hide();
		$('.js_custom_block_entry').hide();
		$('.js_profile_main_block').show();	
	}
	else
	{
		$.ajaxCall('profile.loadProfileBlock', 'load_ajax_controller=true&url=' + sBlockName + '&profile_id=' + $('.js_cache_profile_id').html() + '&user_name=' + $('.js_cache_profile_user_name').html());
	}
	
	$('.sub_section_menu ul li').removeClass('active');
	$('.sub_section_menu ul').find('.js_hash_' + (empty(sBlockName) ? 'profile' : sBlockName)).addClass('active');		
	
	sCurrentAjaxSection = sBlockName;
};

$Behavior.theme_default_profile_init_2 = function()
{
	var bIsCreated = false;
	$('.sub_section_menu ul li a').click(function()
	{	
		var sHashName = trim($(this).parent().attr('class')
			.replace(' active', '').
			replace('js_hash_', ''));
		
		window.location = '#' + sHashName;	
		
		if (bIsCreated === false)
		{
			$.address.change(function(event)
			{
				$Core.profileAjaxSection(event.path.replace('/', ''));
			});
		}		
		bIsCreated = true;
		
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
	
	if (!empty($.address.path().replace('/', '')))
	{
		$Core.profileAjaxSection($.address.path().replace('/', ''));
	}
};