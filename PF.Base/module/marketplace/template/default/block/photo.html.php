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
<h3>{phrase var='marketplace.photos'}</h3>

{foreach from=$aImages name=images item=aImage}
<div id="js_photo_holder_{$aImage.image_id}" class="js_mp_photo go_left{if $aForms.image_path == $aImage.image_path} row_focus{/if}" style="width:22%; text-align:center; margin-bottom:10px; margin-right:2px; padding:5px;">
	<div class="js_mp_fix_holder" style="width:120px; margin:auto; position:relative;">
		<div style="position:absolute; right:0; margin:-2px -2px 0px 0px;">
			<a href="#" title="{phrase var='marketplace.delete_this_image_for_the_listing'}" onclick="if (confirm('{phrase var='marketplace.are_you_sure' phpfox_squote=true}')) {literal}{{/literal} $('#js_photo_holder_{$aImage.image_id}').remove(); $.ajaxCall('marketplace.deleteImage', 'id={$aImage.image_id}'); $('#js_mp_image_{$aImage.image_id}').remove(); {literal}}{/literal} return false;">{img theme='misc/delete_hover.gif' alt=''}</a>
		</div>
		{if $aForms.image_path != $aImage.image_path}<a href="#" title="{phrase var='marketplace.click_to_set_as_default_image'}" onclick="$('.js_mp_photo').removeClass('row_focus'); $(this).parents('.js_mp_photo:first').addClass('row_focus'); $.ajaxCall('marketplace.setDefault', 'id={$aImage.image_id}'); return false;">{/if}
		{img server_id=$aImage.server_id path='marketplace.url_image' file=$aImage.image_path suffix='_120' max_width='120' max_height='120' class='js_mp_fix_width'}		
		{if $aForms.image_path != $aImage.image_path}</a>{/if}
	</div>
</div>
{if is_int($phpfox.iteration.images/4)}
	<div class="clear"></div>
{/if}
{/foreach}
<div class="clear"></div>