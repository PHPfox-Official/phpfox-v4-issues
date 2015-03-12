<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: rate.html.php 3533 2011-11-21 14:07:21Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !isset($aPhoto.photo_id)}
<div class="extra_info">
	{phrase var='photo.no_available_images_to_rate'}
</div>
{else}
<div class="main_break"></div>
<div class="t_center">
	<ul id="rate_bar">
		{$sRatingBar}		
	</ul>	
	{img server_id=$aPhoto.server_id path='photo.url_photo' file=$aPhoto.destination suffix='_500' max_width=500 max_height=500}
	<div class="extra_info">
		{phrase var='photo.added_by_full_name_br_on_time_stamp' full_name=$aPhoto|user time_stamp=$aPhoto.time_stamp|convert_time}
	</div>
	{plugin call='photo.template_controller_rate'}
</div>
{/if}