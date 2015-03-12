<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: setting.html.php 6923 2013-11-21 10:56:36Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	{foreach from=$aSettings item=aProduct}
		{foreach from=$aProduct key=sKey item=aSetting}
			{foreach from=$aSetting name=settings item=aItem}
			<a name="setting{$aItem.setting_id}"></a>
			<div id="iSettingId{$aItem.setting_id}" class="{if is_int($phpfox.iteration.settings/2)}table1{else}table2{/if}{if $aItem.is_admin_setting} is_admin_setting{/if}">
				<div class="table_left2">				
				{if PHPFOX_DEBUG}
				<div class="p_4">
					<input type="text" name="val[order][{$aItem.setting_id}]" value="{$aItem.ordering}" style="font-size:9pt; padding:0px; text-align:center;" onclick="this.select();" size="2" /> 
					<input type="text" name="param[{$aItem.setting_id}]" value="{$sKey}.{$aItem.name}" style="font-size:9pt; padding:0px;" onclick="this.select();" />
					- <a href="{url link="admincp.user.group.setting" id=""$aItem.setting_id"" gid=""$aForms.user_group_id""}">{phrase var='user.edit'}</a>
				</div>
				{/if}				
				{$aItem.setting_name}
				</div>
				<div class="table_right2">				    
					{if in_array($aItem.name,$aCurrency) == true || isset($aItem.isCurrency)}
					    <input type="hidden" name="val[sponsor_setting_id_{$aItem.setting_id}]" value="{$aItem.setting_id}" />
					    {module name='core.currency' currency_field_name='val[value_actual]['$aItem.setting_id']'}					
					{elseif $aItem.type_id == 'big_string'}
					<textarea cols="60" rows="8" name="val[value_actual][{$aItem.setting_id}]">{$aItem.value_actual}</textarea>
					{elseif ($aItem.type_id == 'integer' || $aItem.type_id == 'string')}
					<input type="text" name="val[value_actual][{$aItem.setting_id}]" value="{$aItem.value_actual}" size="25" onclick="this.select();" />		
					{elseif ($aItem.type_id == 'boolean')}
						<div class="item_is_active_holder">	
							<span class="js_item_active item_is_active">
								<input type="radio" class="radio_yes" name="val[value_actual][{$aItem.setting_id}]" value="1" {if $aItem.value_actual == true || $aItem.value_actual == "1"}data-it="1yes" checked="checked" {/if}/> {phrase var='user.yes'}
							</span>
							<span class="js_item_active item_is_not_active">
								<input type="radio" class="radio_no" name="val[value_actual][{$aItem.setting_id}]" value="0" {if !$aItem.value_actual}checked="checked" {/if}/> {phrase var='user.no'}
							</span>
						</div>
					{elseif ($aItem.type_id == 'array')}
						<input type="text" name="val[value_actual][{$aItem.setting_id}]" value="{foreach from=$aItem.value_actual name=arraysetting item=aValueActual}{if $phpfox.iteration.arraysetting != 1},{/if}{$aValueActual}{/foreach}" />
					{/if}
				</div>
				<div class="clear"></div>
			</div>	
			{/foreach}
		{/foreach}
	{/foreach}