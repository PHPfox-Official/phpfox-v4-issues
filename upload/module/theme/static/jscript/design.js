
$Core.design =
{
	aParams: {},
	
	init: function(aParams)
	{
		this.aParams = aParams;
		window.bHideIm = true;
	},	
	
	updateSorting: function()
	{
		var iCnt = 0;
		var sOrder = '';
		var aCache = new Array();
		var aClones = new Array();
		var aFinalCache = new Array();		
		
		$('.js_sortable').each(function()
		{			
			if (!empty(this.id))
			{					
				if (this.id.match(/clone_(.*)/))
				{
					aClones[this.id.replace('clone_', '')] = $(this).parents('.js_content_parent:first').attr('id');
				}
					
				aCache[this.id] = 'content';//$(this).parents('.js_content_parent:first').attr('id');	
					
				
				
				/* Figure out if this is in a sidebar */
				/* Check 1. if its not inside #main_content then its on the left side bar */
				//console.log('ids: ' + $(this).parents('div').map(function(){return this.id}).get().join(' '));
				
				/* this is the center section/div, not a sidebar*/
				aCache[this.id] = $(this).parent().attr('id').replace('js_can_move_blocks_', '');//'sidebar';				
				
				this.id = this.id.replace('clone_', '');	
			}	
		});				
		
		for (sBlock in aCache)
		{
			iCnt++;				
			if (!isset(aClones[sBlock]))
			{					
				aFinalCache[sBlock.replace('clone_', '')] = aCache[sBlock];
					
				sOrder += '&val[order][' + sBlock.replace('clone_', '') + '][' + aCache[sBlock] + ']=' + iCnt + '';					
			}
		}

		for (sParam in this.aParams)
		{
			sOrder += '&val[param][' + sParam + ']=' + this.aParams[sParam];
		}
		
		if (function_exists('designOnOrder'))
		{
			designOnOrder(aFinalCache);
		}		
		
		$.ajaxCall('theme.updateOrder', sOrder);
	}
}

function on_change_color(aParam, sHex)
{	
	var iIndexOfMatch = aParam['name'].indexOf('%20');
	while (iIndexOfMatch != -1)
	{
		aParam['name'] = aParam['name'].replace('%20', ' ');
		
		iIndexOfMatch = aParam['name'].indexOf('%20');
	}
	
	if (!empty(sHex) && !oValidateCss.isHex('#' + sHex))
	{
		p(sHex + ' is not a valid hex.');
		
		return false;
	}
	
	switch (aParam['attr'])
	{
		case 'font-color':
			aParam['attr'] = 'color';
			break;
		default:
		
			break;
	}
	
	if (sHex == '#transparent')
	{
		sHex = 'transparent';
	}
	
	if (function_exists('theme_on_change_color'))
	{
		theme_on_change_color(aParam, sHex);
	}
	
	p(aParam['name'] + ' -> ' + aParam['attr'] + ' -> '  + sHex);
	
	if (aParam['name'] == 'a')
	{
		$('body').append('<style type="text/css">' + aParam['name'] + '{' + aParam['attr'] + ':#' + sHex + ';}</style>');
	}
	else if (aParam['name'] == 'a:hover')
	{
		$('body').append('<style type="text/css">' + aParam['name'] + '{' + aParam['attr'] + ':#' + sHex + ';}</style>');
	}	
	else if (aParam['name'].search(/a:hover/i) != -1)
	{
		$('body').append('<style type="text/css">' + aParam['name'] + '{' + aParam['attr'] + ':#' + sHex + ';}</style>');		
	}
	else
	{	
		p(aParam['name'] + '{' + aParam['attr'] + ':' + (sHex == 'transparent' ? sHex : '#' + sHex) + ';}');
		$('body').append('<style type="text/css">' + aParam['name'] + '{' + aParam['attr'] + ':' + (sHex == 'transparent' ? sHex : '#' + sHex) + ';}</style>');		
	}
	
	return false;
}

function on_change_image(oObj)
{	
	if (!empty(oObj.value) && !oValidateCss.isImageLink(oObj.value))
	{
		p(oObj.value + ' is not a valid image.');
		
		return false;
	}	
	
	var aMatches = oObj.name.match(/(.*?)\[(.*?)\]\[(.*?)\]/i);
	
	if (function_exists('theme_on_change_image'))
	{
		theme_on_change_image(aMatches, oObj);
	}	
	
	$(aMatches[2]).css('background-image', 'url(\'' + oObj.value + '\')');	
	
	return false;
}

function on_change_attr(sName, sAttr, sValue)
{	
	if (!empty(sValue))
	{
		if (!isset(oValidateCss[sAttr]))
		{
			p(sAttr + ' is not valid.');
			
			return false;
		}
		
		if (!isset(oValidateCss[sAttr][sValue]))
		{			
			p(sAttr + ': ' + sValue + ' is not valid.');
			
			return false;
		}
	}
	
	p(sAttr + ' -> ' + sName + ' -> ' + sValue);
	
	$(sName).css(sAttr, sValue);
	
	return false;
}