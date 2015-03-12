/* $(oNewTr).find('.hid_input').val(#) => 1:true, 2:false, 0:text;*/
$Core.subscribe = {

	iTotalFeatures : 0,
	bIsDisplay : false,
	
	addRow : function()
	{
		if ($Core.subscribe.bIsDisplay == true)
		{
			return;
		}
		
		if ($('.th_package_title').length < 1)
		{
			alert(getPhrase('subscribe.no_subscription_package_has_been_created_you_need_at_least_one_subscription_package'));
			return;
		}
		var oDate = new Date();
		var sNewId = 'js_new_' + oDate.getTime();
		
		var sTemplate = '<tr class="tr tr_feature" id="' + sNewId + '">' + $('#tr_features_template').clone().html() + '</tr>';
		
		$('#tr_last').before(sTemplate);
		
		/* replace the _ID_ part of the name*/
		var iIterator = 0;
		var sNew = '';
		$('.tr_feature').each(function(){
			$(this).find('.txt_package_feature, .txt_title, .hid_input').each(function(){
				sNew = $(this).attr('name').replace(/compare\[[0-9]+\]/, 'compare[' + iIterator + ']');				
				$(this).attr('name', sNew);				
			});
			
			iIterator++;
		});		
		
		$('#' + sNewId).find('.txt_title').val(getPhrase('subscribe.add_a_feature')).addClass('txt_title_new').focus(function(){
			if (this.value == getPhrase('subscribe.add_a_feature')){
				this.value = '';
				$(this).removeClass('txt_title_new');
			}
		});
		
		$Behavior.globalToolTip();
	},
	
	switchType: function(oObj)
	{
		if ($Core.subscribe.bIsDisplay == true)
		{
			return;
		}
		$(oObj).parent().find('span').not('.switch_type').not('.js_hover_info').toggle();
		if ($(oObj).parent().find('.div_text').css('display') != 'none')
		{
			$(oObj).parent().find('.hid_input').val('0');
		}
		else
		{
			$(oObj).parent().find('.hid_input').val( $(oObj).parent().find('.img_accept').is(':visible') ? '1' : '2' );
		}
	},
	
	toggleAccept: function(oObj)
	{
		if ($Core.subscribe.bIsDisplay == true)
		{
			return;
		}
		$(oObj).parent().find('img').toggle();
		$(oObj).parent().find('.hid_input').val( $(oObj).parent().find('.img_accept').is(':visible') ? '1' : '2' );
	},
	
	loadCompare : function(jCompare, bIsDisplay)
	{		
	
		var aCompare = JSON.parse(jCompare);
		var iTrCounter = 1;
		if (bIsDisplay == true)
		{
			$Core.subscribe.bIsDisplay = true;
		}
		
		for (var i in aCompare)
		{
			var sTemplate = '<tr class="tr tr_feature" id="tr_counter_' + iTrCounter + '">' + $('#tr_features_template').clone().html() + '</tr>';		
			
			$('#tr_last').before(sTemplate);
			
			/* Find the txt_title and set its value*/
			var oNewTr = $('#tr_counter_' + iTrCounter);
			
			if (aCompare[i]['feature_title'].indexOf('no-feature-title') < 0)
			{
				$(oNewTr).find('.txt_title').val(aCompare[i]['feature_title'].replace('&#039;', '\''));
			}
				
			$(oNewTr).find('.txt_title, .txt_package_feature, .hid_input').each(function(){
				$(this).attr('name', $(this).attr('name').replace(/compare\[[0-9]+\]/, 'compare[' + iTrCounter + ']'))
			});
			
			
			for (var j in aCompare[i]['feature_value'])
			{
				var oNewTrTd = $(oNewTr).find('#td_feature_' + aCompare[i]['feature_value'][j]['package_id']);
				
				if (aCompare[i]['feature_value'][j]['value'] == 'img_accept.png')
				{
					$(oNewTrTd).find('.div_text, .img_reject').hide();
					$(oNewTrTd).find('.div_radio, .img_accept').show();
					$(oNewTrTd).find('.hid_input').val(1);
				}
				else if (aCompare[i]['feature_value'][j]['value'] == 'img_cross.png')
				{
					$(oNewTrTd).find('.div_text, .img_accept').hide();
					$(oNewTrTd).find('.div_radio, .img_reject').show();
					$(oNewTrTd).find('.hid_input').val(2);
				}
				else
				{
					$(oNewTrTd).find('.div_text').show();
					$(oNewTrTd).find('.div_radio').hide();
					$(oNewTrTd).find('.hid_input').val(0);
					if (bIsDisplay == true)
					{
						$(oNewTrTd).find('.div_text .txt_package_feature').before(aCompare[i]['feature_value'][j]['value']).remove();
					}
					else
					{
						$(oNewTrTd).find('.div_text .txt_package_feature').val( aCompare[i]['feature_value'][j]['value']);
					}					
				}
				
				
			}
			
			iTrCounter++;
		}
		
		$Behavior.globalToolTip();
	}
}

$Behavior.loadImages = function()
{
	$('.img_accept').each(function(){
		$(this).attr('src', oParams['sImagePath'] + 'misc/accept.png');
	});
	$('.img_reject').each(function(){
		$(this).attr('src', oParams['sImagePath'] + 'misc/cross.png');
	});
}