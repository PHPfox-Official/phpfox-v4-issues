
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


$Core.custom =
{
	iDefault: 4,
		
	aOptions: null,
	
	sUrl: '',
	
	init: function(iDefault, aOptions)
	{
		this.iDefault = iDefault;
		
		if (!empty(aOptions))
		{
			this.aOptions = aOptions;
			
			var iCnt = 0;
			for (i in aOptions)
			{
				iCnt++;
			}			
		}				
		
		this.display();			
	},
	
	url: function(sUrl)
	{
		this.sUrl = sUrl;
	},
	
	display: function()
	{		
		var sForm = $('#js_sample_option').html();
		var sForms = '';
		for (i = 0; i < this.iDefault; i++)
		{			
			sForms += sForm;
		}
		$('#js_option_holder').html(sForms).show();
		//$('#tbl_add_custom_option').show();
		
		this.update();	
	},
	
	update: function()
	{
	    //return;
		var iCnt = 0;
		var aMatches;
		$('.js_option_holder').each(function()
		{
			iCnt++;
			//return;
			$(this).find('.js_option_count').html((iCnt - 1));			
			
			$(this).find('input').each(function()
			{
				if ($Core.custom.aOptions !== null)
				{
					aMatches = $(this).attr('name').match(/val\[option\]\[(.*?)\]/i);
					if (isset(aMatches[1]) && isset($Core.custom.aOptions['option_' + (iCnt - 1) + '_' + aMatches[1]]))
					{
						$(this).val($Core.custom.aOptions['option_' + (iCnt - 1) + '_' + aMatches[1]]);
					}
				}
				
				// admincp.custom.add has a different format for 2nd run (clicking in "Add New Option")
				if ( $(this).attr('name').indexOf('val[option][0]') > (-1))
				{
					$(this).attr('name', $(this).attr('name').replace('val[option][0]', 'val[option][' + (iCnt-1) + ']'));
				}
				else if ($(this).attr('name').match(/val\[option\]\[[0-9]+\]/))
				{
					$(this).attr('name', $(this).attr('name').replace(/\[[0-9]+\]/, '[' + (iCnt-1) + ']'));
				}
				else
				{
					$(this).attr('name', $(this).attr('name').replace('#', (iCnt-1)));//(/\[option\]\[([a-z0-9]+)\]/, '[option][' + (iCnt-1) + '][$1]'));
				}
				
				
			});
			
			if ((iCnt - 1) > $Core.custom.iDefault)
			{
				$(this).find('.js_option_delete').html('<a href="#" onclick="return $Core.custom.remove(this);"><img src="' + getParam('sImagePath') + 'misc/delete.png" alt="" /></option>');				
			}
		});		
	},
	
	add: function()
	{	
	    
		$('#js_option_holder').append($('#js_sample_option').html());	
		
		this.update();		
	},
	
	remove: function(oObj)
	{
		$(oObj).parents('.js_option_holder').remove();		
		
		return false;
	},
	
	updateSort: function()
	{
		$('.sortable').removeClass('odd');
		$('.sortable').removeClass('first');
		$('.sortable li:first').addClass('first');		
		
		var iGroupCnt = 0;
		$('.sortable ul .group').each(function()
		{
			iGroupCnt++;
			$(this).find('input:first').val(iGroupCnt);
		});
		
		var iFieldCnt = 0;
		$('.sortable ul .field').each(function()
		{
			iFieldCnt++;
			$(this).find('input:first').val(iFieldCnt);
		});		
	},
	
	action: function(oObj, sAction)
	{
		aParams = $.getParams(oObj.href);	
		
		$('.dropContent').hide();		
		
		switch (sAction)
		{
			case 'edit':
				if (aParams['type'] == 'group')
				{
					window.location.href = this.sUrl + 'group/add/id_' + aParams['id'] + '/';
				}
				else
				{
					window.location.href = this.sUrl + 'add/id_' + aParams['id'] + '/';
				}
				break;
			case 'delete':
				if (confirm(oTranslations['core.are_you_sure']))
				{
					if (aParams['type'] == 'group')
					{
						window.location.href = this.sUrl + 'delete_' + aParams['id'] + '/';
					}
					else
					{
						$.ajaxCall('custom.deleteField', 'id=' + aParams['id']);
					}					
				}
				break;
			default:
				if (aParams['type'] == 'group')
				{
					$.ajaxCall('custom.toggleActiveGroup', 'id=' + aParams['id']);
				}
				else
				{
					$.ajaxCall('custom.toggleActiveField', 'id=' + aParams['id']);
				}				
				break;
		}
		
		return false;
	},
	
	addSort: function()
	{
		$('.sortable ul').sortable({
				axis: 'y',
				update: function(element, ui)
				{
					$Core.custom.updateSort();
				},
				opacity: 0.4
			}
		);		
	},
	
	toggleFieldActivity: function(iId)
	{
		if ($('#js_field_' + aParams['id']).html().match(/<del(.*?)>/i))
		{
			$('#js_field_' + aParams['id']).html($('#js_field_' + aParams['id']).html().replace(/<del(.*?)>/i, '').replace(/<\/del>/i, ''));
		}
		else
		{
			$('#js_field_' + aParams['id']).html('<del>' + $('#js_field_' + aParams['id']).html() + '</del>');
		}		
	},
	
	toggleGroupActivity: function(iId)
	{
		if ($('#js_group_' + aParams['id']).html().match(/<del>/i))
		{
			$('#js_group_' + aParams['id']).html($('#js_group_' + aParams['id']).html().replace('<del>', '').replace('</del>', ''));
		}
		else
		{
			$('#js_group_' + aParams['id']).html('<del>' + $('#js_group_' + aParams['id']).html() + '</del>');
		}
	},
	toggleShowFeed: function(iVal)
	{
		if (iVal == 1)
		{
			$('div.add_feed').each(function(){$(this).show()});
		}
		else
		{
			$('div.add_feed').each(function(){$(this).hide()});
		}
	}
}

$Behavior.custom_admin_init = function()
{	
	$('.js_drop_down').click(function()
	{		
		eleOffset = $(this).offset();
		
		aParams = $.getParams(this.href);
		
		$('#js_cache_menu').remove();
		
		$('body').prepend('<div id="js_cache_menu" style="position:absolute; left:' + eleOffset.left + 'px; top:' + (eleOffset.top + 15) + 'px; z-index:100; background:red;">' + $('#js_menu_drop_down').html() + '</div>');
		
		$('#js_cache_menu .link_menu li a').each(function()
		{			
			if (this.hash == '#active' && (($('#js_field_' + aParams['id']).html() && $('#js_field_' + aParams['id']).html().match(/<del>/i)) || ($('#js_group_' + aParams['id']).html() && $('#js_group_' + aParams['id']).html().match(/<del>/i))))
			{
				$(this).html('Set to Active');
			}
			
			this.href = '#?id=' + aParams['id'] + '&type=' + aParams['type'] + '';			
		});
		
		$('.dropContent').show();		
		
		$('.dropContent').mouseover(function()
		{
			$('.dropContent').show(); 
			
			return false;
		});
		
		$('.dropContent').mouseout(function()
		{
			$('.dropContent').hide(); 
			$('.sJsDropMenu').removeClass('is_already_open');			
		});
		
		return false;
	});		
	
	$('.var_type').change(function()
	{
		$('#js_multi_select').hide();
		
		switch (this.value)
		{
			case 'select':
			case 'multiselect':
			case 'radio':
			case 'checkbox':
				$('#tbl_option_holder').show();	
				$('#tbl_add_custom_option').show();
				break;
			default:
				$('#tbl_option_holder').hide();
				$('#tbl_add_custom_option').hide();
				break;
		}
	});
	
	if ($('.var_type').val() == 'text' || $('.var_type').val() == 'textarea')
	{
		$('#tbl_option_holder').hide();
		$('#tbl_add_custom_option').hide();
	}
	
	$('.js_add_custom_option').click(function()
	{    
		$Core.custom.add();
		
		return false;
	});
	
	$('#js_create_new_group').click(function()
	{
		$('#js_field_holder').hide();
		$('#js_group_holder').show();
		
		return false;
	});
	
	$('#js_cancel_new_group').click(function()
	{
		$('#js_group_holder').hide();
		$('#js_field_holder').show();		
		
		return false;
	});	
	
	$('.js_delete_current_option').click(function()
	{
		if (confirm(oTranslations['custom.are_you_sure_you_want_to_delete_this_custom_option']))
		{
			aParams = $.getParams(this.href);
			
			$.ajaxCall('custom.deleteOption', 'id=' + aParams['id']);
		}
		
		return false;
	});
	$('.js_custom_change_group').click(function()
	{		
		$(this).parents('ul:first').find('li').removeClass('active');
		$(this).parent().addClass('active');
		$('.js_custom_groups').hide();
		$('.js_custom_group_' + this.id.replace('group_', '')).show();				
		
		return false;
	});
};