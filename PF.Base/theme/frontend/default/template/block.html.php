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
{if (isset($sHeader) && (!PHPFOX_IS_AJAX || isset($bPassOverAjaxCall) || isset($bIsAjaxLoader))) || (defined("PHPFOX_IN_DESIGN_MODE") && PHPFOX_IN_DESIGN_MODE) || (Theme_Service_Theme::instance()->isInDnDMode())}

<div class="block{if (defined('PHPFOX_IN_DESIGN_MODE') || Theme_Service_Theme::instance()->isInDnDMode()) && (!isset($bCanMove) || (isset($bCanMove) && $bCanMove == true ) )} js_sortable{/if}{if isset($sCustomClassName)} {$sCustomClassName}{/if}"{if isset($sBlockBorderJsId)} id="js_block_border_{$sBlockBorderJsId}"{/if}{if defined('PHPFOX_IN_DESIGN_MODE') && Phpfox_Module::instance()->blockIsHidden('js_block_border_' . $sBlockBorderJsId . '')} style="display:none;"{/if}>
	{if !empty($sHeader) || (defined("PHPFOX_IN_DESIGN_MODE") && PHPFOX_IN_DESIGN_MODE) || (Theme_Service_Theme::instance()->isInDnDMode())}
		<div class="title {if defined('PHPFOX_IN_DESIGN_MODE') || Theme_Service_Theme::instance()->isInDnDMode()}js_sortable_header{/if}">
		{if isset($sBlockTitleBar)}
			{$sBlockTitleBar} 
		{/if}
		{if (isset($aEditBar) && Phpfox::isUser())}
			<div class="js_edit_header_bar">
				<a href="#" title="{phrase var='core.edit_this_block'}" onclick="$.ajaxCall('{$aEditBar.ajax_call}', 'block_id={$sBlockBorderJsId}{if isset($aEditBar.params)}{$aEditBar.params}{/if}'); return false;">
					<i class="fa fa-edit"></i>
				</a>
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

		
		
{if (isset($sHeader) && (!PHPFOX_IS_AJAX || isset($bPassOverAjaxCall) || isset($bIsAjaxLoader))) || (defined("PHPFOX_IN_DESIGN_MODE") && PHPFOX_IN_DESIGN_MODE) || (Theme_Service_Theme::instance()->isInDnDMode())}
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