<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Blog
 * @version 		$Id: menu.html.php 979 2009-09-14 14:05:38Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="menu">
	<ul>
		<li><a href="{url link='blog.add'}" class="first">{phrase var='blog.add_new_blog'}</a></li>
		{if isset($iDraftsCount) && $iDraftsCount > 0}
		<li><a href="{url link='profile.blog' status='draft'}">{phrase var='blog.view_drafts_count' count=$iDraftsCount}</a></li>
		{/if}
	</ul>						
</div>