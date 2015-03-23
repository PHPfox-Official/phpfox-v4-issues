$Core.input =
{
	iTotalOptions : 0,
	aLanguages: [],
	isEdit: false,
	aLanguages: [],
	isNewInput: false,
	
	/*Template for the languages in a table*/
	sLangsHeader: '',
	
	/*Template for inputs */
	sLangsInputTxt : '',
	
	countOptions: function()
	{
			$Core.input.iTotalOptions = $('#js_field_holder .m_option').length;
	},
	
	checkSubmit : function()
	{
		if ($('.chk_input:checked').length < 1)
		{
			$('#core_js_messages').html('<div class="error_message">Please allow at least one user group to enter information in this Input</div>');			
			return false;
		}
		/* Check Name */
			var bEmptyName = true;
			$('.lang_input_txt').each(function(){
				if ($(this).val().length > 0)
				{
					bEmptyName = false;
					return false;
				}
			});
			if (bEmptyName)
			{
				$('#core_js_messages').html('<div class="error_message">Im sorry but we need a name for this Input</div>');
				return false;
			}
		
		/* Check Options */		
		if ( $('#select_type').val().indexOf('text') < 0 && ($('.lang_option_txt').length < 1 || $('.lang_option_txt').filter(function(){
			return $(this).val() == '';
			}).length >= $('.lang_option_txt').length))
		{
			$('#core_js_messages').html('<div class="error_message">This type of field requires options to be added</div>');
			return false
		}
		return true;
	},
	
	addOption : function(oValue)
	{		
		if (typeof oValue == 'undefined')
		{
			$('.empty_option').parents('tr').remove();
		}
		
		$('#tbl_options tr:last').after('<tr>' + $Core.input.sLangsInputTxt + '</tr>');
		var iCount = $('#tbl_options .lang_input_txt').length;	
		if (iCount > 0)
		{
			$('#tbl_options tr:last .lang_input_txt').each(function()
			{				
				$(this).attr('name', 'val[option]['+ $(this).attr('id') +'][' + iCount +']');
			
				if (typeof oValue != 'undefined' && oValue['language_id'] == $(this).attr('id'))
				{
					$('.empty_option').html('');
					$(this).val(oValue['text']);
					$(this).attr('name', 'val[option][edit][' + $(this).attr('id') + '][' + oValue['phrase_id'] + ']');
					if (typeof oValue['option_id'] != 'undefined')
					{
						$(this).parents('tr').find('.ajax_ordering_option').attr('name', 'val[ordering][' + oValue['option_id'] + ']').val(oValue['ordering']);
						
					}
					if (typeof oValue['disabled'] != 'undefined')
					{
						$(this).replaceWith( $('<span />').text('No Options added').addClass('empty_option')).parent('tr').find('.drag_handle').html('');
					}
				}
				else
				{
					$(this).addClass('language_' + $(this).attr('id'));
				}
				$(this).addClass('lang_option_txt');
				
				 $(this).attr('id', $(this).attr('id') + '_' + iCount);
			});
		}
		 
		$('#tbl_options tr').each(function(){ $(this).find('.td_delete:not(:first)').html(''); });
		
	},
	
	deleteOption : function(oObj)
	{		
		if (confirm('are you sure?'))
		{
			$(oObj).parents('tr').find('.lang_input_txt').each(function(){
				$(this).attr('name', $(this).attr('name').replace('[edit]', '[delete]'));
			});
			
			if ($Core.input.isNewInput)
			{
				$(oObj).parents('tr').remove();
			}
			else
			{
				$(oObj).parents('tr').hide();
			}
		}
	},
	
	setLanguages: function(jLanguages)
	{
		$Core.input.aLanguages = JSON.parse(jLanguages);
		$Core.input.sLangsHeader = '';
		for (var i in $Core.input.aLanguages)
		{
			$Core.input.sLangsHeader += '<th></th><th></th><th>' + $Core.input.aLanguages[i]['title'] + '</th>';
			$Core.input.sLangsInputTxt += '<td class="drag_handle"><input type="hidden" class="ajax_ordering_option" name="val[][11]" value="1" /></td><td class="td_delete"><a href="#" onclick="$Core.input.deleteOption(this);return false;"><img src="' + getParam('sImagePath') + 'misc/delete.png" alt="" /></td><td class="td_lang_input"><input type="text" class="lang_input_txt" id="'+ $Core.input.aLanguages[i]['language_id']+'" /></a></td>';
		}
	},
	
	_prepareName:function()
	{
		var sTblName = '<table id="tbl_name"><tr>' + $Core.input.sLangsHeader + '</tr><tr>' + $Core.input.sLangsInputTxt + '</tr></table>';
		$('#div_input_name').html(sTblName);
		
		$('#tbl_name .td_delete').each(function(){$(this).html('');});
		
		var iCount = 1;		
		$('#tbl_name .lang_input_txt').each(function(){
			$(this).attr('name', 'val[name]['+ $(this).attr('id') +']');
			$(this).addClass('language_' + $(this).attr('id'));
			$(this).attr('id', 'txt_name_' + iCount);			
			iCount++;
		});
	},
	
	_prepareOption:function()
	{
		var sTblOptions = '<table id="tbl_options" class="js_drag_drop"><tr>' + $Core.input.sLangsHeader + '</tr></table>';		
		$('#div_input_option').html(sTblOptions);
	},
	
	prepareAdd: function()
	{
		$Core.input.isNewInput = true;
		$Core.input._prepareName();		
		/* Language inputs */
		$('#txt_only_language').remove();
		$Core.input._prepareOption();
				
		$Core.input.addOption();
		$Core.input.showOrHideOptions();
	},
	
	prepareEdit: function(jEdit)
	{
		$Core.input.isNewInput = false;
		$Core.input._prepareName();
		$Core.input._prepareOption();
		$('#tbl_name .td_delete').each(function(){$(this).html('');});
		
		var oEdit = JSON.parse(jEdit);
		
		for (var i in oEdit['name'])
		{
			$('#tbl_name .lang_input_txt').each(function()
			{
				if ($(this).hasClass('language_' + oEdit['name'][i]['language_id']))
				{
					$(this).val(oEdit['name'][i]['text']);
					$(this).attr('name', $(this).attr('name') + '[' + oEdit['name'][i]['phrase_id'] + ']');
				}
			});
		}
		
		/* Select the right action */
		$('#lst_module #' + oEdit['module_id'] + '.' + oEdit['action']).attr('selected','selected');
		$('#select_type #opt_' + oEdit['type_id']).attr('selected', 'selected');
		
		/* Conditions */
		for (var i in oEdit['condition'])
		{
			var oCondition = oEdit['condition'][i]; // easier
			if (oCondition['table_name'] == 'user')
			{
				var aOptions = oCondition['full_value'].split(',');
				for (var j in aOptions)
				{
					var sId = '#' + oCondition['column_name'] + '_' + aOptions[j];					
					if ($(sId).length > 0)
					{
						switch ($(sId).attr('type'))
						{
							case 'checkbox':
								$(sId).attr('checked', 'checked');
								break;
						}						
					}
				}
			}
		}
		
		/* Required */
		if (oEdit['required'] == 1)
		{
			$('#opt_required_yes').attr('selected', 'selected');
		}
		else
		{
			$('#opt_required_no').attr('selected', 'selected');
		}
		
		if (typeof oEdit['option'] == 'undefined' && oEdit['type_id'].indexOf('text') < (0))
		{
			$Core.input.addOption({
				'disabled':'disabled', 
				'phrase_id': 'none', 
				'language_id': 'en',
				'text': 'No options have been added'
			});
		}
		else
		{
			for (var i in oEdit['option'])
			{
				$Core.input.addOption(oEdit['option'][i]);
			}
		}
		
		$Core.input.showOrHideOptions('');
		
		if (typeof oEdit['is_required'] != 'undefined')
		{
			$('#lst_required #opt_required_' + (oEdit['is_required'] == 1 ? 'yes' : 'no')).attr('selected', 'selected');
		}
	},
	
	showOrHideOptions : function(sSpeed)
	{
		if (typeof sSpeed == 'undefined')
		{
			sSpeed = '';
		}
		if ($('#select_type').length < 1) return;
		var bShow = $('#select_type').val().indexOf('text') > 0;
		/* Check if we should display the "Add Options" part*/
		if ( bShow)
		{
			if ($('#div_options').is(':visible'))
			{
				$('#div_options').hide();
			}			
		}
		else 
		{
			$('#div_options').show();
		}
		
		/* Remove the "delete" button from the first option*/
		$('#tbl_options .td_delete:not(:first)').html('');
	},
	
	/* Adds sorting capabilities, are we using this function?? */
	addSort: function()
	{
		$('.sortable ul').sortable({
				axis: 'y',
				update: function(element, ui)
				{
					$Core.input.updateSort();
				},
				opacity: 0.4
			}
		);		
	},
}

$Behavior.initAdminInput = function()
{
	$('#select_type').change($Core.input.showOrHideOptions);
}