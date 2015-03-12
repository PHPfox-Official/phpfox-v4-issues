
/* Implements Google Places into Pages */
$Core.PagesLocation = 
{	
	bGoogleReady: false,
	/* Here we store the places gotten from Google and Pages. This array is reset as the user moves away from the found place */
	aPlaces: [],
	
	/* The id of the div that will display the map of the current location */
	sMapId : 'js_location',
		
	/* Google requires the key to be passed so we store it here*/
	sGoogleKey : '',
	
	/* Google's Geocoder object */
	gGeoCoder: undefined,
	
	/* Google's marker in the map */
	gMarker: undefined,
	
	/* If the browser does not support Navigator we can get the latitude and longitude using the IPInfoDBKey */	
	sIPInfoDbKey: '',
		
	/* Google object holding my location*/
	gMyLatLng : undefined,		
	
	/* This is the google map object, we can control the map from this variable */
	gMap : {},
	
	/* This function is triggered by the callback from loading the google api*/
	loadGoogle : function(sGoogleKey)
	{
		sAddr = 'http://';
		if (window.location.protocol == "https:")
		{
			sAddr = 'https://';
		}
		var script  = document.createElement("script");
		script.type = "text/javascript";
		script.src  = sAddr+"maps.google.com/maps/api/js?libraries=places&sensor=true&key=" + oParams['core.google_api_key'] + "&callback=$Core.PagesLocation.init";
		document.body.appendChild(script);
	},
	
	init : function()
	{
		
		if(navigator.geolocation)
		{
			navigator.geolocation.getCurrentPosition(function(position) 
			{
			    
				$Core.PagesLocation.gMyLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				console.log('Check 1');console.log($Core.PagesLocation.gMyLatLng);
				$Core.PagesLocation.createMap();
				$Core.PagesLocation.createSearch();
				if ($('#txt_location_latlng').val() == '')
				{
				    $('#txt_location_latlng').val( $Core.PagesLocation.gMyLatLng.lat() + ',' + $Core.PagesLocation.gMyLatLng.lng() );
				}
			},
			function()
			{
				$Core.PagesLocation.gMyLatLng = new google.maps.LatLng('-4.49509', '-19.06131'); /* In the middle of the Atlantic ocean */
				$Core.PagesLocation.createMap();
				$Core.PagesLocation.createSearch();
				if ($('#txt_location_latlng').val() == '')
				{
				    $('#txt_location_latlng').val( $Core.PagesLocation.gMyLatLng.lat() + ',' + $Core.PagesLocation.gMyLatLng.lng() );
				}
			});
		}
		else
		{
			$Core.PagesLocation.gMyLatLng = new google.maps.LatLng('-4.49509', '-19.06131'); /* In the middle of the Atlantic ocean */
			$Core.PagesLocation.createMap();
			$Core.PagesLocation.createSearch();
			if ($('#txt_location_latlng').val() == '')
			{
			    $('#txt_location_latlng').val( $Core.PagesLocation.gMyLatLng.lat() + ',' + $Core.PagesLocation.gMyLatLng.lng() );
			}
		}
		
		$('#js_add_location_suggestions').css({'max-height': '100px', 'overflow-y': 'auto'});
		$($Core.PagesLocation).trigger('mapCreated');
	},
	
	/* Ready the input for the search */
	createSearch : function()
	{
		$Core.PagesLocation.gSearch = new google.maps.places.PlacesService($Core.PagesLocation.gMap);
		
		/* Prepare the input field so the user can type in locations */
		$('#txt_location_name')
		.css({'width': '300px'})
		.on('keyup',function(){
			var sName = $(this).val();
			if (sName.length < 3 || sName == $Core.PagesLocation.sLastName)
			{
				return;
			}
			$Core.PagesLocation.sLastName = sName;
			$Core.PagesLocation.gSearch.nearbySearch
			(
				{
					location: $Core.PagesLocation.gMyLatLng,
					radius: 6000,
					keyword: sName,
				}, 
				function(results, status)
				{
					if (status == google.maps.places.PlacesServiceStatus.OK)
					{
						$Core.PagesLocation.aPlaces = results;
						$Core.PagesLocation.displaySuggestions();
					}
				}
			);
			
		});
	},
	
	createMap: function()
	{
		var oMapOptions = 
		{
		  zoom: 13,
		  mapTypeId: google.maps.MapTypeId.ROADMAP,
		  center: $Core.PagesLocation.gMyLatLng
		};
		$Core.PagesLocation.gMap = new google.maps.Map(document.getElementById($Core.PagesLocation.sMapId), oMapOptions);
		$Core.PagesLocation.gSearch = new google.maps.places.PlacesService($Core.PagesLocation.gMap);
		
		/* Build the marker */
		$Core.PagesLocation.gMarker = new google.maps.Marker({
			map: $Core.PagesLocation.gMap,
			position: $Core.PagesLocation.gMyLatLng,
			draggable: true,
			animation: google.maps.Animation.DROP
		});
		
		$('#' + $Core.PagesLocation.sMapId).css({'height' : '300px', 'width' : '300px'});
		
		$Core.PagesLocation.gMap.panTo($Core.PagesLocation.gMyLatLng);
		google.maps.event.trigger($Core.PagesLocation.gMap, 'resize');
		
		/* Now attach an event for the marker */
		google.maps.event.addListener( $Core.PagesLocation.gMarker, 'mouseup', function()
		{
			/* Refresh gMyLatLng*/
			$Core.PagesLocation.gMyLatLng = new google.maps.LatLng($Core.PagesLocation.gMarker.getPosition().lat(), $Core.PagesLocation.gMarker.getPosition().lng());
			
			/* Refresh the hidden input */
			$('#txt_location_latlng').val($Core.PagesLocation.gMyLatLng.lat() + ',' + $Core.PagesLocation.gMyLatLng.lng());			
			
			/* Center the map */
			$Core.PagesLocation.gMap.panTo($Core.PagesLocation.gMyLatLng);
			
			/* Get the establishments near the new location */
			$Core.PagesLocation.getEstablishments($Core.PagesLocation.displaySuggestions);
		});
		$($Core.PagesLocation).trigger('mapCreated');
		$($Core.PagesLocation.gMarker).trigger('mouseup');
	},
	
	getEstablishments : function(oObj)
	{
		$Core.PagesLocation.gSearch.nearbySearch({
			location: $Core.PagesLocation.gMyLatLng,
			radius: '500'			
		}, function(aResults, iStatus){
			if (iStatus == google.maps.places.PlacesServiceStatus.OK) 
			{				
				$Core.PagesLocation.aPlaces = aResults;
				if (typeof oObj == 'function')
				{
					oObj();
				}
				$($Core.PagesLocation).trigger('gotEstablishments');
			}
		});
		
	},
	
	displaySuggestions: function()
	{
		var sOut = '';		
		$Core.PagesLocation.aPlaces.map(function(oPlace)
		{
			sOut += '<div class="js_div_place" onmouseover="$Core.PagesLocation.hintPlace(\''+oPlace['id']+'\');" onclick="$Core.PagesLocation.chooseLocation(\'' + oPlace['id'] + '\');">';
			sOut += '<div class="js_div_place_name">' + oPlace['name'] + '</div>';
			if (typeof oPlace['vicinity'] != 'undefined')
			{
				sOut += '<div class="js_div_place_vicinity">, ' + oPlace['vicinity'] + '</div>';
			}
			sOut += '</div>';
		});
		
		$('#js_add_location_suggestions').html(sOut).css({'z-index': 900, 'max-height':'100px'}).show();
	},
	
	hintPlace: function(sId)
	{
		$Core.PagesLocation.aPlaces.map(function(oPlace){
			if (oPlace.id == sId)
			{
				$Core.PagesLocation.gMap.panTo( oPlace['geometry']['location'] );
				$Core.PagesLocation.gMarker.setPosition( oPlace['geometry']['location'] );
				return;
			}
		});
	},
	
	chooseLocation: function(sId)
	{
		$Core.PagesLocation.aPlaces.map(function(oPlace){
			if (oPlace.id == sId)
			{
				$('#txt_location_name').val(oPlace.name);
				$('#txt_location_latlng').val( oPlace.geometry.location.lat() + ',' + oPlace.geometry.location.lng() );
				$('#js_add_location_suggestions').hide();
			}
		});
	},
	
	/* Only called from the php controller when editing*/
	setLocation: function(fLat, fLng, sName)
	{
		/* Check that the map exists */
		if (typeof $Core.PagesLocation.gMap == 'undefined' || typeof google == 'undefined' || typeof $Core.PagesLocation.gMap == 'undefined' || typeof $Core.PagesLocation.gMarker == 'undefined')
		{
			setTimeout($Core.PagesLocation.setLocation, 1000, fLat, fLng, sName);
			return;
		}
		
		sName = $('<div/>').html(sName).text();
		$('#txt_location_name').val(sName);
		$('#txt_location_latlng').val(fLat + ',' + fLng);
		
		/* point gMyLatLng to our current location */
		$Core.PagesLocation.gMyLatLng = new google.maps.LatLng(fLat, fLng);
		
		$Core.PagesLocation.gMap.panTo( $Core.PagesLocation.gMyLatLng);
		$Core.PagesLocation.gMarker.setPosition( $Core.PagesLocation.gMyLatLng );
		
		
		
	}
	
};

$Behavior.initPagesLocation = function(){
	/* Load Google */
	$('#' + $Core.PagesLocation.sMapId).hide();
	$Core.PagesLocation.loadGoogle();
	$('a[rel^=js_pages_block_]').click(function(){
		if ($(this).attr('rel') == 'js_pages_block_location')
		{
			$('#' + $Core.PagesLocation.sMapId).show();
			google.maps.event.trigger($Core.PagesLocation.gMap, 'resize');
			$Core.PagesLocation.gMap.panTo($Core.PagesLocation.gMyLatLng);
			$($Core.PagesLocation).on('mapCreated', function(){
			    $Core.PagesLocation.gMap.setCenter($Core.PagesLocation.gMyLatLng);
			});
		}
		else
		{
			$('#' + $Core.PagesLocation.sMapId).hide();
		}
	});
}
