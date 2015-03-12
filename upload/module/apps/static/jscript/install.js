function allowApp(iId)
{
	var sParams='';
	$('select option:selected').each(function(){
		if ($(this).val() != 1)
		sParams += $(this).parent('.select_allow').attr('id') + ',';
	});
	
	$.ajaxCall('apps.install', 'iId='+iId+'&disallow=' + sParams);
}