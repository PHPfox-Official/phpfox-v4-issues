	<li>
		<div class="block_listing_image">
			<a href="#" onclick="$.ajaxCall('music.playInFeed', 'id={$aSong.song_id}&amp;track={if isset($sCustomPlayId)}{$sCustomPlayId}{else}js_profile_block_track_player{/if}'); return false;">{img theme='misc/play_button.png'}</a>
		</div>
		<div class="block_listing_title" style="padding-left:38px;">
			<a href="{permalink module='music' id=$aSong.song_id title=$aSong.title}">{$aSong.title|clean}</a>
			<div class="extra_info">
				<ul class="extra_info_middot"><li>by {$aSong|user}</li><li>&middot;</li><li>{if $aSong.total_play == 1}{phrase var='music.1_play'}{else}{$aSong.total_play|number_format} {phrase var='music.plays_lowercase'}{/if}</li></ul>
			</div>
		</div>
		<div class="clear"></div>			
	</li>		