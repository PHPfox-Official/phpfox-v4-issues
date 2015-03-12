<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_Bulletin
 * @version 		$Id: add.html.php 1298 2009-12-05 16:19:23Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{$sCreateJs}
<div class="main_break">
	<form method="post" action="{url link='bulletin.add'}" id="js_form" name="js_form" onsubmit="{$sGetJsForm}">
		{if isset($aForms.bulletin_id)}<div><input type="hidden" name="id" value="{$aForms.bulletin_id}"></div>{/if}
		<div><input type="hidden" name="val[attachment]" id="js_attachment" value="{value type='input' id='attachment'}" /></div>
		<div class="table">
			<div class="table_left">
			{required}<label for="title">{phrase var='bulletin.title'}:</label>
			</div>
			<div class="table_right">
				<input type="text" name="val[title]" id="title" value="{value type='input' id='title'}" size="40" /> 
			</div>			
		</div>		
		<div class="table">
			<div class="table_left">
			{required}<label for="message">{phrase var='bulletin.message'}:</label>
			</div>
			<div class="table_right">
				{editor id='text'}
			</div>
		</div>		
		{if Phpfox::isModule('comment') && Phpfox::getParam('bulletin.can_post_comments_on_bulletin') && Phpfox::getUserParam('bulletin.can_control_comments_on_bulletins')}
		<div class="table">
			<div class="table_left">
				{phrase var='bulletin.comments'}:
			</div>
			<div class="table_right label_hover">
				<select name="val[allow_comment]" id="allow_comment">
					<option value="1"{value type="select" id="allow_comment" default="1"}>{phrase var='bulletin.allow_comments'}</option>
					<option value="2"{value type="select" id="allow_comment" default="2"}>{phrase var='bulletin.moderate_comments_first'}</option>
					<option value="0"{value type="select" id="allow_comment" default="0"}>{phrase var='bulletin.no_comments'}</option>
				</select>
			</div>			
		</div>
		{/if}		
		{if Phpfox::isModule('captcha') && Phpfox::getUserParam('bulletin.bulletin_enable_captcha')==true}
			{module name='captcha.form' sType=bulletin}
		{/if}				
		<div class="table_clear">
			<input type="submit" name="Submit" value="{phrase var='bulletin.submit'}" class="button" />
			<input type="button" name="val[preview]" value="{phrase var='bulletin.preview'}" class="button" onclick="tb_show('{phrase var='bulletin.bulletin_preview' phpfox_squote=true}', $.ajaxBox('bulletin.preview', 'height=400&amp;width=600&amp;text=' + encodeURIComponent(Editor.getContent())));" />	
		</div>
	</form>
	
	{if Phpfox::getParam('core.display_required')}
	<div class="table_clear">
		{required} {phrase var='core.required_fields'}
	</div>
	{/if}
</div>