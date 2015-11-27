
var PF = {
	events: {},

	tools: {
		versionCompare: function(v1, v2, operator) {
			this.php_js = this.php_js || {};
			this.php_js.ENV = this.php_js.ENV || {};

			var i = 0,
				x = 0,
				compare = 0,
				vm = {
					'dev'   : -6,
					'alpha' : -5,
					'a'     : -5,
					'beta'  : -4,
					'b'     : -4,
					'RC'    : -3,
					'rc'    : -3,
					'#'     : -2,
					'p'     : 1,
					'pl'    : 1
				},
				prepVersion = function(v) {
					v = ('' + v)
						.replace(/[_\-+]/g, '.');
					v = v.replace(/([^.\d]+)/g, '.$1.')
						.replace(/\.{2,}/g, '.');
					return (!v.length ? [-8] : v.split('.'));
				};

			numVersion = function(v) {
				return !v ? 0 : (isNaN(v) ? vm[v] || -7 : parseInt(v, 10));
			};
			v1 = prepVersion(v1);
			v2 = prepVersion(v2);
			x = Math.max(v1.length, v2.length);
			for (i = 0; i < x; i++) {
				if (v1[i] == v2[i]) {
					continue;
				}
				v1[i] = numVersion(v1[i]);
				v2[i] = numVersion(v2[i]);
				if (v1[i] < v2[i]) {
					compare = -1;
					break;
				} else if (v1[i] > v2[i]) {
					compare = 1;
					break;
				}
			}
			if (!operator) {
				return compare;
			}

			switch (operator) {
				case '>':
				case 'gt':
					return (compare > 0);
				case '>=':
				case 'ge':
					return (compare >= 0);
				case '<=':
				case 'le':
					return (compare <= 0);
				case '==':
				case '=':
				case 'eq':
					return (compare === 0);
				case '<>':
				case '!=':
				case 'ne':
					return (compare !== 0);
				case '':
				case '<':
				case 'lt':
					return (compare < 0);
				default:
					return null;
			}
		}
	},

	url: {
		make: function(url) {
			url = getParam('sJsHome') + trim(url, '/');

			return url;
		},

		send: function(url, relocation) {
			url = PF.url.make(url);
			if (relocation) {
				window.location.href = url;
				return;
			}

			history.pushState(null, null, url);
		}
	},

	event: {
		trigger: function(name, param) {
			if (typeof(PF.events[name]) != 'object') {
				return;
			}

			$.each(PF.events[name], function(name, callbacks) {
				this(this, param);
			});
		},

		on: function(name, callback) {
			if (typeof(PF.events[name]) != 'array') {
				PF.events[name] = new Array();
			}
			PF.events[name].push(callback);
		}
	}
};


var $Cache = {};
var $oEventHistory = {};
var $oStaticHistory = {};
var $bDocumentIsLoaded = false;

if (typeof window.console == 'undefined')
{
	window.console = { log : function(sTxt){} };
}
if (typeof window.console.log == 'undefined')
{
	window.console.log = function(sTxt){};
}

$.fn.message = function(sMessage, sType) 
{
	switch(sType)
	{
		case 'valid':
			sClass = 'valid_message';
			break;
		case 'error':
			sClass = 'error_message';
			break;
		case 'public':
			sClass = 'public_message';
			break;
	}

	this.html(this.html() + '<div class="' + sClass + '">' + sMessage + '</\div>');
	
	return this;
};

$.getParams = function(sUrl)
{
	var aArgs = sUrl.split('#');
	var aArgsFinal = aArgs[1].split('?');	
	var aFinal = aArgsFinal[1].split('&');
	
	var aUrlParams = Array();

	for (count = 0; count < aFinal.length; count++)
	{
		var aArg = aFinal[count].split('=');	
		
		aUrlParams[aArg[0]] = aArg[1];
	}
	
	return aUrlParams;
};

$.ajaxProcess = function(sMessage, sSize)
{
	sMessage = (sMessage ? sMessage : getPhrase('core.processing'));
	
	if (empty(sSize))
	{
		sSize = 'small';
	}	
	
	return '<span style="margin-left:4px; margin-right:4px; font-size:9pt; font-weight:normal;"><img src="' + eval('oJsImages.ajax_' + sSize + '') + '" class="v_middle" /> ' + (sMessage === 'no_message' ? '' : sMessage + '...') + '</span>';
};

$Behavior.imageHoverHolder = function()
{
	$('#panels .block .title').click(function() {
		var t = $(this).parent();
		if (t.find('.content').length) {
			t.find('.content').first().toggle();
		}
	});

	$('#show-side-panel').click(function() {
		var b = $('body');
		if (b.hasClass('show-side-panel-mode')) {
			b.removeClass('show-side-panel-mode');
			return;
		}

		b.addClass('show-side-panel-mode');
	});

	$('body').click(function(){
		$('.image_hover_menu_link').each(function() {
			if ($(this).hasClass('image_hover_active'))
			{
				$(this).removeClass('image_hover_active');
				$(this).parent().find('.image_hover_menu:first').hide();
				$(this).hide();
			}				
		});
	});
	
	$('.image_hover_holder').mouseover(function()
	{		
		if (!empty($(this).find('.image_hover_menu:first').html()))
		{
			$(this).addClass('image_hover_holder_hover').find('.image_hover_menu_link:first').show();
		}
	});

	$('.image_hover_holder').mouseout(function()
	{
		if (!$(this).find('.image_hover_menu_link').hasClass('image_hover_active'))
		{
			$(this).removeClass('image_hover_holder_hover').find('.image_hover_menu_link:first').hide();
		}
	});
	
	$('.image_hover_menu_link').click(function(){
		
		var oMenu = $(this).parent().find('.image_hover_menu:first');
		
		if ($(this).hasClass('image_hover_active'))
		{
			$(this).removeClass('image_hover_active');
			
			oMenu.hide();
			
			return false;
		}
		
		$('.image_hover_menu_link').each(function() {
			if ($(this).hasClass('image_hover_active'))
			{
				$(this).removeClass('image_hover_active');
				$(this).parent().find('.image_hover_menu:first').hide();
				$(this).hide();
			}				
		});
		
		$(this).addClass('image_hover_active');
		
		oMenu.show();
		
		return false;
	});
};

$Behavior.targetBlank = function()
{
	$('.targetBlank').click(function()
	{
		window.open($(this).get(0).href);
		return false;
	});
};

var bCacheIsHover = false;
$Behavior.dropDown = function()
{
	$('.sJsDropMenu').click(function()
	{
		$(this).blur();
		$('.dropContent').hide();
		$('.sub_menu_bar li a').removeClass('is_already_open');	
		
		if ($(this).hasClass('is_already_open'))
		{
			$(this).parent().find('.dropContent:first').hide();
			$(this).removeClass('is_already_open');
		}
		else
		{
			$(this).parent().find('ul').addClass('dropdown-menu dropdown-menu-right');
			$(this).parent().find('.dropContent:first').addClass('open').show();
			$(this).addClass('is_already_open');	
		}
			
		return false;
	});

	$('.breadcrumbs').click(function(){
    $('.breadcrumbs ul').toggle();
  });

	$('.dropContent').mouseover(function(){
		bCacheIsHover = true;
	});
	
	$('.dropContent').mouseout(function(){
		bCacheIsHover = false;
	});	
	
	$('body').click(function()
	{
		if (!bCacheIsHover){		
			$('.dropContent').hide();
			$('.sub_menu_bar li a').each(function(){
				if ($(this).hasClass('is_already_open')){
					$(this).removeClass('is_already_open');
				}
			});
		}
	});
};

/**
 * Drop down auto jump
 */
$Behavior.goJump = function()
{
	$('.goJump').change(function()
	{
		// Empty value, do nothing
		if ($(this).get(0).value == "")
		{
			return false;
		}		
		
		// Is this a delete link? If it is make sure they confirm they want to delete the item
		if ($(this).get(0).value.search(/delete/i) != -1 && !confirm(getPhrase('core.are_you_sure')))
		{
			return false;
		}		
		
		// All set lets send them to the new page
		window.location.href = $(this).get(0).value;
	});
};

$Behavior.inlinePopup = function()
{
	$('.inlinePopup').click(function()
	{
		var $aParams = $.getParams($(this).get(0).href);
		var sParams = '&tb=true';
		for (sVar in $aParams)
		{			
			sParams += '&' + sVar + '=' + $aParams[sVar] + '';
		}
		sParams = sParams.substr(1, sParams.length);		
		
		tb_show($(this).get(0).title, $.ajaxBox($aParams['call'], sParams));		
		
		return false;
	});
};

$Behavior.blockClick = function()
{
	$('.block .menu ul li a').click(function()
	{
		$(this).parents('.block:first').find('li').removeClass('active');
		$(this).parent().addClass('active');
		
		if (this.href.match(/#/))
		{
			var aParts = explode('#', this.href);
			var aParams = explode('?', aParts[1]);
			var aParamParts = explode('&', aParams[1]);
			var aRequest = Array();
			for (count in aParamParts)
			{
				var aPart = explode('=', aParamParts[count]);
				
				aRequest[aPart[0]] = aPart[1];
			}			

			$('.js_block_click_lis_cache').remove();
			// $(this).parents('.menu:first').find('ul').append('<li class="js_block_click_lis_cache" style="margin-top:2px;">' + $.ajaxProcess('no_message') + '</li>');
			$.ajaxCall(aParams[0], aParams[1] + '&js_block_click_lis_cache=true', 'GET');			
		}		
		
		return false;
	});
};

$Behavior.deleteLink = function()
{
	$('.delete_link').click(function()
	{
		if (confirm(getPhrase('core.are_you_sure')))
		{
			$aParams = $.getParams($(this).get(0).href);
			var sParams = '';
			for (sVar in $aParams)
			{			
				sParams += '&' + sVar + '=' + $aParams[sVar] + '';
			}
			sParams = sParams.substr(1, sParams.length);
				
			$.ajaxCall($aParams['call'], sParams);
		}
				
		return false;			
	});	
};

$Behavior.globalToolTip = function()
{
	if ($('#js_global_tooltip').length <= 0)
	{
		$('body').prepend('<div id="js_global_tooltip" style="display:none;"></div>');		
	}
	
	$('.js_hover_title').mouseover(function()
	{
		var offset = $(this).offset();					
		var sContent = '';
		if ($(this).find('.js_hover_info').length && $(this).find('.js_hover_info').html() !== null && $(this).find('.js_hover_info').html().length < 1)
		{
			
		}
		else
		{
			$('#js_global_tooltip').css('display', 'block');
			
			if ($(this).find('.js_hover_info').length > 0)
			{
				sContent = $(this).find('.js_hover_info').html();
			}
			else
			{
				var oParent = $(this).parent();			
				
				if (!empty(oParent.attr('title')))
				{
					oParent.data('title', oParent.attr('title')).removeAttr('title');
				}
				
				sContent = oParent.data('title');
			}
			
			$('#js_global_tooltip').html('<div id="js_global_tooltip_display">' + sContent + '</div>');
			$('#js_global_tooltip').css('top', (offset.top - ($('#js_global_tooltip_display').height() + 10)) + 'px');

			var pos = ($(window).width() - (offset.left + $('#js_global_tooltip').width()));
			if (pos < 10) {
				offset.left = (offset.left - $('#js_global_tooltip').width()) + 20;
			}

			$('#js_global_tooltip').css('left', (offset.left - 10) + 'px');
		}		
	});
	
	$('.js_hover_title').mouseout(function()
	{
		$('#js_global_tooltip').hide()
			.html('')
			.css('top', '0px')
			.css('left', '0px');
	});
};

$Behavior.clearTextareaValue = function()
{
	$('.js_comment_text_area #text').focus(function()
	{
		if ($(this).val() == $('#js_comment_write_phrase').html())
		{
			$(this).val('');
		}
	});
};

$Behavior.loadEditor = function()
{
	if ((!getParam('bWysiwyg') || typeof(bForceDefaultEditor) != 'undefined') && typeof(Editor) == 'object')
	{
		Editor.getEditors();
	}	
};

var sMoreFeedIds = {};
$Core.loadMoreFeeds = function()
{
	$Core.bRebuiltActivityFeed = false;
    $.ajaxCall('feed.appendMore', 'ids=' + sMoreFeedIds, 'GET');    
    return false;
};

/* This controls when to show the "X More Feeds" sign. */
$Core.bRebuiltActivityFeed = false;

$Core.rebuildActivityFeedCount = function(iTotal, sIds)
{
	
	sMoreFeedIds = sIds;
	
    $('.activity_feed_updates_link').hide();    
    if (iTotal && $Core.bRebuiltActivityFeed == true)
    {
        $('#activity_feed_updates_link_holder').show();
        if (iTotal == 1)
        {
            $('#activity_feed_updates_link_single').show();
        }
        else
        {
            $('#activity_feed_updates_link_plural').show();
            $('#js_new_update_view').html(iTotal);            
        }        
    }  
	else
	{
		$('#activity_feed_updates_link_holder').hide();
		$Core.bRebuiltActivityFeed = true;
	}
};

$Core.reloadActivityFeed = function(){
	/* Enable ajax reload only if not checking a hashtag */
	if ($('#sHashTagValue').length < 1)
	{
		setTimeout("$.ajaxCall('feed.reloadActivityFeed', 'reload-ids=' + $Core.getCurrentFeedIds(), 'GET');", 2000);
	}
};

$Ready(function() {
	$('.audio_player:not(.built)').each(function() {
		var t = $(this),
			onPlay = t.data('onplay');

		// p('loading...');

		t.addClass('built');
		var audio = document.createElement('audio');
		audio.setAttribute('src', t.data('src'));
		audio.setAttribute('controls', 'controls');
		audio.setAttribute('preload', 'none');

		// audio.setAttribute('preload', 'none');

		t.get(0).appendChild(audio);

		if (onPlay) {
			audio.addEventListener('play', function() {
				$.ajax({
					url: onPlay
				});
			});
		}
	});
});

$Core.player = {
	load: function(params) {
		var t = $('#' + params.id),
			html = '';

		if (params.type != 'music') {
			return '';
		}

		/*
		html = '<audio controls>' +
			'<source src="' + params.play + '" type="audio/mpeg">' +
			'</audio>';
		*/

		var audio = document.createElement('audio');
		audio.setAttribute('src', params.play);
		audio.setAttribute('controls', 'controls');
		audio.setAttribute('preload', 'none');

		// audio.setAttribute("autoplay","autoplay");

		t.get(0).appendChild(audio);

		if (typeof(params.on_start) == 'function') {
			audio.addEventListener('play', params.on_start);
		}

		// t.html(audio);
		// audio.prependTo(t);
	}
};

$Core.getCurrentFeedIds = function()
{
	var sMoreFeedIds = '';
	$('.js_parent_feed_entry').each(function(){
		sMoreFeedIds += $(this).attr('id').replace('js_item_feed_', '') + ',';				
	});	
	
	return sMoreFeedIds;
};

$Core.processForm = function(sSelector, bReset)
{
	if (bReset === true)
	{
		$(sSelector).find('.button:first').removeClass('button_off').attr('disabled', false);
		$(sSelector).find('.table_clear_ajax').hide();		
	}
	else
	{
		$(sSelector).find('.button:first').addClass('button_off').attr('disabled', true);
		$(sSelector).find('.table_clear_ajax').show();
	}
};

$Core.exists = function(sSelector)
{
	return ($(sSelector).length > 0 ? true : false);
};

$Core.searchFriends = function($aParams)
{	
	if (typeof($Core.searchFriendsInput) == 'undefined'){
		return;
	}
	$Core.searchFriendsInput.init($aParams);
};

$Core.loadStaticFile = function($aFiles)
{
	$Core.loadStaticFiles($aFiles);	
};

var sCustomHistoryUrl = '';
$Core.loadStaticFiles = function($aFiles)
{
	if (typeof($aFiles) == 'string')
	{
		$aFiles = new Array($aFiles);	
	}
	
	if (!$bDocumentIsLoaded)
	{
		if (!isset($Cache['post_static_files']))
		{
			$Cache['post_static_files'] = new Array();
		}
		
		$Cache['post_static_files'].push($aFiles);	
		
		return;
	}		
	
	/* $Core.loadInit is triggered before this function finishes loading all the JS files we use this counter to control loadInit and make it wait for all JS files*/
	$Core.dynamic_js_files = 0;
	$($aFiles).each(function($sKey, $sFile){
		if (substr($sFile, -3) == '.js' && !isset($oStaticHistory[$sFile]))
		{
			$Core.dynamic_js_files++;
		}
	});
	
	$($aFiles).each(function($sKey, $sFile)
	{
		if (!isset($oStaticHistory[$sFile]))
		{
			$oStaticHistory[$sFile] = true;
			if (substr($sFile, -3) == '.js')
			{
				// $('head').append('<script type="text/javascript" src="' + $sFile + '?v=' + getParam('sStaticVersion') + '"></script>');
				/*var d = document;
				var js, id = $sFile; 
				if (d.getElementById(id)) {return;}
				js = d.createElement('script'); 
				js.id = id; 
				js.async = true;
				js.src = $sFile;
				js.onreadystatechange= function () 
				{
					console.log('State for ' + $sFile + ' is ' + this.readyState);
					if (this.readyState == 'complete')
					{
						$Core.dynamic_js_files--;
					}
				}
				d.getElementsByTagName('head')[0].appendChild(js);*/
				$.ajax($sFile + '?v=' + getParam('sStaticVersion') + '').always(function(){
					$Core.dynamic_js_files--;
				});
			}
			else if (substr($sFile, -4) == '.css')
			{				
				var sCustomId = '';
				if (substr($sFile, -10) == 'custom.css'){
					sCustomHistoryUrl = $sFile;
					sCustomId = 'js_custom_css_loader';
				}
				$('head').prepend('<link ' + sCustomId + ' rel="stylesheet" type="text/css" href="' + $sFile + '?v=' + getParam('sStaticVersion') + '" />');
			}
			else
			{
				eval($sFile);				
			}
		}
		else
		{
			if (substr($sFile, -10) == 'custom.css'){
				sCustomHistoryUrl = $sFile;
			}
		}
	});	

	if (!empty(sCustomHistoryUrl)){
		$('#js_custom_css_loader').remove();
		$('head').append('<link id="js_custom_css_loader" rel="stylesheet" type="text/css" href="' + sCustomHistoryUrl + '?v=' + getParam('sStaticVersion') + '" />');			
	}
};

var lastClassName;
$Core.openPanel = function(obj) {
	// $('body').addClass('panel_is_active');
	$('#header_search_form').hide();
	$('._search').show();
	if (lastClassName) {
		$('#panel').removeClass(lastClassName).attr('style', '');
		lastClassName = null;
	}

	PF.event.trigger('openPanel', obj);

	if (obj instanceof jQuery) {
		if (obj.find('span').length) {
			obj.find('span').html('').hide();
		}

		if (obj.hasClass('active')) {
			obj.removeClass('active');
			$('body').removeClass('panel_is_active');

			return;
		}

		if (obj.data('class')) {
			lastClassName = obj.data('class');
			var panel = $('#panel').addClass(obj.data('class'));
			panel.css({
				top: (obj.offset().top - $(window).scrollTop())
			});
		}

		$('.notifications a.active').removeClass('active');
		obj.addClass('active');
		$('body').addClass('panel_is_active').removeClass('user_block_is_active');

		$('#panel').html('<i class="fa fa-spin fa-circle-o-notch"></i>');

		$.ajax({
			url: obj.data('open'),
			contentType: 'application/json',
			success: function(e) {
				$('#panel').html(e.content);
				$('#panel').find('._block').remove();
				$Core.loadInit();
			}
		})
	}
};

$Behavior.globalInit = function()
{
	$('.js_pager_view_more_link:not(.built)').each(function() {
		var t = $(this),
			isInView = false,
			url = t.find('.next_page').attr('href');

		t.addClass('built');
		$(window).scroll(function() {
			if ($Core.isInView(t, 100) && !isInView) {
				if (t.find('.next_page').length) {
					t.find('.next_page').addClass('focus');
					$.ajax({
						url: url,
						contentType: 'application/json',
						data: 'core[ajax]=true' + (t.data('pagination') ? '&pagination=1' : ''),
						success: function(e) {
							if (typeof(e.content) == 'string') {
								if (t.data('pagination')) {
									var pager = t.parents('.pagination');
									pager.replaceWith(e.content);
								} else {
                  //remove duplication content
                  t.parent().find('.mail_duplication_content').remove();
									t.before(e.content);
									t.remove();
								}

								$Core.loadInit();
							}
							else {
								t.remove();
							}
						}
					});
				}
				isInView = true;
			}
		});
	});

	/*
	if ($('#right').length && $('#panels').height() > $(window).height()) {
		var isRightEnd = false;
		var lastScrollTop = 0;
		var leftPosition = $('#panels').offset().left;
		var savedSpot = 0;
		$(window).scroll(function() {
			var st = $(this).scrollTop();
			if (st > lastScrollTop){

			} else {
				if (st <= savedSpot) {
					isRightEnd = false;
					$('body').removeClass('right_is_fixed');
					$('#panels').attr('style', '');
					return;
				}
			}
			lastScrollTop = st;

			if ($Core.isInView('#end_right')) {
				if (!isRightEnd) {
					isRightEnd = true;
					savedSpot = lastScrollTop;
					$('body').addClass('right_is_fixed');
					$('#panels').css({
						left: leftPosition
					});
				}
			}
		});
	}
	*/

	/*
	if ($('#js_block_border_ad_display').length
		&& !$('#js_block_border_ad_display').hasClass('is_built')
		&& $('#js_block_border_ad_display').is(':visible')
		) {
		var t = $('#js_block_border_ad_display');
		var thisPosition = t.offset(),
			isInFixed = false,
			extraHeight = ($('#header').height() + 20),
			goFixed = (thisPosition.top - extraHeight),
			thisScroll = function() {
				var w = $(this);
				if ((w.scrollTop() >= goFixed)) {
					if (!isInFixed) {
						isInFixed = true;
						// p(($(this).scrollTop() - extraHeight));
						p(extraHeight);
						t.css({
							position: 'fixed',
							top: extraHeight,
							width: t.width()
						})
					}
				}
				else {
					if (isInFixed) {
						isInFixed = false;
						t.attr('style', '');
					}
				}
			};
		$(window).off('scroll', thisScroll);
		$(window).on('scroll', thisScroll);
	}
	*/

	if ($('.set_to_fixed').length) {
		$('.set_to_fixed:not(.built)').addClass('dont-unbind').each(function() {
			var t = $(this),
				o = t.offset(),
				isFixed = false;

			t.addClass('built');
			$(window).scroll(function() {
				var total = (o.top - $(this).scrollTop());
				if (total <= 1 && !isFixed) {
					isFixed = true;
					$('body').addClass(t.data('class'));
				}

				if (isFixed && total >= 2) {
					isFixed = false;
					$('body').removeClass(t.data('class'));
				}
			});
		});
	}

	$('.user_block_toggle').click(function() {
		$('body').toggleClass('user_block_is_active');
	});

	$('.mobile_menu').click(function() {
		$('body').toggleClass('show_mobile_menu');
		$('body').removeClass('panel_is_active');
	});

	$('.feed_form_toggle').unbind().click(function() {
		$('.feed_form_menu').slideToggle('fast');
	});

	$('.feed_form_share:not(.active)').click(function() {
		var t = $(this),
			f = t.parents('form:first');

		t.addClass('feed_form_share');
		$.ajax({
			url: f.attr('action'),
			type: 'POST',
			data: f.serialize(),
			complete: function(e) {
				$Core.resetFeedForm(f);
				eval(e.responseText);
			}
		});

		return false;
	});

	$('.cancel_post').click(function() {
		$('._load_is_feed').removeClass('active');
		$('body').removeClass('panel_is_active');
		$('#panel').hide();
	});
	$('.feed_form_textarea textarea').keydown(function() {
		$Core.resizeTextarea($(this));
	});

	$('.feed_form_textarea textarea:not(.dont-unbind)').click(function() {
		var t = $(this);

		t.addClass('dont-unbind');
		t.parents('form:first').addClass('active');
	});

	$('._panel').click(function() {
		$Core.openPanel($(this));

		return false;
	});

	if ($('.mosaicflow_load:not(.built_flow)').length) {
		var mLoad = setInterval(function() {
			if (typeof(jQuery().mosaicflow) == 'function') {
				$('.mosaicflow_load').addClass('built_flow');

				$('.mosaicflow_load').mosaicflow({
					minItemWidth: $('.mosaicflow_load').data('width'),
					itemHeightCalculation: 'attribute'
				});
				clearInterval(mLoad);
			}
		}, 500);
	}

	$('.image_deferred:not(.built)').each(function() {
		var t = $(this),
			src = t.data('src'),
			i = new Image();

		t.addClass('built');
		if (!src) {
			t.addClass('no_image');
			return;
		}

		t.addClass('has_image');
		i.onerror = function(e, u) {
			t.replaceWith('');
		};
		i.onload = function(e) {
			t.attr('src', src);
		};
		i.src = src;
	});

	$('.image_load:not(.built)').each(function() {
		var t = $(this),
			src = t.data('src'),
			i = new Image();

		t.addClass('built');
		if (!src) {
			t.addClass('no_image');
			return;
		}

		t.addClass('has_image');
		i.onload = function(e) {
			t.css('background-image', 'url(' + src + ')');
		};
		i.src = src;
	});

	if ($('.moderate_link').length) {
		$('.moderate_link:not(.built)').each(function() {
			var t = $(this),
				parents,
				html = '',
				obj;
      var location = t.data('id');
      if (location=='mod'){
        t.html('<i class="fa"></i>');
      }
			t.addClass('built');
			if (t.parents('.table_row:first').length) {
				parents = t.parents('.table_row:first').parent();
			}
			else {
				parents = t.parents('article:first');
			}

			obj = $('<div class="_moderator">' + html + '</div>');

			// html += t.clone();

			parents.before(obj);
			// parents.find('.')

			if (t.parent().find('.row_edit_bar_parent').length) {

				t.parent().find('.row_edit_bar_parent').prependTo(obj);
			}
			t.prependTo(obj);
      if (location == 'user'){
        //t.parent().remove();
      }
		});
	}


	// Confirm before deleting an item
	$('.sJsConfirm').click(function()
	{
		if (confirm(getPhrase('core.are_you_sure')))
		{
			return true;
		}
		return false;
	});
	
	$('#select_lang_pack').click(function()
	{
		tb_show(oTranslations['core.language_packages'], $.ajaxBox('language.select', 'height=300&amp;width=300'));
		
		return false;
	});	
	
	if (!oCore['core.is_admincp'])
	{
		if ($('#country_iso').length > 0 && !empty(oCore['core.country_iso']))
		{			
			if (empty($('#country_iso').val()))
			{
				$('#js_country_iso_option_' + oCore['core.country_iso']).attr('selected', true);			
			}	
		}
	}

	$('.js_item_active').each(function() {
		var t = $(this).find('input'),
			i = t.parents('.item_is_active_holder:first');

		if (t.prop('checked')) {
			if (t.parent().hasClass('item_is_active')) {
				i.addClass('item_selection_active');
			}
			else {
				i.addClass('item_selection_not_active');
			}
		}
		else {

		}
	});
	
    $('.js_item_active').click(function()
    {
	    var p = $(this).parents('.item_is_active_holder:first');

	    p.removeClass('item_selection_active').removeClass('item_selection_not_active');
    	$(this).parent().find('.js_item_active input').prop('checked', false);
    	if ($(this).hasClass('item_is_active'))
    	{
    		$(this).parent().find('.item_is_active input').prop('checked', true);
		    p.addClass('item_selection_active');
    	}
    	else
    	{
    		$(this).parent().find('.item_is_not_active input').prop('checked', true);
		    p.addClass('item_selection_not_active');
    	}

	    $(this).parent().find('.item_is_active input').trigger('change');
    }); 
    
    if ($('.moderate_link').length > 0)
	{   
		$('.moderation_drop').unbind('click');  
    	$('.moderation_drop').click(function() 
    	{   
    		if (parseInt($('.js_global_multi_total').html()) === 0)
    		{
    			return false;
    		}
    	
    		if ($(this).hasClass('is_clicked'))
    		{
    			$('.moderation_holder ul').hide();
    			$(this).removeClass('is_clicked');
    		}
    		else
    		{
    			$('.moderation_holder ul').show();
    			$('.moderation_holder ul').css({'margin-top': '-' + ($(this).height() + $('.moderation_holder ul').height() + 4) + 'px'});
    			$(this).addClass('is_clicked');    			
    		}
    	
    		return false;
    	});
    
    	var iEmptyModLinks = 0;
    	$('.moderate_link').each(function()
    	{
    		var sName = 'js_item_m_' + $(this).attr('rel') + '_' + $(this).attr('href').replace('#', '');
    		if (getCookie(sName))
			{
     			$(this).addClass('moderate_link_active');     		
			}
    		else
    		{
    			iEmptyModLinks++;
    		}
    	});
    	
    	if (iEmptyModLinks === 0)
    	{
    		$('.moderation_action_unselect').show();
    		$('.moderation_action_select').hide();
    	}
    }
    
    $('.moderation_process_action').click(function()
    {		
		if ($(this).attr('rel') == 'mail.mailThreadAction' && $(this).attr('href').replace('#', '') == 'forward'){
			var sGlobalModeration = '';			
			$('.js_global_item_moderate').each(function(){
				sGlobalModeration += ',' + parseInt($(this).val());
			});
			$Core.box('mail.compose', 500, 'forward_thread_id=' + $('#js_forward_thread_id').val() + '&forwards=' + sGlobalModeration);
			$Core.moderationLinkClear();
		}
		else if ($(this).attr('rel') == 'mail.archive' && $(this).attr('href').replace('#', '') == 'export'){
			$(this).parents('form:first').submit();	
			$Core.moderationLinkClear();
		}
		else if ($(this).attr('rel') == 'mail.moderation' && $(this).attr('href').replace('#', '') == 'move'){
			$Core.box('mail.listFolders', 400);
		}
		else{
			$('.moderation_process').show();
			$('#js_global_multi_form_holder').ajaxCall($(this).attr('rel'), 'action=' + $(this).attr('href').replace('#', ''));			
			$Core.moderationLinkClear();
		}    	
		
    	return false;
    });
    
    $('.moderation_clear_all').click(function()
    {
    	$Core.moderationLinkClear();

    	return false;
    });
    
    $('.moderation_action').click(function()
    {    	
    	var sType = $(this).attr('rel');
    	
    	$(this).hide();
    	
    	if (sType == 'select')
    	{
	    	$('.moderation_action_unselect').show();	    	
    	}
    	else
    	{
			$('.moderation_action_select').show();
    	}
    	
	    $('.moderate_link').each(function()
	    {
			$Core.moderationLinkClick(this, sType);
	    });    	
    	
    	return false;
    });
    
    $('.moderate_link').unbind('click');
    $('.moderate_link').click(function()
    {
    	return $Core.moderationLinkClick(this);
    });
    
    $('.page_section_menu ul li a').click(function()
    {
		var sRel = $(this).attr('rel');
    	if (empty(sRel))
    	{
			return true;		
		}
    	$('.page_section_menu ul li').removeClass('active');
    	$('.page_section_menu_holder').hide();
    	$('#' + sRel).show();
    	$(this).parent().addClass('active');
    	
    	if ($('#page_section_menu_form').length > 0)
    	{
    		$('#page_section_menu_form').val(sRel);
    	}
    		
    	return false;
    });
    
    if ($('.js_date_picker').length > 0)
    {
		var sFormat = oParams['sDateFormat'];
		
		sFormat = sFormat.charAt(0) + '/' + sFormat.charAt(1) + '/' + sFormat.charAt(2);
		sFormat = sFormat.replace('D','d').replace('M','m').replace('Y','yy');
		
		$('.js_date_picker').datepicker('destroy');
		$('.js_date_picker').datepicker(
		{			
			dateFormat: sFormat,
			// minDate: new Date(oParams['user.date_of_birth_start'], new Date().getMonth(), new Date().getDate()), 
			// maxDate: new Date(oParams['user.date_of_birth_end'], new Date().getMonth(), new Date().getDate()), 
			onSelect: function(dateText, inst) 
			{
				var aParts = explode('/', dateText);				
				var sMonth;
				var sDay;
				var sYear;
				
				switch (oParams['sDateFormat']){
					case 'YMD':
						sMonth = ltrim(aParts[1], '0');
						sDay = ltrim(aParts[2], '0');
						sYear = aParts[0];						
						break;
					case 'DMY':
						sMonth = ltrim(aParts[1], '0');
						sDay = ltrim(aParts[0], '0');
						sYear = aParts[2];						
						break;						
					default:
						sMonth = ltrim(aParts[0], '0');
						sDay = ltrim(aParts[1], '0');
						sYear = aParts[2];
						break;
				}

				$(this).parents('.js_datepicker_holder:first').find('.js_datepicker_month').val(sMonth);
				$(this).parents('.js_datepicker_holder:first').find('.js_datepicker_day').val(sDay);
				$(this).parents('.js_datepicker_holder:first').find('.js_datepicker_year').val(sYear);
			}
		});
		
		
		$('.js_datepicker_image').each(function(){
		$(this).click(function(){
		 $(this).parent().find('.js_date_picker').datepicker('show');
		});
		});

    }
	
	$('#js_login_as_page').click(function(){
		$Core.box('pages.login', 500);
		return false;
	});
	
	$('.mobile_view_options').click(function(){
		$('#js_mobile_form_holder').toggle();
		
		return false;
	});

	if (typeof $.browser != 'undefined' && $.browser.msie && parseInt($.browser.version, 10) < 8 && !getParam('bJsIsMobile')){
		$('#js_update_internet_explorer').show();
	}
};

$Core.pageSectionMenuShow = function(sId)
{
	$('.page_section_menu_holder').hide();
	$('.page_section_menu ul li').removeClass('active');
	$(sId).show();
	$('.page_section_menu ul li a').each(function()
	{
		if ($(this).attr('rel') == sId.replace('#', ''))
		{
			$(this).parent().addClass('active');
			
			return false;
		}
	});
};

$Core.moderationLinkClear = function()
{
	var aCookies = document.cookie.split(';');
	$(aCookies).each(function(sKey, sValue)
	{
		if (sValue.match(/js_item_m/i))
		{
			var aParts = explode('=', sValue);
			
			deleteCookie(trim(aParts[0].replace(getParam('sJsCookiePrefix'), '')));
		}
	});
	
	$('.moderate_link').removeClass('moderate_link_active');
	$('#js_global_multi_form_ids').html('');
	$('.js_global_multi_total').html('0');
	$('.moderation_drop').addClass('not_active');
	$('.moderation_holder ul').hide();
	$('.moderation_action_unselect').hide();
	$('.moderation_action_select').show();	
};

$Core.moderationLinkClick = function(oObj, sType)
{
	var sName = 'js_item_m_' + $(oObj).attr('rel') + '_' + $(oObj).attr('href').replace('#', '');
	var iTotalItems = parseInt($('.js_global_multi_total').html());
	
	if (($(oObj).hasClass('moderate_link_active') && sType != 'select') || sType == 'unselect')
	{
		$(oObj).removeClass('moderate_link_active');
		$('#js_global_multi_form_ids').find('.' + sName).remove();
		deleteCookie(sName);
		iTotalItems--;
	}
	else
	{
		if (!$(oObj).hasClass('moderate_link_active'))
		{
			$(oObj).addClass('moderate_link_active');
			$('#js_global_multi_form_ids').append('<div class="' + sName + '"><input class="js_global_item_moderate" type="hidden" name="item_moderate[]" value="' + $(oObj).attr('href').replace('#', '') + '" /></div>');
			setCookie(sName, $(oObj).attr('rel') + '_' + $(oObj).attr('href').replace('#', ''), 1);
			iTotalItems++;
		}
	}    
	iTotalItems = $('.moderate_link_active').length;
	$('.js_global_multi_total').html(iTotalItems);
	
	if (iTotalItems)
	{
		$('.moderation_drop').removeClass('not_active');
	}
	else
	{
		$('.moderation_drop').addClass('not_active');
	}
	
	return false;	
};

$Behavior.privacySettingDropDown = function()
{	
	$('body').click(function()
	{
		$('.privacy_setting_active').each(function()
		{
			if ($(this).hasClass('is_active'))
			{
				$(this).parent().find('.privacy_setting_holder').hide();			
				$(this).removeClass('is_active');			
			}			
		});	
	});	
	
	$('.privacy_setting_active').click(function()
	{		
		var $oParent = $(this).parent().find('.privacy_setting_holder');
		
		if ($(this).hasClass('is_active'))
		{
			$oParent.hide();
			$(this).removeClass('is_active');
		}
		else
		{
			$('.privacy_setting_active').each(function()
			{
				if ($(this).hasClass('is_active'))
				{
					$(this).parent().find('.privacy_setting_holder').hide();			
					$(this).removeClass('is_active');			
				}			
			});					
			$oParent.show();
			$(this).addClass('is_active');
		}
		
		$('#js_global_tooltip').hide()
			.html('')
			.css('top', '0px')
			.css('left', '0px');		
		
		return false;
	});
		
	$('.privacy_setting_holder ul li a').click(function()
	{		
		var $oParent = $(this).parents('.privacy_setting_div:first').find('.privacy_setting_active');
		var $sContent = $(this).html();
		
		if ($sContent.toLowerCase().indexOf('<span>') > -1)
		{
			var $aParts = explode('<span>', $sContent);
			if (!isset($aParts[1]))
			{
				$aParts = explode('<SPAN>', $sContent);	
			}
			
			$sContent = $aParts[0];
		}		
		
		$oParent.html('' + $sContent + '<span class="js_hover_info">' + $sContent + '</span>');
		
		$(this).parents('.privacy_setting_div:first').find('.privacy_setting_holder').hide();
		$oParent.removeClass('is_active');
		
		$(this).parents('.privacy_setting_div:first').find('input').val($(this).attr('rel'));
		
		$('.privacy_setting_holder ul li a').removeClass('is_active_image');
		$(this).addClass('is_active_image');	
		
		return false;
	});	
};

var cacheShadownInfo = false;
var shadow = null;
var minHeight = null;
$Core.resizeTextarea = function(oObj)
{
	if (cacheShadownInfo === false)
	{	
		var lineHeight = oObj.css('lineHeight');
		minHeight = oObj.height();		
		cacheShadownInfo = true;
        shadow = $('<div></div>').css(
        {
			position:   'absolute',
			top:        -10000,
			left:       -10000,
			width:      oObj.width(),
			fontSize:   oObj.css('fontSize'),
			fontFamily: oObj.css('fontFamily'),
            lineHeight: oObj.css('lineHeight'),
			resize:     'none'
		}).appendTo(document.body);            
	}        
                
	var val = oObj.val().replace(/</g, '&lt;')
		.replace(/>/g, '&gt;')
		.replace(/&/g, '&amp;')
		.replace(/\n/g, '<br/>');
                
		shadow.html(val);
		oObj.css('height', Math.max(shadow.height() + 20, minHeight));              
};

$Core.getObjectPosition = function(sId) 
{
	if ($('#' + sId).length <= 0)
	{
		return false;
	}
	
	var curleft = 0;
    var curtop = 0;
    var obj = document.getElementById(sId);
    if (obj.offsetParent) 
    {
    	do 
    	{
        	curleft += obj.offsetLeft;
            curtop += obj.offsetTop;
		} while (obj = obj.offsetParent);
	}
    
	return {left: curleft, top: curtop};
};

$Core.getFriends = function(aParams)
{
	tb_show('', $.ajaxBox('friend.search', 'height=410&width=600&input=' + aParams['input'] + '&type=' + (isset(aParams['type']) ? aParams['type'] : '') + ''));
};

$Core.browseUsers = function(aParams)
{
	tb_show('', $.ajaxBox('user.browse', 'height=410&width=600&input=' + aParams['input'] + ''));
};

$Core.composeMessage = function(aParams)
{
	if (aParams === undefined)
	{
		aParams = new Array();
	}
	
	tb_show('', $.ajaxBox('mail.compose', 'height=300&width=500' + (!isset(aParams['user_id']) ? '' : '&id=' + aParams['user_id']) + '&no_remove_box=true'));
};

$Core.addAsFriend = function(iUserId)
{
	tb_show('', $.ajaxBox('friend.request', 'width=420&user_id=' + iUserId + ''));
	
	return false;
};

$Core.getParams = function(sHref)
{
	var aParams = new Array();
	var aUrlParts = explode('/', sHref);
	var iRequest = 0;
	for (count in aUrlParts)
	{
		if (empty(aUrlParts[count]))
		{
			continue;
		}
			
		aUrlParts[count] = aUrlParts[count].replace('#', '');
		if (aUrlParts[count].match(/_/i))
		{
			var aUrlParams = explode('_', aUrlParts[count]);
				
			aParams[aUrlParams[0]] = aUrlParams[1];
		}
		else
		{
			iRequest++;			

			aParams['req' + iRequest] = aUrlParts[count];		
		}	
	}	
	
	return aParams;	
};

$Core.getRequests = function(sHref, bReturnPath)
{
	var sParams = '';	
	var sUrlString = '';
	var sModuleName = oCore['core.section_module'];	
	
	switch (oCore['core.url_rewrite'])
	{
		case '1':
			if (getParam('sHostedVersionId') == ''){
				var oReq = new RegExp("" + getParam('sJsHome') + "(.*?)$","i");
				var aMatches = oReq.exec(sHref + (getParam('sHostedVersionId') == '' ? '' : getParam('sHostedVersionId') + '/'));
				var aParts = explode('/', aMatches[1]);
										
				sUrlString = '/' + aMatches[1];				
			}
			else {						
				var aParts = explode('/', ltrim(sHref.pathname, '/'));										
				sUrlString = sHref.pathname;				
			}					
			break;
		case '3':
			if (oCore['profile.is_user_profile'])
			{
				var aProfileMatches = sHref.match(/http:\/\/(.*?)\.(.*?)/i);
				sModuleName = aProfileMatches[1];
			}		
		
			var oReq = new RegExp("" + oParams['sJsHome'] + "(.*?)$","i");
			var aMatches = oReq.exec(sHref);
			
			sUrlString = sModuleName + '/' + (aMatches != null && isset(aMatches[1]) ? aMatches[1] : '');		
			break;
		default:
			var oReq = new RegExp("(.*?)=\/(.*?)$","i");
			var aMatches = oReq.exec(sHref);	
			if (aMatches !== null)
			{		
				var aParts = explode('/', aMatches[2]);		
				
				sUrlString = aMatches[2];
			}
					
			break;
	}	
	
	if (bReturnPath === true)
	{
		return '/' + ltrim(sUrlString, '/');
	}	
	
	return $Core.parseUrlString(sUrlString);
};

$Core.parseUrlString = function(sUrlString)
{
	var sParams = '';
	var aUrlParts = explode('/', sUrlString);
	var iRequest = 0;
	var iLoadCount = 0;
	
	for (count in aUrlParts)
	{
		if (empty(aUrlParts[count]) || aUrlParts[count] == '#')
		{
			continue;
		}		
		
		iLoadCount++;
		
		if (iLoadCount != 1 && aUrlParts[count].match(/_/i))
		{
			var aUrlParams = explode('_', aUrlParts[count]);
				
			sParams += '&' + aUrlParams[0] + '=' + aUrlParams[1];	
		}
		else
		{
			iRequest++;
			
			sParams += '&req' + iRequest + '=' + aUrlParts[count];						
		}	
	}	
	
	return sParams;
};

$Core.reverseUrl = function(sForm, aSkip)
{	
	var aForms = explode('&', sForm);	
	var sUrlParam = '';	
	for (count in aForms)
	{			
		var aFormParts = aForms[count].match(/(.*?)=(.*?)$/i);
		if (aFormParts !== null)
		{			
			if (isset(aSkip))
			{				
				if (in_array(aFormParts[1], aSkip))
				{					
					continue;
				}
			}
				
			sUrlParam += aFormParts[1] + '_' + encodeURIComponent(aFormParts[2]) + '/';
		}
	}		
		
	return sUrlParam;
};

$Core.getHashParam = function(sHref)
{
	var sParams = '';
	var aParams = $.getParams(sHref);
	
	for (var sKey in aParams)
	{
		sParams += '&' + sKey + '=' + aParams[sKey];
	}
	sParams = ltrim(sParams, '&');
	
	return sParams;
};

$Core.box = function($sRequest, $sWidth, $sParams)
{
	tb_show('', $.ajaxBox($sRequest, 'width=' + $sWidth + ($sParams ? '&' + $sParams : '')));	
	
	return false;
};

$Core.ajax = function(sCall, $oParams)
{
	var sParams = '&' + getParam('sGlobalTokenName') + '[ajax]=true&' + getParam('sGlobalTokenName') + '[call]=' + sCall;
	
	if (!sParams.match(/\[security_token\]/i))
	{
		sParams += '&' + getParam('sGlobalTokenName') + '[security_token]=' + oCore['log.security_token'];
	}
	
	if (isset($oParams['params']))
	{
		if (typeof($oParams['params']) == 'string')
		{
			sParams += $oParams['params'];
		}
		else		
		{
			$.each($oParams['params'], function($sKey, $sValue)
			{
				sParams += '&' + $sKey + '=' + encodeURIComponent($sValue) + '';
			});
		}		
	}
	
	$.ajax(
	{
		type: (isset($oParams['type']) ? $oParams['type'] : 'GET'),
		url: getParam('sJsStatic') + "ajax.php",
		dataType: 'html',
		data: sParams,
		success: $oParams['success']
	});	
};

$Core.popup = function(sUrl, aParams)
{
	oDate = new Date();
	iId = oDate.getTime();
	var sParams = '';
	var iCount = 0;
	var bCenter = false;
	for (count in aParams)
	{
		if (count == 'center')
		{
			bCenter = true;
			continue;
		}
		
		iCount++;
		if (iCount != 1)
		{
			sParams += ',';
		}	
		
		sParams += count + '=' + aParams[count];
	}
	
	if (bCenter === true)
	{
		sParams += ',left=' + (($(window).width() - aParams['width']) / 2) + ',top=' + (($(window).height() - aParams['height']) / 2) + '';
	}
	
	window.open(sUrl, iId, sParams);
};

$Core.processing = function()
{
	$('.ajax_processing').remove();
	$('body').prepend('<div class="ajax_processing"><i class="fa fa-spin fa-circle-o-notch"></i></div>');
};

$Core.processingEnd = function() {
	$('.ajax_processing').fadeOut();
};

$Core.ajaxMessage = function()
{
	$('#global_ajax_message').html('<i class="fa fa-spin fa-circle-o-notch"></i>').show();
};

/**
 * Used for the accordion effect on sections with many categories
 */
$Core.toggleCategory = function(sName, iId)
{
    $('.' + sName).toggle();
    $('#show_more_' + iId).toggle();
    $('#show_less_' + iId).toggle();  	
};

if (substr(window.location.hash, 0, 2) == '#!')
{
	if (oCore['core.url_rewrite'] == '1')
	{
		var sUrl = trim(getParam('sJsHome'), '/');
	}
	else
	{
		var sUrl = getParam('sJsHome') + 'index.php?' + getParam('sGetMethod') + '=';
	}
	
	window.location = sUrl + window.location.hash.replace('#!', '');	 
}

$Core.page = function(url) {
	PF.event.trigger('on_page_change_start');

	// p(url);
	$.ajax({
		url: url,
		contentType: 'application/json',
		complete: function(e) {
			if (e.responseText.substr(0, 1) != '{') {
				eval(e.responseText);
				return;
			}

			e = $.parseJSON(e.responseText);

			$Core.show_page(e);
		}
	});
};

if (!isset(page_editor_meta)) {
	var page_editor_meta;
}

var cacheCurrentBody = null;
$Core.show_page = function($aParams)
{
	if (typeof CorePageAjaxBrowsingStart == 'function')
	{
		CorePageAjaxBrowsingStart($aParams);
	}
	
	if (isset($aParams['phrases']))
	{
		for (sKey in $aParams['phrases'])
		{
			if (!isset(oTranslations[sKey]))
			{
				oTranslations[sKey] = $aParams['phrases'][sKey];
			}
		}
	}
	
	$('.js_user_tool_tip_holder').remove();
	
	$('#js_user_profile_css').remove();
	
	
	if (isset($aParams['profilecss'])){
		$('body').append($aParams['profilecss']);
	}		
	
	if (!empty($aParams['files']))
	{
		$Core.loadStaticFiles($aParams['files']);
	}

	if ($aParams['keep_body']) {
		cacheCurrentBody = {
			contentObject: $('#content').html(),
			main: $('#main').html(),
			scrollTop: $(window).scrollTop(),
			id: $('body').attr('id'),
			title: document.title,
			class: $('body').attr('class'),
			url: window.location.href
		};
	}
	else {
		cacheCurrentBody = null;
	}

	for (var location in $aParams['blocks']) {
		$('._block[data-location="' + location + '"]').html('');
		for (var i in $aParams['blocks'][location]) {
			$('._block[data-location="' + location + '"]').append($aParams['blocks'][location][i]);
		}
	}

	$('#public_message').remove();
	$('._block_menu_sub').html($aParams['menuSub']);
	$('._block_top').html($aParams['search']);
	$('._block_breadcrumb').html($aParams['breadcrumb']);
	$('._block_h1').html($aParams['h1']);
	$('._block_error').html($aParams['error']);

	// controller_e
	if ($('#page_editor_popup').length) {
		page_editor_meta = $aParams['meta'];
		$('#page_editor_popup').attr('href', $aParams['controller_e']);
	}

	$('body').attr('id', 'page_' + $aParams['id']);
	$('body').attr('class', $aParams['class']);

	if (isset($aParams['customcss'])){
		var sCustomCss = '';
		$('#js_global_custom_css').remove();
		for (sKey in $aParams['customcss']){
			sCustomCss += $aParams['customcss'][sKey];
		}
		if (!empty(sCustomCss)){
			// $('body').append()
		}
	}

	var pageTitle = $aParams['title'].replace(new RegExp('&#039;s', 'g'), "'");
	if (self == top) {
		document.title = pageTitle;
	}
	else {
		window.parent.document.title = pageTitle;
	}
	
	$('._block_content').html('' + $aParams['content'] + '');

	$('body').css('cursor', 'auto');

	PF.event.trigger('on_page_change_end');
	
	// $oEventHistory[($Core.hasPushState() ? $Core.getRequests(window.location, true) : window.location.hash.replace('#!', ''))] = $aParams['content'];
	
	$Core.loadInit();
	
	scroll(0,0);
	
	$Behavior.loadTinymceEditor = function () {};
};

$Behavior.fixLayoutGrid  = function(){

	var emptyLeft = $('#left .block').length == 0,
		emptyRight = $('#right .block').length == 0,
		main  = $('#main'),
		holder = $('#content-holder');


	main[emptyLeft?'addClass':'removeClass']('empty-left');
	main[emptyRight?'addClass':'removeClass']('empty-right');

	if($('section#site-header').length){
		$('#content-holder').css({
			minHeight: Math.max($(window).height() - $('section#site-header').height()  - $('footer').height(), $('#left').height())
		});
	}

	// remove collapse
	$('.collapse.in').removeClass('in');

	// toggle sub blocks
	$('#left .block .title, #right .block .title').click(function(){
		$(this).closest('.block').toggleClass('open');
	});
}

$Core.updatePageHistory = function()
{
	var $sLocation = window.location.hash.replace('#!', '');
	if (empty($sLocation))
	{
		$sLocation = '/';
	}
		
	$oEventHistory[$sLocation] = $('#main_content_holder').html();
};

$Behavior.janRainLoader = function(){	
	$('._a_back').click(function() {
		$('.imgareaselect-outer').remove();
		$('.imgareaselect-selection').each(function() {
		   $(this).parent().remove();
		});
		
		if (typeof(cacheCurrentBody.main) == 'string') {
			$('#main').html(cacheCurrentBody.main);
			$('body').attr('id', cacheCurrentBody.id);
			history.pushState(null, null, lastPushState);
			$('html, body').animate({
				scrollTop: cacheCurrentBody.scrollTop
			}, 400);
			$Core.loadInit();
		}
	});
};

var bAjaxLinkIsClicked = false;
var bCanByPassClick = false;
var sClickProfileName = '';
var lastPushState;
$Behavior.linkClickAll = function()
{
	if (!$Core.hasPushState() || $('#admincp_base').length) {
		return;
	}
	
	$('a, ._a').click(function(e)
	{
		// fix issue hold command on click to open new tab instead of ajax
		if(e.metaKey || e.ctrlKey || e.altKey)
			return;

		var $sLink = $(this).attr('href');
		if (!$sLink) {
			$sLink = $(this).data('href');
		}
		
		if (!$sLink)
		{
			return;
		}

		if ((substr($sLink, 0, 7) != 'http://' && substr($sLink, 0, 8) != 'https://')
			|| substr($sLink, -1) == '#'
			|| $sLink == '#'
		)
		{
			return;
		}

		if ($(this).hasClass('no_ajax_link')
			|| $(this).hasClass('thickbox')
			|| $(this).hasClass('popup')
			|| $(this).hasClass('ajax')
			|| $(this).hasClass('no_ajax')
			|| $(this).hasClass('inlinePopup')
			|| $(this).hasClass('sJsConfirm'))
		{
			return;
		}

		var $aUrlParts = parse_url($sLink);
		
		if ($aUrlParts['host'] != getParam('sJsHostname'))
		{
			return;
		}
		
		if (!isset($aUrlParts['query']))
		{
			var sTempHost = $aUrlParts['scheme'] + '://' + $aUrlParts['host'] + $aUrlParts['path'];
			$aUrlParts['query']	= sTempHost.replace(getParam('sJsHome'), '/');
		}

		if (isset($aUrlParts['query']))
		{
			var aUrlParts = explode('/', $aUrlParts['query']);
			if (aUrlParts[1] == 'user' && aUrlParts[2] == 'logout')
			{
				return;
			}			
		}
		
		if (bCanByPassClick === true && aUrlParts[1] != sClickProfileName){
			bCanByPassClick = false;
			return;
		}
		
		if ($('#noteform').length > 0)
		{
 			$('#noteform').hide(); 
		}

		if ($('#user_profile_photo').length > 0)
		{
 			$('#user_profile_photo').imgAreaSelect({ hide: true });		
		}	
		
		$('.ajax_link_reset').hide();
		$('#core_js_messages').html('');
		
		bAjaxLinkIsClicked = true;
		
		$('body').css('cursor', 'wait');

		$(document).trigger('pageChangeStart');

		$('#header_menu a.menu_is_selected').removeClass('menu_is_selected');
		if ($(this).parents('#header_menu:first').length) {
			$(this).addClass('menu_is_selected');
		}
		
		$('.js_user_tool_tip_holder').hide();
		$('#js_global_tooltip').hide();
		
		$(this).addClass('is_built');
		
		if (typeof BehaviorlinkClickAllAClick == 'function')
		{
			var bReturn = BehaviorlinkClickAllAClick($aUrlParts);
			if (bReturn == true)
			{
				return false;
			}
		}

		if (cacheCurrentBody === null) {
			lastPushState = window.location.href;
		}

		if (self == top) {
			history.pushState(null, null, $sLink);
		}
		else {
			window.parent.history.pushState(null, null, $sLink);
		}

		$Core.page($sLink);
					
		return false;
	});
};

$Core.loadInit = function(forceIt)
{
	if ($Core.dynamic_js_files > 0 && forceIt !== true)
	{
		setTimeout(function(){ 
			$Core.loadInit();
		}, 20);

		return false;
	}
	
	//debug('$Core.loadInit() Loaded');
	
	$('*:not(.star-rating, .dont-unbind)').unbind();
	
	$.each($Behavior, function() 
	{		
		this(this);
	});
};

$(window).load(function(){
    if ($('.nano').length) {
      $('.nano, .nano-content').addClass('dont-unbind');
      $('.nano').css('visibility', 'visible').nanoScroller();
      $('.nano, .nano-content, .nano-pane').addClass('dont-unbind');
    }
});
$Core.init = function()
{
	if ($Core.hasPushState())
	{
		window.addEventListener("popstate", function(e) {
			$Core.page(document.location.href);
		});
	}

	$bDocumentIsLoaded = true;
	$(document).ready(function()
	{
    if ($('.nano').length) {
      $('.nano').css('visibility', 'visible').nanoScroller();
      $('.nano, .nano-content, .nano-pane').addClass('dont-unbind');
    }

		$.each($Behavior, function() 
		{
			this(this);
		});

		$.each($Events, function() {
			this(this);
		});
	});    
	
    $('script,link').each(function()
	{			
		if (!empty(this.src))
		{
			var $sVar = this.src;
				
			if (this.src.indexOf('f=') !== -1)
			{
				var $aFiles = explode('f=', $sVar);
				var $aParts = explode('&v=', $aFiles[1]);
				var $aGetFiles = explode(',', $aParts[0]);
				$($aGetFiles).each(function($sKey, $sFile)
				{
					if (substr($sFile, 0, 7) == 'module/')
					{
						$oStaticHistory[getParam('sJsHome') + $sFile] = true;
					}
					else
					{
						$oStaticHistory[getParam('sJsStatic') + 'jscript/' + $sFile] = true;
					}
				});
				return;
			}				
		}
		else if (!empty(this.href))
		{
			var $sVar = this.href;	
			
			if (this.href.indexOf('f=') !== -1)
			{
				var $aFiles = explode('f=', $sVar);
				var $aParts = explode('&v=', $aFiles[1]);
				var $aGetFiles = explode(',', $aParts[0]);
				$($aGetFiles).each(function($sKey, $sFile)
				{
					$oStaticHistory[getParam('sJsHome') + $sFile] = true;
				});
				return;
			}
		}
		
		if (!empty($sVar))
		{
			var $aParts = explode('?', $sVar);				
			$oStaticHistory[$aParts[0]] = true;	
		}
	});
		
	if (isset($Cache['post_static_files']))
	{
		$($Cache['post_static_files']).each(function($sKey, $mValue)
		{
			$Core.loadStaticFiles($mValue);
		});
	}
};

$Core.hasPushState = function(){
	return (typeof(window.history.pushState) == 'function' ? true : false);
};

/**
 * Adds a hash to the URL string, which is used to emulate a AJAX page
 *
 * @param object oObject Is the anchor object (this)
 */
$Core.addUrlPager = function(oObject, bShort)
{	
	if ($Core.hasPushState()){
		window.history.pushState('', '', oObject.href);
	}
	else{
		window.location = '#!' + (bShort ? oObject.href : $Core.getRequests(oObject.href, true));	
	}
};

$Core.reloadPage = function()
{
	/* which is why we have these fallbacks*/
	if (typeof window.location.reload == 'function') window.location.reload();
	else if (typeof history != 'undefined' && history.go == 'function') history.go(0);	
};

$Behavior.addExpanderListener  =  function(){
	$(document).on('click','[data-expand="expander"]',function(){
		var $this =  $(this),
			target =  $($this.data('target'));
		if(target.length){
			target.toggleClass('close');
		}
	});

	var hd  = $('#section-header'), ft = $('#section-footer'), st = $('#content-stage');

	if(hd.length && ft.length && st.length)
	{
		$('#content-stage').css({
			minHeight: Math.max($(window).height() - hd.height() - ft.height(), $('#left').outerHeight(), $('#right').outerHeight())
		});
	}
};

$Behavior.addModerationListener = function()
{
	var m = $('#public_message');
	if (m.length) {
		var h = m.html().length;
		if (h) {
			m.show();
			m.animate({
				'margin-bottom': '0px'
			}, 'fast', function() {
				setTimeout(function() {
					m.animate({'margin-bottom': '-50px'}, 'fast', function() {
						m.html('').hide();
					});
				}, 1100);
			});
		}
	}

	$(window).on('moderation_ended', function(){
		/* Search for moderation rows */
		if ($('.moderation_row:visible').length < 1)
		{
			if ($('a.pager_previous_link').length > 0 && $('a.pager_previous_link:first').attr('href') != '#')
			{
				window.location.href = $('a.pager_previous_link:first').attr('href');
				return;
			}
			
			if ( window.location.href.indexOf('page_1') > (-1) )
			{
				window.location.href = window.location.href.replace('/page_1','');
				return;
			}
			
			return $Core.reloadPage();
			
			/* Check if we have a pager */
						
			if ( $('a.pager_next_link').length > 0)
			{
				if (isset($Core.Pager) && isset($Core.Pager.count) && ($Core.Pager.count - $Core.Pager.size ) > 20)
				{
					window.location.href = $('a.pager_next_link:first').attr('href');
					return;
				}
				window.location.href = $('a.pager_next_link:first').attr('href');
			}
			else
			{
				wndow.location.href=window.location.href;
			}
		}
		else if ( $('.moderation_row:first').is(':animated') )
		{
			setTimeout('$(window).trigger("moderation_ended");', 1000);
		}
		else
		{
			/* console.log('Moderation_rows still exist and are not being animated');*/
		}
	});
};

/* We use the block core.delayed-block as placeholder */
$Behavior.loadDelayedBlocks = function()
{
	if (isset($Core.delayedBlocks) && Object.prototype.toString.call($Core.delayedBlocks).indexOf('Array') > (-1) )
	{
		// we could issue several ajax calls (one per location)
		$.ajaxCall('core.loadDelayedBlocks', 'locations=' + $Core.delayedBlocks.join(','));
	}
	
	/* We load the main content (the middle column) here */
	if ($('#delayed_block').length > 0)
	{	
		if ( //oCore['profile.is_user_profile'] == true || 
			(oParams['sController'] == 'core.index-member') ||
			(oCore['sController'] == 'pages.view'))
		{
			console.log('Behavior.loadDelayedBlock, Dont load the content');			
		}
		else
		{
			var sContent = $('#delayed_block').html();
			// $('#delayed_block').show();
			// Get the params from the url
			// console.log('Behavior.loadDelayedBlock, load ' + sContent);
			var sUrl = $Core.getRequests(window.location.href, true);
			var aUrl = sUrl.split('/');
			var oUrlParams = {};
			var aTemp = [];
			
			for (var count in aUrl)
			{
				if (aUrl[count].indexOf('_') > (-1) )
				{
					aTemp = aUrl[count].split('_');
					oUrlParams[aTemp[0]] = aTemp[1];
				}
				oUrlParams['req' + j] = aUrl[count];
			}
			var sParams = $.param({params: oUrlParams});
			
			//setTimeout(function(){	/* Uncomment to test */
				$.ajaxCall('core.loadDelayedBlocks', 'loadContent=' + sContent + '&' + sParams, 'GET');
			// }, 2000);
		}
	}
	/* Any extra delayed loading is done here, for example with the comments */
	if ($('.load_delayed'). length > 0)
	{
		var oGet = {};
		$('.load_delayed').each(function(){
			if ($(this).attr('id') == undefined || $(this).attr('id').length < 1)
			{
				$(this).attr('id', 'load_delayed_' + Math.floor(Math.random() * 999));
			}
			oGet[$(this).find('.block_id').html()] = {
				block_id: $(this).find('.block_id').html(),
				block_name: $(this).find('.block_name').html(), 
				block_param: $(this).find('.block_param').html()
			};
		});
		var sParams = encodeURIComponent(JSON.stringify(oGet));
		//console.log(sParams);
		//setTimeout(function(){	/* Uncomment to test */
			$.ajaxCall('core.loadDelayedBlocks', 'delayedTemplates=' + sParams, 'GET');
		// }, 2000);
	}	
};

		/************************ Compatibility Features (Mostly due to IE8) *******************************/
/* Production steps of ECMA-262, Edition 5, 15.4.4.19
   Reference: http://es5.github.com/#x15.4.4.19
   Taken from https://developer.mozilla.org/en-US/docs/JavaScript/Reference/Global_Objects/Array/map
*/
if (!Array.prototype.map) {
  Array.prototype.map = function(callback, thisArg) {
 
    var T, A, k;
 
    if (this == null) {
      throw new TypeError(" this is null or not defined");
    }
    var O = Object(this);
    var len = O.length >>> 0;
    if (typeof callback !== "function") {
      throw new TypeError(callback + " is not a function");
    }
    if (thisArg) {
      T = thisArg;
    }
    A = new Array(len);
    k = 0;
    while(k < len) {
 
      var kValue, mappedValue;
      if (k in O) {
 
        kValue = O[ k ];
        mappedValue = callback.call(T, kValue, k, O);
        A[ k ] = mappedValue;
      }
      k++;
    }
    return A;
  };      
}
/* Taken from https://developer.mozilla.org/en-US/docs/JavaScript/Reference/Global_Objects/Array/filter */
if (!Array.prototype.filter)
{
  Array.prototype.filter = function(fun /*, thisp */)
  {
    "use strict";
 
    if (this == null)
      throw new TypeError();
 
    var t = Object(this);
    var len = t.length >>> 0;
    if (typeof fun != "function")
      throw new TypeError();
 
    var res = [];
    var thisp = arguments[1];
    for (var count = 0; count < len; count++)
    {
      if (count in t)
      {
        var val = t[count];
        if (fun.call(thisp, val, j, t))
          res.push(val);
      }
    }
 
    return res;
  };
}
