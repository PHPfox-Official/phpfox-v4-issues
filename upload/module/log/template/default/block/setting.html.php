<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: setting.html.php 1318 2009-12-14 22:34:04Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="#" onsubmit="$(this).ajaxCall('core.updateComponentSetting'); $(this).parents('.edit_bar:first').slideUp().html(''); return false;">
	<div><input type="hidden" name="val[var_name]" value="log.user_login_display_limit" /></div>
	<div><input type="hidden" name="val[load_block]" value="log.login" /></div>
	<div><input type="hidden" name="val[block_id]" value="js_block_border_log_login" /></div>	
	<div class="table">
		<div class="table_left">
			{phrase var='log.view'}:
		</div>
		<div class="table_right">
			<select name="val[user_value]">
				<option value="0"{if $iDefaultSetting !== 1} selected="selected"{/if}>{phrase var='log.everyone'}</option>
				<option value="1"{if $iDefaultSetting === 1} selected="selected"{/if}>{phrase var='log.friends_only'}</option>
			</select>
		</div>
		<div class="clear"></div>
	</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='log.save'}" class="button v_middle" />
		<input type="button" value="{phrase var='log.cancel'}" class="button v_middle" onclick="$(this).parents('.edit_bar:first').slideUp().html('');" />
	</div>
</form>