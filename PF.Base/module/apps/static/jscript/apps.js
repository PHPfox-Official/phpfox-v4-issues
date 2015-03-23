
$Behavior.coreApps = function(){
	
	$('.js_apps_menu_click').click(function(){
		
		$('.apps_dev_menu ul li a').removeClass('active');
		$('.apps_module_holder').hide();
		$('#js_apps_module_' + $(this).attr('rel')).show();		
		$(this).addClass('active');
		
		return false;
	});
	
}