<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: track.html.php 6307 2013-07-19 06:29:55Z Raymond_Benc $
 */

defined('PHPFOX') or exit('NO DICE!');

?>
<div id="js_block_track_player"></div>
<ul class="block_listing block_listing_hover" id="js_store_album_track">
	{foreach from=$aTracks name=songs item=aSong}
	{template file='music.block.track-entry'}
	{/foreach}
</ul>
{* if defined('PHPFOX_IS_ALBUM_VIEW')}
<div class="bottom">
	<ul>
		<li class="first">
			<a href="#" onclick="$Core.popup('{url link='music.player' album=$aAlbum.album_id play=1}', {l}scrollbars: 'no', location: 'no', menubar: 'no', width: 400, height: 450, resizable: 'no', center: true{r}); return false;">{phrase var='music.play_all'}</a>
		</li>
	</ul>
</div>
{/if *}
{if !count($aTracks)}
<div id="js_track_song_no_tracks" class="extra_info">
	{phrase var='music.no_tracks_have_been_added'}
</div>
{/if}