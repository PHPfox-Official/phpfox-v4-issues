<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: final.html.php 759 2009-07-14 07:44:23Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{$sCreateJs}
<script type="text/javascript">
<!--
function addUser()
{literal}{{/literal}
	if ({$sGetJsForm})
	{literal}
	{		
		$('.button').attr('disabled', true);
		$('.button').val('Processing...');
		return true;
	}
	{/literal}	
	return false;
{literal}}{/literal}
-->
</script>
<form method="post" action="{url link=""$sUrl".final"}" id="js_form" onsubmit="return addUser();">
	<div class="table_header">
		Administrators Account
	</div>
	<div class="table">
		<div class="table_left">
			Full Name:
		</div>
		<div class="table_right">
			<input type="text" name="val[full_name]" id="full_name" value="{value type='input' id='full_name'}" size="30" />	
		</div>
	</div>
	<div class="table">
		<div class="table_left">
			User Name:
		</div>
		<div class="table_right">
			<input type="text" name="val[user_name]" id="user_name" value="{value type='input' id='user_name'}" size="30" />	
		</div>
	</div>
	<div class="table">
		<div class="table_left">
			Password:
		</div>
		<div class="table_right">
			<input type="password" name="val[password]" id="password" value="{value type='input' id='password'}" size="30" />	
		</div>
	</div>
	<div class="table">
		<div class="table_left">
			Email:
		</div>
		<div class="table_right">
			<input type="text" name="val[email]" id="email" value="{value type='input' id='email'}" size="30" />	
		</div>
	</div>
	
	<div class="table">
		<div class="table_left">
			Date of Birth:	
		</div>
		<div class="table_right">
			{select_date start_year='1900' end_year='2008' field_separator=' / ' field_order='MDY'}
		</div>
		<div class="clear"></div>
	</div>
	
	<div class="table">
		<div class="table_left">
			<label for="country_iso">Location:</label>
		</div>
		<div class="table_right">
			{select_location}
		</div>
		<div class="clear"></div>
	</div>
	
	<div class="table">
		<div class="table_left">
			<label for="gender">Gender:</label>
		</div>
		<div class="table_right">
			{select_gender}
		</div>
		<div class="clear"></div>
	</div>
	
	<div style="display:none;">
	{template file='video.block.install'}
	</div>
	
	<div class="table_clear">
		<input type="submit" value="Submit" class="button" />
	</div>
</form>