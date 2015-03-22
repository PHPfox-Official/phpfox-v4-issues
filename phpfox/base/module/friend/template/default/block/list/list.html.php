<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Friend
 * @version 		$Id: list.html.php 2621 2011-05-22 20:09:22Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="js_friend_box_lists">
	<ul class="action">
	{foreach from=$aLists name=lists item=aList}
		<li{if count($aLists) == $phpfox.iteration.lists} id="js_last_folder" {/if} class="sJsList_{$aList.list_id}"><a href="{url link='friend' view='list' id=$aList.list_id}">{$aList.name|clean|split:30} ({$aList.used})</a></li>
	{foreachelse}
		<li id="js_last_folder"></li>
	{/foreach}
	</ul>	
</div>