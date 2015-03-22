<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: genre-profile.html.php 1164 2009-10-09 09:27:09Z Anna_Eliasson $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	<div class="info">
		<div class="info_left">
			{phrase var='music.genre'}:
		</div>	
		<div class="info_right">
			{foreach from=$aUserGenres item=aUserGenre}
				<div>
					<a href="{url link='music.'$aUserGenre.name_url''}">{$aUserGenre.name|clean}</a>
				</div>
			{/foreach}
		</div>	
	</div>