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
<div class="main_break"></div>
<form method="post" action="#" onsubmit="$('#js_copying_forum').html($.ajaxProcess('{phrase var='forum.copying' phpfox_squote=true}')); $(this).ajaxCall('forum.processCopy'); return false;">
	<div><input type="hidden" name="thread_id" value="{$aThread.thread_id}" /></div>
	<div class="table">
		<div class="table_left">
			{phrase var='forum.new_title'}:
		</div>
		<div class="table_right">
			<input type="text" name="title" value="{$aThread.title|clean}" size="30" />
		</div>
	</div>	
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
	<div class="table_clear">
		<input type="submit" value="{phrase var='forum.copy_thread'}" class="button" /> <span id="js_copying_forum"></span>
	</div>
</form>