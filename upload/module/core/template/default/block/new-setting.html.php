<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: new-setting.html.php 982 2009-09-16 08:11:36Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<script type="text/javascript">
<!--
	function saveWhatsNewSettings(oObj)
	{left_curly}
		$(oObj).ajaxCall('core.updateComponentSetting'); $(oObj).parents('.edit_bar:first').slideUp().html(''); return false;
	{right_curly}
-->
</script>
<form method="post" action="#" onsubmit="return saveWhatsNewSettings(this);">
	<div><input type="hidden" name="val[var_name]" value="core.whats_new_blocks" /></div>
	<div><input type="hidden" name="val[load_block]" value="core.new" /></div>
	<div><input type="hidden" name="val[block_id]" value="js_block_border_core_new" /></div>
	<div><input type="hidden" name="val[load_entire_block]" value="true" /></div>
	<div><input type="hidden" name="val[load_init]" value="true" /></div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.display'}:
		</div>
		<div class="table_right">
			<select name="val[display][]" multiple="multiple" style="width:90%; height:75px;">
				{foreach from=$aModuleItems key=sModuleName item=aModuleItem}
				<option value="{$aModuleItem.id}"{if $aModuleItem.is_used} selected="selected"{/if}>{$aModuleItem.name}</option>
				{/foreach}
			</select>
		</div>
	</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='admincp.save'}" class="button" />
		<input type="button" value="{phrase var='admincp.cancel'}" class="button v_middle" onclick="$(this).parents('.edit_bar:first').slideUp().html('');" />
	</div>
</form>