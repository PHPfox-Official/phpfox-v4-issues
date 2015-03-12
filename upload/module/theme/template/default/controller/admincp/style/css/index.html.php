<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 4906 2012-10-22 04:52:14Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if defined('PHPFOX_IS_HOSTED_SCRIPT')}
<div class="table_header">
	CSS
</div>
		<form method="post" action="{url link='current'}" id="js_template_form" onsubmit="$Core.ajaxMessage(); $('#js_last_modified').show(); $(this).ajaxCall('theme.saveCssFile', 'global_ajax_message=true'); return false;">
			<div id="js_hidden_cache">
				<div><input type="hidden" name="val[style_id]" value="{$aStyle.style_id}" id="js_css_style_id" /></div>				
				<div><input type="hidden" name="val[file_name]" value="custom.css" id="js_css_file" /></div>
				<div><input type="hidden" name="val[module_id]" value="" id="js_css_module" /></div>
			</div>
			<textarea cols="50" rows="15" name="val[css_data]" id="js_template_content" style="width:98%;">{if isset($aCustomDataContent.css_data)}{$aCustomDataContent.css_data|clean}{/if}</textarea>			
			<div>
				<div class="go_left">
					<input type="submit" value="{phrase var='theme.save'}" class="button" id="js_update_template" />					
					<span id="js_last_modified"{if !isset($aCustomDataContent.time_stamp)} style="display:none;"{/if}><input type="button" value="{phrase var='theme.revert'}" class="button" id="js_revert" onclick="return $Core.cssEditor.revert();" /></span>										
				</div>
				<div class="t_right" style="margin-right:20px;">
					<div>				
						<div id="js_last_modified_info"><span class="extra_info">{if isset($aCustomDataContent.time_stamp)}{$aCustomDataContent.time_stamp|date}{/if}</span></div>
					</div>
				</div>
				<div class="clear"></div>
				<div id="js_theme_cache_info" style="display:none;"></div>
			</div>
		</form>
{else}
<div class="table_header">
	{phrase var='theme.css_files'}
</div>
<div id="content_editor_holder">
	<div id="content_editor_menu">
		<ul>
		{foreach from=$aFiles key=sType item=aCssFiles}
			<li><a href="#" class="menu_parent js_open_template_list first">{if $sType == null}{phrase var='theme.global_css'}{else}{$sType}{/if}</a>
				<ul class="js_list_templates" style="display:none;">			
				{foreach from=$aCssFiles item=sFile}
					<li><a href="#" onclick="return $Core.cssEditor.openFile(this, '{$aStyle.style_id}', '{if is_array($sFile)}{$sFile.0}{else}{$sFile}{/if}', '{$sType}');"{if is_array($sFile)} class="modified"{/if}><div style="position:absolute; right:0; display:none;">{img theme='ajax/small.gif'}</div>{if is_array($sFile)}{$sFile.0}{else}{$sFile}{/if}</a>				
				{/foreach}
				</ul>
			</li>
		{/foreach}
		</ul>
	</div>
	<div id="content_editor_text">
		<div class="content_editor_overlay" id="js_template_content_loader"></div>
		<form method="post" action="{url link='current'}" id="js_template_form" onsubmit="return $Core.cssEditor.save(this);">
			<div id="js_hidden_cache">
				<div><input type="hidden" name="val[style_id]" value="" id="js_css_style_id" /></div>				
				<div><input type="hidden" name="val[file_name]" value="" id="js_css_file" /></div>
				<div><input type="hidden" name="val[module_id]" value="" id="js_css_module" /></div>
			</div>
			<div style="display:none;"><textarea cols="50" rows="15" name="val[css_data]" id="js_template_content_text" style="width:100%;"></textarea></div>
			<textarea cols="50" rows="15" name="val[editor_text]" id="js_template_content"></textarea>			
			<div>
				<div class="go_left">
					<input type="submit" value="{phrase var='theme.save'}" class="button" id="js_update_template" />		
					<span id="js_last_modified"><input type="button" value="{phrase var='theme.revert'}" class="button" id="js_revert" onclick="return $Core.cssEditor.revert();" /></span>		
					<span id="js_delete_custom"><input type="button" value="{phrase var='theme.delete'}" class="button" onclick="return $Core.cssEditor.deleteItem();" /></span>
				</div>
				<div class="t_right" style="margin-right:20px;">
					Product:
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
{/if}