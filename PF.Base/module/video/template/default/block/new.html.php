<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: new.html.php 1316 2009-12-10 22:42:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aVideos)}
{foreach from=$aVideos name=videos item=aVideo}
	{template file='video.block.entry'}
{/foreach}
<div class="clear"></div>
{else}
<div class="extra_info">
	{phrase var='video.no_videos_have_been_added_yet'}
	<ul class="action">
		<li><a href="{url link='video.upload'}">{phrase var='video.be_the_first_to_add_a_video'}</a></li>
	</ul>
</div>
{/if}