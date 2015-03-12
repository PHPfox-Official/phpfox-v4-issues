var oMarker;
var oGeoCoder;
var sQueryAddress;
var oMap;
var oLatLng;
var bDoTrigger = false;
/* This function takes the information from the input fields and moves the map towards that location*/
function inputToMap()
{
	var sQueryAddress = $('#address').val() + ' ' + $('#postal_code').val() + ' ' + $('#city').val();
	if ($('#js_country_child_id_value option:selected').val() > 0)
	{
		sQueryAddress += ' ' + $('#js_country_child_id_value option:selected').text();

		//$.ajaxCall('core.getChildre','country_iso=' + $('#country_iso option:selected').val());
	}
	sQueryAddress += ' ' + $('#country_iso option:selected').text();
	debug ('Searching for: ' + sQueryAddress);
	oGeoCoder.geocode({
		'address': sQueryAddress
		}, function(results, status)
		{
			if (status == google.maps.GeocoderStatus.OK)
			{
				oLatLng = new google.maps.LatLng(results[0].geometry.location.lat(),results[0].geometry.location.lng());
				oMarker.setPosition(oLatLng);
				oMap.panTo(oLatLng);
				$('#input_gmap_latitude').val(oMarker.position.lat());
				$('#input_gmap_longitude').val(oMarker.position.lng());
			}
		}
	);
	if (bDoTrigger)
	{
		google.maps.event.trigger(oMarker, 'dragend');
		bDoTrigger = false;
	}
}

function initialize()
{
	oGeoCoder = new google.maps.Geocoder();
	oLatLng = new google.maps.LatLng(aInfo.latitude, aInfo.longitude);
	
	var myOptions = {
		zoom: 11,
		center: oLatLng,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		mapTypeControl: false,
		streetViewControl: false
	}
	oMap = new google.maps.Map(document.getElementById("mapHolder"), myOptions);
	oMarker = new google.maps.Marker({
		draggable: true,
		position: oLatLng,
		map: oMap
	});

	
	/* Fake the dragend to populate the city and other input fields */
	google.maps.event.trigger(oMarker, 'dragstart');
	google.maps.event.trigger(oMarker, 'dragend');
	google.maps.event.addListener(oMarker, "dragend", function()
	{
		debug('drag end');
		$('#input_gmap_latitude').val(oMarker.position.lat());
		$('#input_gmap_longitude').val(oMarker.position.lng());
		oLatLng = new google.maps.LatLng(oMarker.position.lat(), oMarker.position.lng());
		oGeoCoder.geocode({
			'latLng': oLatLng
		},
		function(results, status)
		{
			if (status == google.maps.GeocoderStatus.OK)
			{
				$('#city').val('');
				$('#postal_code').val('');
				//debug (results[0]);
				for (var i in results[0]['address_components'])
				{
					if (results[0]['address_components'][i]['types'][0] == 'locality')
					{
						$('#city').val(results[0]['address_components'][i]['long_name']);
					}
					if (results[0]['address_components'][i]['types'][0] == 'country')
					{
						var sCountry = $('#country_iso option:selected').val();
						$('#js_country_iso_option_'+results[0]['address_components'][i]['short_name']).attr('selected','selected');
						if (sCountry != $('#country_iso option:selected').val())
						{
							$('#country_iso').change();
						}
					}
					if (results[0]['address_components'][i]['types'][0] == 'postal_code')
					{
						$('#postal_code').val(results[0]['address_components'][i]['long_name']);
					}
					if (results[0]['address_components'][i]['types'][0] == 'street_address')
					{
						$('#address').val(results[0]['address_components'][i]['long_name']);
					}
					if (isset($('#js_country_child_id_value')) && results[0]['address_components'][i]['types'][0] == 'administrative_area_level_1')
					{
						$('#js_country_child_id_value option').each(function(){
							if ($(this).text() == results[0]['address_components'][i]['long_name'])
							{
								$(this).attr('selected','selected');
								bHasChanged = true;
							}
						});
					}					
				}
			}
		});
	});
	/* Sets events for when the user inputs info */
	inputToMap();
}

function loadScript()
{
	sAddr = 'http://';
	if (window.location.protocol == "https:")
	{
		sAddr = 'https://';
	}
	var script = document.createElement('script');
	script.type= 'text/javascript';
	script.src = sAddr+'maps.google.com/maps/api/js?sensor=false&callback=initialize';
	document.body.appendChild(script);
}


$(document).ready(function(){
	$('#js_country_child_id_value').change(function(){
		debug("Cleaning  city, postal_code and address");
		$('#city').val('');
		$('#postal_code').val('');
		$('#address').val('');
	});
	$('#country_iso, #js_country_child_id_value').change(inputToMap);
	$('#address, #postal_code, #city').blur(inputToMap);	
	loadScript();
});
