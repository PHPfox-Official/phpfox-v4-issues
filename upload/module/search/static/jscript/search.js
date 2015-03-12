
$Core.search =
{
	aParams: new Array(),
	
	iCurrent: 0,
	
	init: function(aParams)
	{
		this.aParams = aParams;
		
		this.iCurrent = this.aParams['limit'];
	},
	
	viewMore: function(bNoSlide)
	{
		var iFirstDiv = null;
		$('.search_result').each(function()
		{
			var iId = this.id.replace('search_', '');
			
			if (iId > $Core.search.iCurrent && iId <= ($Core.search.iCurrent + $Core.search.aParams['limit']))
			{
				if (iFirstDiv === null)
				{
					iFirstDiv = iId;					
				}
				
				$(this).show();
			}			
		});		
		
		if (bNoSlide !== true)
		{
			$.scrollTo('#scroll_' + iFirstDiv, 800);
		}
		
		this.iCurrent = (this.iCurrent + $Core.search.aParams['limit']);
		
		var iNextView = (this.aParams['total'] - this.iCurrent);		
		
		if (iNextView <= 0)
		{
			$('#js_view_more_holder').hide();
		}
		else
		{
			$('#js_view_more_count').html(iNextView);
		}
	},
	
	show: function(sModule)
	{
		$('.search_result').hide();
		$('.search_result').removeClass('row_first');
		$('#search ul li').removeClass('active');
		
		if (sModule == 'all')
		{			
			this.iCurrent = 0;
			
			$('#search ul li:first').addClass('active');	
			$('.module_form').hide();
			$('#js_view_more_holder').show();
			$('.search_result:first').addClass('row_first');
			
			this.viewMore(true);
		}
		else
		{
			$('.menu_' + sModule).addClass('active');		
			$('.module_' + sModule).show();
			$('#js_view_more_holder').hide();
			$('.module_form').hide();
			$('#js_view_more_form').show();
			$('#form_' + sModule).show();
			
			$('.module_' + sModule + ':first').addClass('row_first');			
		}
	}
}

$Behavior.search_search_1 = function()
{
	$('#js_view_more_results').click(function()
	{
		$Core.search.viewMore();	
		
		return false;
	});
	
	$('#search ul li a').click(function()
	{
		var aParts = explode('#', this.href);
		var sModule = aParts[1].replace('/', '');
		
		$Core.search.show(sModule);		
	});
};