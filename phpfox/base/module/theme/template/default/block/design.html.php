<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: design.html.php 4444 2012-07-02 10:23:15Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="js_style_holder">
	<div class="style_header">
		<div class="style_top_menu">
			<a href="#" id="js_designer_full_screen" title="{phrase var='theme.full_screen'}: {$aDesigner.design_header}" class="no_ajax_link">{phrase var='theme.full_screen'}</a> |
			<a href="#" id="js_toggle_designer_content" title="{phrase var='theme.toggle'}: {$aDesigner.design_header}" class="no_ajax_link">{phrase var='theme.toggle'}</a> |
			{if !isset($aDesigner.hide_block_link)}
			<a href="#" id="js_toggle_blocks" title="{phrase var='theme.toggle_all_blocks'}" class="no_ajax_link">{phrase var='theme.blocks'}</a> |
			{/if}
			<a href="{$aDesigner.current_page}" class="no_ajax_link">{phrase var='theme.close'}</a>
		</div>
			{$aDesigner.design_header}
	</div>		
	<div id="js_designer_content">
		<div class="style_content_left">
			<ul>
				<li><a href="#theme" class="active">{img theme='misc/color_wheel.png' class='v_middle'} {phrase var='theme.themes'}</a></li>					
				{if isset($aBlocks)}
				<li><a href="#block">{img theme='misc/shape_square_add.png' class='v_middle'} {phrase var='theme.blocks'}</a></li>
				{/if}					
				{if isset($aAdvanced)}
				<li><a href="#advanced">{img theme='misc/color_swatch.png' class='v_middle'} {phrase var='theme.advanced'}</a>
				<li><a href="#css">{img theme='misc/page_white_code.png' class='v_middle'} {phrase var='theme.css'}</a>
				</li>
				{/if}					
			</ul>
		</div>
		{if isset($aAdvanced)}				
		<div class="style_separate"></div>		
		<div class="style_content_middle">			
			<ul>
				{foreach from=$aAdvanced name=css item=aEdit}
				<li><a href="#{$aEdit.id}"{if $phpfox.iteration.css == 1} class="active"{/if}>{$aEdit.block}</a><span style="display:none;">{$aEdit.name}</span></li>
				{/foreach}
			</ul>
		</div>					
		{/if}
		<div class="style_separate"></div>
		<div class="style_content_right">
			<div class="js_designer_section" id="js_designer_theme">
			{if $iTestStyleId}
				<form method="post" action="#" onsubmit="$(this).ajaxCall('theme.updateTheme'); return false;">
					<div><input type="hidden" name="style_id" value="{$iTestStyleId}" /></div>
					<div><input type="hidden" name="type_id" value="{$aDesigner.type_id}" /></div>
					<div><input type="hidden" name="item_id" value="{$aDesigner.item_id}" /></div>
					<div class="style_submit_box style_submit_box_theme">
						<input type="submit" value="{phrase var='theme.use_theme'}" class="button" />		
					</div>			
				</form>
			{else}
			<br />
			{/if}		

			<div class="style_main_content" style="padding:4px 0px 0px 4px;">				
			{foreach from=$aStlyes item=aStyle}
				<form method="post" action="{$aDesigner.design_page}">
					<div><input type="hidden" name="test_style_id" value="{$aStyle.style_id}" /></div>
					<div class="style_box{if $aDesigner.current_style_id == $aStyle.style_id} style_box_active{/if}{if $iTestStyleId == $aStyle.style_id} style_box_test{/if}">
						<a href="#" onclick="$(this).parents('form:first').submit(); return false;">{$aStyle.name}</a>		
						<div style="padding-top:5px;">
							<a href="#" onclick="$(this).parents('form:first').submit(); return false;">
								<img src="{$aStyle.sample_image}" alt="" />
							</a>
						</div>
					</div>				
				</form>
			{/foreach}			
				<div class="clear"></div>							
			</div>					
	</div>
	{if isset($aAdvanced)}
	<div class="js_designer_section" id="js_designer_css" style="display:none;">		
		<form method="post" action="{$aDesigner.design_page}" onsubmit="$('.js_save_css_code_button').addClass('disabled'); $('#js_save_css_code').show(); $(this).ajaxCall('theme.processCss'); return false;">
			<div><input type="hidden" name="type_id" value="{$aDesigner.type_id}" /></div>
			<div class="style_submit_box">
				<input type="hidden" name="action" value="" />
				<input type="submit" value="{phrase var='theme.save'}" name="save" class="button js_save_css_code_button" onclick="action.value = 'save';"/>
				<input type="submit" value="{phrase var='theme.preview'}" name="preview" class="button button_off js_save_css_code_button"  onclick="action.value = 'preview';" />
				<span id="js_save_css_code" style="display:none;">{img theme='ajax/small.gif' class='v_middle'}</span>
			</div>
			<div class="p_4">
				<textarea cols="60" rows="6" name="css" style="width:98%;" id="js_css_code_editor">{if isset($aDesigner.css_code)}{$aDesigner.css_code|htmlspecialchars}{/if}</textarea>					
			</div>					
		</form>
	</div>
					
	<div class="js_designer_section" id="js_designer_advanced" style="display:none;">										
		<form method="post" action="{$aDesigner.design_page}" id="js_cache_form_css">
			<div><input type="hidden" name="reset_form" value="1" /></div>
			<div><input type="hidden" name="reset_group" value="{$sResetGroup}" id="js_reset_group" /></div>
		</form>
					
		<form id="user_design_profile" method="post" action="#" onsubmit="$('#js_save_css_button').attr('disabled', true).addClass('disabled'); $('#js_save_css').show(); $(this).ajaxCall('theme.updateCss'); return false;">
			<div><input type="hidden" name="type_id" value="{$aDesigner.type_id}" /></div>
			<div class="style_submit_box">
				<div class="style_submit_box_revert">				
					<input type="button" value="{phrase var='theme.revert_to_default'}" class="button" onclick="if (confirm('{phrase var='theme.are_you_sure_note_that_this_will_revert_all_your_changes_and_not_just_those_within_this_group' phpfox_squote=true}')) {literal}{ $.ajaxCall('theme.revertDesign'); } return false;" />
				{/literal}
				</div>
				<div class="style_submit_box_revert_save">
					<input type="submit" value="{phrase var='theme.save'}" class="button" id="js_save_css_button" /> <span id="js_save_css" style="display:none;">{img theme='ajax/small.gif' class='v_middle'}</span>							
				</div>
			</div>
			<div class="style_main_content">
				<div class="p_4">
				{foreach from=$aAdvanced name=css item=aEdit}
					<div class="js_designer_child_section" id="js_designer_child_{$aEdit.id}" style="display:none;">
		
							{if isset($aEdit.design.width)}				
								{phrase var='theme.width'}:
								<div class="p_2">
								<select class="js_form_value" name="css[{$aEdit.name}][width]" onchange="return on_change_attr('{$aEdit.name}', 'width', this.value);">
									<option value=""{if empty($aEdit.value.width)} selected="selected"{/if}>{phrase var='theme.default'}</option>
								{foreach from=$aEdit.design.width item=sWidth}
									<option value="{$sWidth}"{if isset($aEdit.value.width) && $aEdit.value.width == $sWidth} selected="selected"{/if}>{$sWidth}</option>
								{/foreach}
								</select>
								</div>
							{/if}
							
								{if isset($aEdit.design.background)}
								<fieldset>
									<legend>{phrase var='theme.background'}</legend>
									{if isset($aEdit.design.background.color)}
									<div class="go_left">
										{phrase var='theme.color'}:
										<div class="p_2">
											<div><input class="js_colorpicker_div js_form_value" type="hidden" name="css[{$aEdit.name}][background-color]" value="{if isset($aEdit.value.background.color)}{$aEdit.value.background.color|clean}{/if}" size="20" /></div>
											<a href="#?name={$aEdit.name}&amp;attr=background-color" class="colorpicker_select"{if isset($aEdit.value.background.color)} style="background-color:{$aEdit.value.background.color};"{/if}>Color</a>	
										</div>
									</div>
									{/if}		
									
									{if isset($aEdit.design.background.image)}
									<div class="go_left">
										{phrase var='theme.url'}:
										<div class="p_2">
											<input class="js_form_value" type="text" name="css[{$aEdit.name}][background-image]" id="js_theme_url_{$aEdit.id}" value="{if isset($aEdit.value.background.image)}{$aEdit.value.background.image|clean}{/if}" size="20" onblur="return on_change_image(this);" />
											<a href="#" onclick="tb_show('{phrase var='theme.attach_files' phpfox_squote=true}', $.ajaxBox('attachment.add', 'height=500&width=600&category_id=theme&amp;item_id={$aDesigner.item_id}&amp;input=js_theme_url_{$aEdit.id}')); return false;">
												{img theme='misc/attach.png' class='v_middle'}										
											</a>
										</div>
									</div>
									{/if}
									
									{if isset($aEdit.design.background.attachment)}
									<div class="go_left">
										{phrase var='theme.scroll'}:
										<div class="p_2">
											<select class="js_form_value" name="css[{$aEdit.name}][background-attachment]" onchange="return on_change_attr('{$aEdit.name}', 'background-attachment', this.value);">
												<option value=""{if isset($aEdit.value.background.attachment) && empty($aEdit.value.background.attachment)} selected="selected"{/if}>{phrase var='theme.default'}</option>
												<option value="scroll"{if isset($aEdit.value.background.attachment) && $aEdit.value.background.attachment == 'scroll'} selected="selected"{/if}>{phrase var='theme.yes'}</option>
												<option value="fixed"{if isset($aEdit.value.background.attachment) && $aEdit.value.background.attachment == 'fixed'} selected="selected"{/if}>{phrase var='theme.no'}</option>
											</select>
										</div>
									</div>
									{/if}		
									
									{if isset($aEdit.design.background.position)}
									<div class="go_left">
										{phrase var='theme.position'}:
										<div class="p_2">
											<select class="js_form_value" name="css[{$aEdit.name}][background-position]" onchange="return on_change_attr('{$aEdit.name}', 'background-position', this.value);">
												<option value=""{if isset($aEdit.value.background.position) && empty($aEdit.value.background.position)} selected="selected"{/if}>{phrase var='theme.default'}</option>
												{foreach from=$aPositions item=sPosition}
													<option value="{$sPosition}" {if isset($aEdit.value.background.position) && $aEdit.value.background.position == $sPosition} selected="selected"{/if}>{$sPosition}</option>
												{/foreach}
											</select>
										</div>
									</div>
									{/if}	
									
									{if isset($aEdit.design.background.repeat)}
									<div class="go_left">
										{phrase var='theme.repeat'}:
										<div class="p_2">
											<select class="js_form_value" name="css[{$aEdit.name}][background-repeat]" onchange="return on_change_attr('{$aEdit.name}', 'background-repeat', this.value);">
												<option value=""{if isset($aEdit.value.background.repeat) && empty($aEdit.value.background.repeat)} selected="selected"{/if}>{phrase var='theme.default'}</option>
												<option value="no-repeat"{if isset($aEdit.value.background.repeat) && $aEdit.value.background.repeat == 'no-repeat'} selected="selected"{/if}>{phrase var='theme.do_not_repeat'}</option>
												<option value="repeat-x"{if isset($aEdit.value.background.repeat) && $aEdit.value.background.repeat == 'repeat-x'} selected="selected"{/if}>{phrase var='theme.across'}</option>
												<option value="repeat-y"{if isset($aEdit.value.background.repeat) && $aEdit.value.background.repeat == 'repeat-y'} selected="selected"{/if}>{phrase var='theme.down'}</option>
												<option value="repeat"{if isset($aEdit.value.background.repeat) && $aEdit.value.background.repeat == 'repeat'} selected="selected"{/if}>{phrase var='theme.tile'}</option>
											</select>
										</div>
									</div>
									{/if}								
									
									<div class="clear"></div>
									
								</fieldset>
								{/if}
								
								{if isset($aEdit.design.font)}
								<fieldset>
									<legend>{phrase var='theme.font'}</legend>
									{if isset($aEdit.design.font.color)}
									<div class="go_left">
										{phrase var='theme.color'}:
										<div class="p_2">
											<div><input class="js_colorpicker_div js_form_value" type="hidden" name="css[{$aEdit.name}][font-color]" value="{if isset($aEdit.value.font.color)}{$aEdit.value.font.color|clean}{/if}" size="20" /></div>
											<a href="#?name={$aEdit.name}&amp;attr=font-color" class="colorpicker_select"{if isset($aEdit.value.font.color)} style="background-color:{$aEdit.value.font.color};"{/if}>Color</a>	
										</div>
									</div>
									{/if}
									
									{if isset($aEdit.design.font.family)}
									<div class="go_left">
										{phrase var='theme.family'}:
										<div class="p_2">
											<select class="js_form_value" name="css[{$aEdit.name}][font-family]" onchange="return on_change_attr('{$aEdit.name}', 'font-family', this.value);">
												<option value=""{if isset($aEdit.value.font.family) && empty($aEdit.value.font.family)} selected="selected"{/if}>{phrase var='theme.default'}</option>
												{foreach from=$aFonts item=sFont}
													<option value="{$sFont}" style="font-family:{$sFont};"{if isset($aEdit.value.font.family) && $aEdit.value.font.family == $sFont} selected="selected"{/if}>{$sFont}</option>
												{/foreach}
											</select>
										</div>
									</div>
									{/if}			
									
									{if isset($aEdit.design.font.size)}
									<div class="go_left">
										{phrase var='theme.size'}:
										<div class="p_2">
											<select class="js_form_value" name="css[{$aEdit.name}][font-size]" onchange="return on_change_attr('{$aEdit.name}', 'font-size', this.value);">
												<option value=""{if isset($aEdit.value.font.size) && empty($aEdit.value.font.size)} selected="selected"{/if}>{phrase var='theme.default'}</option>
												{foreach from=$aFontSizes item=iSize}
													<option value="{$iSize}"{if isset($aEdit.value.font.size) && $aEdit.value.font.size == $iSize} selected="selected"{/if}>{$iSize}</option>
												{/foreach}
											</select>
										</div>
									</div>
									{/if}	
									
									{if isset($aEdit.design.font.style)}
									<div class="go_left">
										{phrase var='theme.style'}:
										<div class="p_2">
											<select class="js_form_value" name="css[{$aEdit.name}][font-style]" onchange="return on_change_attr('{$aEdit.name}', 'font-style', this.value);">
												<option value=""{if isset($aEdit.value.font.style) && empty($aEdit.value.font.style)} selected="selected"{/if}>{phrase var='theme.default'}</option>
												{foreach from=$aFontStyles item=sStyle}
													<option value="{$sStyle}"{if isset($aEdit.value.font.style) && $aEdit.value.font.style == $sStyle} selected="selected"{/if}>{$sStyle}</option>
												{/foreach}
											</select>
										</div>
									</div>
									{/if}			
									
									{if isset($aEdit.design.font.weight)}
									<div class="go_left">
										{phrase var='theme.weight'}:
										<div class="p_2">
											<select class="js_form_value" name="css[{$aEdit.name}][font-weight]" onchange="return on_change_attr('{$aEdit.name}', 'font-weight', this.value);">
												<option value=""{if isset($aEdit.value.font.weight) && empty($aEdit.value.font.weight)} selected="selected"{/if}>{phrase var='theme.default'}</option>
												{foreach from=$aFontWeights item=sWeight}
													<option value="{$sWeight}"{if isset($aEdit.value.font.weight) && $aEdit.value.font.weight == $sWeight} selected="selected"{/if}>{$sWeight}</option>
												{/foreach}
											</select>
										</div>
									</div>
									{/if}
									
									<div class="clear"></div>
									
								</fieldset>
								{/if}					
								
								{if isset($aEdit.design.text)}
								<fieldset>
									<legend>{phrase var='theme.text'}</legend>
									
									{if isset($aEdit.design.text.align)}
									<div class="go_left">
										{phrase var='theme.align'}:
										<div class="p_2">
											<select class="js_form_value" name="css[{$aEdit.name}][text-align]" onchange="return on_change_attr('{$aEdit.name}', 'text-align', this.value);">
												<option value=""{if isset($aEdit.value.text.align) && empty($aEdit.value.text.align)} selected="selected"{/if}>{phrase var='theme.default'}</option>
												{foreach from=$aTextAlign item=sAlign}
													<option value="{$sAlign}"{if isset($aEdit.value.text.align) && $aEdit.value.text.align == $sAlign} selected="selected"{/if}>{$sAlign}</option>
												{/foreach}
											</select>
										</div>
									</div>
									{/if}				
									
									{if isset($aEdit.design.text.transform)}
									<div class="go_left">
										{phrase var='theme.transform'}:
										<div class="p_2">
											<select class="js_form_value" name="css[{$aEdit.name}][text-transform]" onchange="return on_change_attr('{$aEdit.name}', 'text-transform', this.value);">
												<option value=""{if isset($aEdit.value.text.transform) && empty($aEdit.value.text.transform)} selected="selected"{/if}>{phrase var='theme.default'}</option>
												{foreach from=$aTextTransforms item=sTransform}
													<option value="{$sTransform}"{if isset($aEdit.value.text.transform) && $aEdit.value.text.transform == $sTransform} selected="selected"{/if}>{$sTransform}</option>
												{/foreach}
											</select>
										</div>
									</div>
									{/if}
									
									{if isset($aEdit.design.text.decoration)}
									<div class="go_left">
										{phrase var='theme.decoration'}:
										<div class="p_2">
											<select class="js_form_value" name="css[{$aEdit.name}][text-decoration]" onchange="return on_change_attr('{$aEdit.name}', 'text-decoration', this.value);">
												<option value=""{if isset($aEdit.value.text.decoration) && empty($aEdit.value.text.decoration)} selected="selected"{/if}>{phrase var='theme.default'}</option>
												{foreach from=$aTextDecorations item=sDecoration}
													<option value="{$sDecoration}"{if isset($aEdit.value.text.decoration) && $aEdit.value.text.decoration == $sDecoration} selected="selected"{/if}>{$sDecoration}</option>
												{/foreach}
											</select>
										</div>
									</div>
									{/if}	
									
									<div class="clear"></div>

								</fieldset>
								{/if}							
								
								{if isset($aEdit.design.border)}
								{foreach from=$aEdit.design.border.type key=sBorderPlacement item=bBorderValue}
								<fieldset>
									<legend>{phrase var='theme.border'}: {$sBorderPlacement|translate:'css_position'}</legend>
									
									<div class="go_left">
										{phrase var='theme.style'}:
										<div class="p_2">
											<select class="js_form_value" name="css[{$aEdit.name}][border-{$sBorderPlacement}-style]" onchange="return on_change_attr('{$aEdit.name}', 'border-{$sBorderPlacement}-style', this.value);">
												<option value="">{phrase var='theme.default'}</option>
											{foreach from=$aBorderStyles item=sBorderStyle}
												<option value="{$sBorderStyle}"{if ($sBorderPlacement == 'top' && isset($aEdit.value.border.top.style) && $aEdit.value.border.top.style == $sBorderStyle) || ($sBorderPlacement == 'right' && isset($aEdit.value.border.right.style) && $aEdit.value.border.right.style == $sBorderStyle) || ($sBorderPlacement == 'bottom' && isset($aEdit.value.border.bottom.style) && $aEdit.value.border.bottom.style == $sBorderStyle) || ($sBorderPlacement == 'left' && isset($aEdit.value.border.left.style) && $aEdit.value.border.left.style == $sBorderStyle)} selected="selected"{/if}>{$sBorderStyle}</option>
											{/foreach}
											</select>
										</div>
									</div>										
									
									<div class="go_left">
										{phrase var='theme.width'}:									
										<div class="p_2">
											<select class="js_form_value" name="css[{$aEdit.name}][border-{$sBorderPlacement}-width]" onchange="return on_change_attr('{$aEdit.name}', 'border-{$sBorderPlacement}-width', this.value);">
												<option value="">{phrase var='theme.default'}</option>
											{foreach from=$aBorderWidths item=sBorderWidth}
												<option value="{$sBorderWidth}"{if ($sBorderPlacement == 'top' && isset($aEdit.value.border.top.width) && $aEdit.value.border.top.width == $sBorderWidth) || ($sBorderPlacement == 'right' && isset($aEdit.value.border.right.width) && $aEdit.value.border.right.width == $sBorderWidth) || ($sBorderPlacement == 'bottom' && isset($aEdit.value.border.bottom.width) && $aEdit.value.border.bottom.width == $sBorderWidth) || ($sBorderPlacement == 'left' && isset($aEdit.value.border.left.width) && $aEdit.value.border.left.width == $sBorderWidth)} selected="selected"{/if}>{$sBorderWidth}</option>
											{/foreach}
											</select>
										</div>
									</div>									
									
									<div class="go_left">
										{phrase var='theme.color'}:
										<div class="p_2">
											<div><input class="js_colorpicker_div js_form_value" type="hidden" name="css[{$aEdit.name}][border-{$sBorderPlacement}-color]" value="{if ($sBorderPlacement == 'top' && isset($aEdit.value.border.top.color))}{$aEdit.value.border.top.color|clean}{elseif ($sBorderPlacement == 'right' && isset($aEdit.value.border.right.color))}{$aEdit.value.border.right.color|clean}{elseif ($sBorderPlacement == 'bottom' && isset($aEdit.value.border.bottom.color))}{$aEdit.value.border.bottom.color|clean}{elseif ($sBorderPlacement == 'left' && isset($aEdit.value.border.left.color))}{$aEdit.value.border.left.color|clean}{/if}" size="20" /></div>
											<a href="#?name={$aEdit.name}&amp;attr=border-{$sBorderPlacement}-color" class="colorpicker_select"{if ($sBorderPlacement == 'top' && isset($aEdit.value.border.top.color))} style="background-color:{$aEdit.value.border.top.color};"{elseif ($sBorderPlacement == 'right' && isset($aEdit.value.border.right.color))} style="background-color:{$aEdit.value.border.right.color};"{elseif ($sBorderPlacement == 'bottom' && isset($aEdit.value.border.bottom.color))} style="background-color:{$aEdit.value.border.bottom.color};"{elseif ($sBorderPlacement == 'left' && isset($aEdit.value.border.left.color))} style="background-color:{$aEdit.value.border.left.color};"{/if}>Color</a>
										</div>
									</div>		
									
									<div class="clear"></div>
																
								</fieldset>					
								{/foreach}
								{/if}			
								
								{if isset($aEdit.design.padding)}
								{foreach from=$aEdit.design.padding.type key=sPaddingPlacement item=bPaddingValue}
								<fieldset>
									<legend>{phrase var='theme.padding'}: {$sPaddingPlacement|translate:'css_position'}</legend>										
									
									<div class="go_left">
										{phrase var='theme.size'}:									
										<div class="p_2">
											<select class="js_form_value" name="css[{$aEdit.name}][padding-{$sPaddingPlacement}]" onchange="return on_change_attr('{$aEdit.name}', 'padding-{$sPaddingPlacement}', this.value);">
												<option value="">{phrase var='theme.default'}</option>
											{foreach from=$aPaddingSizes item=sPaddingSize}
												<option value="{$sPaddingSize}"{if ($sPaddingPlacement == 'top' && isset($aEdit.value.padding.top) && $aEdit.value.padding.top == $sPaddingSize) || ($sPaddingPlacement == 'right' && isset($aEdit.value.padding.right) && $aEdit.value.padding.right == $sPaddingSize) || ($sPaddingPlacement == 'bottom' && isset($aEdit.value.padding.bottom) && $aEdit.value.padding.bottom == $sPaddingSize) || ($sPaddingPlacement == 'left' && isset($aEdit.value.padding.left) && $aEdit.value.padding.left == $sPaddingSize)} selected="selected"{/if}>{$sPaddingSize}</option>
											{/foreach}
											</select>
										</div>
									</div>									
									
								</fieldset>					
								{/foreach}
								{/if}							
									
									<div style="margin-top:4px;">				
										<input type="button" value="{phrase var='theme.reset'}" class="button js_design_reset" id="js_reset_button_{$aEdit.id}" /> <span id="js_reset_span_{$aEdit.id}" style="display:none;">{img theme='ajax/small.gif' class='v_middle'}</span>
									</div>								
											
								</div>						
							
							
							{/foreach}			
							</div>
							</div>	
														
						</form>
					</div>
					{/if}
					
					{if isset($aBlocks)}
					<div class="js_designer_section" id="js_designer_block" style="display:none;">		
						<div style="position:relative; height:35px; padding:6px 0px 0px 0px;">
							<div style="position:absolute; right:7px; top:7px;">
								<input type="button" class="button" onclick="if (confirm(getPhrase('core.are_you_sure'))) {l} window.location.href='{$aDesigner.design_page}resetblock_true/'; {r}" value="{phrase var='theme.reset'}" />
							</div>
							<div class="extra_info">
								{phrase var='theme.click_on_the_blocks_below_to_hide_unhide_them'}							
							</div>														
						</div>						
						<div style="padding:4px 0px 0px 4px;">				
						{foreach from=$aBlocks item=aBlock}
							<div class="style_box{if $aBlock.is_installed} style_box_active{/if}">							
								<div><input type="hidden" name="js_block_installed" value="{if $aBlock.is_installed}0{else}1{/if}" id="js_block_installed_{$aBlock.block_id}" /></div>
								<a href="#" onclick="if ($('#js_block_installed_{$aBlock.block_id}').val() == '0') {left_curly} $('#js_block_installed_{$aBlock.block_id}').val('1'); $(this).parent().removeClass('style_box_active'); {right_curly} else {left_curly} $('#js_block_installed_{$aBlock.block_id}').val('0'); $(this).parent().addClass('style_box_active'); {right_curly} if ($('#js_block_installed_{$aBlock.block_id}').val() == '1') {left_curly} $('#js_block_border_{$aBlock.cache_id}').hide(); {right_curly} else {left_curly} $('#js_block_border_{$aBlock.cache_id}').show(); {right_curly} $.ajaxCall('theme.updateBlock', 'val[item_id]={$aDesigner.item_id}&amp;val[type_id]={$aDesigner.type_id}&amp;val[cache_id]={$aBlock.cache_id}&amp;val[is_installed]=' + $('#js_block_installed_{$aBlock.block_id}').val()); return false;">{$aBlock.title|convert}</a>
							</div>
						{/foreach}
							<div class="clear"></div>							
						</div>						
					</div>					
					{/if}
				
			</div>
			<div class="clear"></div>
		</div>	
</div>
{$sResetJs}
{literal}
<script type="text/javascript">
	$Behavior.customDesignPanelPush = function(){
		if ($Core.exists('#js_style_holder')){
			$('body').addClass('main_core_body_holder_class');
		}
		else {
			$('body').removeClass('main_core_body_holder_class');
		}
	}
</script>
{/literal}