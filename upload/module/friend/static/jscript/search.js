
$Core.searchFriendsInput =
{
	aParams: {},
	iCnt: 0,
	aFoundUsers: {},
	aLiveUsers: {},
	sId: '',
	bNoSearch: false,
	
	aFoundUser: {}, // Store the found user here
	sHtml : '', // Store the final html here. Useful for onBeforePrepend
	init: function($aParams)
	{
		this.aParams = $aParams;
		if (!isset(this.aParams['search_input_id']))
		{
			this.aParams['search_input_id'] = 'search_input_name_' + Math.round(Math.random() * 10000);
		}
		if (this._get('no_build')){
			this.sId = $aParams['id'].replace('#', '');
		}
		else{
			this.sId = $aParams['id'].replace('#', '').replace('.', '') + '__tmp__';
		}
		this.build();
	},
	
	build: function()
	{		
		var $sHtml = '';
		if (!this._get('no_build')){			
			
			$sHtml += '<div style="width:' + this._get('width') + '; position:relative;" class="js_friend_search_form" id="' + this.sId + '">';
			$sHtml += '<input type="text" id="' + this._get('search_input_id') + '" name="null" value="' + this._get('default_value') + '" autocomplete="off" onfocus="$Core.searchFriendsInput.buildFriends(this);" onkeyup="$Core.searchFriendsInput.getFriends(this);" style="width:100%;" class="js_temp_friend_search_input" />';
			$sHtml += '<div class="js_temp_friend_search_form" style="display:none;"></div>';
			$sHtml += '</div>';
			
			$(this._get('id')).html($sHtml);			
		}
		else{
			$sHtml += '<div class="js_temp_friend_search_form js_temp_friend_search_form_main" style="display:none;"></div>';
			$('#' + this.sId).find('form:first').append($sHtml);
		}			
		
		$('#' + this.sId).find('.js_temp_friend_search_input').keypress(function(e)
		{
			switch (e.keyCode)
			{
				case 9:
				case 40:
				case 38:
					var $iNextCnt = 0;
					$('.js_friend_search_link').each(function()
					{
						$iNextCnt++;
						if ($(this).hasClass('js_temp_friend_search_form_holder_focus'))
						{
							$(this).removeClass('js_temp_friend_search_form_holder_focus');							
							
							return false;
						}
					});		
					
					if (!$iNextCnt)
					{
						return false;
					}
					
					$Core.searchFriendsInput.bNoSearch = true;
						
					var $iNewCnt = 0;
					var $iActualFocus = 0;
					$('.js_friend_search_link').each(function()
					{
						$iNewCnt++;	
						if ((e.keyCode == 38 ? ($iNextCnt - 1) == $iNewCnt : ($iNextCnt + 1) == $iNewCnt))
						{
							$iActualFocus++;
							$(this).addClass('js_temp_friend_search_form_holder_focus');
							return false;
						}
					});
					
					if (!$iActualFocus)
					{
						$('.js_friend_search_link').each(function()
						{
							$(this).addClass('js_temp_friend_search_form_holder_focus');
							
							return false;							
						});							
					}
					
					return false;
					break;
				case 13:
					$Core.searchFriendsInput.bNoSearch = true;
					$('.js_friend_search_link').each(function()
					{
						if ($(this).hasClass('js_temp_friend_search_form_holder_focus'))
						{
							$Core.searchFriendsInput.processClick(this, $(this).attr('rel'));
						}
					});
					break;
				default:
					// p(e.keyCode);
					break;
			}
		});
	},
	
	buildFriends: function($oObj)
	{
		$($oObj).val('');
		
		if (empty($Cache.friends) && !isset(this.aParams['is_mail']))
		{
			$.ajaxCall('friend.buildCache', (this._get('allow_custom') ? '&allow_custom=1' : ''), 'GET');		
		}
	},
	
	getFriends: function($oObj)
	{		
		if (empty($oObj.value))
		{
			this.closeSearch($oObj);
			
			return;
		}
		
		if (this.bNoSearch)
		{
			this.bNoSearch = false;
			
			return;
		}			
		
		
		if (isset(this.aParams['is_mail']) && this.aParams['is_mail'] == true)
		{
			$.ajaxCall('friend.getLiveSearch', 'parent_id=' + $($oObj).attr('id') + '&search_for=' + $($oObj).val() + '&width=' + this._get('width') + '&total_search=' + $Core.searchFriendsInput._get('max_search'), 'GET');
			return;
		}
		
		var $iFound = 0;
		var $sHtml = '';		
		$($Cache.friends).each(function($sKey, $aUser)
		{
			var $mRegSearch = new RegExp($oObj.value, 'i');
			
			if ($aUser['full_name'].match($mRegSearch))	
			{	
				if (isset($Core.searchFriendsInput.aLiveUsers[$aUser['user_id']]))
				{
					return;
				}

				$iFound++;								
				
				$Core.searchFriendsInput.storeUser($aUser['user_id'], $aUser);
				
				$sHtml += '<li><a rel="' + $aUser['user_id'] + '" class="js_friend_search_link ' + (($iFound === 1 && !$Core.searchFriendsInput._get('global_search')) ? 'js_temp_friend_search_form_holder_focus' : '') + '" href="#" onclick="return $Core.searchFriendsInput.processClick(this, \'' + $aUser['user_id'] + '\');"><img src="' + $aUser['user_image'] + '" alt="" style="width:25px; height:25px;" />' + $aUser['full_name'] + '<div class="clear"></div></a></li>';
				if ($iFound > $Core.searchFriendsInput._get('max_search'))
				{					
					return false;
				}
			}
		});
		
		if ($iFound)
		{		
			if (this._get('global_search')){
				$sHtml += '<li><a href="#" class="holder_notify_drop_link" onclick="$(this).parents(\'form:first\').submit(); return false;">' + oTranslations['friend.show_more_results_for_search_term'].replace('{search_term}',htmlspecialchars($oObj.value)) + '</a></li>';
			}
			
			$($oObj).parent().find('.js_temp_friend_search_form').html('<div class="js_temp_friend_search_form_holder" style="width:' + this._get('width') + ';"><ul>' + $sHtml + '</ul></div>').show();
		}
		else
		{
			$($oObj).parent().find('.js_temp_friend_search_form').html('').hide();	
		}
	},
	
	storeUser: function($iUserId, $aData)
	{
		this.aFoundUsers[$iUserId] = $aData;	
	},
	
	removeSelected: function($oObj, $iUserId)
	{
		if (isset(this.aLiveUsers[$iUserId]))
		{
			delete this.aLiveUsers[$iUserId];
		}
		$($oObj).parents('li:first').remove();
	},
	
	processClick: function($oObj, $iUserId)
	{
		if (!isset(this.aFoundUsers[$iUserId]))
		{
			return false;
		}
		
		if (isset(this.aLiveUsers[$iUserId]))
		{
			return false;
		}
		
		this.aLiveUsers[$iUserId] = true;
		$Behavior.reloadLiveUsers = function(){
			$Core.searchFriendsInput.aLiveUsers = {};
			$Behavior.reloadLiveUsers = function(){}
		}
		this.bNoSearch = false;
		
		var $aUser = this.aFoundUser = this.aFoundUsers[$iUserId];
		var $oPlacement = $(this._get('placement'));
		
		//$($oObj).parents('.js_friend_search_form:first').find('.js_temp_friend_search_input').val('').focus();
		$($oObj).parents('.js_friend_search_form:first').find('.js_temp_friend_search_form').html('').hide();		
		
		var $sHtml = '';
		$sHtml += '<li>';
		
		$sHtml += '<a href="#" class="friend_search_remove" title="Remove" onclick="$Core.searchFriendsInput.removeSelected(this, ' + $iUserId + ');  return false;">Remove</a>';
		if (!this._get('inline_bubble'))
		{
			$sHtml += '<div class="friend_search_image"><img src="' + $aUser['user_image'] + '" alt="" style="width:25px; height:25px;" /></div>';
		}
		$sHtml += '<div class="friend_search_name">' + $aUser['full_name'] + '</div>';
		if (!this._get('inline_bubble'))
		{
			$sHtml += '<div class="clear"></div>';
		}
		$sHtml += '<div><input type="hidden" name="' + this._get('input_name') + '[]" value="' + $aUser['user_id'] + '" /></div>';
		$sHtml += '</li>';
		this.sHtml = $sHtml;
		
		if (empty($oPlacement.html()))
		{
			$oPlacement.html('<div class="js_custom_search_friend_holder"><ul' + (this._get('inline_bubble') ? ' class="inline_bubble"' : '') + '></ul>' + (this._get('inline_bubble') ? '<div class="clear"></div>' : '') + '</div>');
		}
		
		if (this._get('onBeforePrepend'))
		{			
			this._get('onBeforePrepend')(this._get('onBeforePrepend'));
		}
		
		$oPlacement.find('ul').prepend(this.sHtml);
		
		if (this._get('onclick'))
		{
			this._get('onclick')(this._get('onclick'));	
		}
		
		if (this._get('global_search')){
			window.location.href = $aUser['user_profile'];
			$($oObj).parents('.js_temp_friend_search_form:first').hide();
		}
		
		this.aFoundUsers = {};
		
		if (this._get('inline_bubble')){
			$('#' + this._get('search_input_id') + '').val('').focus();
		}
		
		return false;
	},
	
	closeSearch: function($oObj)
	{
		$($oObj).parent().find('.js_temp_friend_search_form').html('').hide();	
	},
	
	_get: function($sParam)
	{
		return (isset(this.aParams[$sParam]) ? this.aParams[$sParam] : '');
	}
}