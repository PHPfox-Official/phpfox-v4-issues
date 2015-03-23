<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Admincp
 * @version 		$Id: add.html.php 979 2009-09-14 14:05:38Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!');

?>
<form method="post" action="{url link='admincp.privacy'}">
	<div class="table_header">
		{phrase var='admincp.add_new_privacy_rule'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.url'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[url]" value="{value type='input' id='url'}" size="30" style="width:95%;" />
			<div class="extra_info">
				{phrase var='admincp.provide_full_path'}
			</div>
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.user_groups'}:
		</div>
		<div class="table_right">
			<div class="extra_info">{phrase var='admincp.select_a_user_group_this_rule_should_apply_to'}</div>
			{foreach from=$aUserGroups item=aUserGroup}
				<div class="p_4">
					<label><input type="checkbox" name="val[user_group][]" value="{$aUserGroup.user_group_id}" /> {$aUserGroup.title|convert|clean}</label>
				</div>
			{/foreach}			
		</div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.wildcard'}:
		</div>
		<div class="table_right">	
			<div class="item_is_active_holder">		
				<span class="js_item_active item_is_active"><input type="radio" name="val[wildcard]" value="1" {value type='radio' id='wildcard' default='1'}/> {phrase var='rss.yes'}</span>
				<span class="js_item_active item_is_not_active"><input type="radio" name="val[wildcard]" value="0" {value type='radio' id='wildcard' default='0' selected='true'}/> {phrase var='rss.no'}</span>				
			</div>
			<div class="extra_info">{phrase var='admincp.option_sub_section'}</div>
		</div>
		<div class="clear"></div>		
	</div>	
	<div class="table_clear">
		<input type="submit" value="{phrase var='admincp.submit'}" class="button" />
	</div>	
</form>

<br />
<br />

<div class="table_header">
	{phrase var='admincp.rules'}
</div>
{if count($aRules)}
<form method="post" action="{url link='admincp.ad'}">	
	<table>
	<tr>
		<th style="width:20px;"></th>
		<th style="width:30px;">{phrase var='admincp.url'}</th>
		<th>{phrase var='admincp.user_groups'}</th>		
		<th>{phrase var='admincp.wildcard'}</th>
	</tr>
	{foreach from=$aRules key=iKey item=aRule}
	<tr class="{if is_int($iKey/2)} tr{else}{/if}">
		<td class="t_center">
			<a href="#" class="js_drop_down_link" title="{phrase var='ad.manage'}">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
			<div class="link_menu">
				<ul>
					<li><a href="{url link='admincp.privacy' delete=$aRule.rule_id}">{phrase var='admincp.delete'}</a></li>
				</ul>
			</div>		
		</td>
		<td>{$aRule.url|clean}{if $aRule.wildcard}*{/if}</td>
		<td>{$aRule.user_groups}</td>
		<td>{if $aRule.wildcard}Yes{else}No{/if}</td>
	</tr>
	{/foreach}
	</table>	
</form>
{else}
<div class="extra_info">
	{phrase var='admincp.there_are_no_privacy_rules_at_the_moment'}
</div>
{/if}