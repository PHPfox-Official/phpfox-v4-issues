<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Feed
 * @version 		$Id: display.html.php 4176 2012-05-16 10:49:38Z Raymond_Benc $
 * This fileis called from the form.html.php template in the feed module
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>

<li>
	<a href="#" type="button" id="btn_display_check_in" class="activity_feed_share_this_one_link parent feed_share_map js_hover_title" onclick="return false;">
		<span class="js_hover_info">
			Check-in
		</span>
	</a>
	
	<script type="text/javascript">
		$Behavior.prepareInit = function()
		{l}
			$Core.Feed.sIPInfoDbKey = '{param var="core.ip_infodb_api_key"}';
			$Core.Feed.sGoogleKey = '{param var="core.google_api_key"}';
			
			{if isset($aVisitorLocation)}
				$Core.Feed.setVisitorLocation({$aVisitorLocation.latitude}, {$aVisitorLocation.longitude} );
			{else}
				
			{/if}
			
			$Core.Feed.googleReady();
			$Core.Feed.init();
		{r}
	</script>
	<script type="text/javascript" src="{param var='core.url_module'}feed/static/jscript/places.js"></script>
	<script type="text/javascript" src="{if Phpfox::getParam('core.force_https_secure_pages')}https://{else}http://{/if}maps.googleapis.com/maps/api/js?key={param var="core.google_api_key"}&sensor=true&libraries=places"></script>					
</li>
