<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: popular.html.php 829 2009-08-02 18:45:42Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<ul class="action">
{foreach from=$aPopularGroups item=aGroup}
	<li><a href="{url link='group.'$aGroup.title_url''}">{$aGroup.title}</a></li>
{/foreach}
</ul>