
/* jQuery plugin: PutCursorAtEnd 1.0
	http://plugins.jquery.com/project/PutCursorAtEnd
	by teedyay

	Puts the cursor at the end of a textbox/ textarea
	codesnippet: 691e18b1-f4f9-41b4-8fe8-bc8ee51b48d4
*/
$Behavior.putCursorAtEnd = function()
{
    jQuery.fn.putCursorAtEnd = function()
    {
        return this.each(function()
        {
            $(this).focus();
            /* If this function exists...*/
            if (this.setSelectionRange)
            {
                /* ... then use it
					(Doesn't work in IE)
					Double the length because Opera is inconsistent about whether a carriage return is one character or two. Sigh.*/
                var len = $(this).val().length * 2;
                this.setSelectionRange(len, len);
            }
            else
            {
                /* ... otherwise replace the contents with itself
                   (Doesn't work in Google Chrome)*/
                $(this).val($(this).val());
            }
            /* Scroll to the bottom, in case we're in a tall textarea
               (Necessary for Firefox and Google Chrome)*/
            this.scrollTop = 999999;
        });
    };
};

if (typeof(oEditor) == 'undefined')
{
	debug('oEditor not defined.');
}

var bAllowEditor = true;
if (oEditor['wysiwyg'] === false)
{
	bAllowEditor = false;	
}

var Editor = 
{
	sVersion: '1.0',
	
	sEditorId: 'text',
	
	sImagePath: getParam('sJsStaticImage') + 'editor/',
	
	sEditor: getParam('sEditor'),
	
	aEditors: new Array(),
	
	setId: function(sId)
	{
		this.sEditorId = sId;	
		
		this.aEditors[sId] = true;
		
		return this;
	},
	
	getId: function()
	{
		return this.sEditorId;
	},
	
	getEditors: function()
	{
		for (sEditor in this.aEditors)
		{
			this.sEditorId = sEditor;
			this.getEditor();
		}
	},
	
	fullScreen: function(sEditorId)
	{
		tb_show(oTranslations['core.full_screen_editor'], '#?TB_inline=true&type=textarea&parent_id=' + sEditorId);		
		
		return false;
	},
	
	getEditor: function(bReturn)
	{
		var sHtml;		
		
		if (this.sEditor == 'tinymce' && typeof(tinyMCE) == 'object' && tinyMCE.getInstanceById(this.sEditorId) == null)
		{
			this.sEditor = 'default';
		}
		
		if (!bAllowEditor)
		{
			this.sEditor = 'default';
		}

		sHtml = '';	
/*
		if (!isset(oEditor['no_fullscreen']) && !getParam('bJsIsMobile'))
		{
			sHtml += '<div style="float:right;"><a href="#" onclick="return Editor.fullScreen(\'' + this.sEditorId + '\');" class="editor_button">' + this.getImage(oEditor['toggle_image'], oEditor['toggle_phrase']) + '</a></div>';		
		}
*/
		$(oEditor['images']).each(function($iKey, $aValue)
		{
			if (isset($aValue[0]) && $aValue[0] == 'separator')
			{
				sHtml += Editor.getSeparator();	
			}
			else
			{
				if (isset($aValue['command']))
				{
					sHtml += Editor.getBBCode($aValue['image'], $aValue['command'], $aValue['phrase']);
				}
				else
				{
					sHtml += '<div class="editor_button_holder">';
					sHtml += '<a href="#" class="editor_button" onclick="' + (isset($aValue['js']) ? $aValue['js'] : 'Editor.ajaxCall(this, \'' + $aValue['ajax'] + '\');') + ' return false;">' + Editor.getImage($aValue['image'], $aValue['phrase']) + '</a>';
					sHtml += '<div class="editor_drop_holder"><div class="editor_drop_content"></div></div>';
					sHtml += '</div>';
				}
			}
		});		
	
		/*
		if ((bAllowEditor || oEditor['toggle']) && getParam('bWysiwyg'))
		{
			sHtml += this.getSeparator();			
			sHtml += '<a href="#" class="editor_button" onclick="return Editor.toggle(\'' + this.sEditorId + '\');"><img class="editor_button" src="' + this.sImagePath + 'toggle.gif" alt="' + getPhrase('core.toggle') + '" title="' + getPhrase('core.toggle') + '" id="editor_toggle" /></a>';
		}
		*/
		
		sHtml += '<div class="clear"></div>';
		
		if (bReturn)
		{
			return sHtml;
		}

		$('#js_editor_menu_' + this.getId()).html(sHtml);
		$('#js_editor_menu_' + this.getId()).show();
		$('#editor_toggle').blur();

		return true;
	},
	
	getList: function($sType)
	{
		var $sList = ($sType == 'bullet' ? 'ul' : 'ol');
		this.sLastListType = $sList;
		Editor.createBBtag("[" + $sList + "]", '', this.sEditorId);
		
		this.getListReply();
	},
	
	getListReply: function()
	{
		var $sReply = prompt('Enter text to build your list. Once you are done click cancel.', '');
		
		if (!empty($sReply))
		{
			Editor.createBBtag("\n[*]", "", this.sEditorId, $sReply);
			
			this.getListReply();
		}
		else
		{
			Editor.createBBtag("\n[/" + this.sLastListType + "]\n",'', this.sEditorId);
		}
	},
	
	ajaxCall: function($oObject, $sCall)
	{
		if (!empty($($oObject).parent().find('.editor_drop_content').html()))
		{
			$($oObject).parent().find('.editor_drop_holder').toggle();
			return;
		}
		
		var $sQuery = '';
		$sQuery = getParam('sGlobalTokenName') + '[ajax]=true&' + getParam('sGlobalTokenName') + '[call]=' + $sCall + '&editor_id=' + this.getId();
		
		$.ajax(
		{
			type: 'GET',
			dataType: 'html',
			url: getParam('sJsAjax'),
			data: $sQuery,
			success: function($sOutput)
			{							
				$($oObject).parent().find('.editor_drop_content').html($sOutput);
				$($oObject).parent().find('.editor_drop_holder').show();
			}
		});		
	},
	
	getAttachments: function(sEditorId)
	{
		tb_show('' + getPhrase('attachment.attach_files') + '', $.ajaxBox('attachment.add', 'height=500&width=600&category_id=' + Attachment['sCategory'] + '&attachments=' + $('#js_attachment').val() + '&item_id=' + Attachment['iItemId'] + '&editor_id=' + sEditorId));
		
		return false;
	},
	
	promptUrl: function(sEditorId)
	{
		tb_show('', $.ajaxBox('core.prompt', 'height=200&width=300&type=url&editor=' + sEditorId));
		
		return false;
	},
	
	promptImg: function(sEditorId)
	{
		tb_show('', $.ajaxBox('core.prompt', 'height=200&width=300&type=img&editor=' + sEditorId));

		return false;
	},	
	
	toggle: function(sEditorId) 
	{
		if (tinyMCE.getInstanceById(sEditorId) == null)
		{
			this.sEditor = 'tinymce';
			if (oEditor['toggle'])
			{
				customTinyMCE_init(sEditorId);
			}
			tinyMCE.execCommand('mceAddControl', false, sEditorId);
			$('#js_editor_menu_' + sEditorId).hide();
			debug('Enabled WYSIWYG text editor');
			deleteCookie('editor_wysiwyg');
		}
		else 
		{			
			tinyMCE.execCommand('mceRemoveControl', false, sEditorId);
			if (oEditor['toggle'])
			{
				$('#layer_text').html('<div id="layer_text"><textarea name="val[text]" rows="12" cols="50" class="w_95" id="text">' + tinyMCE.activeEditor.getContent() + '</textarea></div>');				
			}
			debug('Disabled WYSIWYG text editor');			
			setCookie('editor_wysiwyg', true, 360);
			if ($('#js_editor_menu_' + sEditorId).html() != '')
			{
				$('#js_editor_menu_' + sEditorId).show();
				$('#editor_toggle').blur();
				return false;
			}

			this.getEditor();
		}
		
		return false;
	},
	
	getSeparator: function()
	{
		return '<div class="editor_separator"></div>';
	},
	
	getBBCode: function(sName, sCode, sTitle)
	{
		sHtml = '<div class="editor_button_holder">';
		sHtml += '<a href="#" class="editor_button" onclick="return Editor.createBBtag(\'[' + sCode + ']\', \'[/' + sCode + ']\', \'' + this.sEditorId + '\');">' + this.getImage(sName, sTitle) + '</a>';
		sHtml += '</div>';
		
		return sHtml;
	},
	
	getImage: function(sName, sTitle)
	{
		return '<img class="editor_button" src="' + sName + '" alt="' + sTitle + '" title="' + sTitle + '" />';		
	},
	
	setContent: function(mValue)
	{		
		eval('var sContent = ' + this.sEditor + '_wysiwyg_setContent(mValue);');		
	},	
	
	getContent: function()
	{		
		eval('var sContent = ' + this.sEditor + '_wysiwyg_getContent();');
	
		return sContent;
	},
	
	insert: function(mValue)
	{	
		eval(this.sEditor + '_wysiwyg_insert(mValue);');
		
		$('.editor_drop_holder').hide();
		
		return true;
	},
	
	remove: function(mValue)
	{	
		eval(this.sEditor + '_wysiwyg_remove(mValue);');
		
		return true;
	},
	
	createBBtag: function(openerTag, closerTag, areaId, sEmptyValue) 
	{
		if(bIsIE && bIsWin) 
		{
			this.createBBtag_IE( openerTag , closerTag , areaId, sEmptyValue );
		}
		else 
		{
			this.createBBtag_nav( openerTag , closerTag , areaId, sEmptyValue );
		}
		
		$('#' + areaId).putCursorAtEnd();
		return false;
	},
	
	createBBtag_IE: function( openerTag , closerTag , areaId, sEmptyValue ) 
	{
		var txtArea = document.getElementById( areaId );
		var aSelection = document.selection.createRange().text;
		var range = txtArea.createTextRange();
	
		if(aSelection) 
		{
			document.selection.createRange().text = openerTag + aSelection + closerTag;
			txtArea.focus();
			range.move('textedit');
			range.select();
		}
		else 
		{
			if (!empty(sEmptyValue))
			{
				openerTag = openerTag + sEmptyValue;
			}			
			
			var oldStringLength = range.text.length + openerTag.length;
			txtArea.value += openerTag + closerTag;
			txtArea.focus();
			range.move('character',oldStringLength);
			range.collapse(false);
			range.select();
		}
		return;
	},
	
	createBBtag_nav: function( openerTag , closerTag , areaId, sEmptyValue ) 
	{
		var txtArea = document.getElementById( areaId );
		if (txtArea.selectionEnd && (txtArea.selectionEnd - txtArea.selectionStart > 0) ) 
		{
			var preString = (txtArea.value).substring(0,txtArea.selectionStart);
			var newString = openerTag + (txtArea.value).substring(txtArea.selectionStart,txtArea.selectionEnd) + closerTag;
			var postString = (txtArea.value).substring(txtArea.selectionEnd);
			txtArea.value = preString + newString + postString;
			txtArea.focus();
		}
		else 
		{
			if (!empty(sEmptyValue))
			{
				openerTag = openerTag + sEmptyValue;
			}
			
			var offset = txtArea.selectionStart;
			var preString = (txtArea.value).substring(0,offset);
			var newString = openerTag + closerTag;
			var postString = (txtArea.value).substring(offset);
			txtArea.value = preString + newString + postString;
			txtArea.selectionStart = offset + openerTag.length;
			txtArea.selectionEnd = offset + openerTag.length;
			txtArea.focus();
		}
		return;
	}	
};

if (!bAllowEditor)
{
	var bForceDefaultEditor = true;
}