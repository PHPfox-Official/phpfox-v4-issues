<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: featured.html.php 2569 2011-04-27 19:03:20Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="js_profile_block_track_player"></div>
<ul class="block_listing">
{foreach from=$aFeaturedSongs item=aSong}
	{template file='music.block.mini'}
{/foreach}
</ul>