<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: view-mobile.html.php 1491 2010-03-03 15:34:04Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{foreach from=$aFeeds name=feeds item=aFeed}
{template file='feed.block.entry-mobile'}
{/foreach}
{if Phpfox::getParam('feed.allow_comments_on_feeds')}						
<h2>{phrase var='feed.comments'}</h2>
{parse_image width=200 height=200}
{foreach from=$aComments name=comments item=aComment}
	{template file='comment.block.mini'}
{/foreach}
{parse_image clear=true}
<div class="comment_mini comment_mini_form">
	<form method="post" action="{url link='feed.view' id=$aFeed.feed_id}">
			<div><input type="hidden" name="val[type]" value="feed" /></div>			
			<div><input type="hidden" name="val[item_id]" value="{$aFeed.feed_id}" /></div>
			<div><input type="hidden" name="val[parent_id]" value="0" /></div>	
		<div class="comment_mini_form_title">{phrase var='feed.write_a_comment'}</div>
		<div class="comment_mini_form_textarea">
			<textarea cols="60" rows="6" name="val[text]" style="width:100%;"></textarea>
		</div>
		<div class="comment_mini_form_button">
			<input type="submit" value="{phrase var='feed.post'}" class="button" />
		</div>
	</form>
</div>
{/if}