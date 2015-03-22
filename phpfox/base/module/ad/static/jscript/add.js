
var sGlobalAdHolder = 'js_sample_ad_form_728_90';

$Behavior.creatingAnAd = function()
{
	$('#js_upload_image_holder').hide();
	
	if ($('.tbl_province').length > 0)
	{
		$('#country_iso_custom').change($Core.Ad.handleStates);
	}
	
	
	
	if (!$Core.exists('#js_image_holder')){ console.log('exiting');
		return;
	}
	
	if ($Core.exists('#js_upload_image_holder_frame')){
		/*$('body').append($('#js_upload_image_holder_frame').html());
		$('#js_upload_image_holder_frame').remove(); */
	}	

	var oLocation = $('#js_image_holder').offset();
	
	$('#js_upload_image_holder').css('left', oLocation.left + 'px');
	$('#js_upload_image_holder').css('top', oLocation.top + 'px');
	$('#js_upload_image_holder').show();
	
	$('#title').keyup(function()
	{
		$('.js_ad_title').html(htmlspecialchars(this.value));
		limitChars(this, 25, 'js_ad_title_form_limit');
		if (oParams['ad.multi_ad'])
		{
			$('.ad_unit_multi_ad_title').html( $(this).val().replace('<','&lt;').replace('>','&gt;') );
			$('#js_sample_multi_ad_holder').show();
		}
	});
	
	$('#body_text').keyup(function()
	{
		$('.js_ad_body').html(htmlspecialchars(this.value));
		limitChars(this, 135, 'js_ad_body_text_form_limit');
		if (oParams['ad.multi_ad'])
		{
			$('.ad_unit_multi_ad_text').html( $(this).val().replace('<','&lt;').replace('>','&gt;') );
			$('#js_sample_multi_ad_holder').show();
			
		}
	});	
	
	if (oParams['ad.multi_ad'])
	{
		$('#url_link').keyup(function(){
			$('.ad_unit_multi_ad_url').html( $(this).val() );
			$('#js_sample_multi_ad_holder').show();
		})
		.blur(function(){
			$('.ad_unit_multi_ad_url').html( $('.ad_unit_multi_ad_url').html().replace('http://','').replace('<','&lt;').replace('>','&gt;') );
		})
		.focus(function(){
			$('#js_sample_multi_ad_holder').show('slow');
		});
		$('#body_text, #title').focus(function(){
			$('#js_sample_multi_ad_holder').show('slow');
		});
	}
	
	$('#js_ad_type_cpc').focus(function()
	{
		$('.js_ad_select').hide();
		$('#js_ad_cpc').show();
	});
	
	$('#js_ad_type_cpm').focus(function()
	{
		$('.js_ad_select').hide();
		$('#js_ad_cpm').show();
	});	
	
	$('#js_specific_date').focus(function()
	{
		$('#js_show_date').show();	
	});
	
	$('#js_specific_date_hide').focus(function()
	{
		$('#js_show_date').hide();	
	});	
	
	$('.js_create_ad').click(function()
	{
		$('.hide_sub_block').hide();
		$('#js_create_ad').show();
		$(this).parent().addClass('active');
		$('.js_upload_ad').parent().removeClass('active');
		$('#js_sample_ad_create_holder').show();
		$('#js_upload_image_holder').show();
		$('#type_id').val('2');
		
		return false;
	});
	
	$('.js_upload_ad').click(function()
	{
		$('.hide_sub_block').hide();
		$('#js_upload_ad').show();
		$(this).parent().addClass('active');
		$('.js_create_ad').parent().removeClass('active');		
		$('#js_sample_ad_create_holder').hide();
		$('#js_upload_image_holder').hide();
		$('#type_id').val('1');
		
		return false;
	});	

	$('#js_submit_button').click(function()
	{
		$('#html_code').val($('#' + sGlobalAdHolder).parent().html());	
		
		$('#js_custom_ad_form').ajaxCall('ad.checkAdForm');
		
		return false;
	});
	
	$('#location option').each(function()
	{
		if (this.value == '7')
		{
			this.selected = true;
		}
	});
	
	$('#js_ad_continue_form').click(function()
	{
		if (empty($('#js_upload_ad_size_find').val()) && $('#multi_ad_enabled').length < 1)
		{
			alert(getPhrase('ad.select_an_ad_placement'));
			
			return false;	
		}
		
		$.ajaxCall('ad.getAdPrice', 'block_id=' + $('#js_block_id').val() + '&location=' + $('#location').val() + '&isCPM=' + $Core.Ad.isCPM + '&total=' + $('#total_view').val());
		
		return true;
	});
	
	$('#total_view').keyup(function()
	{
		$('#js_ad_cost').hide();
		$('#js_ad_cost_recalculate').show();	
	});

	$('#js_image_holder_link a').click(function()
	{
		$(this).parent().hide(); 
		//$('.js_ad_image').hide(); 
		$('#js_upload_image_holder_frame').show();
		$('#js_upload_image_holder').show(); 
		$('#js_form_upload_file').val(''); 
		$.ajaxCall('ad.changeImage', 'image=' + encodeURIComponent($('#js_image_id').val())); 
		return false;
	});
}

$Core.Ad = 
{
	oPlan : {},
	isCPM : false,	
	recalculate : function()
	{
		var iTotal = $('#total_view').val();
		var sLocation = $('#location').val();
		var sBlockId = $('#js_block_id').val();
		if ($Core.Ad.isCPM == 1 && iTotal < 1000)
		{
			alert(oTranslations['ad.there_is_minimum_of_1000_impressions']);
		}
		else
		{
			$.ajaxCall('ad.recalculate', 'total=' + iTotal + '&location=' + sLocation + '&block_id=' + sBlockId + '&isCPM=' + $Core.Ad.isCPM);
		}		
	},
	setPlan : function(location_id, block_id, default_cost, width, height, is_cpm)
	{
		/* This function is mentioned in the ad.sample block and triggered when the user clicks in a Plan from the 
		pop up when creating an Ad */
		
		$('#location').val(location_id);
		$('#js_block_id').val(block_id);
		$Core.Ad.oPlan.default_cost = default_cost;
		$Core.Ad.blockPlacementCallback(width, height, location_id, is_cpm);	
		
		if (is_cpm == 1)
		{
			$('#js_ad_info_cost').html(oTranslations['ad.amount_currency_per_1000_impressions'].replace('{amount}',default_cost).replace('{currency}', oCore['core.default_currency']));
		}
		else
		{
			$('#js_ad_info_cost').html(oTranslations['ad.amount_currency_per_click'].replace('{amount}', default_cost).replace('{currency}', oCore['core.default_currency']));
		}
		
		tb_remove();
	},
	
	blockPlacementCallback : function(iWidth, iHeight, sBlock, isCPM)
	{
		$('#js_upload_ad_size_find').val('' + iWidth + 'x' + iHeight + '');
		
		$('.js_ad_holder').hide();	
		
		$('#js_ad_position_selected').find('span').html('Block ' + sBlock + ' (' + iWidth + 'x' + iHeight + ')')
		$('#js_ad_position_selected').show();
		$('#js_ad_position_select').hide();
		
		sGlobalAdHolder = (iWidth > iHeight ? 'js_sample_ad_form_728_90' : 'js_sample_ad_form_160_600');
		sId = '#' + sGlobalAdHolder;
		
		$(sId).show();
		$(sId).css('width', iWidth + 'px');
		$(sId).css('height', iHeight + 'px');	
		
		if ($('#type_id').val() == '2'){
			var oLocation = $('#js_image_holder').offset();
		
			$('#js_upload_image_holder').css('left', oLocation.left + 'px');
			$('#js_upload_image_holder').css('top', oLocation.top + 'px');
			$('#js_upload_image_holder').show();			
		}	
		
		if (typeof isCPM != 'undefined')
		{
			$Core.Ad.isCPM = isCPM;
			if ($Core.Ad.isCPM == false && $('#total_view').val() == 1000)
			{
				$('#total_view').val(500);				
			}
		}
		else
		{
			$Core.Ad.isCPM = false;
		}
		$('#js_is_cpm').val($Core.Ad.isCPM);
	},
	
	/* This function is triggered when the selector for countries changes, so we can display a list of provinces/states*/
	handleStates : function()
	{	
		var aChosenCountry = $('#country_iso_custom').val();
		$('.tbl_provice, .select_child_country').hide();
		
		for (var i in aChosenCountry)
		{
			if ( $('#sct_country_' + aChosenCountry[i]).length > 0 && $('#sct_country_' + aChosenCountry[i] + ' option').length > 0)
			{
				$('.tbl_province, #country_' + aChosenCountry[i]).show();
			}
		}		
	},
	
	setCountries: function(jCountries)
	{
		$Core.Ad.countries = JSON.parse(jCountries);		
	},
	
	toggleSelectedCountries : function(jCountries)
	{		
		$("#country_iso_custom > option").each(function(){ 
			if (this.value.length > 0 && (jCountries.indexOf(this.value) > (-1)) || (jCountries == this.value))
			{
				$(this).attr("selected", "selected"); 
				$('.tbl_province, #country_' + jCountries).show();
			}
		}); 
	},
	
	toggleSelectedProvinces : function(oProvinces)
	{		
		$(".sct_child_country > option").each(function(){
			if (isset(oProvinces[$(this).val()])) {
				$(this).attr("selected", "selected");
			}
		});
	}
}
