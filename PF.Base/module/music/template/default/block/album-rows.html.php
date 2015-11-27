
{*
<article class="music_row music_album_row">
	{if !isset($aAlbum.is_in_feed)}
	<div class="music_row_image">
		<a href="{permalink title=$aAlbum.name id=$aAlbum.album_id module='music.album'}">{img server_id=$aAlbum.server_id title=$aAlbum.name path='music.url_image' file=$aAlbum.image_path suffix='_120_square' itemprop='image'}</a>
	</div>
	{/if}
	<div class="music_row_content">
		<header>
			{if !isset($aAlbum.is_in_feed)}
			<h2>{$aAlbum|user}</h2>
			{/if}
			<h1><a href="{permalink title=$aAlbum.name id=$aAlbum.album_id module='music.album'}">{$aAlbum.name|clean}</a></h1>
		</header>
		<div class="music_time">
			{$aAlbum.time_stamp|convert_time}
		</div>
		{if isset($aAlbum.songs)}
		<div class="music_songs">
			<div>Songs</div>
			<ul>
			{foreach from=$aAlbum.songs item=aSong}
				<li><a href="{permalink title=$aSong.title id=$aSong.song_id module='music'}">{$aSong.title|clean}</a></li>
			{/foreach}
			</ul>
		</div>
		{/if}
	</div>
</article>
*}

<article class="music_album_rows">
	<header>
		<h1>
			<a href="{permalink title=$aAlbum.name id=$aAlbum.album_id module='music.album'}">
				<span>{$aAlbum.name|clean}</span>
				<time>{$aAlbum.time_stamp|convert_time}</time>
				{img server_id=$aAlbum.server_id title=$aAlbum.name path='music.url_image' file=$aAlbum.image_path suffix='_200_square' itemprop='image'}
			</a>
		</h1>
	</header>
</article>