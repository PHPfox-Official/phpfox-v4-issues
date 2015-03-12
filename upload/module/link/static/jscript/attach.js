var $bIsPreview = false;
$Core.attachmentLink = function($oObj)
{	
	if ($bIsPreview === true)
	{
		return false;
	}
	
	var $oParent = $($oObj).parents('.js_preview_link_attachment_custom_add_parent:first');
	
	if (empty($oParent.find('.js_global_attach_value_custom:first').val()))
	{
		return false;
	}
	
	$oParent.find('.js_global_attach_link_ajax:first').show();
	$bIsPreview = true;
	
	$Core.ajax('link.preview', 
	{		
		type: 'POST',
		params: 
		{				
			'no_page_update': '1',
			value: $oParent.find('.js_global_attach_value_custom:first').val()			
		},
		success: function($sOutput)
		{				
			if (substr($sOutput, 0, 1) == '{')
			{
				$bIsPreview = false;
				var $oOutput = $.parseJSON($sOutput);
				$oParent.find('.js_preview_link_attachment_custom_error:first').html('<div class="error_message">' + $oOutput['error'] + '</div>');
				$oParent.find('.js_global_attach_link_ajax:first').hide();
			}
			else
			{
				$oParent.find('.js_preview_link_attachment_custom_add:first').hide();
				$oParent.find('.js_preview_link_attachment_custom_holder:first').show();
				$oParent.find('.js_preview_link_attachment_custom_form:first').html($sOutput);
				$oParent.find('.js_hidden_link_id:first').val($oParent.find('.js_global_attach_value_custom:first').val());
			}
		}
	});
}

var $bIsAdded = false;
$Core.attachmentLinkAdd = function($oObj)
{
	if ($bIsAdded === true)
	{
		return false;
	}
	
	$($oObj).parents('.js_preview_link_attachment_custom_add_parent:first').find('.js_global_attach_link_ajax_add:first').show();
	
	$($oObj).ajaxCall('attachment.addViaLink');
	
	$bIsAdded = true;
	$bIsPreview = false;
	return false;
}