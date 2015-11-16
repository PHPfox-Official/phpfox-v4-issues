
var $bUserToolTipIsHover = false;
var $bUserActualToolTipIsHover = false;
var $iUserToolTipWaitTime = 900;
var $iUserToolTipCloseTime = 900;
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
	//$Core.loadInit();
  var d = new Date();
  localStorage.setItem('tooltip_last', d.getTime());
	setTimeout('$Core.showUserToolTip(\'' + $sUserName + '\');', $iUserToolTipWaitTime);
};

$Core.closeUserToolTip = function(sUser)
{
  var d = new Date();
  var lastRun = localStorage.getItem('tooltip_last');
  if (typeof lastRun != 'undefined' && lastRun > 0 && (d.getTime() - lastRun) < 2000){
    return;
  }
	if ($bUserActualToolTipIsHover === true && sUser == $sHoveringOn){
		$Core.userInfoLog('CANCEL CLOSE: ' + sUser);
		return;
	}

	aHideUsers[sUser] = true;

	$Core.userInfoLog('CLOSE: ' + sUser);

	$('#js_user_tool_tip_cache_' + sUser + '').parent().parent().hide();
  localStorage.setItem('tooltip_last', d.getTime());
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

	var obj = $('#js_user_tool_tip_cache_' + sUser + '').parent().parent();
	var pos = $(window).width() - ($oOffset.left + obj.width());
	if (parseInt(pos) < 10) {
		$oOffset.left = ($oOffset.left - obj.width()) + $($oObj).width();
	}
	var obj = $('#js_user_tool_tip_cache_' + sUser + '').parent().parent();
	obj.css('display', 'block')
		.css('top', ($oOffset.top + 16) + 'px')
		.css('left', $oOffset.left + 'px');
};

$Behavior.userHoverToolTip = function()
{	
	$('.user_profile_link_span a').mouseover(function()
	{
    $('#main').click(function() {
      $('.js_user_tool_tip_holder').hide();
    });
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
			$('#js_user_tool_tip_cache_' + $sUserName + '').mouseenter(function(){
				$bUserActualToolTipIsHover = true;
				$Core.userInfoLog('MOUSE ON');
			}).mouseleave(function(){
				oCloseObject = $(this).attr('id').replace('js_user_tool_tip_cache_', '');
				setTimeout('$Core.closeUserToolTip(\'' + oCloseObject + '\');', $iUserToolTipCloseTime);
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
	
	$('.user_profile_link_span a').mouseout(function()
	{
		$bUserToolTipIsHover = false;

		oCloseObject = $(this).parent().attr('id').replace('js_user_name_link_', '');

		setTimeout('$Core.closeUserToolTip(\'' + oCloseObject + '\');', $iUserToolTipCloseTime);
	});	
};