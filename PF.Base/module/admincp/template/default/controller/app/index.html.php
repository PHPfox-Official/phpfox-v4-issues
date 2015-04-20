{if isset($settings)}
	<form class="on_change_submit" method="post" action="{url link='current'}">
		{foreach from=$settings item=setting key=var}
		<div class="table_header2 settings">
			{$setting.info}
		</div>
		<div class="table3 settings">
			<div class="row_right">
				{if $setting.type == 'input:text'}
				<input type="text" name="setting[{$var}]" value="{$setting.value|clean}">
				{elseif $setting.type == 'input:radio'}
				<div class="item_is_active_holder">
					<span class="js_item_active item_is_active">
						<input type="radio"{if $setting.value == 1} checked="checked"{/if} name="setting[{$var}]" value="1"> Yes
					</span>
					<span class="js_item_active item_is_not_active">
						<input type="radio"{if $setting.value != 1} checked="checked"{/if} name="setting[{$var}]" value="0"> No
					</span>
				</div>
				{/if}
			</div>
		</div>
		{/foreach}
	</form>
{/if}

{*
<div class="table">
	<div class="table_left">
		Version:
	</div>
	<div class="table_right">
		{$App.version}
	</div>
</div>
*}