<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: backup.html.php 1268 2009-11-23 20:45:36Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $bCanBackup}
<form method="post" action="{url link='admincp.sql.backup'}">
	<div class="table_header">
		{phrase var='admincp.sql_backup_header'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.path'}:
		</div>
		<div class="table_right">
			<input type="text" name="path" value="{$sDefaultPath}" size="40" style="width:90%;" />
			<div class="extra_info">
				{phrase var='admincp.provide_the_full_path_to_where_we_should_save_the_sql_backup'}
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="table_bottom">
		<input type="submit" value="{phrase var='admincp.save'}" class="button" />
	</div>
</form>
{else}
<div class="error_message">
	{phrase var='admincp.your_operating_system_does_not_support_the_method_of_backup_we_provide'}
</div>
{/if}