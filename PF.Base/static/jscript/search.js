/* This file couples the Search engine with the Inputs module */
if (typeof $Core.Search == 'undefined') $Core.Search = {}

/* this function calls the block input.add to display the available inputs for this module,
	this is used when searching for "Advanced Filters"*/
$Core.Search.showInputs = function(oObj, sModule)
{
	/* See if we need to include any previous filters*/
	var iLength = $(oObj).parents('.header_filter_holder').find('.active').length;	
	/*if (iLength > 0)
	{
		$(oObj).parents('.header_filter_holder').find('.active').each(function(){
			
		});
	}*/
	tb_show('Advanced Filters', $.ajaxBox('input.popUpFilters', 'height=400&width=750&module=' + sModule));	
};

$Core.Search.checkDefaultValue = function(oObj, sDefText)
{
	if ($(oObj).parents('.header_bar_search').find('.txt_input').val() == sDefText)
	{
		$(oObj).parents('.header_bar_search').find('.txt_input').val('');
	}
	
};
