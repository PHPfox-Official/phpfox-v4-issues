
var bIsAdminMenuClickSet = false;
$Behavior.adminMenuClick = function()
{	
	$('body').click(function(){
		
		$('.main_menu_link').each(function(){
			if ($(this).hasClass('active')){
				$(this).parent().find('.main_sub_menu:first').hide();
				$(this).removeClass('active');
				bIsAdminMenuClickSet = false;
			}			
		});
		
		
	});
	
	$('.main_menu_link').click(function(){
		
		if ($(this).attr('href') == '#') {		
		
			if ($(this).hasClass('active')){
				$(this).parent().find('.main_sub_menu:first').hide();
				$(this).removeClass('active');
				bIsAdminMenuClickSet = false;
			}
			else
			{				
				$('.main_sub_menu').hide();
				$('.main_menu_link').removeClass('active');
				if (bIsAdminMenuClickSet) {
					$(this).parent().find('.main_sub_menu:first').show();
				}
				else {
					$(this).parent().find('.main_sub_menu:first').slideDown('fast');
				}				
				$(this).addClass('active');
				
				if (bIsAdminMenuClickSet === false) {
					bIsAdminMenuClickSet = true;
				}
			}
			
			return false;
		}
	});
	
	$('.main_menu_link').hover(function(){
		if (bIsAdminMenuClickSet === true){
			if (!$(this).hasClass('active')){
				$('.main_sub_menu').hide();
				$('.main_menu_link').removeClass('active');
				$(this).parent().find('.main_sub_menu:first').show();
				$(this).addClass('active');
			}
		}
	});
}