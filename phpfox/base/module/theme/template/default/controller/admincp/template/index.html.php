<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Theme
 * @version 		$Id: index.html.php 7022 2014-01-06 19:43:59Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table_header">
	{phrase var='theme.html_templates'}
</div>
<div id="content_editor_holder">
	<div id="content_editor_menu">
		<ul>
		{foreach from=$aTemplates key=sType name=type item=aTemplate}
		{if $sType == 'layout'}
			<li class="active"><a href="#" class="menu_parent js_open_template_list first{if isset($aTemplate.modified)} modified{/if}">{phrase var='theme.global_templates'}</a>
				<ul class="js_list_templates">
				{foreach from=$aTemplate.files item=sFile}
					<li><a href="#?type=layout&amp;name={if is_array($sFile)}{$sFile.0}{else}{$sFile}{/if}&amp;theme={$aTheme.folder}" class="js_get_template_file{if is_array($sFile)} modified{/if}"><div style="position:absolute; right:0; display:none;">{img theme='ajax/small.gif'}</div>{if is_array($sFile)}{$sFile.0}{else}{$sFile}{/if}</a></li>
				{/foreach}
				</ul>
			</li>
		{else}
			<li><a href="#" class="menu_parent js_open_template_list{if isset($aTemplate.modified)} modified{/if}">{$sType}</a>
				<ul class="js_list_templates" style="display:none;">
				{foreach from=$aTemplate item=aModules}		
				{if isset($aTemplate.controller) && count($aTemplate.controller)}
					<li><span>{phrase var='theme.controllers'}</span>
						<ul>
						{foreach from=$aTemplate.controller item=sController}
							<li>
								<a href="#?type=controller&amp;name={if is_array($sController)}{$sController.0}{else}{$sController}{/if}&amp;theme={$aTheme.folder}&amp;module={$sType}" class="js_get_template_file{if is_array($sController)} modified{/if}"><div style="position:absolute; right:0; display:none;">{img theme='ajax/small.gif'}</div>{if is_array($sController)}{$sController.0}{else}{$sController}{/if}
								</a>
							</li>
						{/foreach}
						{unset var=$aTemplate.controller}
						</ul>
					</li>
				{/if}
				{if isset($aTemplate.block) && count($aTemplate.block)}
					<li><span>{phrase var='theme.blocks'}</span>
						<ul>
						{foreach from=$aTemplate.block item=sBlock}
							<li><a href="#?type=block&amp;name={if is_array($sBlock)}{$sBlock.0}{else}{$sBlock}{/if}&amp;theme={$aTheme.folder}&amp;module={$sType}" class="js_get_template_file{if is_array($sBlock)} modified{/if}"><div style="position:absolute; right:0; display:none;">{img theme='ajax/small.gif'}</div>{if is_array($sBlock)}{$sBlock.0}{else}{$sBlock}{/if}</a></li>
						{/foreach}
						{unset var=$aTemplate.block}
						</ul>
					</li>
				{/if}		
				{/foreach}
				</ul>
			</li>
		{/if}
		{/foreach}
		</ul>
	</div>
	<div id="content_editor_text">
		<div class="content_editor_overlay" id="js_template_content_loader"></div>
		<form method="post" action="{url link='current'}" id="js_template_form">
			<div id="js_hidden_cache">
				<div><input type="hidden" name="val[type]" value="" id="js_template_type" /></div>
				<div><input type="hidden" name="val[theme]" value="" id="js_template_theme" /></div>
				<div><input type="hidden" name="val[name]" value="" id="js_template_name" /></div>
				<div><input type="hidden" name="val[module]" value="" id="js_template_module" /></div>
			</div>
			<div style="display:none;"><textarea cols="50" rows="15" name="val[text]" id="js_template_content_text" style="width:100%;"></textarea></div>
			<textarea cols="50" rows="15" name="val[editor_text]" id="js_template_content"></textarea>		
			<div>
				<div class="go_left">
					<input type="button" value="{phrase var='core.save'}" class="button" id="js_update_template" />		
					<span id="js_last_modified"><input type="button" value="{phrase var='theme.revert'}" class="button" id="js_revert" /></span>		
					<span id="js_delete_custom"><input type="button" value="{phrase var='theme.delete'}" class="button" onclick="return $Core.templateEditor.deleteItem();" /></span>
				</div>
				<div class="t_right" style="margin-right:20px;">
					{phrase var='admincp.product'}:
					<select name="val[product_id]" id="js_template_product_id">
					{foreach from=$aProducts item=aProduct}
						<option value="{$aProduct.product_id}">{$aProduct.title}</option>
					{/foreach}
					</select>
					<div>
						<div id="js_last_modified_info"></div>
					</div>
				</div>
				<div class="clear"></div>	
				<div id="js_theme_cache_info" style="display:none;"></div>
			</div>
		</form>
	</div>
	<div class="clear"></div>
</div>
