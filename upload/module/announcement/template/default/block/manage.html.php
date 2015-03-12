<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Display the image details when viewing an image.
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_<INSERT MODULE NAME HERE>
 * @version 		$Id: manage.html.php 1821 2010-09-20 16:11:48Z Miguel_Espinoza $
 */

?>
<table cellpadding="0" cellspacing="0">
	<tr>
		<th style="width:20px;"></th>
		<th>{phrase var='announcement.subject'}</th>
		<th class="t_center" style="width:60px;">{phrase var='announcement.active'}</th>
	</tr>
	{foreach from=$aAnnouncements key=iKey item=aAnnouncement}
	<tr class="{if is_int($iKey/2)} tr{else}{/if}">
		<td class="t_center">
			<a href="#" class="js_drop_down_link" title="Manage">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
			<div class="link_menu">
				<ul>
					<li><a href="{url link='admincp.announcement.add' id=$aAnnouncement.announcement_id}">{phrase var='announcement.edit'}</a></li>		
					<li><a href="{url link='admincp.announcement' delete=$aAnnouncement.announcement_id}" onclick="return confirm('{phrase var='announcement.are_you_sure'}');">{phrase var='announcement.delete'}</a></li>
				</ul>
			</div>		
		</td>
		<td>{phrase var=$aAnnouncement.subject_var}</td>
		<td class="t_center">
			<div class="js_item_is_active"{if !$aAnnouncement.is_active} style="display:none;"{/if}>
				<a href="#?call=announcement.setActive&amp;id={$aAnnouncement.announcement_id}&amp;active=0" class="js_item_active_link" title="{phrase var='admincp.deactivate'}">{img theme='misc/bullet_green.png' alt=''}</a>
			</div>
			<div class="js_item_is_not_active"{if $aAnnouncement.is_active} style="display:none;"{/if}>
				<a href="#?call=announcement.setActive&amp;id={$aAnnouncement.announcement_id}&amp;active=1" class="js_item_active_link" title="{phrase var='admincp.activate'}">{img theme='misc/bullet_red.png' alt=''}</a>
			</div>
		</td>	
	</tr>
	{/foreach}
</table>
