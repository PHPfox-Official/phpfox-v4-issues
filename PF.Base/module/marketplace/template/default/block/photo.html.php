<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: photo.html.php 1298 2009-12-05 16:19:23Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="block">
	<div class="title">{phrase var='marketplace.photos'}</div>
	<div class="content">
		{foreach from=$aImages name=images item=aImage}
		<div id="js_photo_holder_{$aImage.image_id}" class="row1{if $aForms.image_path == $aImage.image_path} row_focus{/if}">
			<a href="#" title="{phrase var='marketplace.delete_this_image_for_the_listing'}" onclick="if (confirm('{phrase var='marketplace.are_you_sure' phpfox_squote=true}')) {literal}{{/literal} $('#js_photo_holder_{$aImage.image_id}').remove(); $.ajaxCall('marketplace.deleteImage', 'id={$aImage.image_id}'); $('#js_mp_image_{$aImage.image_id}').remove(); {literal}}{/literal} return false;">{img theme='misc/delete_hover.gif' alt=''}</a>
			{if $aForms.image_path != $aImage.image_path}<a href="#" title="{phrase var='marketplace.click_to_set_as_default_image'}" onclick="$('.js_mp_photo').removeClass('row_focus'); $(this).parents('.js_mp_photo:first').addClass('row_focus'); $.ajaxCall('marketplace.setDefault', 'id={$aImage.image_id}'); return false;">{/if}
				{img server_id=$aImage.server_id path='marketplace.url_image' file=$aImage.image_path suffix='_120' max_width='120' max_height='120' class='js_mp_fix_width'}
			{if $aForms.image_path != $aImage.image_path}</a>{/if}
		</div>
		{/foreach}
	</div>
</div>