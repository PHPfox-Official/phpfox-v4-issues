
$Behavior.loadVideoIframe = function()
{
	$('#js_upload_frame').html('<iframe id="js_upload_frame" name="js_upload_frame" style="width:90%; height:500px; display:none;"></iframe>');
	
	$('#js_video_form').submit(function()
	{
		$('#js_upload_inner_form').hide();
		$('#js_video_process').show();
		scroll(0,0);
		
		return true;
	});	
}

/**
 * This is a feedback function, it communicates to the user that the file was uploaded.
 * It is called from frame.class.php
 * It also controls if the uploaded file should be converted right away or not
 * @param iFile int file id
 * @param sObjectId string String id according to SWFUpload, it helps identify the id with information about this file
 */
function uploadCompleted(iFile, sObjectId)
{
	var sTarget = "#js_file_" + sObjectId + ' .status_text';

	$(sTarget).html("<span id='js_file_" + sObjectId + "_status'><img src='"+oJsImages['ajax_small']+"'> Converting</span>");
	$('#js_file_' + sObjectId + ' .js_progress_bar').remove();
	$('.swfupload').hide();
	$.ajaxCall("video.convert", "video_id="+iFile+"&fObjectId="+sObjectId, 'GET');
	$('#copyright_notice').hide();
}

function convertCompleted(fObjectId)
{
	$("#js_file_" + fObjectId + '_status').html("<img src='"+oParams['sImagePath']+"misc/accept.png'> File was Converted");
	$('#js_video_done').show();
}

function convertFailed(fObjectId)
{
	$("#js_file_" + fObjectId + '_status').html("<img src='"+oParams['sImagePath']+"misc/flag_red.png'> File could not be converted");
}