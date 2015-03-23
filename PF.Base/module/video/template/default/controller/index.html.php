<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Video
 * @version 		$Id: index.html.php 3342 2011-10-21 12:59:32Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !count($aVideos)}
<div class="extra_info">
	{phrase var='video.no_videos_found'}
</div>
{else}
<div id="js_video_edit_form_outer" style="display:none;">
	<form method="post" action="#" onsubmit="$(this).ajaxCall('video.viewUpdate'); return false;">
		<div id="js_video_edit_form"></div>
		<div class="table_clear">
			<ul class="table_clear_button">
				<li><input type="submit" value="{phrase var='video.update'}" class="button" /></li>
				<li><a href="#" id="js_video_go_advanced" class="button_off_link">{phrase var='video.go_advanced_uppercase'}</a></li>
				<li><a href="#" onclick="$('#js_video_edit_form_outer').hide(); $('#js_video_outer_body').show(); return false;" class="button_off_link">{phrase var='video.cancel_uppercase'}</a></li>
			</ul>
			<div class="clear"></div>
		</div>
	</form>
</div>

<div id="js_video_outer_body">
	{foreach from=$aVideos name=videos item=aVideo}
		{template file='video.block.entry'}
	{/foreach}
	<div class="clear"></div>
	{if Phpfox::getUserParam('video.can_approve_videos') || Phpfox::getUserParam('video.can_delete_other_video')}
	{moderation}
	{/if}
	{pager}	
</div>
{/if}