
var bIsAdminMenuClickSet = false;
$Behavior.adminMenuClick = function()
{
	if ($('#phpfox_store_load').length && !$('#phpfox_store').length) {
		var url = 'http://store.phpfox.com/';

		// url = 'http://localhost/moxi9/moxi9.com/';
		$('body').prepend('<iframe src="' + url + $('#phpfox_store_load').data('load') + '?iframe-mode=' + $('#phpfox_store_load').data('token') + '" id="phpfox_store"></iframe>');
		$('#phpfox_store').addClass('built').css({
			width: $(window).width() - 200,
			height: $(window).height()
		});
	}

	$('.apps_menu ul li a').click(function() {
		if ($('.active_app').length) {
			$.ajax({
				url: $(this).attr('href'),
				contentType: 'application/json',
				success: function(e) {
					$('._block_content').html(e.content);
					$Core.loadInit();
				}
			});

			return false;
		}
	});

	var storeFeatured = $('.phpfox_store_featured');
	if (storeFeatured.length && !storeFeatured.hasClass('is_built')) {
		var parentUrl = $('.phpfox_store_view_more').attr('href');
		var url = 'http://store.phpfox.com/featured';

		storeFeatured.addClass('is_built');
		// url = 'http://localhost/moxi9/moxi9.com/featured';
		$.ajax({
			url: url,
			data: 'type=' + storeFeatured.data('type'),
			success: function(e) {
				var html = '', className = 'admincp_apps', articleImage = '', icon = '';
				if (typeof(e) == 'object') {
					switch (storeFeatured.data('type')) {
						case 'themes':
							className = 'themes';
							break;
					}
				}

				html += '<div class="' + className + '">';
				for (var i in e) {
					var t = e[i];

					icon = '';
					articleImage = '';
					if (typeof(e) == 'object') {
						switch (storeFeatured.data('type')) {
							case 'themes':
								articleImage = ' style="background-image:url(' + t.icon + ')"';
								icon = '';
								break;
							case 'apps':
								icon = '<div class="app_icons image_load" data-src="' + t.icon + '"></div>';
								break;
						}
					}
					html += '<article' + articleImage + '><h1><a href="' + parentUrl + '&open=' + encodeURIComponent(t.url) + '">' + icon + '<span>' + t.name + '</span></a></h1></article>';
				}
				html += '</div>';

				storeFeatured.html(html);
				$Core.loadInit();
			}
		});
	}

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
					$(this).parent().find('.main_sub_menu:first').show();
				}				
				$(this).addClass('active');
				
				if (bIsAdminMenuClickSet === false) {
					bIsAdminMenuClickSet = true;
				}
			}
			
			return false;
		}
	});

	/*
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
	*/
};