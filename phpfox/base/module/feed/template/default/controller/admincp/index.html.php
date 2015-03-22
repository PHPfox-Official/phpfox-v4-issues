<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 1599 2010-05-28 04:31:26Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aFeeds)}
<form method="post" action="{url link='admincp.feed' view='approval'}">
	<div class="table_header">
		{phrase var='feed.profile_feed_comments'}
	</div>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th style="width:10px;"><input type="checkbox" name="val[id]" value="" id="js_check_box_all" class="main_checkbox" /></th>
			<th>{phrase var='feed.id'}</th>
			<th>{phrase var='feed.owner'}</th>
			<th>{phrase var='feed.profile'}</th>
			<th>{phrase var='feed.posted_on'}</th>
			<th>{phrase var='feed.content'}</th>
		</tr>
		{foreach from=$aFeeds name=iFeed item=aFeed}
		<tr id="js_row{$aFeed.feed_id}" class="checkRow{if is_int($phpfox.iteration.iFeed/2)} tr{/if}">
			<td><input type="checkbox" name="id[]" class="checkbox" value="{$aFeed.feed_id}" id="js_id_row{$aFeed.feed_id}" /></td>
			<td><a href="{url link=$aFeed.owner_user_name feed=$aFeed.feed_id}#feed">{$aFeed.feed_id}</a></td>		
			<td>{$aFeed|user:'viewer_'}</td>
			<td>{$aFeed|user:'owner_'}</td>
			<td>{$aFeed.time_stamp|date}</td>
			<td>{$aFeed.content|parse}</td>
		</tr>
		{/foreach}
	</table>
	<div class="table_clear">
		<input type="submit" name="approve" value="{phrase var='feed.approve_selected'}" class="button sJsCheckBoxButton disabled" disabled="true" />
		<input type="submit" name="deny" value="{phrase var='feed.deny_selected'}" class="sJsConfirm button sJsCheckBoxButton disabled" disabled="true" />
	</div>
</form>
{pager}
{else}
<div class="message">
	{phrase var='feed.nothing_to_approve_at_this_time'}
</div>
{/if}