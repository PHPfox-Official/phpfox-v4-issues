<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: note.html.php 2826 2011-08-11 19:41:03Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="t_center">
	<div style="position:absolute; right:0; margin-right:20px; margin-top:2px; display:none;" id="js_save_note">
		{img theme='ajax/small.gif'}
	</div>
	<textarea id="js_admincp_note" name="admincp_note" cols="60" rows="8" style="width:98%;" onfocus="$('#js_share_user_status').show();">{$sAdminNote}</textarea>
	<div class="p_4 t_right" id="js_share_user_status" style="display:none;">
		<input type="button" value="{phrase var='admincp.save'}" class="button" onclick="$('#js_share_user_status').hide(); $('#js_save_note').show(); $('#js_admincp_note').ajaxCall('core.admincp.updateNote'); return false;" />
		<input type="button" name="null" value="{phrase var='admincp.cancel'}" onclick="$('#js_share_user_status').hide(); return false;" class="button" />
	</div>	
</div>