
$Core.appsResizeIframe = function(height){
	$('#apps_iframe').height(parseInt(height) + 60);
}

$Core.apps_view = function(){		
	if ($Core.exists('.app_iframe')){		   
		$('#apps_iframe').width('100%');
		/*
		if (typeof window.bAppIntervalSet == 'undefined'){
			var iInterval = (oParams['apps.keep_alive'] > 10 ? ( (oParams['apps.keep_alive'] * 1000) - 10000) : oParams['apps.keep_alive'] * 1000);
			setInterval("if ($Core.exists('.app_iframe'))$.ajaxCall('apps.alive', 'appid=" + $('#js_apps_view_id').val() + "','GET');", iInterval);
			window.bAppIntervalSet = true;
		}
		*/
	}
}


$Core.apps_uninstall = function(iId)
{
	if (confirm(oTranslations['core.are_you_sure']))
	{
		window.location = oParams['sJsHome'] + 'index.php?' + oParams['sGetMethod'] + '=/apps/uninstall_' + iId;
	}	
	return false;
}

$Behavior.apps_load = function(){
	$Core.apps_view();
}