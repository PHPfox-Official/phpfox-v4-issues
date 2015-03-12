$Core.notification =
{	
	bDebug: false,
	
	update: function()
	{
		setTimeout('$.ajaxCall("notification.update", "", "GET");', 1000);
	},
	
	setTitle: function()
	{
		var iTotal = 0;
		var sTitle = $('title').html();
		
		$('.holder_notify_count').each(function(){
			iTotal += parseInt($(this).html());
		});
		
		var newTitle = '';		
		var aMatches = sTitle.match(/(\([0-9]*\))/i);
		if (aMatches !== null && isset(aMatches[1])){
			if (iTotal > 0){
				newTitle = '(' + iTotal + ') ' + sTitle.replace(aMatches[1], '');
				//$('title').html(newTitle.replace('#',''));
				// document.title = newTitle.replace('#', '');
			}
			else{
				//$('title').html(aMatches[1].replace('#',''));
				// document.title = aMatches[1].replace('#', '');
			}
		}
		else{
			if (iTotal > 0){
				//$('title').prepend('(' + iTotal + ') '); // it doesnt work in IE8
				// ie8 doesnt like hashes			
				var NewTitle = document.title.replace('#','');				
				// document.title = '(' + iTotal + ') ' + NewTitle;
				
			}
			else{
			}
		}
		
		if (getParam('notification.notify_ajax_refresh') > 0)
		{
			setTimeout('$.ajaxCall("notification.update", "", "GET");', (this.bDebug ? 10000 : (getParam('notification.notify_ajax_refresh') * 60000)));
		}
	}
};

var bRunNotificationUpdate = true;
$Behavior.notification_update_begin = function()
{
	if (!bRunNotificationUpdate){
		return;
	}
	$Core.notification.update();
	bRunNotificationUpdate = false;
};