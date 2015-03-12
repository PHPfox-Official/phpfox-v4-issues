
var $bUserToolTipIsHover = false;
var $bUserActualToolTipIsHover = false;
var $iUserToolTipWaitTime = 900;
var $oUserToolTipObject = null;
var $sHoveringOn = null;
var aHideUsers = new Array();
var bUserInfoLogDebug = false;

$Core.userInfoLog = function(sLog){
	if (bUserInfoLogDebug){
		p(sLog);
	}	
};

$Core.loadUserToolTip = function($sUserName)
{	   
	setTimeout('$Core.showUserToolTip(\'' + $sUserName + '\');', $iUserToolTipWaitTime);
};

$Core.closeUserToolTip = function(sUser)
{	
	if ($bUserActualToolTipIsHover === true && sUser == $sHoveringOn){
		$Core.userInfoLog('CANCEL CLOSE: ' + sUser);
		return;
	}
	
	aHideUsers[sUser] = true;
	
	$Core.userInfoLog('CLOSE: ' + sUser);
	
	$('#js_user_tool_tip_cache_' + sUser + '').parent().parent().hide();
};

$Core.showUserToolTip = function(sUser)
{
	var $oObj = $oUserToolTipObject;

    $('.js_user_tool_tip_holder').hide();
	 
	if ($bUserToolTipIsHover === false){
		$Core.userInfoLog('NO LOAD: ' + sUser);
		return;
	}
   
   if (isset(aHideUsers[sUser])){
	   $Core.userInfoLog('HIDING: ' + sUser);  
	   delete aHideUsers[sUser];
	   return;
   }
   
   if (sUser != $sHoveringOn){
		$Core.userInfoLog('NO SHOW: ' + sUser);
		return;
   }
   
	$Core.userInfoLog('SHOWING: ' + sUser);
   
	var $oOffset = $($oObj).offset();
	
	$('#js_user_tool_tip_cache_' + sUser + '').parent().parent().css('display', 'block')		
		.css('top', ($oOffset.top + 16) + 'px')
		.css('left', $oOffset.left + 'px');
};

$Behavior.userHoverToolTip = function()
{	
	$('#main_content_holder .user_profile_link_span a').mouseover(function()
	{	
		$Core.userInfoLog('----------------------------- START -----------------------------');
                
		var $sUserName = $(this).parent().attr('id').replace('js_user_name_link_', '');		
		
		if (empty($sUserName))
		{
			return;
		}
		
		if ($('#js_user_tool_tip_cache_' + $sUserName + '').length <= 0)
        {
			$('body').append('<div class="js_user_tool_tip_holder"><div class="js_user_tool_tip_body"><div id="js_user_tool_tip_cache_' + $sUserName + '"></div></div></div>');
			
			$.ajaxCall('user.tooltip', 'user_name=' + $sUserName, 'GET');
			
			$('#js_user_tool_tip_cache_' + $sUserName + '').hover(function(){
				$bUserActualToolTipIsHover = true;
				$Core.userInfoLog('MOUSE ON');
			}, function(){ 		
				oCloseObject = $(this).attr('id').replace('js_user_tool_tip_cache_', '');
				setTimeout('$Core.closeUserToolTip(\'' + oCloseObject + '\');', $iUserToolTipWaitTime);
				$bUserActualToolTipIsHover = false;				
				$Core.userInfoLog('MOUSE OFF'); 
			});	
		}		
		
		if (isset(aHideUsers[$sUserName])){
			delete aHideUsers[$sUserName];
		}
		
		$bUserToolTipIsHover = true;
		$sHoveringOn = $sUserName;
		
		$Core.userInfoLog('HOVER: ' + $sUserName);
		
		$('.js_user_tool_tip_holder').hide();
		$oUserToolTipObject = this;

		if ($('#js_user_tool_tip_cache_' + $sUserName).html().length <= 0){					
			
		} else {
			$Core.loadUserToolTip($sUserName);
		}		
	});
	
	$('#main_content_holder .user_profile_link_span a').mouseout(function()
	{
		$bUserToolTipIsHover = false;		

		oCloseObject = $(this).parent().attr('id').replace('js_user_name_link_', '');
		
		setTimeout('$Core.closeUserToolTip(\'' + oCloseObject + '\');', $iUserToolTipWaitTime);
	});	
};