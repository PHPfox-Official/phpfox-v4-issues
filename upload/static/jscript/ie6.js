
$Behavior.buttonHover = function()
{	
	$('.button').hover(function()
	{
		$(this).addClass('button_hover');
	},
	function ()
	{
		$(this).removeClass('button_hover');
	});	
};

var initPage = function() 
{
	initNav();
};

var initNav = function() 
{
	var menu_m = document.getElementById('main_nav');
	if (menu_m) {
		var lis = menu_m.getElementsByTagName('li');
		for (var i = 0; i < lis.length; i++){
			lis[i].onmouseover = function() {
				this.className += ' hover';
			};
			lis[i].onmouseout = function() {
				this.className = this.className.replace('hover','');
			};
		}
	}
	
	var menu_m = document.getElementById('right_nav');
	if (menu_m) {
		var lis = menu_m.getElementsByTagName('li');
		for (var i = 0; i < lis.length; i++){
			lis[i].onmouseover = function() {
				this.className += ' hover';
			};
			lis[i].onmouseout = function() {
				this.className = this.className.replace('hover','');
			};
		}
	}	
};

if (window.addEventListener)
{
	window.addEventListener("load", initPage, false);
} 
else if (window.attachEvent)
{
	window.attachEvent("onload", initPage);
}