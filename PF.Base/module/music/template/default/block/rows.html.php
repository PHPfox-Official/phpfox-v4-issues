<article class="music_row">
	{if !isset($aSong.is_in_feed)}
	<div class="music_row_image">{img user=$aSong suffix='_120_square'}</div>
	{/if}
	<div class="music_row_content">
		<header>
			{if !isset($aSong.is_in_feed)}
			<h2>{$aSong|user}</h2>
			{/if}
			<h1><a href="{permalink title=$aSong.title id=$aSong.song_id module='music'}">{$aSong.title|clean}</a></h1>
		</header>
		{if !isset($aSong.is_in_feed)}
		<div class="music_time">
			{$aSong.time_stamp|convert_time}
		</div>
		{/if}
		<div class="audio_player" data-src="{$aSong.song_path}" data-onplay="{url link='music.view' play=$aSong.song_id}"></div>
		{*
		<div class="music_song_stats">
			{if !isset($aSong.is_in_feed)}
			<a href="#" class="do_like">Like</a>
			<a href="#" class="do_comment">Comment</a>
			{/if}
			<ul>
				<li class="total_plays"><a href="#">{$aSong.total_play}</a></li>
				<li class="total_likes"><a href="#">{$aSong.total_like}</a></li>
				<li class="total_comments"><a href="#">{$aSong.total_comment}</a></li>
			</ul>
		</div>
		*}
	</div>
</article>