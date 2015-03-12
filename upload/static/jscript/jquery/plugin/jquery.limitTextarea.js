
function limitChars(textid, limit, infodiv)
{
	var text = $((typeof(textid) == 'object' ? textid : '#' + textid)).val();	
	var textlength = text.length;
	
	if(textlength > limit)
	{
		$('#' + infodiv).html(oTranslations['core.you_cannot_write_more_then_limit_characters'].replace('{limit}', limit));
		
		$((typeof(textid) == 'object' ? textid : '#' + textid)).val(text.substr(0,limit));
		
		return false;
	}
	else
	{
		$('#' + infodiv).html(oTranslations['core.you_have_limit_character_s_left'].replace('{limit}', (limit - textlength)));
		
		return true;
	}
}