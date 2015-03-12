<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="js_error_message"></div>
<div class="main_break"></div>
<form method="post" action="#" onsubmit="$(this).ajaxCall('forum.processMerge'); return false;">
	<div><input type="hidden" name="thread_id" value="{$aThread.thread_id}" /></div>
	<div class="table">
		<div class="table_left">
			{phrase var='forum.url'}:
		</div>
		<div class="table_right">
			<input type="text" name="url" value="" size="30" />
		</div>
	</div>
	{if !$bIsGroup}
	<div class="table">
		<div class="table_left">
			{phrase var='forum.destination_forum'}:
		</div>
		<div class="table_right">
			<select name="forum_id" style="width:300px;">
				{$sForums}
			</select>
		</div>
	</div>	
	{/if}
	<div class="table_clear">
		<input type="submit" value="{phrase var='forum.merge_threads'}" class="button"/>
	</div>
</form>