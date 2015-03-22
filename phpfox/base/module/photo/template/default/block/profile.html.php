<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: profile.html.php 1298 2009-12-05 16:19:23Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !count($aPhotos)}
<div class="extra_info">
	{phrase var='photo.no_photos_uploaded_yet'}
	<ul class="action">
		<li><a href="{url link='photo.upload'}">{phrase var='photo.click_here_to_upload_photos'}</a></li>
	</ul>
</div>
{else}
{foreach from=$aPhotos item=aPhoto}
<div class="go_left t_center" style="width:30%;">
	{if ($aPhoto.mature == 0 || (($aPhoto.mature == 1 || $aPhoto.mature == 2) && Phpfox::getUserId() && Phpfox::getUserParam('photo.photo_mature_age_limit') <= Phpfox::getUserBy('age'))) || $aPhoto.user_id == Phpfox::getUserId()}
	<a href="{$aPhoto.link}" title="{phrase var='photo.title_by_full_name' title=$aPhoto.title|clean full_name=$aPhoto.full_name|clean}">{img server_id=$aPhoto.server_id path='photo.url_photo' file=$aPhoto.destination suffix='_150' max_width=150 max_height=150 class="hover_action" title=$aPhoto.title}</a>
	{else}
	<a href="{$aPhoto.link}"{if $aPhoto.mature == 1} onclick="tb_show('{phrase var='photo.warning' phpfox_squote=true}', $.ajaxBox('photo.warning', 'height=300&amp;width=350&amp;link={$aPhoto.link}')); return false;"{/if}>{img theme='misc/no_access.png' alt=''}</a>
	{/if}
	<div class="p_4">
		<a href="{$aPhoto.link}">{$aPhoto.title|clean|shorten:45:'...'|split:20}</a>
		{if !empty($aPhoto.album_name)}
		<div class="extra_info">
			in <a href="{url link=''$aUser.user_name'.photo.'$aPhoto.album_url''}">{$aPhoto.album_name|clean|shorten:45:'...'|split:20}</a>
		</div>	
		{/if}
	</div>
</div>
{/foreach}
<div class="clear"></div>
{/if}