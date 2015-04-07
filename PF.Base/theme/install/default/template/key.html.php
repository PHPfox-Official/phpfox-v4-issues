<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: key.html.php 2833 2011-08-15 19:56:43Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	<div class="table_header">
		Client Details
	</div>
	<form method="post" action="#key" id="js_form">
		<div class="table">
			<div class="table_right">
				<input type="text" name="val[license_id]" id="license_id" value="{value type='input' id='license_id'}" size="30" placeholder="License ID" />
			</div>
		</div>
		<div class="table">
			<div class="table_right">
				<input type="text" name="val[license_key]" id="license_key" value="" size="30" placeholder="License Key" />
			</div>
		</div>
		<div class="table_clear">
			<input type="submit" value="Continue" class="button" />
		</div>
	</form>