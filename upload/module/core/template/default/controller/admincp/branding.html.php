<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="message">
	{phrase var='admincp.login_with_your_phpfox_client_details'}
</div>
<form method="post" action="{url link='admincp.core.branding'}">
	<div class="table_header">
		{phrase var='admincp.phpfox_client_login_details'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.client_email'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[email]" id="email" value="{value type='input' id='email'}" size="40" />
		</div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.client_password'}:
		</div>
		<div class="table_right">
			<input type="password" name="val[password]" id="password" value="" size="40" />
		</div>
	</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='admincp.login'}" class="button" />
	</div>	
</form>