<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="main_break"></div>
{if count($aVideos)}
<div id="js_video_edit_form_outer" style="display:none;">	
	<form method="post" action="#" onsubmit="$(this).ajaxCall('video.viewUpdate'); return false;">
		<div id="js_video_edit_form"></div>
		<div class="table_clear">
			<input type="submit" value="{phrase var='video.update'}" class="button" />
			- <a href="#" id="js_video_go_advanced">{phrase var='video.go_advanced'}</a>
			- <a href="#" onclick="$('#js_video_edit_form_outer').hide(); $('#js_video_outer_body').show(); return false;">{phrase var='video.cancel'}</a>
		</div>
	</form>
</div>

<div id="js_video_outer_body">
	{foreach from=$aVideos name=videos item=aVideo}
		{template file='video.block.entry'}
	{/foreach}
	<div class="clear"></div>
</div>
{else}
<div class="extra_info">
	{phrase var='video.no_videos_added_yet'}
	<ul class="action">
		<li><a href="{url link='video.upload'}">{phrase var='video.add_a_new_video'}</a></li>
	</ul>
</div>
{/if}