<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: register.html.php 5538 2013-03-25 13:20:22Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{literal}
<script type="text/javascript">
<!--
	$Behavior.music_register = function()
	{
		$('#js_terms_of_use').click(function()
		{
			tb_show('Terms of Use', $.ajaxBox('page.view', 'height=410&width=600&title=terms'));
			
			return false;
		});
		
		$('#js_privacy_policy').click(function()
		{
			tb_show('Privacy Policy', $.ajaxBox('page.view', 'height=410&width=600&title=policy')); 
			
			return false;
		});
	};
-->
</script>
{/literal}
<div class="main_break"></div>
<div class="message" style="font-weight:normal;">
	{phrase var='music.you_retain_all_rights_in_your_music_that_you_upload'}
</div>

{if Phpfox::getUserBy('user_group_id') == ADMIN_USER_ID}
<div class="error_message">
	{phrase var='music.b_notice_b_you_have_an_admin_account_and_if_you_convert_your_account_into_a_musicians_account'}
</div>
{/if}

<div class="main_break"></div>

{$sCreateJs}
<form method="post" action="{url link='music.register'}" onsubmit="{$sGetJsForm}" id="js_form">
	<div class="table">
		<div class="table_left">
			{required}{phrase var='music.artist_band_name'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[full_name]" value="{value type='input' id='full_name'}" id="full_name" size="30" maxlength="255" />
		</div>
	</div>
	
	{foreach from=$aSettings item=aSetting}
	<div class="table">
		<div class="table_left">
		{if $aSetting.is_required}{required}{/if}
			{phrase var=$aSetting.phrase_var_name}:
		</div>
		<div class="table_right">
			{template file='custom.block.form'}
		</div>
	</div>
	{/foreach}	
	
	<div class="table_clear">
		<input type="checkbox" name="val[agree]" id="agree" value="1" class="checkbox v_middle" {value type='checkbox' id='agree' default='1'}/> {required}{phrase var='music.i_have_read_and_agree_to_the_terms_of_use_and_privacy_policy'}
	</div>

	<div class="table_clear">
		<input type="submit" value="{phrase var='music.register'}" class="button" />
	</div>
</form>