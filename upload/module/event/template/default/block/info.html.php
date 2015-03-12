<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: info.html.php 7046 2014-01-15 20:18:25Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="info_holder">

	<div class="info">
		<div class="info_left">
			<span itemprop="startDate" style="display:none;">{$aEvent.start_time_micro}</span>
			{phrase var='event.time'}
		</div>
		<div class="info_right">
			{$aEvent.event_date}	
		</div>
	</div>	
	
	{if is_array($aEvent.categories) && count($aEvent.categories)}
	<div class="info">
		<div class="info_left">
			{phrase var='event.category'}
		</div>
		<div class="info_right">
			{$aEvent.categories|category_display}
		</div>
	</div>		
	{/if}
	
	<div class="info" itemscope itemtype="http://schema.org/Place">
		<div class="info_left">
			{phrase var='event.location'}
		</div>
		<div class="info_right">				 	
			<span itemprop="name">{$aEvent.location|clean|split:60}</span>
			<div itemscope itemtype="http://schema.org/PostalAddress">
				{if !empty($aEvent.address)}
				<div class="p_2" itemprop="streetAddress">{$aEvent.address|clean}</div>
				{/if}			
				{if !empty($aEvent.city)}
				<div class="p_2" itemprop="addressLocality">{$aEvent.city|clean}</div>
				{/if}					
				{if !empty($aEvent.postal_code)}
				<div class="p_2" itemprop="postalCode">{$aEvent.postal_code|clean}</div>
				{/if}								
				{if !empty($aEvent.country_child_id)}
				<div class="p_2" itemprop="addressRegion">{$aEvent.country_child_id|location_child}</div>
				{/if}			
				<div class="p_2" itemprop="addressCountry">{$aEvent.country_iso|location}</div>
			</div>
			{if isset($aEvent.map_location)}						
			<div style="width:390px; height:170px; position:relative;">
				<div style="margin-left:-8px; margin-top:-8px; position:absolute; background:#fff; border:8px blue solid; width:12px; height:12px; left:50%; top:50%; z-index:200; overflow:hidden; text-indent:-1000px; border-radius:12px;">Marker</div>
				<a href="{if Phpfox::getParam('core.force_https_secure_pages')}https://{else}http://{/if}maps.google.com/?q={$aEvent.map_location}" target="_blank" title="{phrase var='event.view_this_on_google_maps'}"><img src="{if Phpfox::getParam('core.force_https_secure_pages')}https://{else}http://{/if}maps.googleapis.com/maps/api/staticmap?center={$aEvent.map_location}&amp;zoom=16&amp;size=390x170&amp;sensor=false&amp;maptype=roadmap" alt="" /></a>
			</div>		
			<div class="p_top_4">					
				<a href="{if Phpfox::getParam('core.force_https_secure_pages')}https://{else}http://{/if}maps.google.com/?q={$aEvent.map_location}" target="_blank">{phrase var='event.view_on_google_maps'}</a>
			</div>			
			{/if}
		</div>
	</div>
	
	<div class="info">
		<div class="info_left">
			{phrase var='event.created_by'}
		</div>
		<div class="info_right">
			{$aEvent|user}	
		</div>
	</div>

	{$aEvent.description|parse|split:70}

</div>
