<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Fernando Gutierrez
 * @package  		Module_Blog
 * @version 		$Id: specialmenu.html.php 7290 2014-04-30 12:36:00Z Fernando_Gutierrez $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="profile_blog_special_menu">
    <a href="{$aDrafts.url}" {if $aDrafts.active == true} class="active"{/if}>
    	<div>
			{$aDrafts.total}<span> {$aDrafts.phrase}</span>
		</div> 
    </a>
</div>
<div class="clear"></div>
