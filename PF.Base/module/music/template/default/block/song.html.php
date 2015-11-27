<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: song.html.php 2577 2011-04-29 08:48:05Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="js_my_block_track_player"></div>
<ul class="block_listing">
{foreach from=$aSongs name=songs item=aSong}
	{template file='music.block.mini'}
{/foreach}
</ul>