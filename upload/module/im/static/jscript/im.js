
var oCachedImInterval = new Array();

/* Semaphore for when to request an update on the IM
 **/
var bIsWaiting = false;
/* This object stores the text_id per parent_id (last message received per chat room)
 * for example:
 *		aLastUpdatePerRoom = {45 : 23, 12: 39};
 *		last message received in the chat with user 45 is message 23
 * */
var aLastUpdatePerRoom = {};

/* This variable tells if the current user is online in the IM, if 
 * the user is offline we avoid ajax calls 
 * */
var bIsOnline = true;
/* We use this variable to tell when */
var bWasAborted = false;

var oAjax = false;

/* How wide should the screen be to go full height*/
var iMinWidth = 99388; /* this was changed to "disable" it based in a bug report.*/

/* Wrapper to a conditioned ajaxCall */
function getUpdate()
{
	/* Check if user is updating */
	if ( bWasAborted == false && $('#js_im_find_friend_value').length > 0 && ($('#js_im_find_friend_value').val() != oTranslations['im.find_your_friends']))
	{
		if (oAjax !== false)
		{		
			oAjax.abort();
			bWasAborted = true;
		}	
		return false;
	}
	else if (bWasAborted == true && bIsWaiting == true)
	{
		bIsWaiting = false;
		bWasAborted = false;
	}
	else
	{
	}
	/* If we are waiting for an update then just dont ajax yet */
	if (bIsWaiting)
	{
		return false;
	}
	if (bIsOnline == false)
	{
		return false;
	}
	bIsWaiting = true;
	/* Format the params part of the ajax Call*/
	var sParams = '';
	for (var i in aLastUpdatePerRoom)
	{
		sParams += 'aRoom[' + i + ']=' + aLastUpdatePerRoom[i] + '&';
	}
	
	/* get the list of open chat rooms */
	/*var aOpenChatRooms = [];
	$('.js_cache_im_room').each(function()
	{		
		/* Make sure that there is only one chat room open 
		var iId = $(this).attr('id').replace('js_cache_im_room_','');
		if($.inArray(iId, aOpenChatRooms) > (-1))
		{
			/* Extra check to make sure we only have one chat room open 
			 * for each chat room
			/* $('#' + $(this).attr('id') + ':last').remove();			
		}
		else
		{
			aOpenChatRooms.push(iId);
		}
	})
	
	sParams += '&openRooms=' + aOpenChatRooms.join(',');*/
	
	if (sParams.length > 0)
	{
		sParams.substr(0, sParams.length -1);
	}
	
	if (oAjax !== false)
	{		
		oAjax.abort();
	}	
	else
	{
		sParams += '&bIsNew=1';
	}
	
	oAjax = $.ajaxCall('im.getUpdate', sParams, 'GET');
	return true;
}

/* Called from an ajax response, handles displaying a message.
 *  ( This function was code in the ajax function im.getMessage )
 *  */
function showMessage($iParentId, $sRoomContent, bForceScroll)
{
    $('#js_im_messages_' + $iParentId).append($sRoomContent);
	var iRand = Math.floor(Math.random() * 110);
	/* Handle auto scrolling */
    doScroll($iParentId, bForceScroll, iRand);	
	
    /* if the messages window is hidden or non existent */
	var bExists = $('#js_messages_' + $iParentId).length > 0;
	var bVisible = $('#js_messages_' + $iParentId).is(':visible');
		
	 /* console.log(' showMessage. bExists: ' + bExists + ' _  bVisible ' + ': ' + bVisible + ' iParentId: ' + $iParentId); */ 
    if ( ((bExists == false) || (bVisible == false)) && (bForceScroll != true))
    {
		$('#js_cache_im_room_' + $iParentId).addClass('focus').addClass('new').removeClass('seen');		
		if (oParams['im_beep'] == true)
		{
			$Core.player.play("js_im_player", oParams['sJsStatic'] +  'mp3/incoming.mp3');			
		}
    }
}

/* This function adds the link in the footer to see the list of messages in a conversation.
 * This function is called from an ajax response when a new conversation is started by 
 * someone else */
function addImLink(iParentId, sHtml)
{
	/* Check if this already exists */
	if ($('#js_link_'+iParentId).length > 0)
	{
		/* is the messages window open? */
		/*var bShowMessages = $('#js_messages_'+iParentId).is(':visible');	*/	
		var sLink = $(sHtml).find('#js_link_' + iParentId).html();
		$('#js_link_'+iParentId).html(sLink);		
		return;
	}
	/* check if there are other ImLink */
	if ($('.js_cache_im_room').length > 0)
	{
		$('.js_cache_im_room:first').before(sHtml);
	}
	else
	{
		$('#js_im_holder').before(sHtml);
	}
}

/*
 * This function was copied from the template im.block.link
 **/
function clickOnLink(iParentId)
{	
	$('.js_im_link').parents('li').removeClass('seen');
	$('.js_messages').html('');
	
	if ($('#js_messages_'+iParentId).is(':visible'))
	{		
		minimizeChat(iParentId);		
	}
	else 
	{
		$('#js_cache_im_room_' + iParentId).find('.im_ajax_button:first').show(); 
			
		$.ajaxCall('im.open', 'id=' + iParentId, 'GET'); 
		
		/* Only add the class seen if we are opening it (js_messages is not shown)*/
		$('#js_cache_im_room_'+ iParentId).addClass('seen').removeClass('new');		
	} 
	
	/* This is called from a link so returning false */
	return false;	 
}

/**
 * This function was copied from the template im.block.chat and modified after
 */ 
function minimizeChat(iRoom)
{
	$('#js_messages_'+iRoom).html(' ');
	$.ajaxCall('im.hideRoom', 'id=' + iRoom, 'GET'); 
	$('#js_cache_im_room_' + iRoom).removeClass('seen');
	
	return false;	
}
/**
 * This function was copied from the template im.block.chat and modified after
 */ 
function closeChat(iRoom)
{
	/* this was part of im.link
	 * $('.js_temp_image_block').remove(); 
	 * $('#js_cache_im_room_{$aRoom.parent_id}').remove(); 
	 * $Core.im.extraIsEmpty(); 
	 * $.ajaxCall('im.close', 'id={$aRoom.parent_id}');
	 *  return false;
	 * */
	 
	$('#js_cache_im_room_' + iRoom).remove();
	$.ajaxCall('im.close', 'id='+iRoom);
	return false;
}

/* This function handles the automatic scrolling in js_im_content
 * (the container for the messages). Criteria is:
 * if user has scrolled more than 17 px then do not scroll
 * */
function doScroll(iId, bForce, iRand)
{	
	if ($('#js_im_messages_' + iId).length < 1)
	{
		return false;
	}
	if (bForce != true)
	{
		bForce = false;
	}
	
	var oOut = $('#js_im_content');
	var oInn = $('#js_im_messages_'+iId);

	var iLeft = oOut.scrollTop() + oOut.height() + 20;
	var iRight = oInn.height() -  15;
	if ($('.js_im_latest_message').length > 0)
	{
		iLeft = iLeft + $('.js_im_latest_message').height();
		$('.js_im_latest_message').removeClass('js_im_latest_message');
	}
	if ( iLeft >= iRight || bForce == true) 
	{
		document.getElementById('js_im_content').scrollTop = document.getElementById('js_im_content').scrollHeight;
	}
	else
	{
	}
	return true;
}

/* This function aborts the ajax call for getUpdate IF the user 
 * is typing the name of a friend, this is needed so the ajax 
 * response wont recreate im.list */
function stopForSearch()
{
	var sInput = $('#js_im_find_friend_value').val();
	if ( sInput.length > 0 && oAjax !== false)
	{	
		oAjax.abort();		
		bIsWaiting = true; /* just a precaution*/
	}
}

/**
 * This function checks if there is enough room to go full height and changes the CSS accordingly
 * made as an independent function to be called from ajax responses
 */ 
function goFullHeight()
{
    /* if we have enough space then display the IM in "full mode"*/
    var iHeight = 400;
    if ($('body').width() > iMinWidth)
    {
		iHeight = $(window).height();	
		if ($('#js_im_holder #js_im_friend_list').is(':visible') == false)
		{
			$.ajaxCall('im.load','','GET');
		}
		
		$('#js_footer_im_holder').css({bottom: '0px'});
		/* $('#im_footer_bar').css({right: '0px'});*/
		$('#js_main_chat_header').hide();
    }
	else{
		
		$('#js_footer_im_holder').css({bottom: '23px'});
		/* $('#im_footer_bar').css({right: '10px'});*/
		$('#js_main_chat_header').show();
	}

    $('#js_footer_im_holder').height(iHeight);
	
	/* If we have a chat conversation open and the window is resized hide the main window*/
	if ($('.js_messages').length > 0)
	{
		
	}
	
}

$Behavior.initIm = function()
{	
	/* the first time getUpdate is called it will not call im.load 
	 * and goFullHeight will not call im.load if the screen is big enough*/
	if ($('body').width() <= iMinWidth && getCookie('js_im_open'))
	{
		$.ajaxCall('im.load', '','GET');
	}
	setTimeout('getUpdate', 100);
	setInterval('getUpdate();', oParams['im_interval_for_update']);
	
	if (oCore['im.is_hidden'] != '1')
	{
		$Core.im.checkSize();
		
		$('body').prepend('<div style="width:1px;height:1px;position:absolute;"><div id="js_im_player"></div></div>');

		$(window).bind('resize', function() 
		{
			$Core.im.checkSize();
			
			$('.js_temp_image_block').each(function()
			{			
				eleOffset = $Core.getObjectPosition($(this).find('span:first').html());
				/*$(this).css('top', (eleOffset.top - 402) + 'px');
				$(this).css('left', (eleOffset.left - (250 - $('#' + $(this).find('span:first').html()).width())) + 'px');			*/
			});
			goFullHeight();			
		});		
	}
	goFullHeight();
	
	/* When clicking the close button from im.link it should not bubble */
	$('.im_delete_button').live('click',function(e){
		var iId = $(this).parent().attr('id').replace('js_link_','');
		closeChat(iId);
		e.stopPropagation();
	});
	/* Remove the "new" status when the input text gains focus*/
	$('#js_im_text').live('focus',function(e){
		$(this).parents().find('.new').removeClass('new');
		e.stopPropagation();
	});
	
}

$Core.im = 
{		
	iX: 1,
	
	iSet: 1,
	
	iLastSoundToggle : 0,
	iResourceSoundToggle : 0,
	/**
	 * This object stores which friends are online. It is updated from the ajax response
	 * to getUpdate.
	 * @example aOnlineFriends : [1,4,12,11]
	 */
	aOnlineFriends : [],
	clearConversation: function(iParent)
	{
		if ($('#js_im_messages_' + iParent).html().length < 5)
		{
			return false;
		}
		$('#js_im_messages_' + iParent).html('');
		$('#js_chat_room_' + iParent).find('.im_in_chat_menu_bar').hide();
		$.ajaxCall('im.clearConversation', 'iParent='+iParent);
		/* console.log('called ajax'); */
		return false;
	},
	toggleSound: function()
	{
		if (oParams['im_beep'])
		{ /* turning sound off */
			$('#im_a_toggle_sound_no').show();
			$('#im_a_toggle_sound_yes').hide();
			oParams['im_beep'] = false;
		}
		else
		{
			$('#im_a_toggle_sound_no').hide();
			$('#im_a_toggle_sound_yes').show();
			oParams['im_beep'] = true;
		}
		/* The following routine keeps the user from repeatedly updating the value in the database */
		/* 1. Get current time */
		var iCurrentTime = Math.floor(new Date().getTime() / 1000);
		/* 2. If it has been more than 5 seconds since the user updated the value */
		if ($Core.im.iLastSoundToggle < (iCurrentTime - 5))
		{
			/* 2.1 Then update the value in the database right away*/
			$.ajaxCall('im.toggleSound', 'enabled=' + (oParams['im_beep'] == true ? '1' : '0'));
			if ($Core.im.iResourceSoundToggle > 0)
			{
				/* 2.2 If there is a timeout in process cancel it because we already updated it in db*/
				clearTimeout($Core.im.iResourceSoundToggle);
			}
		}
		else
		{
			/* 3. Less than 5 seconds ago the user updated the sound value*/
			if ($Core.im.iResourceSoundToggle > 0)
			{
				/*3. if there is a scheduled update lets cancel it*/
				clearTimeout($Core.im.iResourceSoundToggle);
			}
			/* 3.2 And schedule a new one to update the databsae in 5 seconds */
			$Core.im.iResourceSoundToggle = setTimeout(function(){				
				$.ajaxCall('im.toggleSound', 'enabled=' + (oParams['im_beep'] == true ? '1' : '0'));				
			}, 5000); /* Wait 5 seconds*/
		}
		
		$Core.im.iLastSoundToggle = iCurrentTime;	
		
		return false;
	},
	
	toggleMessengerLink : function()
	{
		if ($('#js_instant_messenger_link').hasClass('seen') && $('body').width() < iMinWidth)
		{			
			$('#main_messenger_holder').hide();
			$('#js_instant_messenger_link').removeClass('seen');
			setCookie('js_im_open', '2');
		}
		else
		{
			setCookie('js_im_open', '1');
			$.ajaxCall('im.load', 'doEnable=1', 'GET');
			$('#main_messenger_link').find('#js_instant_messenger_link').addClass('seen');			
		}		
	},
	
	/*
	 * This function updates the local variable aOnlineFriends
	 * it also updates the chat rooms open by changing the 
	 * image bullet_red to bullet_green and viceversa accordingly
	 * (instead of sending over the entire block for each room).
	 * Displaying that a user is Offline inside the chat room happens
	 * when the chat room is loaded (via another ajax response) so that
	 * part is not handled here
	 * @param $aFriends a JS array of parent_id (The chat room ids)
	 * @example setOnlineFriends([1,4,12,11]);	 
	 **/
	setOnlineFriends : function($aFriends)
	{
		this.aOnlineFriends = $aFriends;
		var $iLen = $aFriends.length;
		/* Update the count on the IM menu */
		/*$('#js_im_total_friend_count').html($iLen);//$('.im_user_list ').length);*/
		if (empty($aFriends))
		{
			$('.bullet_green').each(function(){				
				$(this).attr('src', $(this).attr('src').replace('bullet_green', 'bullet_red'));
			});
			return;
		}
		$('.js_im_link').each(function(){
			var $bChanged = false;
			for (var $iKey in $aFriends)
			{
				var thisId = $(this).attr('id').replace('js_link_','');
				if ($aFriends[$iKey] == thisId)
				{
					var $sSrc = $('#js_link_' + $aFriends[$iKey] + ' > a > img').attr('src');
					$('#js_link_'+$aFriends[$iKey]+' > a > img').attr('src', $sSrc.replace('bullet_red','bullet_green'));
					$bChanged = true;
				}
			}
			if ($bChanged == false)
			{
				/* Replace the green bullet for the red one*/
				var $oImg = $(this).find('.bullet_red');
				var sSrc =$($oImg).attr('src');
				var sNewSrc = sSrc.replace('bullet_green', 'bullet_red');				
				$($oImg).attr('src', sNewSrc);
			}
		});
	},
	extraIsEmpty: function()
	{
		iCnt = 0;
		$('.im_extra_room').find('.js_cache_im_room').each(function()
		{
			iCnt++;
		});		
		
		if (iCnt == 0)
		{
			$('#js_cache_extra_rooms').hide();
			$('#js_temp_im_extra_position').hide();			
		}		
	},
	
	getSplitCount: function()
	{
		iSplitCount = 4;		
		if ($(window).width() < 1024)
		{
			iSplitCount = 2;
		}
		
		if ($(window).width() < 800)
		{
			iSplitCount = 1;
		}		
		
		return iSplitCount;	
	},
	
	toggleMoreConversations: function()
	{
		if ($('#js_temp_im_extra_position').find('a').hasClass('is_already_open'))
		{
			$('.js_footer_holder').hide();	
			$('#js_cache_extra_rooms').hide(); 
			$('#im_footer_bar').find('a').removeClass('focus').removeClass('is_already_open');
			/* $('#js_cache_extra_rooms').removeClass('is_already_open');*/
		}
		else
		{
			$('.js_footer_holder').hide();	
			$('#im_footer_bar').find('a').removeClass('focus').removeClass('is_already_open'); 
			$('#js_cache_extra_rooms').show(); 			
			$('#js_temp_image_block').remove(); 
			$('#js_temp_im_extra_position').find('a').addClass('focus'); 
			$('#js_temp_im_extra_position').find('a').addClass('is_already_open');			
			$.ajaxCall('im.getRooms','','GET');
		}
		
		return false;		
	},
	
	checkSize: function()
	{		
		iSplitCount = this.getSplitCount();
		
		$('#js_cache_extra_rooms').remove();
		$('#js_temp_im_extra_position').remove();
		
		$('body').prepend('<div id="js_cache_extra_rooms" class="im_extra_room_holder js_footer_holder"><div class="im_header"><div style="position: absolute; right: 0pt; margin-right: 2px;"><a href="#" class="footer_menu_minimize" onclick="$(\'.js_footer_holder\').hide(); $(\'#js_cache_extra_rooms\').hide(); $(\'#im_footer_bar\').find(\'a\').removeClass(\'focus\').removeClass(\'is_already_open\'); return false;"><img src="' + oJsImages.misc_minimize + '" alt="" class="v_middle" /></a></div>' + oTranslations['im.conversations'] + '</div><ul class="js_cache_extra_rooms im_extra_room"></ul></div>');
		
		$('.js_cache_im_list:first').before('<li id="js_temp_im_extra_position" style="width:150px;"><a href="#" onclick="return $Core.im.toggleMoreConversations();">' + oTranslations['im.more_conversations'] + '</a></li>');
		
		iTotal = 0;
		iNewTotal = 0;
		$('.js_cache_im_room').each(function()
		{			
			iTotal++;
			
			if (iTotal > iSplitCount)
			{
				iNewTotal++;
				
				$('.js_cache_extra_rooms').append('<li class="js_cache_im_room js_cache_im_list" id="' + $(this).attr('id') + '">' + $(this).html() + '</li>');
						
				$(this).remove();
			}	
		});
		
		eleOffset = $Core.getObjectPosition('js_temp_im_extra_position');
		/*
     	if ($.browser.msie && $.browser.version.substr(0,1) < 7)
     	{
     		$('#js_cache_extra_rooms').bgiframe();
     	}
     	*/		
		
     	if (!$.browser.msie || ($.browser.msie && $.browser.version.substr(0,1) >= 7)) 
     	{
    		$('#js_cache_extra_rooms').css('top', (eleOffset.top - 400) + 'px');
     	}     	  	
		
		$('#js_cache_extra_rooms').css('left', eleOffset.left + 'px');
		
		if (iNewTotal == 0)
		{
			$('#js_cache_extra_rooms').hide();
			$('#js_temp_im_extra_position').hide();
		}
	},
	
	addBlock: function(sId, sHtml)
	{
		if ($('#' + sId).parent().hasClass('js_cache_extra_rooms') || $('#' + sId).hasClass('js_is_new_room'))
    	{
    		iTotalActiveRooms = 0;
    		$('.js_cache_im_room').each(function()
			{
				iTotalActiveRooms++;	
				$(this).css('z-index', '999');				
			});
			
			if (iTotalActiveRooms > this.getSplitCount())
			{    		
				$('#js_temp_im_extra_position').show();	    		
				
				sTempHtml = $('#' + sId).html();
	    		
	    		$('#' + sId).remove();
	    		
	    		$('.js_cache_im_list:last').after('<li class="js_cache_im_room js_cache_im_list" id="' + sId + '" style="position:relative; width:150px;">' + sTempHtml + '</li>');    	
	    		
	    		iRoomCount = 0;
	    		$('.js_cache_im_room').each(function()
				{
					if (!$(this).parent().hasClass('js_cache_extra_rooms'))
					{
						if (sId != $(this).attr('id'))
						{						
							iRoomCount++;
							
							if (iRoomCount == 1)
							{
								$('.js_cache_extra_rooms').append('<li class="js_cache_im_room js_cache_im_list" id="' + $(this).attr('id') + '">' + $(this).html() + '</li>');
								
								$(this).remove();
							}
						}
					}
				});    		
			}
    	}
    	
    	$('#js_cache_extra_rooms').hide();		
		
		oPosition = $Core.getObjectPosition(sId);
    	
    	if (oCore['im.is_hidden'] == '1')
    	{
			$('.im_status_image').hide();
			$('#js_im_status_online').show();
			
			$('.im_status_display').hide();
			$('#js_im_display_online').show();				
    	}
    	
    	$('#js_temp_image_block').remove();
    	$('#im_footer_bar').find('a').removeClass('focus').removeClass('is_already_open');
    	$('.js_footer_holder').hide();
    	$('#' + sId).find('a').removeClass('new');
    	$('#' + sId).find('a').addClass('focus');    	
		
     	$('body').prepend('<div class="js_temp_image_block im_block" id="js_temp_image_block" style="z-index:999; width:200px; position:absolute; right: 1px' + /*(oPosition.left - (250 - $('#' + sId).width()) + 1) +*/ '"><span style="display:none;">' + sId + '</span>' + sHtml + '</div>');
     	/*
     	if ($.browser.msie && $.browser.version.substr(0,1) < 7)
     	{
     		$('#js_temp_image_block').bgiframe();
     	}
    	*/
     	if (!$.browser.msie || ($.browser.msie && $.browser.version.substr(0,1) >= 7)) 
     	{
    		$('#js_temp_image_block').css('top', '' + (oPosition.top - 400) + 'px');    		
     	}
    	$('#js_footer_im_holder').css('float', 'right');
    	if ($('#js_im_text').length > 0)
    	{
    		/*$('#js_im_text').width($('.im_text_form').innerWidth() - 2);*/
			$('#js_im_text').width('99%');
    	}
    
	},
	
	getChatOrder: function()
	{
		iCnt = 0;
		sRooms = '';
		$('.js_cache_im_room').each(function()
		{
			iCnt++;
			sRooms += '&order[' + $(this).attr('id').replace('js_cache_im_room_', '') + ']=' + iCnt;
		});
		
		return sRooms;
	},
	
	onKeyUp: function(oEvent)
	{
		var iKey = oEvent.keyCode ? oEvent.keyCode : (oEvent.which ? oEvent.which : oEvent.charCode);
		
		if (iKey == 13)
		{		
			$('#js_im_temp_form').ajaxCall('im.add');	
			$('#js_im_text').val('').parents().find('.new').removeClass('new');			
		}
	},
	
	onKeyUpPersonalStatus: function(oEvent)
	{
		var iKey = oEvent.keyCode ? oEvent.keyCode : (oEvent.which ? oEvent.which : oEvent.charCode);
		
		if (iKey == 13)
		{
			this.changePersonalStatus();
		}		
	},	
	
	changePersonalStatus: function()
	{			
		if ($('#js_im_status_value').val() != $('#js_im_status_input').val())
		{
			$.ajaxCall('im.updatePersonalStatus', 'status=' + $('#js_im_status_input').val());
		}						
		else
		{
			$('#js_im_status_form').hide();			
			$('#js_im_status_phrase').show();
		}	
	},
	
	block: function(sId)
	{
		if (!confirm(oTranslations['core.are_you_sure']))
		{
			return false;
		}
		
		/*$('.js_temp_image_block').remove();
		$('#js_cache_im_room_' + sId + '').remove();*/
		closeChat(sId);
		$.ajaxCall('im.block', 'id=' + sId);
		
		return false;
	},
	
	toggleOptions: function(oObj)
	{
		if ($(oObj).hasClass('active'))
		{
			$(oObj).removeClass('active'); 
			$('.im_option').hide(); 			
		}
		else
		{		
			$(oObj).addClass('active'); 
			$('.im_option').show(); 
		}
		
		return false;
	},
	
	goOffline: function()
	{
		deleteCookie('im_last_open_window');
		
		$('.js_cache_im_room').remove();
		
		$('.js_footer_holder').hide();
		$('#js_im_holder').find('a:first').removeClass('focus');
		
		$('.im_status_image').hide();
		$('#js_im_status_offline').show();
		
		$('.im_status_display').hide();
		$('#js_im_display_offline').show();
		
		if (oCacheAjaxRequest !== null)
		{
			oCacheAjaxRequest.abort();
		}
		
		
		aCacheAjaxLastCall = {};
		
		$.ajaxCall('im.goOffline','','GET');
		
		return false;
	},
	
	changeStatus: function(oObj)
	{
		$('.im_status_image').hide();		
		
		switch ($(oObj).val())
		{
			case '1':
				$('#js_im_status_away').show();
				break;
			case '2':
				$('#js_im_status_offline').show();
				break;
			default:
				$('#js_im_status_online').show();
				break;
		}
		
		$.ajaxCall('im.changeStatus', 'status=' + $(oObj).val());
	},
		
	alertNew: function(iId)
	{
		this.iSet = 1;
		
		var oTmpObj = $('#js_cache_im_room_' + iId + '').find('a');
		
		if (this.iX == 0 && this.iSet == 1)
		{
			this.iX = 1;
			this.iSet = 0;
			$(oTmpObj).addClass('new');
		}		
		if (this.iX == 1 && this.iSet == 1)
		{
			this.iX = 0;
			this.iSet = 0;		
			$(oTmpObj).removeClass('new');	
		}
	}
}
