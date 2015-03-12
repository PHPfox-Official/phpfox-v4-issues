
function default_wysiwyg_getContent()
{
	return $('#' + Editor.getId()).val();
}

function default_wysiwyg_insert(mValue)
{
	switch(mValue['type'])
	{
		case 'emoticon':
			sValue = '' + mValue['text'] + '';
			break;
		case 'image':
			sValue = '[img]' + mValue['path'] + '[/img]';
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
	
	var myField = document.getElementById(Editor.getId());
	if (document.selection)
	{
		myField.focus();				
		sel = document.selection.createRange();
		sel.text = sValue;
	}
	else if (myField.selectionStart || myField.selectionStart == '0')
	{
		var startPos = myField.selectionStart;
		var endPos = myField.selectionEnd;
		myField.value = myField.value.substring(0, startPos)
		+ sValue
		+ myField.value.substring(endPos, myField.value.length);
		myField.focus();
	}
	else
	{
		myField.value += sValue;
	}
			
	return false;	
}

function default_wysiwyg_remove(mValue)
{
	switch(mValue['type'])
	{
		case 'attachment':

			break;
	}	
}

function default_wysiwyg_setContent(mValue)
{
	$('#' + Editor.getId()).val(mValue);
}