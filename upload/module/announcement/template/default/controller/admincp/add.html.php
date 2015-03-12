<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox
 * @version 		$Id: add.html.php 4493 2012-07-10 15:07:29Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form action="{url link="current"}" method="post" id="frm_announcement">
	<div class="table_header">
		{phrase var='announcement.announcement_details'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='announcement.subject'}:
		</div>
		<div class="table_right">		   
			
		    {foreach from=$aAnnouncement.language item=aLanguage}
			<b>{$aLanguage.title}</b>
			<div class="p_4">
			    <input type="text" name="val[subject][{$aLanguage.language_id}][text]" value="{if isset($aLanguage.subject)}{$aLanguage.subject|clean}{/if}" size="40" />
			    <input type="hidden" name="val[subject][{$aLanguage.language_id}][is_default]" value="{$aLanguage.is_default}">
			</div>
		    {/foreach}


		  
		</div>
		<div class="clear"></div>
	</div>

	<div class="table">
		<div class="table_left">
			{phrase var='announcement.intro'}:
		</div>
		<div class="table_right">
			
		    {foreach from=$aAnnouncement.language item=aLanguage}
			<b>{$aLanguage.title}</b>
			<div class="p_4">
			    <input type="text" name="val[intro][{$aLanguage.language_id}][text]" value="{if isset($aLanguage.intro)}{$aLanguage.intro|clean}{/if}" size="40" />
			    <input type="hidden" name="val[intro][{$aLanguage.language_id}][is_default]" value="{$aLanguage.is_default}">
			</div>
		    {/foreach}

		</div>
	</div>

	<div class="table">
		<div class="table_left">
			{required}{phrase var='announcement.announcement'}:
		</div>
		<div class="table_right">
		{foreach from=$aAnnouncement.language item=aLanguage}
			<b>{$aLanguage.title}</b>
			<div class="p_4">
			    <textarea cols="57" rows="5" name="val[content][{$aLanguage.language_id}][text]">{if isset($aLanguage.content)}{$aLanguage.content|clean}{/if}</textarea>
			    <input type="hidden" name="val[content][{$aLanguage.language_id}][is_default]" value="{$aLanguage.is_default}">
			</div>
		    {/foreach}
			
		</div>

		<div class="table_header">
			{phrase var='announcement.display_options'}
		</div>
		<div class="table">
			<div class="table_left">
				{required}{phrase var='admincp.active'}:
			</div>
			<div class="table_right">
				<div class="item_is_active_holder">
					<span class="js_item_active item_is_active">
						<input type="radio" name="val[is_active]" value="1" {value type='radio' id='is_active' default='1' selected='true'}/> {phrase var='admincp.yes'}
					</span>
					<span class="js_item_active item_is_not_active">
						<input type="radio" name="val[is_active]" value="0" {value type='radio' id='is_active' default='0'}/> {phrase var='admincp.no'}
					</span>
				</div>
			</div>

			<div class="clear"></div>
		</div>
		<div class="clear"></div>

		<div class="table">
			<div class="table_left">
				{required}{phrase var='announcement.can_be_closed'}:
			</div>
			<div class="table_right">
				<div class="item_can_be_closed_holder">
					<span class="item_is_active">
						<input type="radio" name="val[can_be_closed]" value="1" {value type='radio' id='can_be_closed' default='1' selected='true'}/> {phrase var='admincp.yes'}
						   </span>
					<span class=" item_is_not_active">
						<input type="radio" name="val[can_be_closed]" value="0" {value type='radio' id='can_be_closed' default='0'}/> {phrase var='admincp.no'}
						   </span>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="table">
			<div class="table_left">
				{required}{phrase var='announcement.show_in_the_dashboard'}:
			</div>
			<div class="table_right">
				<div class="item_can_be_closed_holder">
					<span class="item_is_active">
						<input type="radio" name="val[show_in_dashboard]" value="1" {value type='radio' id='show_in_dashboard' default='1' selected='true'}/> {phrase var='admincp.yes'}
						   </span>
					<span class=" item_is_not_active">
						<input type="radio" name="val[show_in_dashboard]" value="0" {value type='radio' id='show_in_dashboard' default='0'}/> {phrase var='admincp.no'}
						   </span>
				</div>
			</div>

			<div class="clear"></div>
		</div>
		<div class="table">
			<div class="table_left">
				{required}{phrase var='announcement.show_author'}:
			</div>
			<div class="table_right">
				<div class="item_can_be_closed_holder">
					<span class="item_is_active">
						<input type="radio" name="val[user_id]" value="{$iUser}" id="show_author" {value type='radio' id='user_id' default=''$iUser'' selected='true'}/> {phrase var='admincp.yes'}
					</span>
					<span class=" item_is_not_active">
						<input type="radio" name="val[user_id]" value="0" id="show_author" {value type='radio' id='user_id' default='0' selected='true'}/> {phrase var='admincp.no'}
					</span>
				</div>
			</div>

			<div class="clear"></div>
		</div>
		<div class="table">
			<div class="table_left">
				{phrase var='announcement.start_date'}:
			</div>
			<div class="table_right">
				{select_date prefix='start_' start_year='current_year' end_year='+10' field_separator=' / ' field_order='MDY' default_all=true add_time=true time_separator='core.time_separator'}
			</div>
			<div class="clear"></div>
		</div>


		<div class="table_header">
			{phrase var='announcement.target_viewers'}
		</div>
		<div class="table">
			<div class="table_left">
				{phrase var='announcement.user_groups'}:
			</div>
			<div class="table_right">
				<select name="val[is_user_group]" id="js_is_user_group">
					<option value="1"{value type='select' id='is_user_group' default='1'}>{phrase var='announcement.all_user_groups'}</option>
					<option value="2"{value type='select' id='is_user_group' default='2'}>{phrase var='announcement.selected_user_groups'}</option>
				</select>
				<div class="p_4" style="display:none;" id="js_user_group">
					{foreach from=$aUserGroups item=aUserGroup}
					<div class="p_4">
						<label><input type="checkbox" name="val[user_group][]" value="{$aUserGroup.user_group_id}"{if isset($aAccess) && is_array($aAccess)}{if in_array($aUserGroup.user_group_id, $aAccess)} checked="checked" {/if}{else} checked="checked" {/if}/> {$aUserGroup.title|convert|clean}</label>
					</div>
					{/foreach}
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="table">
			<div class="table_left">
				{phrase var='announcement.location'}:
			</div>
			<div class="table_right">
				{select_location value_title='phrase var=core.any'}
			</div>
			<div class="clear"></div>
		</div>
		<div class="table">
			<div class="table_left">
				{phrase var='announcement.gender'}:
			</div>
			<div class="table_right">
				{select_gender value_title='phrase var=core.any'}
			</div>
			<div class="clear"></div>
		</div>
		<div class="table">
			<div class="table_left">
				{phrase var='announcement.age_group_between'}:
			</div>
			<div class="table_right">
				<select name="val[age_from]" id="age_from">
					<option value="">{phrase var='announcement.any'}</option>
					{foreach from=$aAge item=iAge}
					<option value="{$iAge}"{value type='select' id='age_from' default=$iAge}>{$iAge}</option>
					{/foreach}
				</select>
				<span id="js_age_to">
					&raquo;
					<select name="val[age_to]" id="age_to">
					<option value="">{phrase var='announcement.any'}</option>
						{foreach from=$aAge item=iAge}
						<option value="{$iAge}"{value type='select' id='age_to' default=$iAge}>{$iAge}</option>
						{/foreach}
					</select>
				</span>
			</div>
			<div class="clear"></div>
		</div>	
	</div>

	<div class="table_clear">
		<input type="submit" value="{phrase var='core.submit'}" class="button" />
	</div>
</form>