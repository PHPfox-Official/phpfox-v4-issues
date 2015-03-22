<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: latest-album.html.php 1265 2009-11-20 13:53:45Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aAlbums)}
{foreach from=$aAlbums name=albums item=aAlbum}
<div class="{if is_int($phpfox.iteration.albums/2)}row1{else}row2{/if}{if $phpfox.iteration.albums == 1} row_first{/if}">
	<div class="row_title">
		<div class="row_title_image">
			<a href="{url link=''$aAlbum.user_name'.music.'$aAlbum.name_url''}">{img server_id=$aAlbum.server_id path='music.url_image' file=$aAlbum.image_path suffix='_50' max_width='50' max_height='50'}</a>
		</div>
		<div class="row_title_info">
			<a href="{url link=''$aAlbum.user_name'.music.'$aAlbum.name_url''}">{$aAlbum.name|clean}</a>
			<div class="extra_info">
				<strong>{$aAlbum.full_name|clean}</strong>
				<div style="margin-top:8px; font-size:8pt;">
					{phrase var='music.total_plays' total=$aAlbum.total_play}<br />
					{phrase var='music.released'}: {$aAlbum.year}<br />
					{phrase var='music.total_tracks' total=$aAlbum.total_track}
				</div>
			</div>		
		</div>
	</div>
</div>
{/foreach}
{else}
<div class="extra_info">
	{phrase var='music.no_music_albums_have_been_created'}
</div>
{/if}