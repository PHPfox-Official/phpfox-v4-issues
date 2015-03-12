/**
 * Creates an AJAX call using jQuery.load()
 * Data is inserted into DOM
 *
 * @param string sCall Name of the Component
 * @param string sExtra Extra params we plan to pass
 */
$.ajaxBox = function(sCall, sExtra)
{
	var sParams = getParam('sJsAjax') + '?' + getParam('sGlobalTokenName') + '[ajax]=true&' + getParam('sGlobalTokenName') + '[call]=' + sCall;
	if (sExtra)
	{
		sParams += '&' + sExtra;
	}	
	
	if (!sParams.match(/\[security_token\]/i))
	{
		sParams += '&' + getParam('sGlobalTokenName') + '[security_token]=' + oCore['log.security_token'];
	}	
	
	return sParams;
};

var oCacheAjaxRequest = null;
var aCacheAjaxLastCall = {};

window.onbeforeunload = function() 
{
	if (oCacheAjaxRequest !== null)
	{
		oCacheAjaxRequest.abort();
	}	
};

/**
 * Create AJAX Call
 *
 * @param	string	sFunction	Name of the function we plan to use
 * @param	string	sId	Form ID
 */
$.fn.ajaxCall = function(sCall, sExtra, bNoForm, sType)
{	
	if (empty(sType))
	{
		sType = 'POST';
	}
	
	switch (sCall){
		case 'share.friend':
		case 'share.email':
		case 'share.bookmark':
		case 'share.post':
			sType = 'POST';
			break;
		default:
			
			break;
	}	
	
	var sUrl = getParam('sJsAjax');
	
	if (typeof oParams['im_server'] != 'undefined' && sCall.indexOf('im.') > (-1))
	{
		sUrl = getParam('sJsAjax').replace(getParam('sJsHome'),getParam('im_server'));
	}
	
	var sParams = '&' + getParam('sGlobalTokenName') + '[ajax]=true&' + getParam('sGlobalTokenName') + '[call]=' + sCall + '' + (bNoForm ? '' : this.getForm());
	if (sExtra)
	{
		sParams += '&' + ltrim(sExtra, '&');
	}
	
	if (!sParams.match(/\[security_token\]/i))
	{
		sParams += '&' + getParam('sGlobalTokenName') + '[security_token]=' + oCore['log.security_token'];
	}
	
	sParams += '&' + getParam('sGlobalTokenName') + '[is_admincp]=' + (oCore['core.is_admincp'] ? '1' : '0');
	sParams += '&' + getParam('sGlobalTokenName') + '[is_user_profile]=' + (oCore['profile.is_user_profile'] ? '1' : '0');
	sParams += '&' + getParam('sGlobalTokenName') + '[profile_user_id]=' + (oCore['profile.user_id'] ? oCore['profile.user_id'] : '0');	

	if (getParam('bJsIsMobile')){
		sParams += '&js_mobile_version=true';
	}
	
	oCacheAjaxRequest = $.ajax(
	{
			type: sType,
		  	url: sUrl,//getParam('sJsStatic') + "ajax.php",
		  	dataType: "script",	
			data: sParams			
		}
	);
	return oCacheAjaxRequest;
};

$.ajaxCall = function(sCall, sExtra, sType)
{
    return $.fn.ajaxCall(sCall, sExtra, true, sType);
};

/**
 * Get form details
 * @param	string	frm	Form ID or Element ID
 * @return	string	Return parsed URL string
 */
$.fn.getForm = function()
{
	var objForm = this.get(0);	
	var prefix = "";
	var submitDisabledElements = false;
	
	if (arguments.length > 1 && arguments[1] == true)
	{
		submitDisabledElements = true;
	}
	
	if(arguments.length > 2)
	{
		prefix = arguments[2];
	}

	var sXml = '';
	if (objForm && objForm.tagName == 'FORM')
	{
		var formElements = objForm.elements;		
		for(var i=0; i < formElements.length; i++)
		{
			if (!formElements[i].name)
			{
				continue;
			}
			
			if (formElements[i].name.substring(0, prefix.length) != prefix)
			{
				continue;
			}
			
			if (formElements[i].type && (formElements[i].type == 'radio' || formElements[i].type == 'checkbox') && formElements[i].checked == false)
			{
				continue;
			}
			
			if (formElements[i].disabled && formElements[i].disabled == true && submitDisabledElements == false)
			{
				continue;
			}
			
			var name = formElements[i].name;
			if (name)
			{				
				sXml += '&';
				if(formElements[i].type=='select-multiple')
				{
					for (var j = 0; j < formElements[i].length; j++)
					{
						if (formElements[i].options[j].selected == true)
						{
							sXml += name+"="+encodeURIComponent(formElements[i].options[j].value)+"&";
						}
					}
				}
				else
				{
					sXml += name+"="+encodeURIComponent(formElements[i].value);
				}
			}
		}
	}	

	if ( !sXml && objForm)
	{
		sXml += "&" + objForm.name + "="+ encodeURIComponent(objForm.value);
	}	
	
	return sXml;
};