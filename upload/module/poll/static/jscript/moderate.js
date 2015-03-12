
function approvePoll(iPoll)
{
	if (confirm(getPhrase('core.are_you_sure')))
	{
		$.ajaxCall('poll.moderatePoll','iResult=0&iPoll='+iPoll);	
	}
	return false;
	
}

function deletePoll(iPoll)
{
	if (confirm(getPhrase('core.are_you_sure')))
	{
		$.ajaxCall('poll.moderatePoll','iResult=2&iPoll='+iPoll);	
	}
	return false;
}