
$Core.isIntUserWidth = function(input)
{
    return typeof(input)=='number'&&parseInt(input)==input;
}

$Behavior.setUserWidth = function(){
	var bShow = false;
	if ($('#right').length >= 1){
		var sInnerHtml = trim($('#right').html());
		if (empty(sInnerHtml)){
			bShow = true;
		}
	}
	
	if ($('#right').length <= 0 || bShow){		
		$('.js_parent_user_clear').remove();
		var iCnt = 0;
		$('.js_parent_user').each(function(){
			iCnt++;
			if ($Core.isIntUserWidth(iCnt/7)){
				$(this).after('<div class="clear"></div>');
			}			
		});
	}
}