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
	
	var sUrl = getParam('sJsAjax'),
		sParams;
	if (sCall.substr(0, 7) == 'http://') {
		sUrl = sCall;
		sParams = this.getForm();
	}
	else {
		sParams = '&' + getParam('sGlobalTokenName') + '[ajax]=true&' + getParam('sGlobalTokenName') + '[call]=' + sCall + '' + (bNoForm ? '' : this.getForm());
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
	}

	oCacheAjaxRequest = $.ajax(
	{
			type: sType,
		  	url: sUrl,
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

$Core.processPostForm = function(e, obj) {
	if (typeof(e.append) == 'object') {
		$(e.append.to).append(e.append.with);
		$Core.loadInit();
	}

	if (typeof(e.error) == 'string') {
		obj.prepend(e.error);
	}

	if (obj instanceof jQuery) {
		if (obj.data('callback')) {
			eval('' + obj.data('callback') + '(e, obj);');
		}
	}

	if (typeof(e.redirect) == 'string') {
		window.location.href = e.redirect;
	}

	if (typeof(e.run) == 'string') {
		eval(e.run);
	}

	if (typeof(e.ace) == 'string') {
		$AceEditor.set(e.ace);
	}
};

$Behavior.onAjaxSubmit = function() {
	$('.moxi9:not(.built)').each(function() {
		var t = $(this);

		t.addClass('built');
		$.ajax({
			url: getParam('sJsHome'),
			data: 'm9callback=' + t.data('call') + '&current=' + encodeURIComponent(window.location.href),
			success: function(e) {
				if (typeof(e.error) == 'string') {

					t.html('<div class="error_message">' + e.error + '</div>');

					return;
				}

				t.data('json', e).addClass('success');
				$Core.loadInit();
			}
		});
	});

	$('div.ajax:not(.built)').each(function() {
		var t = $(this);
		t.html('<i class="fa fa-spin fa-circle-o-notch"></i>');
		t.addClass('built');
		$.ajax({
			url: t.data('url'),
			data: 'is_ajax_get=1',
			success: function(e) {
				// $Core.processPostForm(e, t);
				t.html(e);
				t.fadeIn();
				$Core.loadInit();
			}
		});
	});

	$('a.ajax').click(function() {
		var t = $(this),
			url = (t.data('url') ? t.data('url') : t.attr('href'));

		$.ajax({
			url: url,
			contentType: 'application/json',
			data: 'is_ajax_get=1',
			success: function(e) {
				$Core.processPostForm(e, t);
			}
		});

		return false;
	});

	$('.ajax_post').submit(function() {
		var t = $(this),
			callback = t.data('callback'),
			data = t.serialize();

		t.find('.error_message').remove();
		$.ajax({
			url: t.attr('action'),
			type: 'POST',
			data: data + '&is_ajax_post=1',
			success: function(e) {
				$Core.processPostForm(e, t);
				if (callback) {
					window[callback](e, t, t.serializeArray());
				}
			}
		});

		return false;
	});

	$('.on_enter_submit').keydown(function(e) {
		if (e.which == 13) {
			e.preventDefault();
			$(this).parents('form:first').trigger('submit');
			$(this).val('');
			return false;
		}
	});
};

var $AceEditor = {
	obj: null,
	set: function(value) {
		$AceEditor.obj.getSession().setValue(value);
	},
	mode: function(mode) {
		$AceEditor.obj.getSession().setMode('ace/mode/' + mode);
	}
};


$Core.upload = {
	listen: function(obj) {

		var f_input = obj.get(0);

		f_input.addEventListener("dragover", $Core.upload._prevent, false);
		f_input.addEventListener("dragleave", $Core.upload._prevent, false);
		f_input.addEventListener("drop",  function() {
			$Core.upload._upload(obj, this);
		}, false);

		f_input.addEventListener("change", function() {
			$Core.upload._upload(obj, this);
		}, false);
	},

	file: function(obj, file) {
		var xhr;

		xhr = new XMLHttpRequest();

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4) {
				$Core.processPostForm($.parseJSON(xhr.responseText), obj);
			}
		};

		if (obj.data('onstart')) {
			var thisFunction = window[obj.data('onstart')];
			thisFunction();
		}

		xhr.open('POST', obj.data('url'), true);

		xhr.setRequestHeader("Content-Type", "multipart/form-data");
		xhr.setRequestHeader("X-File-Name", file.name);
		xhr.setRequestHeader("X-File-Size", file.size);
		xhr.setRequestHeader("X-File-Type", file.type);

		xhr.send(file);
	},

	_upload: function(obj, _this) {
		if (typeof _this.files !== "undefined") {
			for (var i=0, l = _this.files.length; i<l; i++) {
				$Core.upload.file(obj, _this.files[i]);
			}
		}
	},

	_prevent: function(e) {
		e.stopPropagation();
		e.preventDefault();
	}
};

$Ready(function() {
	$('.on_change_submit').each(function() {
		var t = $(this);
		t.find('input, input:radio, textarea, select').change(function() {
			var t = $(this).parents('form:first');
			if (t.attr('action') == '#') {
				$(this).parents('form:first').trigger('submit');
			}
			else {
				$Core.processing();
				$.ajax({
					url: t.attr('action'),
					type: 'POST',
					data: t.serialize(),
					success: function(e) {
						$('.ajax_processing').fadeOut();
					}
				});
			}
		});

	});

	if ($('.ajax_upload').length) {

		$('.ajax_upload:not(.built)').each(function() {
			$(this).addClass('built');

			$Core.upload.listen($(this));
		});
	}
});

$Ready(function() {
	$('.ace_editor:not(.built)').each(function() {
		var t = $('.ace_editor');

		t.addClass('built');
		$.getScript('//cdn.jsdelivr.net/ace/1.1.8/min/ace.js', function() {
			$AceEditor.obj = ace.edit(t.get(0));
			$AceEditor.obj.setTheme('ace/theme/github');
			$AceEditor.obj.getSession().setMode('ace/mode/' + t.data('ace-mode'));

			if (t.data('ace-save')) {
				$AceEditor.obj.commands.addCommand({
					name: 'saveFile',
					bindKey: {
						win: 'Ctrl-S',
						mac: 'Command-S',
						sender: 'editor|cli'
					},
					exec: function(env, args, request) {
						var data = '';
						if (t.data('form-data')) {
							data = $(t.data('form-data')).serialize() + '&';
						}

						$.ajax({
							url: t.data('ace-save'),
							type: 'POST',
							data: data + 'is_ajax_post=1&content=' + encodeURIComponent($AceEditor.obj.getSession().getValue()),
							success: function(e) {
								p(e);
							}
						});
					}
				});
			}
		});
	});
});