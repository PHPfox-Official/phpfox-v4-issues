<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: category.html.php 3917 2012-02-20 18:21:08Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<ul class="action">
	{foreach from=$aCategories item=aCategory}
	<li class="category"><a href="{$aCategory.link}">{$aCategory.name|convert}</a></li>
	{/foreach}
</ul>