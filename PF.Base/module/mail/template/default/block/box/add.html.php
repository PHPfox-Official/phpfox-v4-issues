<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 3533 2011-11-21 14:07:21Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="error_message" id="js_mail_folder_add_error" style="display:none;"></div>
<form method="post" action="#" onsubmit="$Core.processForm('#js_mail_folder_add_submit'); $(this).ajaxCall('mail.addFolder'); return false;">
	<input type="text" name="add_folder" value="" size="40" /> 
	<div class="extra_info">
		{phrase var='mail.enter_the_name_of_your_custom_folder'}
	</div>
	<div class="p_top_4" id="js_mail_folder_add_submit">
		<ul class="table_clear_button">
			<li><input type="submit" value="{phrase var='mail.submit'}" class="button" /></li>
			<li class="table_clear_ajax"></li>
		</ul>
		<div class="clear"></div>
	</div>
</form>
