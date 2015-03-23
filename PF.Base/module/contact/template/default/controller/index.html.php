<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_Contact
 * @version 		$Id: index.html.php 1870 2010-09-28 15:09:21Z Miguel_Espinoza $
 */

defined('PHPFOX') or exit('NO DICE!');

?>
{$sCreateJs}
<div class="main_break">
	<form method="post" action="{url link='contact'}" id="js_contact_form" onsubmit="{$sGetJsForm}">
		<div class="table">
			<div class="table_left">
				<label for="category_id">{required}{phrase var='contact.category'}:</label>
			</div>
			<div class="table_right">
				<select name="val[category_id]" id="category_id">
				<option value="">{phrase var='contact.select'}:</option>
				{foreach from=$aCategories item=sCategory}
					<option value="{$sCategory.title}"{value type='select' id='category_id' default=$sCategory.title}>{$sCategory.title|convert|clean}</option>
				{foreachelse}
					<option value="#">{phrase var='contact.currently_unavailable'}</option>
				{/foreach}

				</select>
			</div>
			<div class="clear"></div>
		</div>
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
		
		<div class="table">
			<div class="table_left">
				{phrase var='contact.send_yourself_a_copy'}
			</div>
			<div class="table_right">
				<input type="checkbox" name="val[copy]" value="1"{value id='copy' type='checkbox' default='1'}/>
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