<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: user.html.php 2489 2011-03-31 14:28:59Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	<div class="video_user_bar_pager">
		<div class="video_user_bar_pager_menu">
			<ul>
			{for $i = 1; $i <= ceil($iUserTotalVideos / 4); $i++}
				<li><a href="#"{if $i == 1} class="active"{/if} rel="{$i}">{$i}</a></li>
			{/for}
			</ul>
			<div class="clear"></div>
		</div>
		<a href="#" class="video_user_bar_pager_more">View all {$iUserTotalVideos} videos</a>
	</div>
	<div class="video_user_bar_previous"><a href="#" class="video_user_bar_click" rel="previous">Previous</a></div>
	<div class="video_user_bar_next"><a href="#" class="video_user_bar_click" rel="next">Next</a></div>
	<div class="video_user_box">
		<div class="video_user_more_holder">	
			{foreach from=$aMyVideos name=minivideos item=aMiniVideo}
				{if $iLeft = ($phpfox.iteration.minivideos - 1)*150}{/if}
				<div class="view_user_more_item" style="left:{$iLeft}px; height:180px;">					
					<div style="width:90px;">
						<a href="{$aMiniVideo.link}">{img server_id=$aMiniVideo.image_server_id path='video.url_image' file=$aMiniVideo.image_path suffix='_120' max_width=90 max_height=70 class='js_mp_fix_width' title=$aMiniVideo.title}</a>
						<div>
							<a href="{$aMiniVideo.link}">{$aMiniVideo.title|clean}</a>
						</div>
						<div class="extra_info">
							by {$aMiniVideo.full_name}<br />
							{$aMiniVideo.total_view|number_format} views
						</div>
					</div>
				</div>
			{/foreach}
			<div class="clear"></div>
		</div>
	</div>
	<script type="text/javascript">
	$Behavior.videoUserBrowserReload = function()
	{l}
		$iTotalUserVideos = {$iUserTotalVideos};
	{r}
	</script>	