$Core.Newsletter =
{
	toggleMode : function()
	{
		var sMode = $('#js_mode :selected').text();		
		window.location.href= sUrl + "mode_" + sMode;
	}
}

