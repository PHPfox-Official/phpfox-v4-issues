function confirmDelete(iId)
{
	if(confirm(oTranslations['core.are_you_sure']))
	{
		$.ajaxCall('apps.deleteCategory', 'categoryid='+iId);
	}
}

function showEdit(iId)
{
	if ($('#catName' + iId).is(':visible'))
	{
		$('#catName' + iId).hide();
		$('#catInput' + iId).show();
	}
	else
	{
		$('#catName' + iId).show();
		$('#catInput' + iId).hide();
	}
	
}

function updateName(iId)
{
	if ($('#txtName' + iId).val().length < 1)
	{
		alert('Name cannot be empty');
		return false;
	}
	$.ajaxCall('apps.updateCategory', 'categoryid='+iId+'&name=' + $('#txtName'+iId).val());
	return true;
}