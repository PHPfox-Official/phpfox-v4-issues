<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: block.html.php 6820 2013-10-22 13:05:35Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if (isset($sHeader) && (!PHPFOX_IS_AJAX || isset($bPassOverAjaxCall) || isset($bIsAjaxLoader))) || (defined("PHPFOX_IN_DESIGN_MODE") && PHPFOX_IN_DESIGN_MODE) || (Phpfox::getService('theme')->isInDnDMode())}

<div class="block{if (defined('PHPFOX_IN_DESIGN_MODE') || Phpfox::getService('theme')->isInDnDMode()) && (!isset($bCanMove) || (isset($bCanMove) && $bCanMove == true ) )} js_sortable{/if}{if isset($sCustomClassName)} {$sCustomClassName}{/if}"{if isset($sBlockBorderJsId)} id="js_block_border_{$sBlockBorderJsId}"{/if}{if defined('PHPFOX_IN_DESIGN_MODE') && Phpfox::getLib('module')->blockIsHidden('js_block_border_' . $sBlockBorderJsId . '')} style="display:none;"{/if}>
	{if !empty($sHeader) || (defined("PHPFOX_IN_DESIGN_MODE") && PHPFOX_IN_DESIGN_MODE) || (Phpfox::getService('theme')->isInDnDMode())}
		<div class="title {if defined('PHPFOX_IN_DESIGN_MODE') || Phpfox::getService('theme')->isInDnDMode()}js_sortable_header{/if}">		
		{if isset($sBlockTitleBar)}
			{$sBlockTitleBar} 
		{/if}
		{if (isset($aEditBar) && Phpfox::isUser())}
			<div class="js_edit_header_bar">
				<a href="#" title="{phrase var='core.edit_this_block'}" onclick="$.ajaxCall('{$aEditBar.ajax_call}', 'block_id={$sBlockBorderJsId}{if isset($aEditBar.params)}{$aEditBar.params}{/if}'); return false;">{img theme='misc/application_edit.png' alt='' class='v_middle'}</a>				
			</div>
		{/if}
		{if true || isset($sDeleteBlock)}
			<div class="js_edit_header_bar js_edit_header_hover" style="display:none;">
				{if Phpfox::getService('theme')->isInDnDMode() && ( (isset($bCanMove) && $bCanMove) || !isset($bCanMove) )}
					<a href="#" onclick="if (confirm('{phrase var='core.are_you_sure' phpfox_squote=true}')){left_curly}
					$(this).parents('.block:first').remove(); $.ajaxCall('core.removeBlockDnD', 'sController=' + oParams['sController'] 
					+ '&amp;block_id={if isset($sDeleteBlock)}{$sDeleteBlock}{else} {$sBlockBorderJsId}{/if}');{right_curly} return false;"title="{phrase var='core.remove_this_block'}">
						{img theme='misc/application_delete.png' alt='' class='v_middle'}
					</a>
				{else}				
					{if ( (isset($bCanMove) && $bCanMove) || !isset($bCanMove) ) }
						<a href="#" onclick="if (confirm('{phrase var='core.are_you_sure' phpfox_squote=true}')) {left_curly} $(this).parents('.block:first').remove();
						$.ajaxCall('core.hideBlock', '{if isset($sCustomDesignId)}custom_item_id={$sCustomDesignId}&amp;{/if}sController=' + oParams['sController'] + '&amp;type_id={if isset($sDeleteBlock)}{$sDeleteBlock}{else} {$sBlockBorderJsId}{/if}&amp;block_id=' + $(this).parents('.block:first').attr('id')); {right_curly} return false;" title="{phrase var='core.remove_this_block'}">
							{img theme='misc/application_delete.png' alt='' class='v_middle'}
						</a>				
					{/if}
				{/if}
			</div>
			
		{/if}		
			{if empty($sHeader)}
				{$sBlockShowName}
			{else}
				{$sHeader}
			{/if}
		</div>
	{/if}
	{if isset($aEditBar)}
	<div id="js_edit_block_{$sBlockBorderJsId}" class="edit_bar" style="display:none;"></div>
	{/if}
	{if isset($aMenu) && count($aMenu)}
	<div class="menu">
	<ul>
	{foreach from=$aMenu key=sPhrase item=sLink name=content} 
		<li class="{if count($aMenu) == $phpfox.iteration.content} last{/if}{if $phpfox.iteration.content == 1} first active{/if}"><a href="{$sLink}">{$sPhrase}</a></li>
	{/foreach}
	</ul>
	<div class="clear"></div>
	</div>
	{unset var=$aMenu}
	{/if}	
	<div class="content"{if isset($sBlockJsId)} id="js_block_content_{$sBlockJsId}"{/if}>
{/if}
		{layout_content}

		
		
{if (isset($sHeader) && (!PHPFOX_IS_AJAX || isset($bPassOverAjaxCall) || isset($bIsAjaxLoader))) || (defined("PHPFOX_IN_DESIGN_MODE") && PHPFOX_IN_DESIGN_MODE) || (Phpfox::getService('theme')->isInDnDMode())}
	</div>
	{if isset($aFooter) && count($aFooter)}
	<div class="bottom">
		<ul>
			{foreach from=$aFooter key=sPhrase item=sLink name=block}
				<li id="js_block_bottom_{$phpfox.iteration.block}"{if $phpfox.iteration.block == 1} class="first"{/if}>
					{if $sLink == '#'}
						{img theme='ajax/add.gif' class='ajax_image'}
					{/if}
					<a href="{$sLink}" id="js_block_bottom_link_{$phpfox.iteration.block}">{$sPhrase}</a>
				</li>
			{/foreach}
		</ul>
	</div>
	{/if}	
</div>
{/if}
{unset var=$sHeader var2=$sComponent var3=$aFooter var4=$sBlockBorderJsId var5=$bBlockDisableSort var6=$bBlockCanMove var7=$aEditBar var8=$sDeleteBlock var9=$sBlockTitleBar var10=$sBlockJsId var11=$sCustomClassName var12=$aMenu}

{if isset($sClass)}
    {module name='ad.inner' sClass=$sClass}
{/if}