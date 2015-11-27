function checkVal()
{
	return $('#add_select').val() == '0';
}
function readyAdd()
{
$('#add_select').change(function(){
	if (checkVal())
	{
		$('#is_group').hide();
	}
	else
	{
		$('#is_group').show();
	}
});
}

$(document).ready(function(){
	if (checkVal() == true) $('#is_group').hide();
	readyAdd();
});