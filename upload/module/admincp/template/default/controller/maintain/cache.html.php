<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Admincp
 * @version 		$Id: cache.html.php 5332 2013-02-11 08:27:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $bCacheLocked}
<div class="error_message">
	{phrase var='admincp.cache_system_is_locked'}
</div>
<div class="extra_info">
	{phrase var='admincp.the_cache_system_is_locked_during_an_operation_that_requires_all_cache_files_to_be_kept_in_place' link=$sUnlockCache}
</div>
{else}
{if $iCacheCnt > 0}
{if !defined('PHPFOX_IS_HOSTED_SCRIPT')}
<div class="table_header">
	{phrase var='admincp.cache_stats'}
</div>
<div class="table">
	<div class="table_left">
		{phrase var='admincp.total_files'}:
	</div>
	<div class="table_right">
		{$aStats.total}
	</div>
	<div class="clear"></div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='admincp.cache_size'}:
	</div>
	<div class="table_right">
		{$aStats.size|filesize}
	</div>
	<div class="clear"></div>
</div>
{if isset($aStats.last)}
<div class="table">
	<div class="table_left">
		{phrase var='admincp.last_cached_file'}:
	</div>
	<div class="table_right">
		{$aStats.last|date:'admincp.cache_time_stamp'}
	</div>
	<div class="clear"></div>
</div>
{/if}
{/if}
<div class="{if !defined('PHPFOX_IS_HOSTED_SCRIPT')}table_clear{else}t_center{/if}">
	<input type="button" value="{phrase var='admincp.clear_all'}" class="button" onclick="window.location.href = '{url link='admincp.maintain.cache' all=true}';" />
</div>
{else}
<div class="message">
	{phrase var='admincp.no_cache_date_found'}
</div>
{/if}
{/if}