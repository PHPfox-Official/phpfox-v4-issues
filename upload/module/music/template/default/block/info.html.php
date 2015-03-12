<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: info.html.php 1742 2010-08-23 15:10:59Z Miguel_Espinoza $
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
		{phrase var='music.by'}:
	</div>
	<div class="info_right">
		{$aSong|user}
	</div>
</div>
<div class="info">
	<div class="info_left">
		{phrase var='music.added'}:
	</div>
	<div class="info_right">
		{$aSong.song_time_stamp|date}
	</div>
</div>
<div class="info">
	<div class="info_left">
		{phrase var='music.plays'}:
	</div>
	<div class="info_right">
		{$aSong.song_total_play}
	</div>
</div>