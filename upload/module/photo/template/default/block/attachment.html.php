<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: attachment.html.php 3342 2011-10-21 12:59:32Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aPhotos)}
{if $iCurrentPage < 1}
<div class="extra_info">
	{phrase var='photo.note_when_selecting_a_photo_to_import'}	
</div>
{/if}
{foreach from=$aPhotos name=photos item=aPhoto}
<div class="t_center photo_row">
	<div class="js_outer_photo_div js_mp_fix_holder photo_row_holder">
		<div class="photo_row_height image_hover_holder">
			<a href="#" onclick="$.ajaxCall('photo.attachToItem', 'obj-id={$sAttachmentObjId}&amp;input={$sAttachmentInput}&amp;category={$sCategoryId}&amp;photo-id={$aPhoto.photo_id}&amp;attachment-inline={$sIsAttachmentInline}'); return false;">{img server_id=$aPhoto.server_id path='photo.url_photo' file=$aPhoto.destination suffix='_150' max_width=150 max_height=150 title=$aPhoto.title class='js_mp_fix_width photo_holder'}</a>
		</div>
	</div>
</div>
{if is_int($phpfox.iteration.photos/3)}
<div class="clear"></div>
{/if}
{/foreach}
<div class="clear"></div>

{pager}
{else}
<div class="extra_info">
	{phrase var='photo.no_photos_to_select_from'}
</div>
{/if}