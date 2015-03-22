/* Implements Google Places into the Feed to achieve a Check-In, it also checks for existing Pages first */
$Core.Feed = 
{
	/*For some reason a user may not want to fetch places from Google (only from Pages) or in case the admin has not set the Google API Key which is required */
	bUseGoogle : true,
	
	bGoogleReady: false,
	
	/* We store the maps and other information related to maps that only show when hovering over their locations in the feed entries */
	aHoverPlaces: {},
	
	/* Here we store the places gotten from Google and Pages. This array is reset as the user moves away from the found place */
	aPlaces : [],
	
	/* The id of the div that will display the map of the current location */
	sMapId : 'js_feed_check_in_map',
	
	/* This is the button that will trigger loading the autocomplete and the map*/
	sButtonId : 'btn_display_check_in',
	
	/* Google requires the key to be passed so we store it here*/
	sGoogleKey : '',
	
	/* Google's Geocoder object */
	gGeoCoder: undefined,
	
	/* Google's marker in the map */
	gMarker: undefined,
	
	gAutocomplete: undefined,
	
	/* If the browser does not support Navigator we can get the latitude and longitude using the IPInfoDBKey */	
	sIPInfoDbKey: '',
		
	/* Google object holding my location*/
	gMyLatLng : undefined,	
	
	/* Avoid collisions */
	sLastSearch: '',
	
	/* This is the google map object, we can control the map from this variable */
	gMap : undefined,
	
	/* The current status can be:
	 * 0 => Uninitialized
	 * 1 => Waiting for location from IPInfoDb
	 * 2 => Ready to query Google and server
	 */
	iStatus: 0,
	
	/* Prepare our location. If we have the location of the user in the database this function is called After gMyLatLng has been defined. */
	init: function(oInfo)
	{
		$('#' + $Core.Feed.sMapId)
			.css({
					height: '300px'
				})
			.hide();
		
		
		$('#js_location_input, #js_add_location').hide();
		
		if ($Core.Feed.sGoogleKey.length < 1 )
		{
			return;
		}
		
		
		$('#' + $Core.Feed.sButtonId)
			.click(function(){
				if (typeof $Core.Feed.gMyLatLng != 'undefined')
				{
					$Core.Feed.createMap();
					$Core.Feed.showMap();
					return;
				}
				$($Core.Feed).on('mapCreated', function(){ $Core.Feed.showMap(); });
				$Core.Feed.getVisitorLocation();
				
				return false;	
			});
		
		$('#js_add_location_suggestions')
			.on('mouseout', function(){
				/* $('#js_add_location_suggestions').hide();*/
			});
		
		$('#hdn_location_name')
			.focus(function(){				
				$('#js_feed_check_in_map, #js_add_location_suggestions').show();
				google.maps.event.trigger($Core.Feed.gMap, 'resize');
				$Core.Feed.gMap.setCenter($Core.Feed.gMyLatLng);
			})
			.val('Finding your location...')
			.css('width','80%')
			.on('keyup',function(){
				var sName = $(this).val();
				
				if ($(this).val().length < 3 )
				{
					$Core.Feed.aPlaces = [];
					return;
				}
				if ($Core.Feed.sLastSearch == sName)
				{
					return;
				}
				
				
				for (var i in $Core.Feed.aPlaces)
				{
					if (typeof $Core.Feed.aPlaces[i]['is_auto_suggested'] != 'undefined' && $Core.Feed.aPlaces[i]['is_auto_suggested'])
					{
						$Core.Feed.aPlaces.splice(i,1);
					}
					
				}
				$Core.Feed.sLastSearch = sName;
				$Core.Feed.gSearch.nearbySearch(
				{
					/*//bounds: $Core.Feed.gBounds,*/
					location: $Core.Feed.gMyLatLng,
					radius: 6000,
					keyword: sName
					/*//rankBy: google.maps.places.RankBy.DISTANCE*/
				}, 
				function(results, status)
				{
					if (status == google.maps.places.PlacesServiceStatus.OK)
					{
						results.map(function(oResult)
						{
							oResult['is_auto_suggested'] = true;
							$Core.Feed.aPlaces.push(oResult);
						});
						$Core.Feed.displaySuggestions();
					}
				});
				
			})
			.on('focus', function(){
				if ($('#js_add_location_suggestions').is(':visible') != true)
				{
				    $('#js_add_location_suggestions').show();
				}
			})
			.on('click', function(){
				/* Needed if they are selecting text */
				google.maps.event.trigger($Core.Feed.gMap, 'resize');
			});
		
		
		$($Core.Feed).on('gotVisitorLocation', function(){$Core.Feed.createMap();});
		
	},
	
	/* This function is called after a map exists ($Core.Feed.createMap() has been executed), it only shows it like when clicking the button */
	showMap : function()
	{
		if (typeof google == 'undefined')
		{
			$Core.Feed.iTimeShowMap = setTimeout($Core.Feed.showMap, 1000);
			return;
		}		
		
		if (typeof $Core.Feed.iTimeShowMap != 'undefined')
		{
			clearTimeout($Core.Feed.iTimeShowMap);
		}
		

		var gTempLat = false;
		$('#li_location_name, #js_location_input, #hdn_location_name, #js_add_location, #js_add_location_suggestions, #js_feed_check_in_map, #' + $Core.Feed.sMapId).show(400);
		$('.activity_feed_form_button_position').hide(400);
		setTimeout(
		    function()
		    {
			$('#' + $Core.Feed.sMapId).css('height', '300px');			
			
			/*setTimeout(function(){*/
				if (gTempLat == true)
				{
					return;
				}
				else
				{
					gTempLat = true;
				}
				
				$Core.Feed.getNewLocations(true);
				$('#hdn_location_name').focus();
				/*setTimeout(function(){*/
					google.maps.event.trigger($Core.Feed.gMap, 'resize');
					$Core.Feed.gMap.setCenter($Core.Feed.gMyLatLng);
				/*}, 700);*/
				
			/*}, 400);*/
		    }, 400
		);
		
	},
	
	
	getVisitorLocation :function(sFunction)
	{
		$('#js_add_location, #js_add_location_suggestions').show();
		if (typeof $Core.Feed.gMyLatLng != 'undefined')
		{
			if (typeof sFunction == 'function')
			{
				sFunction();
			}
			/* We already have a location */
			return false;
		}
		/* Get the visitors location */
		if(navigator.geolocation)
		{
			navigator.geolocation.getCurrentPosition(function(oPos) 
			{
				if (oPos.coords.latitude == 0 && oPos.coords.longitude == 0)
				{
					return;
				}
				$Core.Feed.gMyLatLng = new google.maps.LatLng(oPos.coords.latitude, oPos.coords.longitude);				
				$($Core.Feed).trigger('gotVisitorLocation');
				$.ajaxCall('user.saveMyLatLng', 'lat=' + oPos.coords.latitude + '&lng=' + oPos.coords.longitude);
			},
				function(){ $Core.Feed.getLocationWithoutHtml5(sFunction); }
			);
		}
		else
		{
			this.getLocationWithoutHtml5();
		}		
	},
	
	getLocationWithoutHtml5: function(sFunction)
	{
		/* Get visitor's city  */
		var sCookieLocation = getCookie('core_places_location');
		if (sCookieLocation != null)
		{
			var aLocation = sCookieLocation.split(',');
			$Core.Feed.gMyLatLng = new google.maps.LatLng( aLocation[0], aLocation[1]);
			$($Core.Feed).trigger('gotVisitorLocation');
		}
		else
		{
			var sParams = 'section=feed';
			switch (sFunction)
			{
				case 'showMap': sParams += '&callback=$Core.Feed.showMap'; break;
				case 'createMap': sParams += '&callback=$Core.Feed.createMap'; break;
			}
			$.ajaxCall('core.getMyCity', sParams);
		}
	},
	
	/* Called from the template when we have the location of the visitor */
	setVisitorLocation : function(fLat, fLng)
	{
		$Core.Feed.gMyLatLng = new google.maps.LatLng(fLat, fLng);
		$($Core.Feed).trigger('gotVisitorLocation');
	},
		
	createMap : function()
	{
		/* Creating map */
		if (typeof $Core.Feed.gMyLatLng == 'undefined' || typeof $Core.Feed.gMap != 'undefined')
		{
			return;
		}
		
		/* Build the map*/		
		var oMapOptions = 
		{
			zoom: 13,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			center: $Core.Feed.gMyLatLng,
			streetViewControl: false,
			scrollWheel: false
		};
		
		$('#js_add_location, #js_feed_check_in_map, #' + $Core.Feed.sMapId).show(400);
		setTimeout( function()
		{
			$Core.Feed.gMap = new google.maps.Map(document.getElementById($Core.Feed.sMapId), oMapOptions);
			/* Create the search object*/
			$Core.Feed.gSearch = new google.maps.places.PlacesService($Core.Feed.gMap);
			/* Build the marker */
			$Core.Feed.gMarker = new google.maps.Marker({
				map: $Core.Feed.gMap,
				position: $Core.Feed.gMyLatLng,
				draggable: true,
				animation: google.maps.Animation.DROP
			});
			
			/* Now attach an event for the marker */
			google.maps.event.addListener( $Core.Feed.gMarker, 'mouseup', function()
			{
				/* Refresh gMyLatLng*/
				$Core.Feed.gMyLatLng = new google.maps.LatLng($Core.Feed.gMarker.getPosition().lat(), $Core.Feed.gMarker.getPosition().lng());
				
				/* Center the map */
				$Core.Feed.gMap.panTo($Core.Feed.gMyLatLng);					
				
				$Core.Feed.getNewLocations();
			});
			
		}, 400);
		
		/* We need the name of the city to pre-populate the input */
		$Core.Feed.gGeoCoder = new google.maps.Geocoder();
		$Core.Feed.gGeoCoder.geocode({'latLng': $Core.Feed.gMyLatLng }, function(oResults, iStatus)
		{
			if (iStatus == google.maps.GeocoderStatus.OK && oResults[1])
			{
				$('#hdn_location_name').val( oResults[1].formatted_address );	
				$('#val_location_name').val( oResults[1].formatted_address );
				$('#val_location_name').val( oResults[1].geometry.location.lat() + ',' + oResults[1].geometry.location.lng() );
				
				oResults[1]['default_location'] = true;
				
				$Core.Feed.oDefaultPlace = oResults[1];				
				$Core.Feed.oDefaultPlace.name = oResults[1].formatted_address;
				$Core.Feed.oDefaultPlace.id = Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
			}
		});
		
		$Core.Feed.gBounds = new google.maps.LatLngBounds(
			new google.maps.LatLng( $Core.Feed.gMyLatLng.lat() - 1, $Core.Feed.gMyLatLng.lng()),
			new google.maps.LatLng( $Core.Feed.gMyLatLng.lat(), $Core.Feed.gMyLatLng.lng() + 1)
		);
		
		
		/* At this point gMyLatLng must exist */
		$.ajaxCall('feed.loadEstablishments', 'latitude=' + $Core.Feed.gMyLatLng.lat() + '&longitude=' + $Core.Feed.gMyLatLng.lng());
		
		$($Core.Feed).trigger('mapCreated');
	},
	
	getHash: function(sStr)
	{
		var iHash = 0;
		if (sStr.length == 0) return iHash;
		for (var i = 0; i < sStr.length; i++)
		{
			iHash = ((iHash << 5) - iHash) + sStr.charCodeAt(i);			
		}
		return iHash;
	},
	
	/* Populates and displays the div to show establishments given the current position as defined by gMyLatLng.
	 * it checks all of the items in aPlaces and gets the 10 nearer gMyLatLng, places the name of the city first.*/	 
	displaySuggestions: function()
	{		
		var sOut = '';
		
		$Core.Feed.aPlaces.push( $Core.Feed.oDefaultPlace );
		$Core.Feed.aPlaces.reverse();
		
		$Core.Feed.aPlaces.map(function(oPlace)
		{
			sOut += '<div class="js_div_place" onmouseover="$Core.Feed.hintPlace(\''+oPlace['id']+'\');" onclick="$Core.Feed.chooseLocation(\'' + oPlace['id'] + '\');">';
			sOut += '<div class="js_div_place_name">' + oPlace['name'] + '</div>';
			if (typeof oPlace['vicinity'] != 'undefined')
			{
				sOut += '<div class="js_div_place_vicinity">, ' + oPlace['vicinity'] + '</div>';
			}
			sOut += '</div>';
		});
		
		$('#js_add_location_suggestions').html(sOut).css({'z-index': 900, 'max-height':'100px'}).show();
	},
	
	/* Move the marker and pan the map to a location */
	hintPlace: function(sId)
	{
		$Core.Feed.aPlaces.map(function(oPlace)
		{
			if (oPlace['id'] == sId)
			{
				$Core.Feed.gMap.panTo( oPlace['geometry']['location'] );
				$Core.Feed.gMarker.setPosition(oPlace['geometry']['location']);
			}
		});
		
	},
	
	/* Visually accepts a suggestion and sets the internal value for the form*/
	chooseLocation: function(id)
	{
		var oPlace = false;
		$Core.Feed.aPlaces.map(function(oCheck){
			if (oCheck['id'] == id){ oPlace = oCheck; return; }
		});
		if (oPlace == false)
		{
			return;
		}
		
		if (typeof oPlace['latitude'] != 'undefined')
		{
			$('#val_location_latlng').val( oPlace['latitude'] + ',' + oPlace['longitude']);
		}
		else if (typeof oPlace['geometry'] != 'undefined')
		{
			$('#val_location_latlng').val( oPlace['geometry']['location'].lat() + ',' +  oPlace['geometry']['location'].lng());
		}
		$('#hdn_location_name, #val_location_name').val( oPlace['name']);
		$('#js_location_feedback').html( oTranslations['feed.at_location'].replace('{location}', oPlace['name'])).show();
		$('#js_add_location_suggestions, #js_feed_check_in_map, #js_location_input').hide();
		$('.activity_feed_form_button_position').show();
	},
	
	/* Adds New places to the $Core.Feed.aPlaces array by scannig the existing items before adding a new one,
	 * Receives a string in json format, called from an ajax response. The second parameter is an optional callback function */
	storePlaces: function(jPlaces, oCallback)
	{
		var oPlaces = $.parseJSON(jPlaces);
		$(oPlaces).each(function(iPlace, oNewPlace)
		{
			var bAddPage = true;
			$Core.Feed.aPlaces.map(function(oFeedPlace)
			{
				if (typeof oFeedPlace['page_id'] != 'undefined' && oFeedPlace['page_id'] == oNewPlace['page_id'])
				{
					/* its a page that we already added*/
					bAddPage = false;
				}
			});
			
			if (bAddPage)
			{
				if (typeof oNewPlace['id'] == 'undefined')
				{
					oNewPlace['id'] = Math.round(1000000*Math.random());
					oNewPlace['geometry']['location'] = new google.maps.LatLng( oNewPlace['geometry']['latitude'], oNewPlace['geometry']['longitude'] );
				}
				
				$Core.Feed.aPlaces.push(oNewPlace);				
			}
		});
		
		if (typeof oCallback == 'function')
		{
			oCallback();
		}
	},
	
	/* Ajax call to get more locations, needs to be called after a marker exists */
	getNewLocations: function(bAuto)
	{
		if (typeof $Core.Feed.gSearch == 'undefined')
		{
		    $Core.Feed.gSearch = new google.maps.places.PlacesService($Core.Feed.gMap);
		}
		var aTemp = [];
		$Core.Feed.aPlaces.map(function(oPlace){
			if (typeof oPlace['page_id'] != 'undefined') aTemp.push(oPlace);
		});
		
		$Core.Feed.aPlaces = aTemp;
		
		var sOut = '';
		
		$Core.Feed.gSearch.nearbySearch({
			location: $Core.Feed.gMyLatLng,
			radius: '500'			
		}, function(aResults, iStatus){
			if (iStatus == google.maps.places.PlacesServiceStatus.OK) 
			{
				for (var i = 0; i < aResults.length; i++) 
				{
					if (typeof bAuto == 'boolean' && bAuto == true)
					{
						aResults[i]['is_auto_suggested'] = true;
					}
					$Core.Feed.aPlaces.push(aResults[i]);					
				}
				$Core.Feed.displaySuggestions();
			}
		});
	},
	
	/* Doesnt have to be exact or in any specific measure, just needs to reliably tell *a* distance*/
	getDistanceFromPoints: function(oPlace1, oPlace2)
	{
		var xs = Math.pow( (oPlace2['latitude'] - oPlace1['latitude']), 2);
		var ys = Math.pow( (oPlace2['longitude'] - oPlace1['longitude']), 2);
		
		return Math.sqrt(xs + ys);
	},
	
	googleReady : function()
	{
		$Core.Feed.bGoogleReady = true;
	},
	
	showHoverMap : function(fLat, fLng, oObj)
	{
		/* Check if this item already has a map */
		if ($(oObj).siblings('.js_location_map').length > 0 )
		{
			$(oObj).siblings('.js_location_map').show();
			/* Trigger the resize to avoid visual glitches */
			google.maps.event.trigger($Core.Feed.aHoverPlaces[ $(oObj).siblings('.js_location_map').attr('id') ], 'resize');
			return;
		}
		
		var sId = 'js_map_' + Math.floor(Math.random() * 100000);
		
		var sInfoWindow = '<div class="js_location_map" id="' + sId + '"></div>';
		
		/* Load the map */
		$(oObj).after(sInfoWindow);
		
		var gLatLng = new google.maps.LatLng(fLat, fLng);
		var oMapOptions = 
		{
		  zoom: 13,
		  mapTypeId: google.maps.MapTypeId.ROADMAP,
		  center: gLatLng,
		  streetViewControl: false,
		  disableDefaultUI: true
		};
		
		$Core.Feed.aHoverPlaces[sId] = {
			map: new google.maps.Map(document.getElementById(sId), oMapOptions),
			geometry: {location : gLatLng}
			};

		/* Build the marker */
		$Core.Feed.gMarker = new google.maps.Marker({
			map: $Core.Feed.aHoverPlaces[sId]['map'],
			position: gLatLng,
			draggable: true,
			animation: google.maps.Animation.DROP
		});
		
		google.maps.event.trigger( $Core.Feed.aHoverPlaces[sId]['map'], 'resize');
		$(oObj).on('mouseout', function(){
			$('#' + sId).hide();			
		});
	},
	
	resetLocation:function()
	{
		$.ajaxCall('core.getMyCity', 'section=feed&saveLocation=1');
		$('#hdn_location_name').val(oTranslations['core.loading']);
	},
	
	
	cancelCheckIn: function()
	{
		/* Visually hide everything */
		$('#js_add_location, #js_location_input').hide();
		$('.activity_feed_form_button_position').show();
		$('#hdn_location_name, #val_location_name ,#val_location_latlng').val('');
	}
};
