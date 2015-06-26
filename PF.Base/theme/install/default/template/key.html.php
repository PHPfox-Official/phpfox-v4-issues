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
<div id="license_selector">
	<div class="table_header">
		Select a license to assign to this copy of PHPfox:
	</div>
	<a href="#" class="premium"><i class="fa fa-diamond"></i>Premium</a>
	<a href="#" class="developers"><i class="fa fa-code"></i>Developers</a>
	{* <a href="#" class="trial"><i class="fa fa-star"></i>Trial</a> *}
</div>
<div id="client_details" style="display:none;">
	<div class="table_header">
		Enter your license ID &amp; Key:
	</div>
	<form method="post" action="#key" id="js_form">
		<div><input type="hidden" id="license_trial" name="val[is_trial]" value="0"></div>
		<div class="table">
			<div class="table_right">
				<input autocomplete="off" type="text" name="val[license_id]" id="license_id" value="{value type='input' id='license_id'}" size="30" placeholder="License ID" />
			</div>
		</div>
		<div class="table">
			<div class="table_right">
				<input autocomplete="off" type="text" name="val[license_key]" id="license_key" value="" size="30" placeholder="License Key" />
			</div>
		</div>
		<div class="table_clear">
			<input type="submit" value="Continue" class="button" />
		</div>
	</form>
</div>