
$Behavior.marketplaceShowImage = function(){
	$('.js_marketplace_click_image').click(function(){
		
		var oNewImage = new Image();
		oNewImage.onload = function(){
			$('#js_marketplace_click_image_viewer').show();
			$('#js_marketplace_click_image_viewer_inner').html('<img src="' + this.src + '" alt="" />');			
			$('#js_marketplace_click_image_viewer_close').show();
		};
		oNewImage.src = $(this).attr('href');
		
		return false;
	});
	
	$('#js_marketplace_click_image_viewer_close a').click(function(){
		$('#js_marketplace_click_image_viewer').hide();
		return false;
	});
}