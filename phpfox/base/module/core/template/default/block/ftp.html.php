<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: ftp.html.php 982 2009-09-16 08:11:36Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="js_ftp_path" style="display:none;">
	<div class="p_4">
		{phrase var='core.ftp_path'}: <input type="text" name="null" value="" id="js_ftp_actual_path" onclick="this.select();" />
		<div class="extra_info" id="js_empty_ftp_path" style="display:none;">
			{phrase var='admincp.your_ftp_path_is_empty_and_does_not_need_to_have_any_value'}
		</div>
	</div>
</div>
<div id="js_ftp_error" class="error_message" style="display:none;"></div>
<div id="js_ftp_form">
	<form method="post" action="#" onsubmit="$('#js_ftp_check_process').html($.ajaxProcess('Checking')); $(this).ajaxCall('core.ftpPathSearch'); return false;">
		<div class="table_header">
			{phrase var='admincp.ftp_details'}
		</div>
		<div class="table">
			<div class="table_left">
				{phrase var='admincp.ftp_host'}:
			</div>
			<div class="table_right">
				<input type="text" name="val[host]" value="" size="30" />
			</div>
			<div class="clear"></div>
		</div>
		<div class="table">
			<div class="table_left">
				{phrase var='admincp.ftp_username'}:
			</div>
			<div class="table_right">
				<input type="text" name="val[user_name]" value="" size="30" />
			</div>
			<div class="clear"></div>
		</div>	
		<div class="table">
			<div class="table_left">
				{phrase var='admincp.ftp_password'}:
			</div>
			<div class="table_right">
				<input type="password" name="val[password]" value="" size="30" />
			</div>
			<div class="clear"></div>
		</div>
		<div class="table_clear">
			<span id="js_ftp_check_process"></span> <input type="submit" value="{phrase var='admincp.submit'}" class="button" />
		</div>
	</form>
</div>