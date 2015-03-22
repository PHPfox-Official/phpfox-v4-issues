<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: photo-album.html.php 867 2009-08-17 13:58:08Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !empty($aAlbum.image_path)}
<div class="t_center" style="margin-bottom:15px;">
	{img thickbox=true server_id=$aAlbum.server_id path='music.url_image' file=$aAlbum.image_path suffix='_200' max_width='200' max_height='200'}
</div>
{/if}