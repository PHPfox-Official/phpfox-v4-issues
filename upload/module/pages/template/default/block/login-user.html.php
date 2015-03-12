<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="js_error_pages_login_user"></div>
<form method="post" action="#" onsubmit="$('#js_error_pages_login_user').show(); $(this).ajaxCall('pages.logBackUser'); return false;">
	<div class="table">
		<div class="table_left">
			Password:
		</div>
		<div class="table_right">
			<input type="password" name="password" value="" size="40" />
			<div class="extra_info">
				Enter the password used to log into the account "{$aGlobalProfilePageLogin.full_name|clean}".
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="table_clear">
		<input type="submit" class="button" value="Login" />
	</div>
</form>