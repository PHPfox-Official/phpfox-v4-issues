<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_Contact
 * @version 		$Id: index.html.php 1347 2009-12-22 18:10:30Z Raymond_Benc $
 */

defined('PHPFOX') or exit('NO DICE!');

?>
{if !empty($bIsSent)}
<div style="background:#FEFBD9; padding:5px; border:1px #E6E1AA solid; margin-bottom:10px;">
	Thank you for getting in contact with us. One of our sales representatives will get back to you shortly.
</div>
{else}
<div style="background:#FEFBD9; padding:5px; border:1px #E6E1AA solid; margin-bottom:10px;">
	Do you have a question that did not get answered within our <a href="{url link='faq'}">FAQ</a>? Then you are more than welcome to use the form below to get in touch with us!
	<br />
	<br />
	<b>Notice:</b> This form is reserved for pre-sales questions, if you are an existing client please use our <a href="http://support.phpfox.com/">Support Suite</a>.
</div>
{$sCreateJs}
<div class="main_break">
	<form method="post" action="{url link='contact'}" id="js_contact_form" onsubmit="{$sGetJsForm}">
		<div><input type="hidden" name="val[category_id]" id="category_id" value="phpfox_sales_ticket" size="30" /></div>
		{if Phpfox::isUser()}
			<div><input type="hidden" name="val[full_name]" id="full_name" value="{$sFullName}" size="30" /></div>
		{else}
		<div class="table">
			<div class="table_left">
				<label for="full_name">{required}{phrase var='contact.full_name'}:</label>
			</div>
			<div class="table_right">
				<input type="text" name="val[full_name]" id="full_name" value="{value type='input' id='full_name'}" size="30" />
			</div>
			<div class="clear"></div>
		</div>
		{/if}

		<div class="table">
			<div class="table_left">
				<label for="subject">{required}{phrase var='contact.subject'}:</label>
			</div>
			<div class="table_right">
				<input type="text" name="val[subject]" id="subject" value="{value type='input' id='subject'}" size="30" />
			</div>
			<div class="clear"></div>
		</div>
		{if Phpfox::isUser()}
			<div><input type="hidden" name="val[email]" id="email" value="{$sEmail}" size="30" /></div>
		{else}
		<div class="table">
			<div class="table_left">
				<label for="email">{required}{phrase var='contact.email'}:</label>
			</div>
			<div class="table_right">
				<input type="text" name="val[email]" id="email" value="{value type='input' id='email'}" size="30" />
			</div>
			<div class="clear"></div>
		</div>
		{/if}

		<div class="table">
			<div class="table_left">
				<label for="message">{required}{phrase var='contact.message'}:</label>
			</div>
			<div class="table_right">
				<textarea cols="60" rows="10" name="val[text]">{value id='text' type='textarea'}</textarea>
			</div>
			<div class="clear"></div>
		</div>		

		{if Phpfox::isModule('captcha') && Phpfox::getParam('contact.contact_enable_captcha')}
			{module name='captcha.form' sType=contact}
		{/if}

		<div class="table_clear">
			<input type="submit" value="{phrase var='contact.submit'}" class="button" />
			<div class="t_right"><span id="js_comment_process"></span></div>
		</div>
	</form>
	{if Phpfox::getParam('core.display_required')}
	<div class="table_clear">
		{required} {phrase var='core.required_fields'}
	</div>
	{/if}
</div>
{/if}