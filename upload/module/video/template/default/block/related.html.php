<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: related.html.php 2322 2011-03-02 11:00:01Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !isset($bIsLoadingMore)}
<form id="js_video_related_page_form" method="post" action="#">
	<div><input type="hidden" name="page_number" value="1" id="js_video_related_page_number" /></div>
	<div><input type="hidden" name="video_id" value="{$aVideo.video_id}" /></div>
	<div><input type="hidden" name="video_title" value="{$aVideo.title|clean}" /></div>
</form>
{/if}
{foreach from=$aRelatedVideos name=minivideos item=aMiniVideo}
	{template file='video.block.mini'}
{/foreach}
{if !isset($bIsLoadingMore)}
<div id="js_video_related_load_more"></div>
{/if}