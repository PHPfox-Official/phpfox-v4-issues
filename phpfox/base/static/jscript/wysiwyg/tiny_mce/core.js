
function tiny_mce_wysiwyg_getContent()
{
	return tinyMCE.activeEditor.getContent();
}

function tiny_mce_wysiwyg_setContent(mValue)
{
	tinyMCE.activeEditor.setContent(mValue);	
}

function tiny_mce_wysiwyg_insert(mValue)
{
	switch(mValue['type'])
	{
		case 'emoticon':			
			sValue = ' <img src="' + mValue['path'] + '" alt="" /> ';
			break;
		case 'image':
			sValue = '<img src="' + mValue['path'] + '" />';
			break;
		case 'attachment':
			sValue = '[attachment="' + mValue['id'] + '"]' + mValue['name'] + '[/attachment]';
			break;
		case 'video':
			sValue = '[video]' + mValue['id'] + '[/video]';
			break;
	}			
	
	// Reset the editor ID# in case we have more then one editor open
	if (mValue['editor_id'])
	{
		Editor.setId(mValue['editor_id']);
	}
	
	tinyMCE.execCommand('mceInsertContent', false, sValue);
			
	return false;	
}

function tiny_mce_wysiwyg_remove(mValue)
{
	switch(mValue['type'])
	{
		case 'attachment':
			
			break;
	}	
}

function tiny_mce_wysiwyg_quick_edit(mId)
{
	tinyMCE.execCommand('mceFocus', false, mId);            
	tinyMCE.execCommand('mceRemoveControl', false, mId);
	tinyMCE.triggerSave(false, false);
}

function tiny_mce_wysiwyg_feed_reply(mId)
{
	tinyMCE.execCommand('mceFocus', false, mId);
	tinyMCE.triggerSave(false, false);	
}

var oFeedHistoryStore = {};
function tiny_mce_wysiwyg_feed_comment(mId)
{
	if (!isset(oFeedHistoryStore[mId]))
	{
		oFeedHistoryStore[mId] = 0;
	}
	
	oFeedHistoryStore[mId]++;
	
	$('#js_item_feed_' + mId).find('.js_comment_feed_textarea:first').attr('id', 'js_comment_feed_textarea_' + mId + oFeedHistoryStore[mId]);
	 
	customTinyMCE_init('js_comment_feed_textarea_' + mId + oFeedHistoryStore[mId]);	 
}

function tiny_mce_wysiwyg_feed_comment_start(mId)
{
	if (isset(oFeedHistoryStore[mId]))
	{
		 tinyMCE.activeEditor.destroy();	
		 p('Destorying TinyMCE ' + mId);
	}
}

function tiny_mce_wysiwyg_feed_comment_form(oObj)
{
	tinyMCE.triggerSave(false, false);		
}

function tiny_mce_wysiwyg_custom_field(mId)
{
	tinyMCE.triggerSave(false, false);	
}

function tiny_mce_newsletter_show_plain()
{
	tinyMCE.triggerSave(false, false);	
}