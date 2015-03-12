
/*
These files should be loaded from the controller that is going to call them. Or we should allow for the block controller to load them so they get cached
$Core.loadStaticFile(getParam('sJsStatic') + 'jscript/jquery/plugin/imgnotes/jquery.imgareaselect.js');
$Core.loadStaticFile(getParam('sJsStatic') + 'jscript/jquery/plugin/imgnotes/imgareaselect/imgareaselect-default.css');
*/
$Core.photo_crop = 
{
	aParams: {},
	
	init: function(aParams)
	{
		this.aParams = aParams;	
	},
	
	save: function(oObj)
	{
		$('#js_photo_preview_ajax').html($.ajaxProcess());
		
		$(oObj).ajaxCall('user.cropPhoto', 'js_disable_ajax_restart=true'); 
		
		return false;
	},
	
	disable: function()
	{
		$('#user_profile_photo').imgAreaSelect({disable: true, hide: true});
	},
	
	enable: function()
	{
		$('#user_profile_photo').imgAreaSelect({aspectRatio: '1:1', onSelectChange: preview, resizable:true, handles: true});		
	}	
}

function preview(img, selection) 
{
	$('#js_photo_preview').show();
	
	var scaleX = $Core.photo_crop.aParams['width'] / selection.width; 
	var scaleY = $Core.photo_crop.aParams['height'] / selection.height; 
	
	$('#js_profile_photo_preview').css({
		width: Math.round(scaleX * $Core.photo_crop.aParams['image_width']) + 'px', 
		height: Math.round(scaleY * $Core.photo_crop.aParams['image_height']) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
	});
	
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
}

$Behavior.imageAreaSelectLoader = function()
{
	$('#user_profile_photo').imgAreaSelect({aspectRatio: '1:1', onSelectChange: preview, resizable:true, handles: true});
}