<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: info.html.php 1121 2009-10-01 12:59:13Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="gmap_{$aEvent.event_id}" style="width:100%; height:300px;">
	GMap holder
</div>
<script type="text/javascript">
	var oLatLng;
	var oMap;
	var oMarker;

	var script = document.createElement('script');
	script.type= 'text/javascript';
	script.src = '{if Phpfox::getParam("core.force_https_secure_pages")}https://{else}http://{/if}maps.google.com/maps/api/js?sensor=false&callback=showOnMap';
	document.body.appendChild(script);

	function showOnMap()
	{left_curly}
		oLatLng = new google.maps.LatLng({$aEvent.gmap.latitude}, {$aEvent.gmap.longitude});
		oMap = new google.maps.Map(document.getElementById("gmap_{$aEvent.event_id}"), {left_curly}
			zoom: 8,
			center: oLatLng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		{right_curly});
		oMarker = new google.maps.Marker({left_curly}
			map: oMap,
			position: oLatLng
		{right_curly});
	{right_curly}
</script>
