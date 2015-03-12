<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox
 * @version 		$Id: category.html.php 890 2009-12-14 13:54:49Z Miguel_Espinoza $
 */

defined('PHPFOX') or exit('NO DICE!');

?>
<ul {if isset($sUlClass)}class="{$sUlClass}"{else}class="action"{/if}>
    {foreach from=$aCategories item=aCategory key=iCategoryCount}
    <li class="{if isset($sModule)}{$sModule}_{/if}category" style="position:relative;">	   	
		
	     {if Phpfox::getParam('core.categories_to_show_at_first') < 1 && count($aCategory.sub) > 0}
	    <span onclick="isClicked_{$aCategory.category_id}=true; $Core.toggleCategory('{if isset($sModule)}{$sModule}_{/if}subcategory_{$aCategory.category_id}',{$aCategory.category_id});" id="show_more_{$aCategory.category_id}" class="category_show_more_less" style="text-align:left;vertical-align:middle;">
			{img theme='misc/plus.gif' class='v_middle'}
	    </span>
	    <span onclick="isClicked_{$aCategory.category_id}=true; $Core.toggleCategory('{if isset($sModule)}{$sModule}_{/if}subcategory_{$aCategory.category_id}',{$aCategory.category_id})" id="show_less_{$aCategory.category_id}" class="category_show_more_less" style="display:none;text-align:left;vertical-align:middle;">{img theme='misc/minus.gif' class='v_middle'}</span>
		    {/if}		
		
	<a {if Phpfox::getParam('core.categories_to_show_at_first') < 1 && count($aCategory.sub) > 0}class="no_ajax_link category_show_more_less_link"{/if} href="{$aCategory.url}{if Phpfox::getLib('request')->get('view') != ''}view_{request var='view'}/{/if}" id="{if isset($sModule)}{$sModule}_{/if}category_{$aCategory.category_id}">
	
		    {$aCategory.name|convert|clean}
	</a>

		{if isset($aCategory.sub) && count($aCategory.sub)}
	<ul>
		{foreach from=$aCategory.sub item=aSubCategory key=iKey}
	    <li {if $iKey >= Phpfox::getParam('core.categories_to_show_at_first')}style="display:none;" class="{if isset($sModule)}{$sModule}_{/if}subcategory_{$aCategory.category_id} special_subcategory"{/if}>
		<a href="{$aSubCategory.url}" id="{if isset($sModule)}{$sModule}_{/if}subcategory_{$aSubCategory.category_id}">
			    {$aSubCategory.name|convert|clean}
		</a>
	    </li>
		{/foreach}

		{if $iKey >= Phpfox::getParam('core.categories_to_show_at_first') && Phpfox::getParam('core.categories_to_show_at_first') > 0}
	    <li onclick="$Core.toggleCategory('{if isset($sModule)}{$sModule}_{/if}subcategory_{$aCategory.category_id}',{$aCategory.category_id})">
		<div id="show_more_{$aCategory.category_id}" style="text-align:right;vertical-align:middle;"><a href="#" onclick="return false;">{img theme='misc/plus.gif' class='v_middle'}{phrase var='user.view_more'}</a></div>
		<div id="show_less_{$aCategory.category_id}" style="display:none;text-align:right;vertical-align:middle;"><a href="#" onclick="return false;">{img theme='misc/minus.gif' class='v_middle'}{phrase var='core.view_less'}</a></div>
	    </li>
		{/if}
	</ul>
		{/if}
    </li>
    {/foreach}   
</ul>