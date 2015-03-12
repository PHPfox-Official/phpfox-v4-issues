<?php

?>
{if Phpfox::getParam('photo.show_info_on_mouseover')}
	{if !isset($aAlbum) || empty($aAlbum)}
		<div class="photo_hover_info">
			{img theme='layout/thickbox_bg.png' class='bg'}
			<div class="photo_hover_info_album_title">
				<strong>
				{if isset($aPhoto.album_name)}
					{$aPhoto.album_name|convert|clean|shorten:22:'...'}
				{elseif !empty($aPhoto.title)}
					{$aPhoto.title|clean|shorten:22:'...'}
				{/if}	
				</strong>
				{if isset($aPhoto.user_name)}<div>{$aPhoto|user:'':'':50:'':'author'}</div>{/if} 
			</div>
			<div class="photo_hover_info_actions">
				{if Phpfox::isModule('like')}
				<div class="photo_hover_info_actions_do">
					<a href="#" class="js_like_photo js_toggle_like_{$aPhoto.photo_id}" id="js_like_{$aPhoto.photo_id}" {if isset($aPhoto.is_liked) && $aPhoto.is_liked}style="display:none;"{/if} onclick="$Core.Photo.inlineAction({$aPhoto.photo_id}, 'js_like', 'add', 'js_toggle_like_{$aPhoto.photo_id}');return false;">{phrase var='like.like_uppercase'}</a>
					<a href="#" class="js_unlike_photo js_toggle_like_{$aPhoto.photo_id}" id="js_undislike_{$aPhoto.photo_id}" {if !isset($aPhoto.is_liked) || !$aPhoto.is_liked}style="display:none;"{/if} onclick="$Core.Photo.inlineAction({$aPhoto.photo_id}, 'js_like', 'delete', 'js_toggle_like_{$aPhoto.photo_id}'); return false;">{phrase var='like.unlike_uppercase'}</a>		  
				</div>
				<div class="photo_hover_info_actions_counter">
					<div class="js_like_counter">
						{img theme='layout/like.png'} <span id="js_like_counter_{$aPhoto.photo_id}">{if isset($aPhoto.total_like)}{$aPhoto.total_like}{else}0{/if}</span>
					</div>
				</div>
				{/if}
			</div>
		</div>
		
	{else}
		<div class="photo_hover_info">
			{img theme='layout/thickbox_bg.png' class='bg'}
			<div class="photo_hover_info_album_title">
				<strong>
				{if isset($aAlbum.name)}
					{$aAlbum.name|clean|shorten:22:'...'}		
				{/if}	
				</strong>
				<div>
					{if $aAlbum.total_photo == '1'}
					{phrase var='photo.number_photo' iCnt=1}
					{else}
					{phrase var='photo.number_photos' iCnt=$aAlbum.total_photo|number_format}
					{/if}
				</div>
				{if !defined('PHPFOX_IS_USER_PROFILE')}	
					<div>{$aAlbum|user:'':'':50|split:10}</div>
				{/if}
			</div>
			<div class="photo_hover_info_actions">
				{if Phpfox::isModule('like')}
				<div class="photo_hover_info_actions_do">
					<a href="#" class="js_like_photo js_toggle_like_{$aAlbum.album_id}" id="js_like_{$aAlbum.album_id}" {if isset($aAlbum.is_liked) && $aAlbum.is_liked}style="display:none;"{/if} onclick="$Core.Photo.albumInlineAction({$aAlbum.album_id}, 'js_like', 'add', 'js_toggle_like_{$aAlbum.album_id}');return false;">{phrase var='like.like_uppercase'}</a>
					<a href="#" class="js_unlike_photo js_toggle_like_{$aAlbum.album_id}" id="js_undislike_{$aAlbum.album_id}" {if !isset($aAlbum.is_liked) || !$aAlbum.is_liked}style="display:none;"{/if} onclick="$Core.Photo.albumInlineAction({$aAlbum.album_id}, 'js_like', 'delete', 'js_toggle_like_{$aAlbum.album_id}'); return false;">{phrase var='like.unlike_uppercase'}</a>		  
				</div>
				<div class="photo_hover_info_actions_counter">
					<div class="js_like_counter">
						{img theme='layout/like.png'} <span id="js_like_counter_{$aAlbum.album_id}">{if isset($aAlbum.total_like)}{$aAlbum.total_like}{else}0{/if}</span>
					</div>
				</div>
				{/if}
			</div>
		</div>
	{/if}
{/if}
