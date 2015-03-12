<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 1124 2009-10-02 14:07:30Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{$sCreateJs}
<form method="post" action="{url link='admincp.forum.add'}" id="js_form" onsubmit="{$sGetJsForm}">
{if isset($aForms.forum_id)}
	<div><input type="hidden" name="id" value="{$aForms.forum_id}" /></div>
{/if}
	<div class="table_header">
	{phrase var='forum.forum_details'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='forum.name'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[name]" value="{value type='input' id='name'}" id="name" size="30" />			
		</div>		
	</div>
	{if !empty($sForumParents)}
	<div class="table">
		<div class="table_left">
			{phrase var='forum.parent_forum'}:
		</div>
		<div class="table_right">
			<select name="val[parent_id]" style="width:300px;">
				<option value="">{phrase var='forum.select'}:</option>
				{$sForumParents}
			</select>
		</div>
	</div>
	{/if}
	<div class="table">
		<div class="table_left">
			{phrase var='forum.is_a_category'}:
		</div>
		<div class="table_right">
			<label><input type="radio" name="val[is_category]" value="1" class="v_middle" {value type='radio' id='is_category' default='1'}/> {phrase var='forum.yes'}</label>
			<label><input type="radio" name="val[is_category]" value="0" class="v_middle" {value type='radio' id='is_category' default='0' selected='true'}/> {phrase var='forum.no'}</label>
		</div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='forum.closed'}:
		</div>
		<div class="table_right">
			<label><input type="radio" name="val[is_closed]" value="1" class="v_middle" {value type='radio' id='is_closed' default='1'}/> {phrase var='forum.yes'}</label>
			<label><input type="radio" name="val[is_closed]" value="0" class="v_middle" {value type='radio' id='is_closed' default='0' selected='true'}/> {phrase var='forum.no'}</label>
		</div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='forum.description'}:
		</div>
		<div class="table_right">
			<textarea name="val[description]" cols="50" rows="8">{value type='textarea' id='description'}</textarea>
		</div>		
	</div>			
	<div class="table_clear">
		<input type="submit" value="{phrase var='admincp.submit'}" class="button" />
		{if isset($aForms)}
		<input type="button" name="cancel" value="{phrase var='forum.cancel_uppercase'}" class="button" onclick="window.location.href = '{url link='admincp.forum'}';" />
		{/if}
	</div>
</form>