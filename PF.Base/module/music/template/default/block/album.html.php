<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: album.html.php 2525 2011-04-13 18:03:20Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="main_break"></div>
{if count($aAlbums)}
{foreach from=$aAlbums name=albums item=aAlbum}
<div class="go_left" style="width:48%; margin-bottom:6px;">
	<div style="position:absolute; margin-left:125px; min-height:120px; height:auto !important; height:120px;">
		<a href="{url link=''$aUser.user_name'.music.'$aAlbum.name_url''}">{$aAlbum.name|clean}</a>
		<div class="extra_info">
			<strong>{$aUser.full_name|clean}</strong>
			<div style="margin-top:8px; font-size:8pt;">
				{phrase var='music.total_play_plays' total_play=$aAlbum.total_play}
				<br />
				{phrase var='music.released'}: {$aAlbum.year}<br />
				{phrase var='music.total_track_tracks' total_track=$aAlbum.total_track}
			</div>
		</div>		
	</div>
	<div style="width:122px; text-align:center; min-height:120px; height:auto !important; height:120px;">
		<a href="{url link=''$aUser.user_name'.music.'$aAlbum.name_url''}">{img server_id=$aAlbum.server_id path='music.url_image' file=$aAlbum.image_path suffix='_120' max_width='120' max_height='120'}</a>
	</div>	
</div>
{if is_int($phpfox.iteration.albums/2)}
<div class="clear"></div>
{/if}
{/foreach}
<div class="clear"></div>
{else}
<div class="extra_info">
	{phrase var='music.no_albums_have_been_created_yet'} 
	<ul>
		<li><a href="{url link='music.album'}">{phrase var='music.click_here_to_create_one'}</a></li>
	</ul>
</div>
{/if}