function quickSubmit(id, sUrl)
{
	var sText = $('#js_quick_edit'+id).val();	
	$.ajaxCall('blog.quickSubmit', 'id='+id+'&sText='+sText+'&sUrl='+sUrl);
	
	
}

