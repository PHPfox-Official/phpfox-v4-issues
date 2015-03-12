/*
$Core.loadStaticFile(getParam('sJsStatic') + 'jscript/jquery/plugin/imgnotes/jquery.imgareaselect.js');
$Core.loadStaticFile(getParam('sJsStatic') + 'jscript/jquery/plugin/imgnotes/jquery.imgnotes.js');
$Core.loadStaticFile(getParam('sJsStatic') + 'jscript/jquery/plugin/imgnotes/imgnotes.css');
$Core.loadStaticFile(getParam('sJsStatic') + 'jscript/jquery/plugin/imgnotes/imgareaselect/imgareaselect-default.css');
*/

$Core.photo_tag =
{
	aParams: {},
	
	sHtml: '',
	
	init: function(aParams)
	{		
		this.aParams = aParams;
				
		notes = aParams['js_notes'];
		
		$(function() 
		{
			if ($Core.photo_tag.aParams['id'] == '#js_photo_view_image'){
				if ($($Core.photo_tag.aParams['id']).is(':hidden')){
					$Core.photo_tag.aParams['id'] = '#js_photo_view_image_small';
				}
			}
			
			if ($($Core.photo_tag.aParams['id']).length <= 0)
			{
				return;
			}			
			
			$('.note').remove();
			
			if (isset(aParams['js_notes']))
			{
				$($Core.photo_tag.aParams['id']).imgNotes();		
			}
 
			$(aParams['tag_link_id']).click(function(){
				
				$($Core.photo_tag.aParams['id']).imgAreaSelect({onInit: showaddnote, onSelectChange: showaddnote, x1: 5, y1: 5, x2: 50, y2: 50});				

				return false;
			});
			
			if (isset($Core.photo_tag.aParams['in_photo']) && !empty($Core.photo_tag.aParams['notes']))
			{
				var sNotes = '';
				var iNoteCount = 0;
				$(aParams['notes']).each(function(){
					iNoteCount++;				
					sNotes += '<span onmouseover="$(\'#js_note_' + this.note_id + '\').addClass(\'note_hover\').show().css(\'z-index\', 10000);" onmouseout="$(\'#js_note_' + this.note_id + '\').removeClass(\'note_hover\').hide();">' + (iNoteCount != 1 ? ', ' : '') + this.note + '</span>';
				});
				
				$($Core.photo_tag.aParams['in_photo']).html(sNotes).parent().show();								
			}
			else
			{
				$($Core.photo_tag.aParams['in_photo']).parent().hide();
			}			
			
			this.sHtml = '<div id="noteform">';
			this.sHtml += '<form id="NoteAddForm" method="post" action="#" onsubmit="$(\'#noteform\').hide(); $(\'' + $Core.photo_tag.aParams['id'] + '\').imgAreaSelect({ hide: true }); $(this).ajaxCall(\'photo.addPhotoTag\'); return false;">';
			this.sHtml += '<input name="' + $Core.photo_tag.aParams['name'] + '[item_id]" type="hidden" value="' + $Core.photo_tag.aParams['item_id'] + '" />';
			this.sHtml += '<input name="' + $Core.photo_tag.aParams['name'] + '[x1]" type="hidden" value="" id="NoteX1" />';
			this.sHtml += '<input name="' + $Core.photo_tag.aParams['name'] + '[y1]" type="hidden" value="" id="NoteY1" />';
			this.sHtml += '<input name="' + $Core.photo_tag.aParams['name'] + '[height]" type="hidden" value="" id="NoteHeight" />';
			this.sHtml += '<input name="' + $Core.photo_tag.aParams['name'] + '[width]" type="hidden" value="" id="NoteWidth" />';
			this.sHtml += '<input name="' + $Core.photo_tag.aParams['name'] + '[tag_user_id]" type="hidden" value="0" id="js_tag_user_id" />';
			this.sHtml += '<input autocomplete="off" size="20" class="v_middle" type="text" name="' + $Core.photo_tag.aParams['name'] + '[note]" id="NoteNote" value="" onkeyup="$.ajaxCall(\'friend.searchDropDown\', \'search=\' + this.value + \'&amp;div_id=js_photo_tag_search_content&amp;input_id=js_tag_user_id&amp;text_id=NoteNote\', \'GET\');" />';
			this.sHtml += '&nbsp;&nbsp;&nbsp;<input type="submit" value="' + oTranslations['photo.save'] + '" class="button" />&nbsp;&nbsp;&nbsp;<input type="button" value="' + oTranslations['photo.cancel'] + '" class="button button_off" onclick="$(\'#noteform\').hide(); $(\'' + $Core.photo_tag.aParams['id'] + '\').imgAreaSelect({ hide: true });" />';
			this.sHtml += '<div style="display:none;"><div class="input_drop_layer" id="js_photo_tag_search_content"></div></div>';
			
			if ($Core.photo_tag.aParams['user_id'] && $('#js_photo_tag_user_id_' + $Core.photo_tag.aParams['user_id']).length == 0)
			{
				this.sHtml += '<div class="extra_info"><a href="#" onclick="$(\'#js_tag_user_id\').val(\'' + $Core.photo_tag.aParams['user_id'] + '\'); $(\'#noteform\').hide(); $(\'' + $Core.photo_tag.aParams['id'] + '\').imgAreaSelect({ hide: true }); $(\'#NoteAddForm\').ajaxCall(\'photo.addPhotoTag\'); return false;">' + oTranslations['photo.click_here_to_tag_as_yourself'] + '</a></div>';
			}			
			this.sHtml += '</form>';
			this.sHtml += '</div>';
			
			$('body').prepend(this.sHtml);	
		});		
	}
};

function showaddnote(img, area) 
{
	imgOffset = $(img).offset();
	form_left  = parseInt(imgOffset.left) + parseInt(area.x1);
	form_top   = parseInt(imgOffset.top) + parseInt(area.y1) + parseInt(area.height)+5;

	$('#noteform').css({ left: form_left + 'px', top: form_top + 'px'});
	$('#noteform').show();
	$('#noteform').css("z-index", 100000000);
	$('#NoteX1').val(area.x1);
	$('#NoteY1').val(area.y1);
	$('#NoteHeight').val(area.height);
	$('#NoteWidth').val(area.width);		
}