<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: default.html.php 2525 2011-04-13 18:03:20Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link=$aBanFilter.url}">
	<div class="table_header">
		{phrase var='ban.add_filter'}
	</div>
	<div class="table">
		<div class="table_left">
			{$aBanFilter.form}:
		</div>
		<div class="table_right">
			<input type="text" name="find_value" value="" size="30" />
			<div class="extra_info">
				{phrase var='ban.use_the_asterisk_for_wildcard_entries'}
			</div>
		</div>
		<div class="clear"></div>
	</div>
	{if isset($aBanFilter.replace)}
	<div class="table">
		<div class="table_left">
			{phrase var='ban.replacement'}:
		</div>
		<div class="table_right">
			<input type="text" name="replacement" value="" size="30" />			
		</div>
		<div class="clear"></div>
	</div>	
	{/if}	
	{module name='ban.form'}
	<div class="table_clear">
		<input type="submit" value="{phrase var='ban.add'}" class="button" />
	</div>
</form>

{if count($aFilters)}
<br />
<div class="table_header">
	{phrase var='ban.ban_filters'}
</div>
<table cellpadding="0" cellspacing="0">
	<tr>
		<th style="width:20px;"></th>
		<th>{$aBanFilter.form}</th>		
		{if isset($aBanFilter.replace)}
		<th>{phrase var='ban.replacement'}</th>
		{/if}
		<th style="width:150px;">{phrase var='ban.added_by'}</th>
		<th style="width:150px;">{phrase var='ban.added_on'}</th>
		<th> Affects </th>
	</tr>
{foreach from=$aFilters name=filters item=aFilter}
	<tr{if !is_int($phpfox.iteration.filters/2)} class="tr"{/if}>
		<td class="t_center">
			<a href="#" class="js_drop_down_link" title="Manage">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
			<div class="link_menu">
				<ul>
					<li><a href="{url link=$aBanFilter.url delete={$aFilter.ban_id}" onclick="return confirm('{phrase var='ban.are_you_sure' phpfox_squote=true}');">{phrase var='ban.delete'}</a></li>					
				</ul>
			</div>		
		</td>		
		<td>{$aFilter.find_value}</td>
		{if isset($aBanFilter.replace)}
		<td>{$aFilter.replacement}</td>
		{/if}
		<td>{if empty($aFilter.user_id)}{phrase var='ban.n_a'}{else}{$aFilter|user}{/if}</td>
		<td>{$aFilter.time_stamp|date}</td>
		<td>{$aFilter.s_user_groups_affected}</td>
	</tr>
{/foreach}
</table>
{/if}