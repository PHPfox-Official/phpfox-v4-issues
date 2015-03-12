{foreach from=$aPerms key=sPerm item=aPerm}
<div class="table">
	<div class="table_left">
		{$aPerm.phrase}
	</div>
	<div class="table_right">
		<div class="item_is_active_holder">		
			<span class="js_item_active item_is_active"><input type="radio" name="val[perm][{$sPerm}]" value="1"{if $aPerm.value} checked="checked"{/if}/> Yes</span>
			<span class="js_item_active item_is_not_active"><input type="radio" name="val[perm][{$sPerm}]" value="0"{if !$aPerm.value} checked="checked"{/if}/> No</span>
		</div>
	</div>
	<div class="clear"></div>
</div>
{/foreach}