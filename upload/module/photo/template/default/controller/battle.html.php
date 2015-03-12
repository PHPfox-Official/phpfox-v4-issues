<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: battle.html.php 3533 2011-11-21 14:07:21Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !isset($aPhotos.two)}
<div class="extra_info">
	{phrase var='photo.no_photos_found'}
</div>
{else}
<div {if $bFullMode} id="photo_battle_full_mode"{/if}>
	
	<div id="photo_battl_full_close">
		{if $bFullMode}
		<a href="{url link='photo.battle'}">{phrase var='photo.close_full_mode'}</a>
		{else}
		<a href="{url link='photo.battle' mode='full'}">{phrase var='photo.open_full_mode'}</a>
		{/if}
	</div>	
	<div class="photo_battle_holder">
		<div class="photo_battle_left">
			<a href="{$aPhotos.one.link}">{img server_id=$aPhotos.one.server_id path='photo.url_photo' file=$aPhotos.one.destination suffix='_'$sImageHeight'' max_width=$sMaxImageHeight max_height=$sMaxImageHeight}</a>
			<div class="extra_info">
				{phrase var='photo.added_by_full_name_br_on_time_stamp' full_name=$aPhotos.one|user time_stamp=$aPhotos.one.time_stamp|convert_time}
			</div>			
		</div>
		<div class="photo_battle_center">{phrase var='photo.vs'}</div>	
		<div class="photo_battle_right">
			<a href="{$aPhotos.two.link}">{img server_id=$aPhotos.two.server_id path='photo.url_photo' file=$aPhotos.two.destination suffix='_'$sImageHeight'' max_width=$sMaxImageHeight max_height=$sMaxImageHeight}</a>
			<div class="extra_info">
				{phrase var='photo.added_by_full_name_br_on_time_stamp' full_name=$aPhotos.two|user time_stamp=$aPhotos.two.time_stamp|convert_time}
			</div>		
		</div>
	</div>
</div>
{/if}