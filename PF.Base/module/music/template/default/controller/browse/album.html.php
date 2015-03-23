<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: album.html.php 3990 2012-03-09 15:28:08Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aAlbums)}
{foreach from=$aAlbums name=albums item=aAlbum}
<div id="js_album_{$aAlbum.album_id}" class="js_album_parent {if $aAlbum.is_sponsor}row_sponsored {/if}{if $aAlbum.is_featured}row_featured {/if}{if is_int($phpfox.iteration.albums/2)}row1{else}row2{/if}{if $phpfox.iteration.albums == 1} row_first{/if}">
	<div class="row_title">		

		<div class="row_title_image">			
			
			<a href="{permalink module='music.album' id=$aAlbum.album_id title=$aAlbum.name}">{img server_id=$aAlbum.server_id path='music.url_image' file=$aAlbum.image_path suffix='_50_square' max_width='50' max_height='50'}</a>
			
			<div class="row_edit_bar_parent">
				<div class="row_edit_bar_holder">
					<ul>
						{template file='music.block.menu-album'}
					</ul>			
				</div>
				<div class="row_edit_bar">				
					<a href="#" class="row_edit_bar_action"><span>Actions</span></a>							
				</div>
			</div>				
			
			{if Phpfox::getUserParam('blog.can_approve_blogs') || Phpfox::getUserParam('blog.delete_user_blog')}<a href="#{$aAlbum.album_id}" class="moderate_link" rel="blog">Moderate</a>{/if}
		</div>
		<div class="row_title_info">    
	
			<a href="{permalink module='music.album' id=$aAlbum.album_id title=$aAlbum.name}" class="link" title="{$aAlbum.name|clean}" {if defined('PHPFOX_IS_POPUP')} onclick="window.opener.location.href=this.href; return false;"{/if}>{$aAlbum.name|clean|shorten:50:'...'|split:30}</a>
			
			<div class="extra_info">
				<ul class="extra_info_middot"><li>{$aAlbum.time_stamp|convert_time} {phrase var='music.by_lowercase'} {$aAlbum|user:'':'':30}</li><li><span>&middot;</span></li><li>{phrase var='music.total_tracks' total=$aAlbum.total_track|number_format}</li><li><span>&middot;</span></li><li>{phrase var='music.total_plays' total=$aAlbum.total_play|number_format}</li></ul>
			</div>
			
			{module name='feed.comment' aFeed=$aAlbum.aFeed}
			
		</div>		
	</div>
</div>
{/foreach}
{if Phpfox::getUserParam('music.can_delete_other_music_albums') || Phpfox::getUserParam('music.can_feature_music_albums')}
{moderation}
{/if}
{pager}
{else}
<div class="extra_info">
	{phrase var='music.no_albums_found'}
</div>
{/if}