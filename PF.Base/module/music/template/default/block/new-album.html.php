<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: new-album.html.php 3346 2011-10-24 15:20:05Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<ul class="block_listing">
{foreach from=$aNewAlbums item=aAlbum}
	<li>
		<div class="block_listing_image">
			<a href="{permalink module='music.album' id=$aAlbum.album_id title=$aAlbum.name}">{img server_id=$aAlbum.server_id path='music.url_image' file=$aAlbum.image_path suffix='_50_square' max_width='32' max_height='32'}</a>
		</div>
		<div class="block_listing_title" style="padding-left:38px;">
			<a href="{permalink module='music.album' id=$aAlbum.album_id title=$aAlbum.name}" title="{$aAlbum.name|clean}">{$aAlbum.name|clean|shorten:30:'...'|split:30}</a>
			<div class="extra_info">
				<ul class="extra_info_middot"><li>{if $aAlbum.total_track == 1}{phrase var='music.1_track'}{else}{phrase var='music.total_tracks' total=$aAlbum.total_track|number_format}{/if}</li><li>&middot;</li><li>{if $aAlbum.total_play == 1}{phrase var='music.1_play'}{else}{phrase var='music.total_plays' total=$aAlbum.total_play|number_format}{/if}</li></ul>
			</div>
		</div>
		<div class="clear"></div>	
	</li>
{/foreach}
</ul>