if (typeof $Core.Pages == 'undefined') $Core.Pages = {};

$Core.Pages.Claim = 
{
	approve : function(iClaimId)
	{
		if (confirm('Are you sure you want to transfer ownership?'))
		{
			$.ajaxCall('pages.approveClaim', 'claim_id=' + iClaimId);
		}
	},
	
	deny : function(iClaimId)
	{
		if (confirm('Are you sure you want to transfer ownership?'))
		{
			$.ajaxCall('pages.denyClaim', 'claim_id=' + iClaimId);
		}
	}
};