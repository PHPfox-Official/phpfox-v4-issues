
function theme_on_change_color(aParam, sHex)
{
	if (aParam['name'] == 'body' && aParam['attr'] == 'background-color')
	{	
		$('#main_content_holder').css('background', 'none');		
	}
	
	if (aParam['name'] == '#header' && aParam['attr'] == 'background-color')
	{	
		$('#header').css('background-image', 'none');		
	}	
	
	if (aParam['name'] == '#header_menu' && aParam['attr'] == 'background-color')
	{	
		$('#header_menu').css('background-image', 'none');		
	}	
	
	if (aParam['name'] == '#header_sub_menu_search_input, #header_sub_menu_search .focus' && aParam['attr'] == 'background-color')
	{	
		$('#header_sub_menu_search_input, #header_sub_menu_search .focus').css('background-image', 'none');		
	}	
}

function theme_on_change_image(aMatches, oObj)
{
	if (aMatches[2] == 'body' && aMatches[3] == 'background-image')
	{
		$('#main_content_holder').css('background', 'none');		
	}		
}