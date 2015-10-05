<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: index.html.php 5109 2013-01-10 09:49:02Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if (defined('PHPFOX_IS_USER_PROFILE') && !PHPFOX_IS_AJAX)}
<div id="main-photo-albums" data-url="{url link=''$aUser.user_name'.photo.albums'}">
	<i class="fa fa-spin fa-circle-o-notch"></i>
</div>
<div id="main-photo-section">
	<div class="hidden-layer"></div>
	<h1 class="photo-h1">Photos</h1>
{/if}

{if !PHPFOX_IS_AJAX}

{if $sView == 'my' && count($aPhotos)}
		<div class="item_bar">
			<div class="item_bar_action_holder">				
				<a href="#" class="item_bar_action"><span>{phrase var='photo.actions'}</span></a>		
				<ul>
					<li><a href="{url link='photo' view='my' mode='edit'}">{phrase var='photo.mass_edit_photos'}</a></li>
				</ul>			
			</div>		
		</div>	    
{/if}

<div id="js_actual_photo_content">
	<div id="js_album_outer_content">
{/if}
		{if count($aPhotos)}

		     {if isset($bIsEditMode)}
		    <form method="post" action="#" onsubmit="$('#js_photo_multi_edit_image').show(); $('#js_photo_multi_edit_submit').hide(); $(this).ajaxCall('photo.massUpdate'{if $bIsMassEditUpload}, 'is_photo_upload=1'{/if}); return false;">
			    {foreach from=$aPhotos item=aForms}
				    {template file='photo.block.edit-photo'}
			    {/foreach}
			    
			    <div class="photo_table_clear">
				    <div id="js_photo_multi_edit_image" style="display:none;">
					    {img theme='ajax/add.gif'}
				    </div>		
				    <div id="js_photo_multi_edit_submit">
					    <input type="submit" value="{phrase var='photo.update_photo_s'}" class="button" />
				    </div>
			    </div>
			    
			    {pager}
		    </form>
		    
		    {else}

			<div class="clearfix mosaicflow_load" data-width="300">
				{foreach from=$aPhotos item=aPhoto}
				<article class="photos_row" data-photo-id="{$aPhoto.photo_id}" id="js_photo_id_{$aPhoto.photo_id}">
					{if Phpfox::getUserParam('photo.can_approve_photos') || Phpfox::getUserParam('photo.can_delete_other_photos')}
					<div class="_moderator">
						<a href="#{$aPhoto.photo_id}" class="moderate_link built" rel="photo"><i class="fa"></i></a>
					</div>
					{/if}

					<header class="_a" data-href="{$aPhoto.link}">
						<h1><a href="{$aPhoto.link}">{$aPhoto.title|clean}</a></h1>
						<ul class="photos_row_info">
							<li>by {$aPhoto|user}</li>
						</ul>
					</header>
					<a href="{$aPhoto.link}">
						{if $aPhoto.can_view}
						{img server_id=$aPhoto.server_id path='photo.url_photo' file=$aPhoto.destination suffix='_500' title=$aPhoto.title}
						{else}
						<div class="photo_mature photo_mature_{$aPhoto.mature}">
							<i class="fa fa-warning"></i>
						</div>
						{/if}
					</a>
				</article>
				{/foreach}
			</div>
			{pager}

			{/if}

			{if Phpfox::getUserParam('photo.can_approve_photos') || Phpfox::getUserParam('photo.can_delete_other_photos')}
				{moderation}
			{/if}

		{else}
			{if !PHPFOX_IS_AJAX}
			<div class="extra_info">
				{phrase var='photo.no_photos_found'}
			</div>
			{/if}
		{/if}


		{if !PHPFOX_IS_AJAX}
	</div>
</div>
{/if}

{if (defined('PHPFOX_IS_USER_PROFILE') && !PHPFOX_IS_AJAX)}
</div>
{literal}
<script>
	$Ready(function() {
		var m = $('#main-photo-section'), a = $('#main-photo-albums');
		if (m.length && !a.hasClass('built')) {
			a.addClass('built');
			$.ajax({
				url: a.data('url'),
				contentType: 'application/json',
				success: function(e) {
					a.html(e.content);
					$('.hidden-layer').remove();
					$Core.loadInit();
				}
			});
		}
	});
</script>
{/literal}
{/if}