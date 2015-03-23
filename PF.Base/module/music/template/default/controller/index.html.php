<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 2569 2011-04-27 19:03:20Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aSongs)}
{foreach from=$aSongs name=songs item=aSong}
	{template file='music.block.entry'}
{/foreach}
{if Phpfox::getUserParam('music.can_approve_songs') || Phpfox::getUserParam('music.can_delete_other_tracks') || Phpfox::getUserParam('music.can_feature_songs')}
{moderation}
{/if}
{pager}
{else}
<div class="extra_info">
	{phrase var='music.no_songs_found'}
</div>
{/if}