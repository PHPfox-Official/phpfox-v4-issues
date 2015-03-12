<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 4074 2012-03-28 14:02:40Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>


<div id="js_field_holder">
	<form method="post" action="{url link='admincp.input.manage'}" id="js_custom_field">
		
		
		{foreach from=$aInputs key=sAction item=aAction}
			<div class="table_header">
				{phrase var='input.adding_a_saction' sAction=$sAction}
			</div>
			<table class="js_drag_drop" cellpadding="0" cellspacing="0">
				{foreach from=$aAction item=aBlock}
					{foreach from=$aBlock key=iKey item=aInput}						
						<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
							<td class="drag_handle"><input type="hidden" name="val[ordering][{$aInput.field_id}]" value="{$aInput.ordering}" /></td>							
							<td class="t_center" style="width:20px;">
								<a href="#" class="js_drop_down_link" title="{phrase var='admincp.manage'}">{img theme='misc/bullet_arrow_down.png' alt=''}</a>													
								<div class="link_menu">
									<ul>
										<li><a href="{url link='admincp.input.add.' id=$aInput.field_id}">{phrase var='admincp.edit'}</a></li>		
										<li><a href="{url link='admincp.input.manage.' delete=$aInput.field_id}" onclick="return confirm('{phrase var='admincp.are_you_sure' phpfox_squote=true}');">{phrase var='admincp.delete'}</a></li>					
									</ul>
								</div>	
							</td>
							<td>
								{phrase var=$aInput.phrase_var}
							</td>
						</tr>
					
					{/foreach}
					
				{/foreach}
			</table>
			{foreachelse}
			<div class="extra_info">
				{phrase var='input.no_fields_have_been_added'}
			</div>
		{/foreach}
	</form>
</div>

