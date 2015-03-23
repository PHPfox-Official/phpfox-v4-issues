<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: view-admincp-login.html.php 1407 2010-01-21 12:35:36Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table_header">
	{phrase var='admincp.log_details'}
</div>
<div class="table">
	<div class="table_left">
		{phrase var='admincp.attempt'}:
	</div>
	<div class="table_right_text">
		{$aLog.attempt}
	</div>
	<div class="clear"></div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='admincp.user'}:
	</div>
	<div class="table_right_text">
		{$aLog|user}
	</div>
	<div class="clear"></div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='admincp.time_stamp'}:
	</div>
	<div class="table_right_text">
	    {if Phpfox::isModule('Mail')}
		{$aLog.time_stamp|date:'mail.mail_time_stamp'}
	{else}
	    {$aLog.time_stamp|date:'core.global_update_time'}
	   {/if}
	</div>
	<div class="clear"></div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='admincp.ip_address'}:
	</div>
	<div class="table_right_text">
		{$aLog.ip_address}
	</div>
	<div class="clear"></div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='admincp.location'}:
	</div>
	<div class="table_right_text">
		<input type="text" name="" value="{$aLog.cache_data.location}" style="width:95%;" />
	</div>
	<div class="clear"></div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='admincp.referrer'}:
	</div>
	<div class="table_right_text">
		<input type="text" name="" value="{$aLog.cache_data.referrer}" style="width:95%;" />
	</div>
	<div class="clear"></div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='admincp.user_agent'}:
	</div>
	<div class="table_right_text">
		<input type="text" name="" value="{$aLog.cache_data.user_agent}" style="width:95%;" />
	</div>
	<div class="clear"></div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='admincp.security_token'}:
	</div>
	<div class="table_right_text">
		<input type="text" name="" value="{$aLog.cache_data.token}" style="width:95%;" />
	</div>
	<div class="clear"></div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='admincp.email'}:
	</div>
	<div class="table_right_text">
		<input type="text" name="" value="{$aLog.cache_data.email}" style="width:95%;" />
	</div>
	<div class="clear"></div>
</div>
<div class="table_clear">
	<input type="button" value="{phrase var='admincp.close'}" class="button" onclick="tb_remove();" />
</div>