<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: player.html.php 3553 2011-11-22 16:46:19Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="js_music_player_all" style="height:30px; width:100%; display:none;"></div>
<div class="label_flow" style="height:350px;">
	{module name='music.track' album_user_id=$aAlbum.user_id album_id=$aAlbum.album_id is_player=true}
</div>