<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: latest.html.php 2553 2011-04-19 20:28:17Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !PHPFOX_IS_AJAX}
<div id="js_music_player_block" style="height:25px; width:100%; display:none;"></div>
<div id="js_music_latest_songs">
{/if}
	{foreach from=$aLatestSongs name=songs item=aSong}
		<div id="js_music_track_{$aSong.song_id}" class="js_music_track {if is_int($phpfox.iteration.songs/2)}row1{else}row2{/if}{if $phpfox.iteration.songs == 1} row_first{/if}">
			<div class="go_left">
				<a href="#" onclick="$('#js_music_cache_id').html('{$aSong.song_id}'); $.ajaxCall('music.play', 'id={$aSong.song_id}'); $Core.player.play('js_music_player_block', '{$aSong.song_path}'); return false;" title='{phrase var='music.play'}: {$aSong.title|clean phpfox_squote=true}'>{img theme='misc/control_play.png' class='v_middle'}</a>
				<a href="{permalink module='music' id=$aSong.song_id title=$aSong.title}"{if defined('PHPFOX_IS_POPUP')} onclick="window.opener.location.href=this.href; return false;"{/if}>{$aSong.title|clean}</a>
				<div class="extra_info">
					{phrase var='music.by'}: {$aSong|user}
				</div>
			</div>
			<div style="text-align:right;">
				{$aSong.duration}
			</div>
			<div class="clear"></div>
		</div>
	{/foreach}
{if !PHPFOX_IS_AJAX}
</div>
{/if}