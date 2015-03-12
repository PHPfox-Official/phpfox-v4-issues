<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
		{if ($aVideo.user_id == Phpfox::getUserId() && Phpfox::getUserParam('video.can_edit_own_video')) || Phpfox::getUserParam('video.can_edit_other_video')}
		<li><a href="{url link='video.edit' id=$aVideo.video_id}">{phrase var='video.edit'}</a></li>
		{/if}
		{if ($aVideo.user_id == Phpfox::getUserId() && Phpfox::getUserParam('video.can_delete_own_video')) || Phpfox::getUserParam('video.can_delete_other_video')}
		<li class="item_delete"><a href="{url link='video' delete=$aVideo.video_id}" class="sJsConfirm">{phrase var='video.delete'}</a></li>
		{/if}

		{if Phpfox::getUserParam('video.can_sponsor_video') && !defined('PHPFOX_IS_GROUP_VIEW')}
		<li>
			<span id="js_sponsor_{$aVideo.video_id}" class="" style="{if $aVideo.is_sponsor != 1}display:none;{/if}">
			    <a href="#" onclick="$('#js_sponsor_{$aVideo.video_id}').hide();$('#js_unsponsor_{$aVideo.video_id}').show();$.ajaxCall('video.sponsor','video_id={$aVideo.video_id}&type=0'); return false;">
				{phrase var='video.un_sponsor'}
			    </a>
			</span>

			<span id="js_unsponsor_{$aVideo.video_id}" class="" style="{if $aVideo.is_sponsor == 1}display:none;{/if}">
			    <a href="#" onclick="$('#js_sponsor_{$aVideo.video_id}').show();$('#js_unsponsor_{$aVideo.video_id}').hide();$.ajaxCall('video.sponsor','video_id={$aVideo.video_id}&type=1'); return false;">
				{phrase var='video.sponsor'}
			    </a>
			</span>
		</li>
		{/if}
		
		{if Phpfox::getUserParam('video.can_purchase_sponsor') && !defined('PHPFOX_IS_GROUP_VIEW')
		    && $aVideo.user_id == Phpfox::getUserId()
		    && $aVideo.is_sponsor != 1}
		    <li>
			<a href="{permalink module='ad.sponsor' id=$aVideo.video_id}section_video/">
				{phrase var='video.sponsor'}
			</a>
		    </li>
		{/if}
		
		{plugin call='video.template_block_menu'}	