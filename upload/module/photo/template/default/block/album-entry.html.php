<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: album-entry.html.php 7055 2014-01-21 17:35:57Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="t_center photo_row {if !Phpfox::getParam('photo.show_info_on_mouseover')}album_entry{else}photo_row_dynamic_view{/if}" id="js_photo_album_id_{$aAlbum.album_id}">
	<div class="js_outer_photo_div js_mp_fix_holder photo_row_holder">	
		<div class="photo_row_height image_hover_holder{if Phpfox::getParam('photo.show_info_on_mouseover')}_dynamic{/if}">
			{if Phpfox::getParam('photo.auto_crop_photo') && false}
			<div class="photo_clip_holder_main{if Phpfox::getParam('photo.show_info_on_mouseover')}_big{/if}">
			{/if}		

				{if ($aAlbum.profile_id == '0' && ((Phpfox::getUserId() == $aAlbum.user_id && Phpfox::getUserParam('photo.can_delete_own_photo_album')) || Phpfox::getUserParam('photo.can_delete_other_photo_albums')))
					|| ($aAlbum.profile_id == '0' && Phpfox::getUserId() == $aAlbum.user_id)
					|| ((Phpfox::getUserId() == $aAlbum.user_id && Phpfox::getUserParam('photo.can_edit_own_photo_album')) || Phpfox::getUserParam('photo.can_edit_other_photo_albums'))
				}
				<a href="#" class="image_hover_menu_link">{phrase var='photo.link'}</a>				
				<div class="image_hover_menu">
					<ul>
						{if $aAlbum.profile_id == '0' && ((Phpfox::getUserId() == $aAlbum.user_id && Phpfox::getUserParam('photo.can_delete_own_photo_album')) || Phpfox::getUserParam('photo.can_delete_other_photo_albums'))}
						<li class="item_delete"><a href="{url link='photo.albums' delete=$aAlbum.album_id}" id="js_delete_this_album" class="sJsConfirm">{phrase var='photo.delete'}</a></li>
						{/if}					
						{if $aAlbum.profile_id == '0' && Phpfox::getUserId() == $aAlbum.user_id}
						<li><a href="{url link='photo.add' album=$aAlbum.album_id}">{phrase var='photo.upload_photo_s'}</a></li>
						{/if}					
						{if (Phpfox::getUserId() == $aAlbum.user_id && Phpfox::getUserParam('photo.can_edit_own_photo_album')) || Phpfox::getUserParam('photo.can_edit_other_photo_albums')}
						<li><a href="{url link='photo.edit-album' id=$aAlbum.album_id}" id="js_edit_this_album">{phrase var='photo.edit'}</a></li>
						{/if}
					</ul>
				</div>
			{/if}

			{if Phpfox::getParam('photo.auto_crop_photo') && false && !Phpfox::getParam('photo.show_info_on_mouseover')}
				<div class="photo_clip_holder_border">
					<a href="{$aAlbum.link}" style="background:url('{if Phpfox::isMobile()}{img server_id=$aAlbum.server_id path='photo.url_photo' file=$aAlbum.destination suffix='_50' max_width=75 max_height=75 return_url=true} {else}{img server_id=$aAlbum.server_id path='photo.url_photo' file=$aAlbum.destination suffix='_240' max_width=240 max_height=240 return_url=true}{/if}') no-repeat 25% center;" class="photo_clip_holder">{$aAlbum.name|clean|shorten:45:'...'|split:20}</a>
				</div>			
			{else}	
				<a 
				    href="{$aAlbum.link}" 
				    title="{phrase var='photo.name_by_full_name' name=$aAlbum.name|clean full_name=$aAlbum.full_name|clean}" 
				    id="js_album_inner_title_link_{$aAlbum.album_id}"
				    style="background-image:url('{img server_id=$aAlbum.server_id path='photo.url_photo' file=$aAlbum.destination suffix='_240' max_width=196 max_height=196 return_url=true}')"
				    class="album_a_img_holder {if Phpfox::getParam('photo.show_info_on_mouseover')}photo_clip_holder_big{/if}"
				    >
				</a>
			{/if}
			{if Phpfox::getParam('photo.auto_crop_photo') && false}
			</div>
			{/if}
			
			{if Phpfox::getParam('photo.show_info_on_mouseover')}
				{template file='photo.block.hoverinfo'}
			{/if}			
		</div>
			
		{if !Phpfox::getParam('photo.show_info_on_mouseover')}
			<div class="photo_row_info photo_row_info_album">
				<a href="{permalink module='photo.album' id=$aAlbum.album_id title=$aAlbum.name}" id="js_album_inner_title_{$aAlbum.album_id}" class="row_sub_link">{$aAlbum.name|clean|shorten:150:'...'|split:40}</a>	
				<div class="extra_info">
					{if !empty($aAlbum.total_photo)}
						{if $aAlbum.total_photo == '1'}
						1 photo
						{else}
						{$aAlbum.total_photo|number_format} photos
						{/if}
					{/if}
					{if !defined('PHPFOX_IS_USER_PROFILE')}	
					<div>{$aAlbum|user:'':'':50|split:10}</div>
					{/if}
					{plugin call='photo.template_block_album_entry_extra_info'}
				</div>
			</div>
		{/if}
	</div>
</div>
