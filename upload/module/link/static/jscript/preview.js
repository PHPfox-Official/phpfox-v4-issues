
	var $iCurrentAttachmentCount = 1;
	
	$Behavior.previewLink = function()
	{		
		$('body').click(function()
		{
			$('.js_text_attachment_edit_link').show();
			$('.js_text_attachment_edit').hide();
			
			$('.js_text_attachment_edit_value').each(function()
			{
				$(this).parent().parent().find('.js_text_attachment_edit_link').html(htmlentities($(this).val()));
			});
		});
		
		$('.js_text_attachment_edit_link').click(function()
		{
			return $Core.editAttachmentText(this);
		});
	};
	
	$Core.editAttachmentText = function($oObj)
	{
		$($oObj).parent().find('.js_text_attachment_edit:first').show();
		$($oObj).hide();	
		$($oObj).parent().find('.js_text_attachment_edit_value').select();	
		
		return false;
	};
	
	$Core.changeDefaultAttachmentImage = function($oObj, $sType)
	{
		$('.attachment_pager ul li').removeClass('no_link');
		
		if ($sType == 'next')
		{
			if ($('#js_hidden_attachment_image_' + ($iCurrentAttachmentCount + 1)).length > 0)	
			{			
				$('#js_attachment_link_default_image').html($('#js_hidden_attachment_image_' + ($iCurrentAttachmentCount + 1)).html());
				$('#js_attachment_link_default_image_input').val($('#js_hidden_attachment_image_value_' + ($iCurrentAttachmentCount + 1)).html());
				
				$iCurrentAttachmentCount++;
			}		
		}
		else
		{
			if ($('#js_hidden_attachment_image_' + ($iCurrentAttachmentCount - 1)).length > 0)	
			{			
				$('#js_attachment_link_default_image').html($('#js_hidden_attachment_image_' + ($iCurrentAttachmentCount - 1)).html());
				$('#js_attachment_link_default_image_input').val($('#js_hidden_attachment_image_value_' + ($iCurrentAttachmentCount - 1)).html());
				
				$iCurrentAttachmentCount--;
			}		
		}
		
		if ($iCurrentAttachmentCount == $iTotalAttachmentImages || $iCurrentAttachmentCount == 1)
		{
			$($oObj).parent().addClass('no_link');
		}		
		
		$('#js_attachment_link_counter').html($iCurrentAttachmentCount + ' of ' + $iTotalAttachmentImages);
		
		return false;
	};
	
	$Core.toggleAttachmentLinkThumb = function($oObj)
	{
		if ($oObj.checked)
		{
			$('#js_attachment_link_default_image_hide').val('1');
			$('.attachment_image_holder').hide();	
		}
		else
		{
			$('#js_attachment_link_default_image_hide').val('0');	
			$('.attachment_image_holder').show();
		}
	};