<?php 
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: sponsored-album.html.php 1559 2010-05-04 13:06:56Z Miguel_Espinoza $
 */

defined('PHPFOX') or exit('NO DICE!'); 

?>

<div class="content t_center">
    <div class="">
	<a href="{url link='ad.sponsor' view=$aSponsorAlbum.sponsor_id}">{$aSponsorAlbum.name|clean|shorten:30}</a>
    </div>
    <a href="{url link='ad.sponsor' view=$aSponsorAlbum.sponsor_id}">{img server_id=$aSponsorAlbum.server_id path='music.url_image' file=$aSponsorAlbum.image_path suffix='_120' max_width='120' max_height='120'}</a>
    <div class="action">
		{$aSponsorAlbum|user} <br />
		{phrase var='music.released'}: {$aSponsorAlbum.year} <br />
		{phrase var='music.total_tracks' total=$aSponsorAlbum.total_track}
    </div>
</div>