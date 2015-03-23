<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: sponsored.html.php 5538 2013-03-25 13:20:22Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="t_center">
	{if $aSponsorVideo.is_stream}
	    {$aSponsorVideo.embed_code}
	{else}
	<script type="text/javascript" src="{param var='core.url_static_script'}player/{param var='core.default_music_player'}/core.js"></script>
	<script type="text/javascript">
		$Behavior.video_block_sponsored = function() {left_curly} $Core.player.load({left_curly}id: 'js_video_sponsor_player', auto: true, type: 'video', play: '{$sPath}'{right_curly}); {right_curly};
	</script>
	<div id="js_video_sponsor_player" style="width:298px; height:223px; margin:auto;"></div>
	{/if}
</div>
<div class="p_4">
	<a href="{url link='ad.sponsor' view=$aSponsorVideo.sponsor_id}" class="row_sub_link">{$aSponsorVideo.title|clean|shorten:30|split:20}</a>
	<div class="extra_info_link">
		by {$aSponsorVideo|user}		
	</div>	
</div>
<div class="bottom">
	<ul>
			<li class="first" id="js_block_bottom_1">
				<a id="" href="{url link='profile'}video/sponsor_1/">{phrase var='video.encourage_sponsor'}</a>
			</li>
	</ul>
</div>