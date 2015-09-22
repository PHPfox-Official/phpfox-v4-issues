
var bIsAdminMenuClickSet = false;
$Behavior.adminMenuClick = function()
{
	var s = $('#phpfox_store_load');
	if (s.length && !$('#phpfox_store').length) {
		var url = 'https://store.phpfox.us/';
		if (s.data('url')) {
			url = s.data('url');
		}

		$('body').prepend('<iframe src="' + url + $('#phpfox_store_load').data('load') + '?iframe-mode=' + $('#phpfox_store_load').data('token') + '" id="phpfox_store"></iframe>');
		$('#phpfox_store').addClass('built').css({
			width: $(window).width() - 200,
			height: $(window).height()
		});
	}

	if ($('.phpfox-product').length) {
		$('.phpfox-product').each(function() {
			var t = $(this);

			var url = 'https://store.phpfox.us/product/' + t.data('internal-id') + '/';
			$.ajax({
				url: url + 'view.json',
				success: function(e) {
					if (PF.tools.versionCompare(e.version, t.data('version'), '>')) {
						$('.am_top').append('<div class="upgrade-product"><a href="' + getParam('sJsHome') + 'admincp/store/?upgrade=' + t.data('internal-id') + '">Upgrade Product</a></div>');
					}
				}
			});
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
		var parentUrl = storeFeatured.data('parent');
		var url = 'https://store.phpfox.us/featured';

		storeFeatured.addClass('is_built');
		// url = 'http://localhost/moxi9/moxi9.com/featured';
		$.ajax({
			url: url,
			data: 'v=1&type=' + storeFeatured.data('type'),
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
							case 'language':
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

	/*
	$('body').click(function() {
		$('.main_menu_link').each(function(){
			if ($(this).hasClass('active')) {
				$(this).parent().find('.main_sub_menu:first').hide();
				$(this).removeClass('active');
				bIsAdminMenuClickSet = false;
			}			
		});
		
	});
	*/
	var options = {
		keys: ['title'],
		includeScore: false
	}

	$('.admincp_search_settings span.remove').click(function() {
		$('.admincp_search_settings').removeClass('is_active');
		$('.admincp_search_settings_results').html('').hide();
		$('.main_sub_menu > ul').show();
		$('.admincp_search_settings input').val('');
	});

	fuse = new Fuse(admincpSettings, options);
	$('.admincp_search_settings input').keydown(function() {
		var t = $(this);

		var word = t.val().split(' ');
		var result = fuse.search(t.val());
		var html = '';
		var mainOutput = $('.admincp_search_settings_results');

		if (t.val().length <= 1) {
			$('.admincp_search_settings').removeClass('is_active');
			mainOutput.html(html).hide();
			$('.main_sub_menu > ul').show();
			return;
		}

		if (result) {

			for (var i in result) {
				var term = result[i]

				var title = term.title;
				for (var w in word) {
					if (!word[w]) {
						continue;
					}

					var pattern = new RegExp("("+word[w]+")", "gi");
					title = title.replace(pattern, "<mark>$1</mark>");
				}

				html += '<a href="' + term.link + '">' + title + '</a>';
			}

			$('.admincp_search_settings').addClass('is_active');
			mainOutput.html(html).show();
			$('.main_sub_menu > ul').hide();
		}
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