
var oProgressBar = {};

var sImages = "";
var bIsHTML5ProgressUpload = false;
if(window.FormData !== undefined)
{
    bIsHTML5ProgressUpload = true;
}

$Core.loadStaticFile(getParam('sProgressCssFile'));

$Behavior.checkHTML5UploadSupport = function(){
    if (bIsHTML5ProgressUpload){
        $('.js_upload_button_link').hide();
    }
}

/**
 * Function is called when the upload is complete.
 */
function completeProgress()
{
   //  iTotalUploadedFiles--;
   // iTotalImagesToBeUploaded--;

	// Check if we have a plug-in
	if (function_exists('plugin_completeProgress'))
	{
		plugin_completeProgress();
	}	

	// $('.js_uploader_files_cache').remove();
	// $('.js_uploader_files_input').attr('disabled', false);
	// $('#js_progress_outer').hide();

	// $Core.loadInit();
	if (hasErrors && hasUploaded) {
		var html = '<div class="extra_info image_upload_failed">Some images failed to upload, however you can manage the ones that did upload <a href="' + sCurrentProgressLocation + sImages + '">here</a>.</a>';
		if ($('.image_upload_failed').length) {
			$('.image_upload_failed').replaceWith(html);
			return;
		}
		$('#js_progress_cache_loader').before(html);
		return;
	}

    if (bIsHTML5ProgressUpload && iTotalUploadedFiles == hasUploaded && !hasErrors)
    {
	   window.location.href = sCurrentProgressLocation + sImages;
    }
}

function startProcess(bForm, bForceImage)
{

}

function getProgress(sProgressKey)
{

}

function startProgress(sProgressKey)
{	

}

function addMoreToProgressBar()
{

}

function removeMoreToProgressBar(iId)
{

}

var iTotalImagesToBeUploaded = 0;
var iTotalUploadedFiles = 0;
var hasUploaded = 0;
var hasErrors = 0;

$Core.progressBarInit = function()
{
    if (!isset(oProgressBar['html5upload']) || (isset(oProgressBar['html5upload']) && !oProgressBar['html5upload'])){
        bIsHTML5ProgressUpload = false;
    }

	p('__LOADING_IMAGE_UPLOADER__');

	if ($(oProgressBar['uploader']).length > 0)
	{
		$(oProgressBar['progress_id']).html('<div id="js_progress_outer" style="width:300px;"><div id="js_progress_inner"><span id="js_progress_percent_value">0</span>/100%</div></div>');
		
		sInput = '<div id="js_uploader_files_outer">';
        if (bIsHTML5ProgressUpload)
        {
            oProgressBar['total'] = 1;
        }
		for (i = 1; i <= oProgressBar['total']; i++)
		{
			sInput += '<div class="js_uploader_files"><input ' + (bIsHTML5ProgressUpload ? 'multiple="multiple"' : '') + ' type="file" name="' + oProgressBar['file_id'] + '" class="js_uploader_files_input" size="30" ' + (bIsHTML5ProgressUpload ? '' : 'onchange="addMoreToProgressBar();"') + ' /></div>' + "\n";
		}
		sInput += '</div>';
		
		var iDivHeight = $(oProgressBar['holder']).innerHeight();	
		// $(oProgressBar['holder']).hide().after('<div id="js_progress_cache_loader" style="height:' + (iDivHeight <= 0 ? '200' : iDivHeight)  + 'px;">' + $.ajaxProcess('Loading', 'large') + '</div>');
		
		$(oProgressBar['holder']).after('<div id="js_progress_cache_loader" style="height:' + (iDivHeight <= 0 ? '200' : iDivHeight)  + 'px; display:none;"></div>');

        if (isset(oProgressBar['frame_id'])) {
            sInput += '<iframe id="' + oProgressBar['frame_id'] + '" name="' + oProgressBar['frame_id'] + '" height="500" width="500" frameborder="1" style="display:none;"></iframe>';
        }
		
		$(oProgressBar['uploader']).html(sInput);
		
		// $.ajaxCall('user.checkSpaceUsage', 'holder=' + oProgressBar['holder'].replace('#', ''), 'GET');

        if (bIsHTML5ProgressUpload){
            $('.js_uploader_files_input')[0].addEventListener("change", function(e) {

	            iTotalImagesToBeUploaded = 0;
	            iTotalUploadedFiles = 0;
	            hasUploaded = 0;
	            hasErrors = 0;

	            $(oProgressBar['holder']).hide();
				$('html, body').animate({
					scrollTop: $(oProgressBar['uploader']).scrollTop()
				});

                var files = e.target.files || e.dataTransfer.files;
	            iTotalUploadedFiles = files.length;
                for (var i = 0, f; f = files[i]; i++) {
                    if (i >= oProgressBar['max_upload']){
                        break;
                    }

                    if (isset(oProgressBar['valid_file_ext']))
                    {
                        sExt = f.name.split('.').pop().toLowerCase();
                        if ($.inArray(sExt, oProgressBar['valid_file_ext']) == -1)
                        {
                            sExts = '';
                            for (iExt in oProgressBar['valid_file_ext'])
                            {
                                if (iExt > 0)
                                {
                                    sExts += ', ';
                                }
                                sExts += oProgressBar['valid_file_ext'][iExt];
                            }
                            alert($('<div/>').html(oTranslations['core.not_a_valid_file_extension_we_only_allow_ext'].replace('{ext}', sExts)).text());

                            break;
                        }
                    }

                    ParseFile(f, i);
                    UploadFile(f, i);
                }
            }, false);
        }
	}
};

function ParseFile(file, iCnt) {

    $(oProgressBar['holder']).after("<div id=\"js_tmp_upload_" + iCnt + "\" class=\"js_tmp_upload_bar\"><div class=\"js_tmp_upload_bar_content\">" + file.name + "</div><div class=\"js_tmp_upload_bar_upload\"></div></div>").hide();
    if (file.type.indexOf("image") == 0) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#js_tmp_upload_' + iCnt).prepend('<div class="js_temp_photo_holder"><img src="' + e.target.result + '" style="max-width:25px; max-height:25px;" /></div>');
        }
        reader.readAsDataURL(file);
    }
};

function UploadFile(file, iCnt) {

    var data = new FormData();
    data.append('ajax_upload', file);
    $.ajax({
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(e) {
                var pc = parseInt((e.loaded / e.total * 100));
                $('#js_tmp_upload_' + iCnt + '').find('.js_tmp_upload_bar_upload').width(pc + '%').show();
                if (pc === 100 && iTotalImagesToBeUploaded === (iCnt + 1)) {

                }
            }, false);

            return xhr;
        },
        url: $(oProgressBar['holder']).find('form').attr('action'),
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        headers: {
            'X-FileName': file.name,
            'X-File-Size': file.size,
            'X-File-Type': file.type,
            'X-Post-Form': $(oProgressBar['holder']).find('form').getForm()
        },
        type: 'POST',
        error: function(error) {
            eval(error);
            $('#js_tmp_upload_' + iCnt + '').addClass('has_failed').find('.js_tmp_upload_bar_content').prepend('FAILED: ');
        },
        success: function(data) {
            eval(data);
        }
    });

    return;

    var xhr = new XMLHttpRequest();
    if (xhr.upload) {
        xhr.upload.addEventListener("progress", function(e) {
            var pc = parseInt((e.loaded / e.total * 100));
            $('#js_tmp_upload_' + iCnt + '').find('.js_tmp_upload_bar_upload').width(pc + '%').show();
            if (pc === 100 && iTotalImagesToBeUploaded === (iCnt + 1)) {

            }
        }, false);

        xhr.onreadystatechange = function(){
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                   eval(xhr.responseText);
                } else {
	                eval(xhr.responseText);
	                $('#js_tmp_upload_' + iCnt + '').addClass('has_failed').find('.js_tmp_upload_bar_content').prepend('FAILED: ');
                }
            }

        }
        xhr.open("POST", $(oProgressBar['holder']).find('form').attr('action'), true);
        // http://stackoverflow.com/questions/13771777/javascript-objects-xmlhttprequest-setrequestheader-method-doesnt-work
        // xhr.setRequestHeader("X_FILENAME", file.name);
        xhr.setRequestHeader("X-FILENAME", encodeURIComponent(file.name));
        // http://stackoverflow.com/questions/13771777/javascript-objects-xmlhttprequest-setrequestheader-method-doesnt-work
        // xhr.setRequestHeader("X_POST_FORM", $(oProgressBar['holder']).find('form').getForm());
        xhr.setRequestHeader("X-POST-FORM", $(oProgressBar['holder']).find('form').getForm());
        xhr.send(file);
    }
};
