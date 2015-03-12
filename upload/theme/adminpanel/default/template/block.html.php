<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: block.html.php 3325 2011-10-20 08:33:09Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if isset($sHeader) && (!PHPFOX_IS_AJAX || isset($bPassOverAjaxCall))}
<div class="block{if (defined('PHPFOX_IN_DESIGN_MODE') && PHPFOX_IN_DESIGN_MODE) || (Phpfox::getService('theme')->isInDnDMode())} js_sortable{/if}"{if isset($sBlockBorderJsId)} id="js_block_border_{$sBlockBorderJsId}"{/if}{if defined('PHPFOX_IN_DESIGN_MODE') && Phpfox::getLib('module')->blockIsHidden('js_block_border_' . $sBlockBorderJsId . '')} style="display:none;"{/if}>
	{if !empty($sHeader)}
		<div class="title js_sortable_header">		
		{if isset($sBlockTitleBar)}
			{$sBlockTitleBar} 
		{/if}
		{if isset($aEditBar)}
			<div class="js_edit_header_bar">
				<a href="#" title="{phrase var='admincp.edit_this_block'}" onclick="$.ajaxCall('{$aEditBar.ajax_call}', 'block_id={$sBlockBorderJsId}{if isset($aEditBar.params)}{$aEditBar.params}{/if}'); return false;">{img theme='misc/application_edit.png' alt='' class='v_middle'}</a>				
			</div>
		{/if}
		{if isset($sDeleteBlock)}
			<div class="js_edit_header_bar js_edit_header_hover" style="display:none;">
				<a href="#" onclick="if (confirm('Are you sure?')) {left_curly} $(this).parents('.block:first').remove(); $.ajaxCall('core.hideBlock', 'type_id={$sDeleteBlock}&amp;block_id=' + $(this).parents('.block:first').attr('id')); {right_curly} return false;" title="{phrase var='admincp.remove_this_block'}">
					{img theme='misc/application_delete.png' alt='' class='v_middle'}
				</a>
			</div>
		{/if}		
			{$sHeader}
		</div>
	{/if}
	{if isset($aEditBar)}
	<div id="js_edit_block_{$sBlockBorderJsId}" class="edit_bar" style="display:none;"></div>
	{/if}
	<div class="content"{if isset($sBlockJsId)} id="js_block_content_{$sBlockJsId}"{/if}>
{/if}
		{layout_content}
{if isset($sHeader) && !PHPFOX_IS_AJAX}
	</div>
	{if isset($aFooter) && count($aFooter)}
	<div class="bottom">
	<ul>
		{foreach from=$aFooter key=sPhrase item=sLink name=block}
			<li id="js_block_bottom_{$phpfox.iteration.block}"{if $phpfox.iteration.block == 1} class="first"{/if}><a href="{$sLink}" id="js_block_bottom_link_{$phpfox.iteration.block}">{$sPhrase}</a></li>
		{/foreach}
	</ul>
	</div>
	{/if}	
</div>
{unset var=$sHeader var1=$sModule var2=$sComponent var3=$aFooter var4=$sBlockBorderJsId var5=$bBlockDisableSort var6=$bBlockCanMove var7=$aEditBar var8=$sDeleteBlock var9=$sBlockTitleBar}
{/if}