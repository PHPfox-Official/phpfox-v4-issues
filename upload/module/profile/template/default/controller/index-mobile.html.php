<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: index-mobile.html.php 2525 2011-04-13 18:03:20Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if Phpfox::isModule('feed')}
{if !$bHideFeedOnProfile}
<form method="post" action="{url link=''$aUser.user_name''}">
	<div class="feed_share_box">
	{if Phpfox::getUserId() == $aUser.user_id}{phrase var='core.what_s_on_your_mind'}{else}Comment{/if}
		<div class="feed_text_box">
			{if Phpfox::getUserId() != $aUser.user_id}
			<div><input type="hidden" name="val[item_id]" value="{$aUser.user_id}" /></div>		
			<div><input type="text" name="val[feed_text]" value="" class="feed_input_bar" /></div>
			{else}
			<input type="text" name="val[status]" value="" class="feed_input_bar" />
			{/if}
			<div class="feed_share_button">
				<input type="submit" value="{phrase var='core.share'}" class="button" />
			</div>
		</div>
	</div>
</form>

{foreach from=$aFeeds name=feeds item=aFeed}
{template file='feed.block.entry-mobile'}
{/foreach}
{pager}
{/if}
{/if}