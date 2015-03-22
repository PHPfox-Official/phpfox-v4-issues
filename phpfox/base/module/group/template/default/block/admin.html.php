<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: admin.html.php 1129 2009-10-03 12:42:56Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<ul class="action">
{foreach from=$aGroupAdmins item=aAdmin}
	<li><a href="{url link=$aAdmin.user_name}">{$aAdmin.full_name|clean}{if $aAdmin.creator_id == $aAdmin.user_id} ({phrase var='group.creator'}){/if}</a></li>
{/foreach}
</ul>