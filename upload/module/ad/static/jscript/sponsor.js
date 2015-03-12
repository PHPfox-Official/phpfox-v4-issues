

$Core.Ad =
{
    iCost : 0,
    setPrice : function(iPrice)
    {
		this.iCost = iPrice;
    },

    roundNumber : function(iNum)
    {
		return Math.round(iNum*100)/100;
    },
    
    calcCost : function()
    {
		var sValue = $("#total_view").val();
		if (isNaN(this.iCost))
		{
			alert(oTranslations['ad.the_currency_for_your_membership_has_no_price']);
			return;	    
		}
		sValue=sValue.replace(/\D/g,'');

		if (sValue < 1000)
		{
			alert(oTranslations['ad.impressions_cant_be_less_than_a_thousand']);
			sValue=1000;
		}
		$("#total_view").val(sValue);
		
		$.ajaxCall('ad.getCost', 'fCost=' + (this.roundNumber(sValue * this.iCost / 1000)) + '&sTargetId=js_ad_cost');
		//$("#js_ad_cost").html(oTranslations['ad.for_currency_total_cost'].replace('{currency}', oCore['core.default_currency']).replace('{total_cost}',this.roundNumber(sValue * this.iCost / 1000))).show();
		$('.hasDatepicker:first').datepicker('setDate', new Date().getTime());
		$("#js_recalculate").hide();
    }
}

$Behavior.initSponsor = function()
{
	/* if ajax browsing is enabled ready is triggered before the dom is repopulated*/
	setTimeout('$Core.Ad.calcCost();', 100);
}