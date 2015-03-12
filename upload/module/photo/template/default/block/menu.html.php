<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: menu.html.php 7088 2014-02-04 15:37:30Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
		{if (Phpfox::getUserParam('photo.can_edit_own_photo') && $aForms.user_id == Phpfox::getUserId()) || Phpfox::getUserParam('photo.can_edit_other_photo')}
		<li><a href="#" onclick="if ($Core.exists('.js_box_image_holder_full')) {l} js_box_remove($('.js_box_image_holder_full').find('.js_box_content')); {r} $Core.box('photo.editPhoto', 700, 'photo_id={$aForms.photo_id}'); $('#js_tag_photo').hide();return false;">{phrase var='photo.edit_this_photo'}</a></li>
		{/if}
		
		{if $aForms.user_id == Phpfox::getUserId() && !defined('PHPFOX_IS_HOSTED_SCRIPT')}
			<li>
				<a href="#" title="Set this photo as your profile image." onclick="if ($Core.exists('.js_box_image_holder_full')) {l} js_box_remove($('.js_box_image_holder_full').find('.js_box_content')); {r} tb_show('', '', null, '{phrase var='photo.setting_this_photo_as_your_profile_picture_please_hold'}', true); $.ajaxCall('photo.makeProfilePicture', 'photo_id={$aForms.photo_id}', 'GET'); return false;">{phrase var='photo.make_profile_picture'}</a>
			</li>
			{if Phpfox::getUserParam('profile.can_change_cover_photo')}
				<li>
					<a href="#" title="{phrase var='user.set_this_photo_as_your_profile_cover_photo'}" onclick="$.ajaxCall('user.setCoverPhoto', 'photo_id={$aForms.photo_id}', 'GET'); return false;">{phrase var='user.set_as_cover_photo'}</a>
				</li>
			{/if}		
		{/if}	
		
		{if Phpfox::isModule('feed') && (Phpfox::getUserParam('feed.can_purchase_sponsor') || Phpfox::getUserParam('feed.can_sponsor_feed'))}
			<li>
				<a href="{url link='ad.sponsor' where='feed' section='photo' item=$aForms.photo_id}">
					{phrase var='feed.sponsor_in_feed'}
				</a>
			</li>
		{/if}
		
		{if Phpfox::getUserParam('photo.can_feature_photo') && !$aForms.is_sponsor}
		    <li id="js_photo_feature_{$aForms.photo_id}">
		    {if $aForms.is_featured}
			    <a href="#" title="{phrase var='photo.un_feature_this_photo'}" onclick="$.ajaxCall('photo.feature', 'photo_id={$aForms.photo_id}&amp;type=0', 'GET'); return false;">{phrase var='photo.un_feature'}</a>
		    {else}
			    <a href="#" title="{phrase var='photo.feature_this_photo'}" onclick="$.ajaxCall('photo.feature', 'photo_id={$aForms.photo_id}&amp;type=1', 'GET'); return false;">{phrase var='photo.feature'}</a>
		    {/if}
		    </li>
		{/if}		

		{if Phpfox::getUserParam('photo.can_sponsor_photo') && !defined('PHPFOX_IS_GROUP_VIEW')}     
		<li id="js_sponsor_{$aForms.photo_id}" class="" style="{if $aForms.is_sponsor}display:none;{/if}">
			    <a href="#" onclick="$('#js_sponsor_{$aForms.photo_id}').hide();$('#js_unsponsor_{$aForms.photo_id}').show();$.ajaxCall('photo.sponsor','photo_id={$aForms.photo_id}&type=1'); return false;">
				{phrase var='photo.sponsor_this_photo'}
			    </a>
		</li>		    
		<li id="js_unsponsor_{$aForms.photo_id}" class="" style="{if $aForms.is_sponsor != 1}display:none;{/if}">
			    <a href="#" onclick="$('#js_sponsor_{$aForms.photo_id}').show();$('#js_unsponsor_{$aForms.photo_id}').hide();$.ajaxCall('photo.sponsor','photo_id={$aForms.photo_id}&type=0'); return false;">
				{phrase var='photo.unsponsor_this_photo'}
			    </a>
		</li>
		{elseif Phpfox::getUserParam('photo.can_purchase_sponsor')  && !defined('PHPFOX_IS_GROUP_VIEW')
		    && $aForms.user_id == Phpfox::getUserId()
		    && $aForms.is_sponsor != 1}
		    <li>
			<a href="{permalink module='ad.sponsor' id=$aForms.photo_id}section_photo/">
				{phrase var='photo.sponsor_this_photo'}
			</a>
		    </li>
		{/if}
		
		{if PHPFOX_IS_AJAX && isset($bIsTheater) && $bIsTheater && (Phpfox::getUserParam('photo.can_edit_own_photo') && $aForms.user_id == Phpfox::getUserId()) || Phpfox::getUserParam('photo.can_edit_other_photo')}
					<li>
						<a href="#" onclick="$('#photo_view_ajax_loader').show(); $('#menu').remove(); $('#noteform').hide(); $('#js_photo_view_image').imgAreaSelect({left_curly} hide: true {right_curly}); $('#js_photo_view_holder').hide(); $.ajaxCall('photo.rotate', 'photo_id={$aForms.photo_id}&amp;photo_cmd=right&amp;currenturl=' + $('#js_current_page_url').html()); return false;">
							{phrase var='photo.rotate_right'}
						</a>
					</li>
					<li>
						<a href="#" onclick="$('#photo_view_ajax_loader').show(); $('#menu').remove(); $('#noteform').hide(); $('#js_photo_view_image').imgAreaSelect({left_curly} hide: true {right_curly}); $('#js_photo_view_holder').hide(); $.ajaxCall('photo.rotate', 'photo_id={$aForms.photo_id}&amp;photo_cmd=left&amp;currenturl=' + $('#js_current_page_url').html()); return false;">		{phrase var='photo.rotate_left'}							
						</a>
					</li>		
		{/if}
		
		{plugin call='photo.template_block_menu'}
		
		{if (Phpfox::getUserParam('photo.can_delete_own_photo') && $aForms.user_id == Phpfox::getUserId()) || Phpfox::getUserParam('photo.can_delete_other_photos')}
		{if defined('PHPFOX_IS_THEATER_MODE')}
		<li class="item_delete"><a href="#" onclick="if (confirm('Are you sure?')) {l} $.ajaxCall('photo.deleteTheaterPhoto', 'photo_id={$aForms.photo_id}'); {r} return false;">{phrase var='photo.delete_this_photo'}</a></li>
		{else}
		<li class="item_delete"><a href="{url link='photo' delete=$aForms.photo_id}" class="sJsConfirm">{phrase var='photo.delete_this_photo'}</a></li>
		{/if}
		{/if}		
		
		{if isset($aCallback)}
			<li>
				<a href="#" onclick="$Core.Photo.setCoverPhoto({$aForms.photo_id},{$aCallback.item_id}); return false;" >
					{phrase var='photo.set_as_page_s_cover_photo'}
				</a>
			</li>
		{/if}
