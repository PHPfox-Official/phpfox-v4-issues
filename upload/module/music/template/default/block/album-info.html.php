<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: album-info.html.php 2562 2011-04-26 19:32:19Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="info">
	<div class="info_left">
		{phrase var='music.rating'}:
	</div>	
	<div class="info_right">
		{module name='rate.display'}
	</div>	
</div>
<div class="info">
	<div class="info_left">
		{phrase var='music.plays'}:
	</div>
	<div class="info_right">
		{$aAlbum.total_play}
	</div>
</div>
{if !empty($aAlbum.year)}
<div class="info">
	<div class="info_left">
		{phrase var='music.released'}:
	</div>
	<div class="info_right">
		{$aAlbum.year}
	</div>
</div>
{/if}
<div class="info">
	<div class="info_left">
		{phrase var='music.tracks'}:
	</div>
	<div class="info_right">
		{$aAlbum.total_track}
	</div>
</div>