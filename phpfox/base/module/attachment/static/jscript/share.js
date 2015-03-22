
var $iPositionPlus = 25;
var $oCurrentGlobalObj = null;

$Core.updateInlineBox = function()
{
	var $oPosition = $($oCurrentGlobalObj).parents('.global_attachment_list:first').find('.js_global_position_photo:first').offset();	
	var $oPositionLink = $('.global_attachment_list li a.active').offset();
	
	$('#global_attachment_list_inline').css(
	{
		top: ($oPosition.top + $iPositionPlus) + 'px',
		left: ($oPositionLink.left) + 'px'
	});
}

$Core.clearInlineBox = function()
{
	$('#global_attachment_list_inline').hide();
	$('.global_attachment_list li a').removeClass('active');
}

$Core.shareInlineBox = function($oObj, $sAttachmentId, $bIsInlineAttachment, $sRequest, $iWidth, $sExtra)
{
	$oCurrentGlobalObj = $oObj;
	
	$('#js_global_tooltip').hide();
	
	$sExtra = $sExtra + '&attachment_obj_id=' + $sAttachmentId;	
	
	if ($bIsInlineAttachment)
	{
		$sExtra = $sExtra + '&attachment_inline=true';
		
		if ($('#global_attachment_list_inline').length <= 0)
		{
			var $sContent = '';
			
			$sContent += '<div id="global_attachment_list_inline"><div id="global_attachment_list_inline_holder"></div>';
			$sContent += '<div id="global_attachment_list_inline_close"><a href="#" onclick="$Core.clearInlineBox(); $bIsPreview=false; return false;">' + getPhrase('core.close') + '</a></div>';
			$sContent += '</div>';
			
			$('body').prepend($sContent);
		}
		
		$('#global_attachment_list_inline').hide();
				
		var $oPosition = $($oObj).offset();
		$('#global_attachment_manage').show();
		$($oObj).parents('.global_attachment_list:first').find('li a').removeClass('active');
		$($oObj).addClass('active');
		
		$Core.ajax($sRequest, 
		{
			params: $sExtra,
			success: function($mData)
			{				
				// $($oObj).parents('.global_attachment_header:first .global_attachment_list_holder:first').html('<div class="attachment_inline_holder">' + $mData + '</div>');
				
				$('#global_attachment_manage').hide();
				$('#global_attachment_list_inline_holder').html($mData);
				$('#global_attachment_list_inline').css(
				{
					left: $oPosition.left + 'px',
					top: ($oPosition.top + $iPositionPlus) + 'px'					
				});
				$('#global_attachment_list_inline').show();
				
			}
		});
	}
	else
	{
		$Core.box($sRequest, $iWidth, $sExtra);
	}
	
	return false;
}

$Core.uploadNewAttachment = function($oObj, $bIsMultiShare, $sUploadPhrase)
{			
	var $oParent = $($oObj).parents('.js_upload_attachment_parent_holder:first').find('.js_default_upload_form:first');
	var $oPostParent = $($oObj).parents('.js_default_upload_form:first');
			
	$($oObj).parents('.js_upload_frame_form:first').submit();	
	$oPostParent.find('.js_upload_form_holder').hide();		
	$oPostParent.find('.js_upload_form_image_holder').find('span:first').html(getPhrase('core.uploading') + ' ' + $($oObj).val() + '...');
	$oPostParent.find('.js_upload_form_image_holder').show();
	
	var $sCategoryName = $oParent.find('.category_name:first').val();
		
	if ($bIsMultiShare)
	{
		var $oNewDate = new Date;
		var $iTotalFormsCreated = $oNewDate.getTime();		
		
		$($oObj).parents('.js_upload_attachment_parent_holder:first').find('.js_add_new_form:first').append('<div id="js_new_temp_form_' + $iTotalFormsCreated + '_' + $sCategoryName + '" class="js_default_upload_form p_bottom_4">' + $oParent.html() + '</div>');
				
		var $oNew = $('#js_new_temp_form_' + $iTotalFormsCreated + '_' + $sCategoryName + '');		
				
		$oNew.find('form:first')[0].reset();
		$oNew.find('.js_file_attachment:first').val('');
		$oNew.find('.js_upload_form_holder').show();		
		$oNew.find('.js_upload_form_image_holder').hide();	
		$oNew.find('.js_temp_upload_id:first').val('js_new_temp_form_' + $iTotalFormsCreated + '_' + $sCategoryName + '');
		$oNew.find('.js_upload_form_holder_global:first').attr('id', '');	
	}
        
        $('.extra_info').hide();
}
