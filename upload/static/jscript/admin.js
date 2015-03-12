
preload_image = new Image(); 
preload_image.src = getParam('sImagePath') + '/layout/main_sub_menu.png'; 

var aAdminCPSearchValues = new Array();

$Behavior.tableHover = function()
{
	if ($Core.exists('.table_hover_action')){
		$('#table_hover_action_holder').remove();
		$('body').append('<div id="table_hover_action_holder" style="display:none;"></div>');	
		$('#table_hover_action_holder').css("left", (($(window).width() - $('#table_hover_action_holder').outerWidth()) / 2) + $(window).scrollLeft() + "px");
		$('#table_hover_action_holder').html($('.table_hover_action').html());			
		
		if (!isScrolledIntoView('.table_hover_action')){			
			$('#table_hover_action_holder').show();
		}

		$(window).scroll(function(){
			if (isScrolledIntoView('.table_hover_action')){
				$('#table_hover_action_holder').hide();
			}
			else{
				$('#table_hover_action_holder').show();
			}
		});		
		
		$('#table_hover_action_holder input').click(function(){
			$('.table_hover_action').append('<div><input type="hidden" name="' + $(this).attr('name') + '" value="' + $(this).attr('value') + '" /></div>')
			if ($('.table_hover_action').hasClass('table_hover_action_custom')){
				$Core.ajaxMessage(); 
				$($('.table_hover_action').parents('form:first')).ajaxCall('user.updateSettings');
				return false;
			}
			else{
				$('.table_hover_action').parents('form:first').submit();			
			}
		});
	}	
	
	$('#admincp_search_input').focus(function(){
		if (empty(aAdminCPSearchValues)){
			$.ajaxCall('admincp.buildSearchValues', '', 'GET');
		}	
		
		if ($(this).val() == $('#admincp_search_input_default_value').html()){
			$(this).val('').addClass('admincp_search_input_focus');
		}
	});
	
	$('#admincp_search_input').blur(function(){		
		if (empty($(this).val())){
			$(this).val($('#admincp_search_input_default_value').html()).removeClass('admincp_search_input_focus');
		}
	});	
	
	$('#admincp_search_input').keyup(function(){
		if (!empty(aAdminCPSearchValues)){
			
			var iFound = 0;
			var oParent = $(this);
			var sHtml = '';
			
			if (empty(oParent.val())){
				$('#admincp_search_input_results').hide();
				return;
			}
			
			$(aAdminCPSearchValues).each(function(sKey, aResult){			
				var mRegSearch = new RegExp(oParent.val(), 'i');

				if (aResult['title'].match(mRegSearch))	
				{
					sHtml += '<li><a href="' + aResult['link'] + '">' + aResult['title'] + '<div class="extra_info">' + aResult['type'] + '</div></a></li>';
					iFound++;
				}
				
				if (iFound > 10){
					return false;
				}
			});
			
			if (iFound > 0){
				$('#admincp_search_input_results').html('<ul>' + sHtml + '</ul>');
				$('#admincp_search_input_results').show();
			}
			else{
				$('#admincp_search_input_results').hide();
			}
		}
	});
	
	$("#js_check_box_all").click(function()
  	{   		
   		var bStatus = this.checked;   		
   		
   		if (bStatus)
   		{
   			$('.checkRow').addClass('is_checked');
   			$('.sJsCheckBoxButton').removeClass('disabled');   	
   			$('.sJsCheckBoxButton').attr('disabled', false);   			
   		}
   		else
   		{
   			$('.checkRow').removeClass('is_checked');
   			$('.sJsCheckBoxButton').addClass('disabled');   	
   			$('.sJsCheckBoxButton').attr('disabled', true);	      			
   		}
   		
   		$("input:checkbox").each(function()
   		{
    		this.checked = bStatus;
   		});   		
  	});	  	
  		
	$('th').hover(function()
	{
		if (typeof($(this).find('a').get(0)) != 'undefined')
		{
			$(this).css('cursor', 'pointer');			
		}
	},
	function ()
	{
		return false;
	});
	
	$('th').click(function()
	{
		if (typeof($(this).find('a').get(0)) != 'undefined')
		{
			window.location.href = $(this).find('a').get(0).href;
		}		
	});
	
	
	$('.text').click(function()
	{
		return false;
	});
	
    $('.checkbox').click(function()
    {
    	var sIdName = '#js_row' + $(this).get(0).id.replace('js_id_row', '');
    	if ($(sIdName).hasClass('is_checked'))
    	{
    		$(sIdName).removeClass('is_checked');
    	}
    	else
    	{
    		$(sIdName).addClass('is_checked');
    	}
    	
    	var iCnt = 0;
   		$("input:checkbox").each(function()
   		{
    		if (this.checked)
    		{
   				iCnt++;
    		}	
   		});
   		
   		if (iCnt > 0)
   		{
   			$('.sJsCheckBoxButton').removeClass('disabled');   	
   			$('.sJsCheckBoxButton').attr('disabled', false);   			
   		}
   		else
   		{
   			$('.sJsCheckBoxButton').addClass('disabled');   	
   			$('.sJsCheckBoxButton').attr('disabled', true);	      			
   		}
    });
    
    $('.checkbox').click(function()
    {
    	var sIdName = '#js_user_' + $(this).get(0).id.replace('js_id_row', '');
    	if ($(sIdName).hasClass('is_checked'))
    	{
    		$(sIdName).removeClass('is_checked');
    	}
    	else
    	{
    		$(sIdName).addClass('is_checked');
    	}
    	
    	var iCnt = 0;
   		$("input:checkbox").each(function()
   		{
    		if (this.checked)
    		{
   				iCnt++;
    		}	
   		});
   		
   		if (iCnt > 0)
   		{
   			$('.sJsCheckBoxButton').removeClass('disabled');   	
   			$('.sJsCheckBoxButton').attr('disabled', false);   			
   		}
   		else
   		{
   			$('.sJsCheckBoxButton').addClass('disabled');   	
   			$('.sJsCheckBoxButton').attr('disabled', true);	      			
   		}
    });    
    
    $('.js_drop_down_link').click(function()
    {
    	eleOffset = $(this).offset();
    	
    	$('#js_drop_down_cache_menu').remove();
    	
    	$('body').prepend('<div id="js_drop_down_cache_menu" style="position:absolute; left:' + eleOffset.left + 'px; top:' + (eleOffset.top + 15) + 'px; z-index:9999;"><div class="link_menu" style="display:block;">' + $(this).parent().find('.link_menu:first').html() + '</div></div>');
    	
		$('#js_drop_down_cache_menu .link_menu').hover(function()
		{

		},
		function()
		{
			$('#js_drop_down_cache_menu').remove();
		});	    	
    	
    	return false;
    });
    
    $('.js_item_active_link').click(function()
    {
    	aParams = $.getParams(this.href);
    	var sParams = '';
		for (sVar in aParams)
		{			
			sParams += '&' + sVar + '=' + aParams[sVar] + '';
		}
		sParams = sParams.substr(1, sParams.length);
		
		if ($(this).hasClass('js_remove_default'))
		{
			$('.js_remove_default').each(function()
			{
				$(this).parent().parent().find('.js_item_is_active:first').hide();
				$(this).parent().parent().find('.js_item_is_not_active:first').show();
			});
		}		
		
		if (aParams['active'] == '1')
		{
			$(this).parent().parent().find('.js_item_is_not_active:first').hide();
			$(this).parent().parent().find('.js_item_is_active:first').show();
		}
		else
		{
			$(this).parent().parent().find('.js_item_is_active:first').hide();
			$(this).parent().parent().find('.js_item_is_not_active:first').show();
		}
				
		$Core.ajaxMessage();
		$.ajaxCall(aParams['call'], sParams + '&global_ajax_message=true');
    	
    	return false;
    });
    
    $('.form_select_active').hover(
    function()
    {
    	$(this).addClass('form_select_is_active');
    },
    function()
    {
		if (!$(this).hasClass('is_selected_and_active'))
		{
    		$(this).removeClass('form_select_is_active');
		}
    });    
    
    $('.form_select_active').click(function()
    {
    	$('.form_select').hide();
    	$('.form_select_active').removeClass('is_selected_and_active').removeClass('form_select_is_active');
    	$(this).addClass('form_select_is_active');
    	$(this).parent().find('.form_select:first').width($(this).innerWidth()).show();    	
    	$(this).addClass('is_selected_and_active');
    	
    	return false;
    });
    
    $('.form_select li a').click(function()
    {    	
    	$(this).parents('.form_select:first').hide();
    	$('.form_select_active').removeClass('is_selected_and_active').removeClass('form_select_is_active');
    	$(this).parents('.form_select:first').parent().find('.form_select_active:first').html($(this).html());    	
    	
    	aParams = $.getParams(this.href);
    	var sParams = '';
		for (sVar in aParams)
		{			
			sParams += '&' + sVar + '=' + aParams[sVar] + '';
		}
		sParams = sParams.substr(1, sParams.length);    	
		
		$Core.ajaxMessage();
		$.ajaxCall(aParams['call'], sParams + '&global_ajax_message=true');
    	
    	return false;
    });
    
    $(document).click(function()
    {
    	$('.form_select').hide();
    	$('.form_select_active').removeClass('is_selected_and_active').removeClass('form_select_is_active');
    });
}

if (!oCore['core.enabled_edit_area'])
{
	var editAreaLoader = {};
	editAreaLoader.openFile = function(sId, oOptions)
	{
		$('#' + sId).val(oOptions['text']);	
	}
	
	editAreaLoader.getValue = function(sId)
	{
		return $('#' + sId).val();
	}
	
	editAreaLoader.setFileEditedMode = function()
	{
		
	}
	
	editAreaLoader.closeFile = function()
	{
		
	}
}