<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: menu-album.html.php 3346 2011-10-24 15:20:05Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	{if (($aAlbum.user_id == Phpfox::getUserId() && Phpfox::getUserParam('music.can_edit_own_albums')) || Phpfox::getUserParam('music.can_edit_other_music_albums'))}
		<li><a href="{url link='music.album' id=$aAlbum.album_id}">{phrase var='music.edit'}</a></li>
	{/if}
	{if (($aAlbum.user_id == Phpfox::getUserId() && Phpfox::getUserParam('music.can_edit_own_albums')))}
		<li><a href="{url link='music.album.track' id=$aAlbum.album_id}">{phrase var='music.upload_new_track'}</a></li>
	{/if}
	{if $aAlbum.view_id == 0 && Phpfox::getUserParam('music.can_feature_music_albums')}
		<li><a id="js_feature_{$aAlbum.album_id}"{if $aAlbum.is_featured} style="display:none;"{/if} href="#" title="{phrase var='music.feature_this_album'}" onclick="$(this).hide(); $('#js_unfeature_{$aAlbum.album_id}').show(); $(this).parents('.js_album_parent:first').addClass('row_featured').find('.js_featured_album').show(); $.ajaxCall('music.featureAlbum', 'album_id={$aAlbum.album_id}&amp;type=1'); return false;">{phrase var='music.feature'}</a></li>
		<li><a id="js_unfeature_{$aAlbum.album_id}"{if !$aAlbum.is_featured} style="display:none;"{/if} href="#" title="{phrase var='music.un_feature_this_album'}" onclick="$(this).hide(); $('#js_feature_{$aAlbum.album_id}').show(); $(this).parents('.js_album_parent:first').removeClass('row_featured').find('.js_featured_album').hide(); $.ajaxCall('music.featureAlbum', 'album_id={$aAlbum.album_id}&amp;type=0'); return false;">{phrase var='music.unfeature'}</a></li>
	{/if}	

	{if Phpfox::getUserParam('music.can_sponsor_album')}
		<li>
			<a href='#' onclick="$.ajaxCall('music.sponsorAlbum','album_id={$aAlbum.album_id}&type={if $aAlbum.is_sponsor == 1}0{else}1{/if}');return false;">
				{if $aAlbum.is_sponsor == 1}
					{phrase var='music.unsponsor_this_album'}
				{else}
					{phrase var='music.sponsor_this_album'}
				{/if}
			</a>
		</li>
	{/if}
	{if Phpfox::getUserParam('music.can_purchase_sponsor_album') && !$aAlbum.is_sponsor && ($aAlbum.user_id == Phpfox::getUserId())}
		<li>
			<a href="{permalink module='ad.sponsor' id=$aAlbum.album_id}section_music-album/">
				{phrase var='music.encourage_sponsor_album'}
			</a>
		</li>
	{/if}
	
	{if (($aAlbum.user_id == Phpfox::getUserId() && Phpfox::getUserParam('music.can_delete_own_music_album')) || Phpfox::getUserParam('music.can_delete_other_music_albums'))}
		<li class="item_delete"><a href="{url link='music.browse.album' id=$aAlbum.album_id}" onclick="return confirm('{phrase var='music.are_you_sure_this_will_delete_all_tracks_that_belong_to_this_album_and_cannot_be_undone' phpfox_squote=true}');">{phrase var='music.delete'}</a></li>
	{/if}	