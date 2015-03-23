<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: size.html.php 2862 2011-08-22 07:06:46Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $bReplace}
	<div class="photo_view_all_sizes">
		<ul>
		{foreach from=$aSizes item=aSize}
			<li class="{if $iDefaultSize == $aSize.actual} is_active{/if}">
				<a href="#" onclick="$('.photo_view_all_sizes li').removeClass('is_active'); $(this).parent().addClass('is_active'); $.ajaxCall('photo.viewAllSizes', 'id={$aPhoto.photo_id}&amp;size={$aSize.actual}&amp;replace=1', 'GET'); return false;">{$aSize.width} x {$aSize.height}</a>
			</li>		
		{/foreach}	
		</ul>
		<div class="clear"></div>
	</div>
	<div id="js_photo_view_all_sizes">
{/if}
		{if $aPhoto.allow_download}
		<a href="{permalink module='photo' id=$aPhoto.photo_id title=$aPhoto.title}download/size_{$iDefaultSize}/" title="{phrase var='photo.download_this_image'}">
		{/if}
	{if $iDefaultSize == 'full'}
		{img server_id=$aPhoto.server_id path='photo.url_photo' file=$aPhoto.destination}
	{else}
		{img server_id=$aPhoto.server_id path='photo.url_photo' file=$aPhoto.destination suffix='_'$iDefaultSize'' max_width=$iDefaultSize max_height=$iDefaultSize}
	{/if}
		{if $aPhoto.allow_download}</a>{/if}
{if $bReplace}
	</div>
{/if}