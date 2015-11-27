<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: parent.html.php 1124 2009-10-02 14:07:30Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !count($aThreads)}
<div class="extra_info">
	{phrase var='forum.no_forum_threads'}
</div>
{else}
{foreach from=$aThreads name=threads item=aThread}
<div class="{if is_int($phpfox.iteration.threads/2)}row1{else}row2{/if}{if $phpfox.iteration.threads == 1} row_first{/if}">
	<div style="width:55px; position:absolute; text-align:center;">
		{img user=$aThread suffix='_50' max_width='50' max_height='50'}
	</div>
	<div style="margin-left:60px; min-height:55px; height:auto !important; height:55px;">	
		<a href="{url link='group.'$aGroup.title_url'.forum.'$aThread.title_url'}">{$aThread.title|clean|shorten:25:'...'|split:20}</a>		
		<div class="extra_info">
			{phrase var='forum.posted_by_user_link_on_time_stamp_phrase' user=$aThread}
		</div>		
	</div>
</div>
{/foreach}
{/if}