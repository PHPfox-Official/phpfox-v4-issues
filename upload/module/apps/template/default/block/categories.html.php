<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="main_section_menu">
	<div class="sub_section_menu">
		<ul>
		{foreach from=$aCategories item=aCategory}
			<li class="{if $iCurrentCategory == $aCategory.category_id} active{/if}">
				<a href="{$aCategory.url}" class="ajax_link">
					{$aCategory.name|convert|clean}
				</a>
			</li>
		{/foreach}
		</ul>
	</div>
</div>	 