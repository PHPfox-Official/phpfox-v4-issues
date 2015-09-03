<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: albums.html.php 6060 2013-06-14 09:28:36Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aAlbums)}
<section class="photo-albums">
	<h1 class="photo-h1">Albums</h1>
	{foreach from=$aAlbums item=aAlbum name=albums}
	<article{if $aAlbum.destination} class="image_load" data-src="{img server_id=$aAlbum.server_id path='photo.url_photo' file=$aAlbum.destination suffix='_500' max_width=500 max_height=500 return_url=true}"{/if}>
	{if !$aAlbum.destination}
		<span class="no_image_item_cover"></span>
	{/if}
		<header>
			<h1>
				<a href="{$aAlbum.link}">
					<span class="name">
						{$aAlbum.name|clean}
						<span class="info">
							{if !empty($aAlbum.total_photo)}
							{if $aAlbum.total_photo == '1'}
							1 photo
							{else}
							{$aAlbum.total_photo|number_format} photos
							{/if}
							{/if}
							{plugin call='photo.template_block_album_entry_extra_info'}
						</span>
					</span>
				</a>
			</h1>
		</header>
	</article>
	{/foreach}
</section>

{/if}