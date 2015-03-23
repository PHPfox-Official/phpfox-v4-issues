<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 2826 2011-08-11 19:41:03Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aGroups)}
<div id="js_menu_drop_down" style="display:none;">
	<div class="link_menu dropContent" style="display:block;">
		<ul>
			<li><a href="#" onclick="return $Core.custom.action(this, 'edit');">{phrase var='custom.edit'}</a></li>
			<li><a href="#active" onclick="return $Core.custom.action(this, 'active');">{phrase var='custom.set_to_inactive'}</a></li>
			<li><a href="#" onclick="return $Core.custom.action(this, 'delete');">{phrase var='custom.delete'}</a></li>
		</ul>
	</div>
</div>
<div class="table_header">
	{phrase var='custom.custom_fields'}
</div>
<form method="post" action="{url link='admincp.custom'}">
		<div class="sortable">
			<ul>
		{foreach from=$aGroups key=mGroup name=groups item=aGroup}	
				<li class="{if $mGroup !== 'PHPFOX_EMPTY_GROUP'}group{/if}{if $phpfox.iteration.groups == 1} first{/if}">
					{if $mGroup === 'PHPFOX_EMPTY_GROUP'}{phrase var='custom.general'}{else}
						<div style="display:none;"><input type="hidden" name="group[{$aGroup.group_id}]" value="{$aGroup.ordering}" /></div>
						<a href="#?id={$aGroup.group_id}&amp;type=group" class="js_drop_down" id="js_group_{$aGroup.group_id}">{img theme='misc/draggable.png' alt='' class='v_middle'}{if !$aGroup.is_active}<del>{/if}{{phrase var=$aGroup.phrase_var_name}{if !empty($aGroup.user_group_name)} ({$aGroup.user_group_name|clean}){/if}</a>{if !$aGroup.is_active}</del>{/if}{{/if}</a>
					{if isset($aGroup.child)}
					<ul>
					{foreach from=$aGroup.child name=fields item=aField}
						<li class="field">
							<div style="display:none;"><input type="hidden" name="field[{$aField.field_id}]" value="{$aField.ordering}" /></div>
							<a href="#?id={$aField.field_id}&amp;type=field" class="js_drop_down" id="js_field_{$aField.field_id}">{img theme='misc/draggable.png' alt='' class='v_middle'} {if !$aField.is_active}<del>{/if}{phrase var=$aField.phrase_var_name}{if !empty($aGroup.user_group_name)} ({$aGroup.user_group_name|clean}){/if}{if !$aField.is_active}</del>{/if}</a>
						</li>
					{/foreach}			
					</ul>
					{/if}
				</li>	
		{/foreach}
			</ul>
		</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='custom.update_order'}" class="button" />
	</div>
</form>
{else}
<div class="extra_info">
	{phrase var='custom.no_custom_fields_have_been_added'}
	<ul class="action">
		<li><a href="{url link='admincp.custom.add'}">{phrase var='custom.add_a_new_custom_field'}</a></li>
	</ul>
</div>
{/if}