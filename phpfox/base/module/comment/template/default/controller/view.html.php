<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: view.html.php 2693 2011-06-28 11:24:05Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="comment_view_holder">
	{if isset($aComment.callback_url)}
	<a href="{$aComment.callback_url}" class="comment_view_link">View Full Item</a>
	{/if}
	<div class="extra_info">
		<ul class="extra_info_middot"><li>{$aComment.unix_time_stamp|convert_time}</li><li>&middot;</li><li>{$aComment|user}</li></ul> 
	</div>
</div>
{$aComment.text|parse}