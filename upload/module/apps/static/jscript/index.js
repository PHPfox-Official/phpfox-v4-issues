function applyFilter()
{
	var sParams = 'cats=';
	$('.chk_category:checked').each(function(){
		sParams += $(this).val() + ',';
	});
	sParams = sParams.substr(0, sParams.length - 1);
	
	$.ajaxCall('apps.filterByCategories', sParams);
}

function genKey()
{
	var aLetters = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
	var sOut = '';
	for (var i = 0; i<32; i++)
	{
		sOut += aLetters[Math.floor(Math.random() * 32) + 1];
	}
	$('#sPrivateKey').val(sOut);
}