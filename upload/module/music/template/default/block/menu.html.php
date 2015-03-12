<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: menu.html.php 3737 2011-12-09 07:50:12Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	{if ($aSong.user_id == Phpfox::getUserId() && Phpfox::getUserParam('music.can_edit_own_song')) || Phpfox::getUserParam('music.can_edit_other_song')}
	<li><a href="{url link='music.upload' id=$aSong.song_id}">{phrase var='music.edit'}</a></li>
	{/if}	
	{if $aSong.view_id == 0 && Phpfox::getUserParam('music.can_feature_songs')}
	<li><a id="js_feature_{$aSong.song_id}"{if $aSong.is_featured} style="display:none;"{/if} href="#" title="{phrase var='music.feature_this_song'}" onclick="$('#js_featured_phrase_{$aSong.song_id}').hide(); $(this).hide(); $('#js_unfeature_{$aSong.song_id}').show(); $(this).parents('.js_song_parent:first').addClass('row_featured').find('.js_featured_song').show(); $.ajaxCall('music.featureSong', 'song_id={$aSong.song_id}&amp;type=1'); return false;">{phrase var='music.feature'}</a></li>
	<li><a id="js_unfeature_{$aSong.song_id}"{if !$aSong.is_featured} style="display:none;"{/if} href="#" title="{phrase var='music.un_feature_this_song'}" onclick="$('#js_featured_phrase_{$aSong.song_id}').show(); $(this).hide(); $('#js_feature_{$aSong.song_id}').show(); $(this).parents('.js_song_parent:first').removeClass('row_featured').find('.js_featured_song').hide(); $.ajaxCall('music.featureSong', 'song_id={$aSong.song_id}&amp;type=0'); return false;">{phrase var='music.unfeature'}</a></li>
	{/if}
	
	{if Phpfox::getUserParam('music.can_sponsor_song')}
	    <li>
		<span id="js_sponsor_{$aSong.song_id}" class="" style="{if $aSong.is_sponsor != 1}display:none;{/if}">
		    <a href="#" onclick="$('#js_sponsor_phrase_{$aSong.song_id}').hide(); $('#js_sponsor_{$aSong.song_id}').hide();$('#js_unsponsor_{$aSong.song_id}').show();$.ajaxCall('music.sponsorSong','song_id={$aSong.song_id}&type=0', 'GET'); return false;">
			{phrase var='music.unsponsor_this_song'}
		    </a>
		</span>
		<span id="js_unsponsor_{$aSong.song_id}" class="" style="{if $aSong.is_sponsor == 1}display:none;{/if}">
		    <a href="#" onclick="$('#js_sponsor_phrase_{$aSong.song_id}').show(); $('#js_sponsor_{$aSong.song_id}').show();$('#js_unsponsor_{$aSong.song_id}').hide();$.ajaxCall('music.sponsorSong','song_id={$aSong.song_id}&type=1', 'GET'); return false;">
			{phrase var='music.sponsor_this_song'}
		    </a>
		</span>
	    </li>
	{elseif Phpfox::getUserParam('music.can_purchase_sponsor_song')
	    && $aSong.user_id == Phpfox::getUserId()
	    && $aSong.is_sponsor != 1}
	    <li>
		<a href="{permalink module='ad.sponsor' id=$aSong.song_id}section_music-song/">
			{phrase var='music.sponsor_this_song'}
		</a>
	    </li>
	{/if}
	{if (($aSong.user_id == Phpfox::getUserId() && Phpfox::getUserParam('music.can_delete_own_track')) || Phpfox::getUserParam('music.can_delete_other_tracks'))
		|| (defined('PHPFOX_IS_PAGES_VIEW') && Phpfox::getService('pages')->isAdmin('' . $aPage.page_id . ''))
	}
	<li class="item_delete"><a href="{url link='music.delete' id=$aSong.song_id}" onclick="return confirm('{phrase var='music.are_you_sure'}');">{phrase var='music.delete'}</a></li>
	{/if}
	