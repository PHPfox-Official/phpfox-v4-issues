
$Behavior.selector = function()
{
	$("#js_check_box_all").click(function()
  	{   		
   		var bStatus = this.checked;   		
   		
   		if (bStatus)
   		{
   			$('.checkRow').addClass('isSelected');
   		}
   		else
   		{
   			$('.checkRow').removeClass('isSelected');
   		}
   		
   		var iCnt = 0;
   		$("input:checkbox").each(function()
   		{
    		this.checked = bStatus;
    		
    		if (bStatus)
    		{
    			iCnt++;
    		}
   		});   		
   		
   		if (iCnt)
   		{
   			$('#js_selector_count').html(iCnt);
   			$('#js_selector_action').show();
   		}
   		else
   		{
   			$('#js_selector_action').hide();
   		}
  	});	
	
	$('.checkbox').click(function()
	{
	   	var iCnt = 0;

		$("input:checkbox").each(function()
	   	{	    	
	   		if (this.checked)
	   		{
	   			iCnt++;
	   			$('.js_selector_class_' + this.value).addClass('isSelected');
	   		}
	   		else
	   		{
	   			$('.js_selector_class_' + this.value).removeClass('isSelected');
	   		}	   		
	   	});
	   	
   		if (iCnt)
   		{
   			$('#js_selector_count').html(iCnt);
   			$('#js_selector_action').show();
   			$('#js_action_selector').attr('disabled', false);
			$('.js_select_all_action').show();
			$('.js_select_unall_button').show();
			$('.js_select_all_button').hide();
   		}
   		else
   		{
   			$('#js_selector_action').hide();
   			$('#js_action_selector').attr('disabled', true);
   		}   	
	});	
	
	$('.js_select_all_button').click(function()
	{
	   	$("input:checkbox").each(function()
	   	{
	    	$('.js_selector_class_' + this.value).addClass('isSelected');
	   		this.checked = true;
	   	});
	   	
	   	$('.js_select_all_action').show();
	   	$('.js_select_unall_button').show();
	   	$(this).hide();
	});
	
	$('.js_select_unall_button').click(function()
	{
	   	$("input:checkbox").each(function()
	   	{
	    	$('.js_selector_class_' + this.value).removeClass('isSelected');
	   		this.checked = false;
	   	});
	   	
	   	$('.js_select_all_action').hide();
	   	$('.js_select_all_button').show();
	   	$(this).hide();
	});	
	
	$('.js_selector').change(function()
	{
		if (this.value == 'all')
		{
	   		$("input:checkbox").each(function()
	   		{
	    		$('.js_selector_class_' + this.value).addClass('isSelected');
	   			this.checked = true;
	   		});				
		}
		else if (this.value == 'none')
		{
	   		$("input:checkbox").each(function()
	   		{
	    		$('.js_selector_class_' + this.value).removeClass('isSelected');
	   			this.checked = false;
	   		});				
		}
		else if (this.value == '')
		{
			return false;
		}
		else if (this.value == 'every')
		{
	   		$("input:checkbox").each(function()
	   		{
	    		$('.js_selector_class_' + this.value).addClass('isSelected');
	   			this.checked = true;
	   		});
		}
		else
		{
	   		$("input:checkbox").each(function()
	   		{
	    		$('.js_selector_class_' + this.value).removeClass('isSelected');
	   			this.checked = false;
	   		});				
			aIds = $('#js_selector_' + this.value).val().split(',');
			for (i = 0; i < aIds.length; i++)
			{
				if (aIds[i] == '')
				{
					continue;
				}
				
				$('.js_selector_class_' + aIds[i]).addClass('isSelected');
				$('#js_selector_checkbox_' + aIds[i]).attr('checked', true);
			}				
		}
	});
};