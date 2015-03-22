<?php
defined('PHPFOX') or exit('No dice!');
?>

<form action="{url link='admincp.custom.relationships'}" method="post">
	<div class="table_header">
		{phrase var='custom.add_status'}
	</div>
	<div class="table">
		<div class="table_left">
			Status name:
		</div>
		<div class="table_right">
			{if isset($aEdit)}
				{module name='language.admincp.form' type='text' id='new' var_name=$aEdit.phrase.new}
			{else}
				{module name='language.admincp.form' type='text' id='new'}
			{/if}

			<div class="extra_info">
			{phrase var='custom.you_can_add_a_language_phrase_if_you_enter_it_like_this'}: <br />
			{l}phrase var='module.phrase_var'{r} <br />
			{phrase var='custom.otherwise_the_script_will_create_the_language_phrase_for_you'}
			</div>
		</div>
		
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='custom.feed_when_confirmed'}:
		</div>
		<div class="table_right">
			{if isset($aEdit)}
				{module name='language.admincp.form' type='text' id='feed_with' var_name=$aEdit.phrase.feed_with}
			{else}
				{module name='language.admincp.form' type='text' id='feed_with'}
			{/if}
			<div class="extra_info">
				{phrase var='custom.this_is_the_message_for_the_feed_when_the_relationship_has_been_confirmed'}
			</div>
		</div>
	</div>
	
	<div class="table">
		<div class="table_left">
			{phrase var='custom.feed_before_confirming'}:
		</div>
		<div class="table_right">
			{if isset($aEdit)}
				{module name='language.admincp.form' type='text' id='feed_new' var_name=$aEdit.phrase.feed_new}
			{else}
				{module name='language.admincp.form' type='text' id='feed_new'}
			{/if}
			<div class="extra_info">
				{phrase var='custom.this_message_will_be_shown_in_the_feed_when_a_user_has_set_a_relationship'}
			</div>
		</div>
	</div>
    
	<div class="table">
	    <div class="table_left">
			{phrase var='custom.requires_confirmation'}:
	    </div>
	    <div class="table_right">		
		    <input type="checkbox" name="val[confirmation]" {if isset($aEdit) && $aEdit.confirmation == 1}checked="checked" {/if}>
			   <div class="extra_info">
			       {phrase var='custom.if_this_field_is_enabled_this_relationship_status_requires_that_both_users_agree_on_displaying_their_relationship'}
			   </div>
	    </div>
	</div>
	<div class="table">
	<div class="extra_info">
			{phrase var='custom.for_all_these_phrases_the_following_transformations_apply'}: 
			<br />{l}with_user_name{r} {phrase var='custom.user_name_of_the_receiving_party'}
			<br />{l}with_full_name{r} {phrase var='custom.full_name_of_the_receiving_party'}
			<br />{l}user_name{r} {phrase var='custom.sender_s_user_name'}
			<br />{l}full_name{r} {phrase var='custom.sender_s_full_name'}
			<br />{l}their{r} {phrase var='custom.sender_s_possessive_adjective_his_her'}
		</div>
	</div>
	<div class="table_clear">		
		<input type="submit" value="{if isset($aEdit)} {phrase var='custom.edit_status'} {else}{phrase var='custom.add_status'}{/if}" class="button">
	</div>	
</form>
{if !isset($aEdit)}
	<br />
	<form action="{url link='admincp.custom.relationships'}" method="post">
		<div class="table_header">
			{phrase var='custom.manage_relationship_statuses'}
		</div>
		<div class="table">		
			{if (isset($aStatuses) && is_array($aStatuses) && !empty($aStatuses))}
			<table>
				<tr>
					<th style="width:20px;"> {phrase var='custom.delete'} </th>
					<th style="width:20px;"> {phrase var='custom.edit'} </th>
					<th> {phrase var='custom.status_name'} </th>
					<th> {phrase var='custom.feed_when_confirmed'} </th>
					<th> {phrase var='custom.feed_when_new'} </th>
					<th> {phrase var='custom.confirmation'} </th>
				</tr>
				{foreach from=$aStatuses name=status item=aStatus}
					<tr class="{if is_int($phpfox.iteration.status/2)}tr{else}{/if}" >
						<td> 
							<a href="{url link='admincp.custom.relationships' delete=$aStatus.relation_id}" onclick="return confirm('{phrase var='core.are_you_sure'}')">
								{img theme='misc/delete.png' style='vertical-align:middle;'}
							</a>
						</td>
						<td> 
							<a href="{url link='admincp.custom.relationships' edit=$aStatus.relation_id}">
								{img theme='misc/page_white_edit.png' style='vertical-align:middle;'}
							</a>
						</td>
						<td> {if isset($aStatus.phrase.new)} {module name='language.admincp.form' type='label' id=$aStatus.relation_id var_name=$aStatus.phrase.new} {/if} </td>
						<td> {if isset($aStatus.phrase.feed_with)} {module name='language.admincp.form' type='label' id=$aStatus.relation_id var_name=$aStatus.phrase.feed_with} {/if} </td>
						<td> {if isset($aStatus.phrase.feed_new)} {module name='language.admincp.form' type='label' id=$aStatus.relation_id var_name=$aStatus.phrase.feed_new}  {/if} </td>
						<td> <input type="checkbox" disabled="disabled" name="confirmation" {if $aStatus.confirmation == 1}checked="checked"{/if}> </td>
					</tr>
				{/foreach}
			</table>
			{else}
				{phrase var='custom.no_relationship_statuses_have_been_added'}
			{/if}
		</div>
		<div class="table_clear"></div>
	</form>
{/if}