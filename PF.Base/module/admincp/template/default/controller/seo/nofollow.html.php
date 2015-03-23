<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: nofollow.html.php 4165 2012-05-14 10:43:25Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="#" onsubmit="$(this).ajaxCall('admincp.nofollow'); return false;">
	<div class="table_header">
		{phrase var='admincp.add_new_url'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.url'}:
		</div>
		<div class="table_right">
			<input type="input" name="val[url]" value="" size="60" id="js_nofollow_url" />
			<div class="extra_info">
				{phrase var='admincp.provide_the_full_url_to_the_page'}
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='admincp.submit'}" class="button" />
	</div>
</form>

<br /><br />

<div id="js_nofollow_holder"{if !count($aNoFollows)} style="display:none;"{/if}>	
	<form method="post" action="#" onsubmit="$(this).ajaxCall('admincp.deleteNoFollow'); return false;">	
		<div class="table_header">
			{phrase var='admincp.urls'}
		</div>
		<table cellpadding="0" cellspacing="0" id="js_nofollow_holder_table">
			<tr>
				<th style="width:10px;"><input type="checkbox" name="val[id]" value="" id="js_check_box_all" /></th>
				<th>{phrase var='admincp.url'}</th>
				<th style="width:20%;">{phrase var='admincp.added'}</th>
			</tr>
		{foreach from=$aNoFollows item=aNoFollow key=iKey}
			<tr id="js_id_row_{$aNoFollow.nofollow_id}" class="js_nofollow_row {if is_int($iKey/2)} tr{else}{/if}">
				<td><input type="checkbox" name="id[]" class="checkbox" value="{$aNoFollow.nofollow_id}" id="js_id_row{$aNoFollow.nofollow_id}" /></td>
				<td>{$aNoFollow.url}</td>
				<td>{$aNoFollow.time_stamp|convert_time}</td>
			</tr>
		{/foreach}
		</table>
		<div class="table_bottom">	
			<input type="submit" name="delete" value="{phrase var='admincp.delete'}" class="button sJsConfirm disabled sJsCheckBoxButton" disabled="true" />
		</div>
	</form>
</div>