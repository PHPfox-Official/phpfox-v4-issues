<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: category.html.php 1322 2009-12-15 19:31:26Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if isset($aCategories)}
{template file='core.block.category'}

{else}
{if $bParent}
<ul class="action">
	<li><a href="{if $aCallback === null}{url link='photo'}{else}{url link=$aCallback.url_home}{/if}" class="js_photo_category">{phrase var='photo.all_categories'}</a>{/if}
		{$sCategories}
{if $bParent}</li>
</ul>
{/if}
{/if}

