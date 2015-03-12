
var $iBoxTotalOpen = 0;
var $iCurrentZIndex = 1;
var $aBoxHistory = {};
var iImageIterationCount = 0;
var iCurrentImageIterationCount = 0;
var $sCurrentId = null;
var sLastOpenUrl = null;
var bIsPhotoImage = false;

$Behavior.addDraggableToBoxes = function()
{
	if ($('.js_box').length > 0 && !$.ui)
    {
    	$Core.loadStaticFile(getParam('sJsHome') + 'static/jscript/jquery/ui.js');
    }
    
    $('.js_box').each(function()
    {
    	$(this).draggable('destroy');
    	tb_draggable(this);
    });
    
    $('a.thickbox').click(function()
    {
		var aExtra = $(this).html().match(/userid="([0-9a-z]?)"/i);
		var sHref = this.href;
		if (aExtra != null && isset(aExtra[1]))
		{
			sHref += 'userid_' + aExtra[1] + '/';
		}
		
    	var bReturn = tb_show('', sHref, this);
		
		if (bReturn === true){
			return true;
		}
    	
    	return false;
    });    
};

function js_box_remove($oObj)
{
	$('#main_core_body_holder').show();
	
	$('.imgareaselect-outer').remove();
	$('#noteform').remove();
	$('.imgareaselect-border1').remove();
	$('.imgareaselect-border2').remove();
	$('.imgareaselect-border3').remove();
	$('.imgareaselect-border4').remove();
	$('.feed_share_on_item a').removeClass('active');
	
	var $oParent = $($oObj).parents('.js_box:first');
	var $oBoxParent = $($oObj).parents('.js_box_image_holder_full:first');
	var $sLink = $oParent.find('.js_box_history:first').html();
	
	if (isset($aBoxHistory[$sLink]))
	{
		delete $aBoxHistory[$sLink];
	}
	
	$oBoxParent.fadeOut(100, function()
	{
		$(this).remove();
	});	
	$oParent.fadeOut(100, function()
	{
		$(this).remove();
	});
	
	$('#global_attachment_list_inline').hide();
	
	if (bIsPhotoImage){
		bIsPhotoImage = false;
	//	$Core.addUrlPager({'href': sLastOpenUrl.replace('/#!', '')}, true);
	}	
	
	return false;
}

function tb_show_new_image(thisObject, sSrc, imageWidth, imageHeight, iCurrentIte)
{	
	$('.js_box_image_gallery img').removeClass('is_active');
	$(thisObject).find('img').addClass('is_active');
	
	iCurrentImageIterationCount = iCurrentIte;
	
	$('#js_thickbox_core_image').attr({
		'src': sSrc,
		'width': imageWidth,
		'height': imageHeight
	});	
}

function js_box_next_image()
{
	iCurrentImageIterationCount++;
	
	var thisObject = $('#js_next_image_thumb_' + iCurrentImageIterationCount);
		
	if (thisObject.length <= 0)
	{
		iCurrentImageIterationCount = 0;
		
		return js_box_next_image();
	}
	
	var aParts = explode('|', thisObject.attr('rel'));	
	
	tb_show_new_image('#js_next_image_thumb_' + iCurrentImageIterationCount, '' + thisObject.attr('href') + '', aParts[0], aParts[1], iCurrentImageIterationCount);
	
	return false;
}

function tb_show(caption, url, thisObject, sForceMessage, bForceNoCilck, sType) 
{	
	var baseURL;
	if (url.indexOf("?")!==-1)
	{
		baseURL = url.substr(0, url.indexOf("?"));
	}
	else
	{
		baseURL = url;
	}	
	
	var urlString = /\.jpg$|\.jpeg$|\.png$|\.gif$|\.bmp$/;
	var urlType = baseURL.toLowerCase().match(urlString);	
	
	if (urlType == '.jpg' || urlType == '.jpeg' || urlType == '.png' || urlType == '.gif' || urlType == '.bmp')
	{
		imgPreloader = new Image();
		imgPreloader.onload = function()
		{
			imgPreloader.onload = null;
	
			var pagesize = tb_getPageSize();
			var x = pagesize[0] - 150;
			var y = pagesize[1] - 150;
			var imageWidth = imgPreloader.width;
			var imageHeight = imgPreloader.height;
	
			if (imageWidth > x) 
			{
				imageHeight = imageHeight * (x / imageWidth);
				imageWidth = x;
				if (imageHeight > y) 
				{
					imageWidth = imageWidth * (y / imageHeight);
					imageHeight = y;
				}
			} 
			else if (imageHeight > y) 
			{
				imageWidth = imageWidth * (y / imageHeight);
				imageHeight = y;
				if (imageWidth > x) 
				{
					imageHeight = imageHeight * (x / imageWidth);
					imageWidth = x;
				}
			}

			TB_WIDTH = imageWidth + 30;
			TB_HEIGHT = imageHeight + 60;
			
			$('.js_box_image_holder').remove();
			$('.js_box_image_holder').unbind('click');
			
			var sHtml = '';
			sHtml += '<div class="js_box_image_holder"><div class="js_box ' + (oParams['bJsIsMobile'] ? 'mobile_js_box' : '') + ' js_box_image" style="display:block;"><div class="js_box_content">';
			
			if ($(thisObject).parents('.js_box_thumbs_holder').length > 0)
			{	
				var sCurrentSource = $(thisObject).find('img:first').attr('src');
				var sNewSource = '';
				var SubimgPreloaderImageWidth = '';
				var SubimgPreloaderImageHeight = '';
				var SubArrayWidth = new Array();
				var SubArrayHeight = new Array();
				var sSubHtml = '';
				var aUrlParts = new Array();
				var aUrlPartsNew = new Array();
				// p('Current: ' + sCurrentSource);
				
				iImageIterationCount = 0;
				iCurrentImageIterationCount = 0;
				
				sHtml += '<div>';
				$(thisObject).parents('.js_box_thumbs_holder').find('.js_box_image_holder_thumbs').find('.thickbox').each(function()
				{
					iImageIterationCount++;
					sNewSource = $(this).find('img').attr('src');
					
					aUrlParts = explode('_', sCurrentSource);
					aUrlPartsNew = explode('_', sNewSource);						
					
					if (aUrlParts[0] == aUrlPartsNew[0])
					{
						iCurrentImageIterationCount = iImageIterationCount;
					}
					
				//	if (sCurrentSource != sNewSource)		
					{
						SubimgPreloader = new Image();
						
						SubimgPreloader.src = $(this).attr('href');
						
						SubimgPreloaderImageWidth = SubimgPreloader.width;
						SubimgPreloaderImageHeight = SubimgPreloader.height;
				
						if (SubimgPreloaderImageWidth > x) 
						{
							SubimgPreloaderImageHeight = SubimgPreloaderImageHeight * (x / SubimgPreloaderImageWidth);
							SubimgPreloaderImageWidth = x;
							if (imageHeight > y) 
							{
								SubimgPreloaderImageWidth = SubimgPreloaderImageWidth * (y / SubimgPreloaderImageHeight);
								imageHeight = y;
							}
						} 
						else if (imageHeight > y) 
						{
							SubimgPreloaderImageWidth = SubimgPreloaderImageWidth * (y / SubimgPreloaderImageHeight);
							SubimgPreloaderImageHeight = y;
							if (SubimgPreloaderImageWidth > x) 
							{
								SubimgPreloaderImageHeight = SubimgPreloaderImageHeight * (x / SubimgPreloaderImageWidth);
								SubimgPreloaderImageWidth = x;
							}
						}
						
						SubArrayWidth.push(SubimgPreloaderImageWidth);
						SubArrayHeight.push(SubimgPreloaderImageHeight);
						
						sSubHtml += '<a rel="' + SubimgPreloaderImageWidth + '|' + SubimgPreloaderImageHeight + '" id="js_next_image_thumb_' + iImageIterationCount + '" href="' + $(this).attr('href') + '" onclick="tb_show_new_image(this, \'' + $(this).attr('href') + '\', ' + SubimgPreloaderImageWidth + ', ' + SubimgPreloaderImageHeight + ', ' + iImageIterationCount + '); return false;"><img src="' + sNewSource + '" alt="" ' + (aUrlParts[0] == aUrlPartsNew[0] ? ' class="is_active" ' : '') + ' /></a>';
					}
				});
								
				TB_WIDTH = ((Math.max.apply(Math, SubArrayWidth)) + 30);
				TB_HEIGHT = ((Math.max.apply(Math, SubArrayHeight)));				
				
				sHtml += '<div class="js_box_image_holder_browse">';
				sHtml += '<div class="js_box_image_gallery_display" style="height:' + TB_HEIGHT + 'px; line-height:' + TB_HEIGHT + 'px;">';
				sHtml += '<a href="#" onclick="return js_box_next_image();"><img src="' + url + '" width="' + imageWidth + '" height="' + imageHeight + '" alt="" id="js_thickbox_core_image" /></a>';
				sHtml += '</div>';
				sHtml += '<div class="js_box_image_gallery">' + sSubHtml + '</div>';
				sHtml += '</div>';
				
				sHtml += '</div>';
			}
			else
			{
				sHtml += '<a href="#" onclick="$(\'.js_box_image_holder\').remove(); return false;"><img src="' + url + '" width="' + imageWidth + '" height="' + imageHeight + '" alt="" id="js_thickbox_core_image" /></a>';	
			}
			
			sHtml += '</div><div class="js_box_close"><a href="#" onclick="return js_box_remove(this);">' + oTranslations['core.close'] + '</a></div></div></div>';			
			
			$('body').prepend(sHtml);
			
			$('.js_box_image').css(
			{
				top: (($(window).height() - $('.js_box_image').outerHeight()) / 2) + "px",
        		left: (($(window).width() - $('.js_box_image').outerWidth()) / 2) + "px",
        		display: 'block'
			});			
	
			var bCanCloseImageBox = true;		
			
			$('.js_box').click(function()
			{
				bCanCloseImageBox = false;
			});
			
			$('.js_box_image_holder').click(function()
			{
				if (!bCanCloseImageBox)
				{
					bCanCloseImageBox = true;
				}
				else
				{
					$(this).remove();
				}
			});
			
		    if ($.browser.msie && $.browser.version == '7.0')
			{
		    	$Behavior.ie7FixZindex();
			}			
		};
		
		imgPreloader.src = url;
		
		return false;
	}		
	
	var bIsAlreadyOpen = false;
	if ($(thisObject).hasClass('photo_holder_image') && !empty($(thisObject).attr('rel')))
	{
		if (!getParam('bPhotoTheaterMode')){
			return true;
		}
		
		if (getParam('bJsIsMobile')){
			return true;
		}			
		
		if ($Core.exists('.js_box_image_holder_full')){
			$('#photo_view_ajax_loader').show();
		}
		
		sLastOpenUrl = (empty(window.location.hash) ? $Core.getRequests(window.location, true) : '/' + window.location.hash);
		// $Core.addUrlPager(thisObject);		
		var sUserId = url.match(/userid_([0-9]+)/);
		var sAlbumId = url.match(/albumid_([0-9]+)/);		
				
		var queryString = '' + getParam('sGlobalTokenName') + '[call]=photo.view&width=940' + (typeof sPhotoCategory != 'undefined' ? '&category=' + sPhotoCategory : '') + '&req2=' + $(thisObject).attr('rel') + '&theater=true&no_remove_box=true' + (sUserId != null && isset(sUserId[1]) ? '&userid='+sUserId[1] :'') + (sAlbumId != null && isset(sAlbumId[1]) ? '&albumid='+sAlbumId[1] :'');
		var params = tb_parseQuery(queryString);
		
		bIsPhotoImage = true;
		if (isset($aBoxHistory[params['' + getParam('sGlobalTokenName') + '[call]']]))
		{
			bIsAlreadyOpen = true;	
		}
		
		if ($('#noteform').length > 0)
		{
 			$('#noteform').hide(); 
		}
		if ($('#js_photo_view_image').length > 0)
		{
 			$('#js_photo_view_image').imgAreaSelect({ hide: true });		
		}		
	}
	else
	{
		if ($Core.exists('.js_box_image_holder_full')){
			js_box_remove($('.js_box_image_holder_full').find('.js_box_content:first'));
		}
		
		if (url.indexOf('#') != -1)
		{
			var aParams = url.split('#');
			url = '#' + aParams[1];			
		}
				
		var queryString = url.replace(/^[^\?]+\??/,'');					
		var params = tb_parseQuery(queryString);
	}
	
	if (!bIsPhotoImage && isset($aBoxHistory[params['' + getParam('sGlobalTokenName') + '[call]']]))
	{		
		return false;
	}
	
	if (!bIsAlreadyOpen)
	{
		$iBoxTotalOpen++;
		$iCurrentZIndex++;
		
		$aBoxHistory[params[getParam('sGlobalTokenName') + '[call]']] = true;
		
		$sCurrentId = 'js_box_id_' + $iBoxTotalOpen;
	}
				
	if (caption === null)
	{ 
		caption = '';
	}
	
	var bIsFullMode = false;
	if (params['width'] == 'full')
	{
		params['width'] = ($(window).width());
		params['height'] = ($(window).height());	
		bIsFullMode = true;
	}
	else if (params['width'] == 'scan')
	{	
		params['width'] = ($(window).width() - (oCore['core.is_admincp'] ? 100 : 150));
		params['height'] = ($(window).height() - (oCore['core.is_admincp'] ? 100 : 150));	
	}	

	TB_WIDTH = (!empty(params['width']) ? ((params['width']*1) + 30) : 630);
	TB_HEIGHT = (params['height']*1) + 40 || 440;	
			
	var pagesize = tb_getPageSize();			
	if (TB_HEIGHT > pagesize[1])
	{
		TB_HEIGHT = (pagesize[1] - 75);
	}		
	
	if (TB_WIDTH > pagesize[0])
	{
		TB_WIDTH = (pagesize[0] - 75);
	}						
			
	ajaxContentW = TB_WIDTH - 30;
	ajaxContentH = TB_HEIGHT - 45;			
	
	if (!bIsAlreadyOpen)
	{
		var sHtml = '';
		
		if (bIsPhotoImage){
			$('.js_box_image_holder').remove();
			$('.js_box_image_holder').unbind('click');	
			sHtml += '<div class="js_box_image_holder_full">';	
			sHtml += '<div class="js_box_image_holder_full_loader" style="position:absolute; top:50%; left:50%;"><img src="' + oJsImages['loading_animation'] + '" alt="" /></div>';
			sHtml += '<div style="display:none;" id="' + $sCurrentId + '" class="js_box' + (oParams['bJsIsMobile'] ? ' mobile_js_box' : ' ') + (isset(params['no_remove_box']) ? ' js_box_no_remove' : '') + '" style="width:' + ajaxContentW + 'px;">';
			sHtml += '<div class="js_box_content"></div>';
			sHtml += '<div class="js_box_close"><a href="#" onclick="return js_box_remove(this);">' + oTranslations['core.close'] + '</a><span class="js_box_history">' + params[getParam('sGlobalTokenName') + '[call]'] + '</span></div>';
			sHtml += '</div>';
			sHtml += '</div>';
		}
		else{			
			if (bIsPhotoImage)
			{
				$('.js_box_image_holder').remove();
				$('.js_box_image_holder').unbind('click');	
				sHtml += '<div class="js_box_image_holder_full">';
			}

			if (bForceNoCilck){
				sHtml += '<div class="js_box_image_holder">';
			}		

			sHtml += '<div id="' + $sCurrentId + '" class="js_box' + (oParams['bJsIsMobile'] ? ' mobile_js_box' : ' ') + (isset(params['no_remove_box']) ? ' js_box_no_remove' : '') + '" style="width:' + ajaxContentW + 'px;">';
			if (!bIsPhotoImage)
			{
				sHtml += '<div class="js_box_title">' + caption + '</div>';
			}
			sHtml += '<div class="js_box_content"><span class="js_box_loader">' + oTranslations['core.loading'] + '...</span></div>';
			// if (!bIsPhotoImage)
			{
				sHtml += '<div class="js_box_close"><a href="#" onclick="return js_box_remove(this);">' + oTranslations['core.close'] + '</a><span class="js_box_history">' + params[getParam('sGlobalTokenName') + '[call]'] + '</span></div>';
			}
			sHtml += '</div>';

			if (bIsPhotoImage)
			{
				sHtml += '</div>';
			}

			if (bForceNoCilck){
				sHtml += '</div>';
			}			
		}
		
		$('body').prepend(sHtml);		
	
		var $oNew = $('#' + $sCurrentId + '');
		
		tb_position($oNew, (bIsFullMode ? bIsFullMode : ''));
		
		if (!bIsPhotoImage){
			$oNew.show();			
		} else {
			$('.js_box_image_holder_full_loader').css({
				'margin-left': '-' + ($('.js_box_image_holder_full_loader').find('img:first').width() / 2) + 'px',
				'margin-top': '-' + ($('.js_box_image_holder_full_loader').find('img:first').height() / 2) + 'px'
			});
		}
	}
	else
	{
		$oNew = $('.js_box_image_holder_full').find('.js_box:first');
	}
	
	if (getParam('bJsIsMobile')){
		queryString += '&js_mobile_version=true';
	}	
	
	if(url.indexOf('TB_inline') != -1){
		
					if (params['type'])
					{
						switch(params['type'])
						{				
							case 'delete':			
								var sHtml = '';
								sHtml += '<div id="js_inline_delete">';
								if (!params['call'])
								{
									sHtml += '<form method="post" action="' + sMainUrl + '">';
									sHtml += '<div><input type="hidden" name="' + getParam('sGlobalTokenName') + '[security_token]" value="' + getParam('sSecurityToken') + '" />';
								}
								sHtml += '<div>';
								sHtml += getPhrase('core.are_you_sure');
								sHtml += '<div class="t_center p_4">';			
								sHtml += ' <input type="hidden" name="item_id" value="' + params['itemId'] + '" id="js_inline_delete_id" /> ';
								if (!params['call'])
								{
									sHtml += ' <input type="submit" value="' + getPhrase('core.yes') + '" class="button" /> ';
								}
								else
								{
									sHtml += ' <input type="button" value="' + getPhrase('core.yes') + '" class="button" onclick="$(\'#js_inline_delete_id\').ajaxCall(\'' + params['call'] + '\', \'' + queryString + '\'); tb_remove();" /> ';
								}
								sHtml += ' <input type="button" value="' + getPhrase('core.no') + '" class="button" onclick="tb_remove();" /> ';			
								sHtml += '</div>';
								sHtml += '</div>';
								if (!params['call'])
								{
									sHtml += '</form>';
								}
								sHtml += '</div>';								
								
								break;
						}
						
						$oNew.find('.js_box_content').html('');
						$oNew.find('.js_box_content').html(sHtml);							
					}
					else
					{
						var sHtml = $('#' + params['inlineId']).children();
					}	
					
		$oNew.find('.js_box_content').html('');			
		$oNew.find('.js_box_content').html(sHtml);	
			
		return;					
	}	
	else if (isset(params['TB_iframe'])){
		var sIframe = '';
		$oNew.find('.js_box_content').html('');
		$oNew.find('.js_box_content').html(sIframe);				
	}
	else{
		if (!empty(sForceMessage)){
			$oNew.find('.js_box_content').html('');
			$oNew.find('.js_box_content').html(sForceMessage);		
			return;
		}
		
		var sAjaxType = 'GET';
		if ( (params['' + getParam('sGlobalTokenName') + '[call]'] == 'share.popup') || sType == 'POST'){
			sAjaxType = 'POST';
		}
		
		$.ajax(
			{
				type: sAjaxType,
				dataType: 'html',
				url: getParam('sJsAjax'),
				data: queryString,
				success: function(sMsg)
				{				   	
					$oNew.find('.js_box_content').html('');
					$oNew.find('.js_box_content').html(sMsg);
					if (!empty($oNew.find('.js_box_title_store:first').html()))
					{
						$oNew.find('.js_box_title:first').html($oNew.find('.js_box_title_store:first').html());	
					}
					$oNew.find('.js_box_title:first').show();
					$oNew.find('.js_box_close:first').show();		
					
					if (bIsFullMode){
						$oNew.find('.js_box_content').height(ajaxContentH);
					}

					if (bIsPhotoImage)
					{
						
						var thisHeight = $(window).height();
						var thisBodyHeight = $('body').height();
						var newHeight = (thisHeight > thisBodyHeight ? thisHeight : thisBodyHeight);
						
						// var newHeight = $('body').height();

						$('.js_box_image_holder_full').css({'top': '0px', 'height': (newHeight + 50) + 'px'});

						var bCanCloseImageBox = true;		

						$Behavior.onCloseThickbox = function()
						{							
							$('.js_box').click(function()
							{
								bCanCloseImageBox = false;
							});

							$('.js_box a').click(function()
							{
								bCanCloseImageBox = false;
							});

							$('.js_box_image_holder_full').click(function()
							{			
								if (!bCanCloseImageBox)
								{
									bCanCloseImageBox = true;
								}
								else
								{
									$('#main_core_body_holder').show();
									if ($('#noteform').length > 0)
									{
										$('#noteform').hide(); 
									}
									if ($('#js_photo_view_image').length > 0)
									{
										$('#js_photo_view_image').imgAreaSelect({ hide: true });		
									}
									bIsPhotoImage = false;
									$(this).remove();
									delete $aBoxHistory[params[getParam('sGlobalTokenName') + '[call]']];
									// $Core.addUrlPager({'href': sLastOpenUrl.replace('/#!', '')}, true);
								}
							});		    		
						}

						$Behavior.onCloseThickbox();
					}
				}
			});			
	}
}

$Behavior.thickboxBrowser = function(){
							
	if ($Core.exists('.js_box_image_holder_full')){
		$(document).keyup(function(e){
			if (e.keyCode == 27){ 
				js_box_remove($('.js_box_image_holder_full').find('.js_box_content')); 
			}  
		});									
	}						
};

function tb_get_active()
{
	var $aAllBoxIndex = new Array();
	var $aAllBoxIndexHolder = new Array();
	$('.js_box').each(function()
    {
    	$aAllBoxIndex[parseInt($(this).css('z-index'))] = $(this).attr('id');
    	$aAllBoxIndexHolder.push(parseInt($(this).css('z-index')));
    });	
    
    var $iFocusBox = parseInt(Math.max.apply(Math, $aAllBoxIndexHolder));
    
    if (isset($aAllBoxIndex[$iFocusBox]) && $('#' + $aAllBoxIndex[$iFocusBox]).length > 0)
   	{
   		return $aAllBoxIndex[$iFocusBox];	
   	}
   	
   	return null;
}

function tb_remove()
{	
	$('#main_core_body_holder').show();

	var $aAllBoxIndex = new Array();
	var $aAllBoxIndexHolder = new Array();
	$('.js_box').each(function()
    {
    	$aAllBoxIndex[parseInt($(this).css('z-index'))] = $(this).attr('id');
    	$aAllBoxIndexHolder.push(parseInt($(this).css('z-index')));
    });
    
   	var $iFocusBox = parseInt(Math.max.apply(Math, $aAllBoxIndexHolder));

   	if (isset($aAllBoxIndex[$iFocusBox]) && $('#' + $aAllBoxIndex[$iFocusBox]).length > 0)
   	{
    	var $sLink = $('#' + $aAllBoxIndex[$iFocusBox]).find('.js_box_history:first').html();
   		
   		$('#' + $aAllBoxIndex[$iFocusBox]).fadeOut('fast');   	
		$('#' + $aAllBoxIndex[$iFocusBox]).parent('.js_box_image_holder').fadeOut('fast');
    	
    	delete $aBoxHistory[$sLink];
   	}
   	
   	$('#global_attachment_list_inline').hide();
   	
	return false;
}

function tb_draggable($oObj)
{
    if ($($oObj).parent().hasClass('js_box_image_holder_full'))
    {
    	return false;
    }
	
	$($oObj).draggable(
    {
    	handle: '.js_box_title',
    	opacity: 0.35,
    	zIndex: 3000,
    	start: function(event, ui)
    	{
   			if ($('#global_attachment_list_inline').length > 0)
   			{
    			$('#global_attachment_list_inline').hide();
   			}
    	},
    	stop: function(event, ui)
    	{
    		if ($('#global_attachment_list_inline').length > 0)
   			{
	    		$Core.updateInlineBox();
	    		$('#global_attachment_list_inline').show();
   			}
    	}
    });	
}

function tb_position($oObj, bFull) 
{	
    if (bFull !== true)
    {
		if (!$.ui)
	    {
	    	$Core.loadStaticFile(getParam('sJsHome') + 'static/jscript/jquery/ui.js');
	    }
	     
	   tb_draggable('.js_box');
    }
    
	var $aAllBoxIndex = new Array();
	$('.js_box').each(function()
    {
    	$aAllBoxIndex.push(parseInt($(this).css('z-index')));
    });    
    
    $('.js_box').unbind('click');    
    $('.js_box').click(function()
    {
    	var $aAllBoxIndexInner = new Array();
		$('.js_box').each(function()
	    {
	    	$aAllBoxIndexInner.push(parseInt($(this).css('z-index')));
	    });
	        	
    	$(this).css(
    	{
    	 	'z-index': (parseInt(Math.max.apply(Math, $aAllBoxIndexInner)) + 1)
    	});    	
    });        
    
    if (bFull === true)
    {
    	$($oObj).css(
	    {
	        top: getPageScroll()[1],
	        left: '50%',
	        'margin-left': '-' + (($($oObj).width() / 2) + 12) + 'px',
	        'z-index': (parseInt(Math.max.apply(Math, $aAllBoxIndex)) + 1)    
	    }); 
    }
    else
    {
		$($oObj).css(
	    {
	        top: getPageScroll()[1] + (getPageHeight() / 5),
	        left: '50%',
	        'margin-left': '-' + (($($oObj).width() / 2) + 12) + 'px',
	        'z-index': (parseInt(Math.max.apply(Math, $aAllBoxIndex)) + 1)    
	    });    
    }
    
    if ($.browser.msie && $.browser.version == '7.0')
	{
    	$Behavior.ie7FixZindex();
	}
}   


function tb_parseQuery(query) 
{
   var Params = {};
	if (!query) 
   {
		return Params;
   }
   
   var Pairs = query.split(/[;&]/);
   for (var i = 0; i < Pairs.length; i++) 
   {
      var KeyVal = Pairs[i].split('=');
      if (!KeyVal || KeyVal.length != 2) 
      {
		continue;
      }
      var key = unescape(KeyVal[0]);
      var val = unescape(KeyVal[1]);
      val = val.replace(/\+/g, ' ');
      
      Params[key] = val;
   }
   
   return Params;
}

function tb_getPageSize()
{
	var de = document.documentElement;
	var w = window.innerWidth || self.innerWidth || (de&&de.clientWidth) || document.body.clientWidth;
	var h = window.innerHeight || self.innerHeight || (de&&de.clientHeight) || document.body.clientHeight;
	arrayPageSize = [w,h];
	
	return arrayPageSize;
}