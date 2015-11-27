<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_Newsletter
 * @version 		$Id: manage.html.php 1168 2009-10-09 14:20:37Z Raymond_Benc $
 */

?>
<div class="table_header">
	{phrase var='newsletter.newsletters'}
</div>
<div>
	<table>
		<tr>
			<th style="width:20px;"></th>
			<th>{phrase var='newsletter.subject'}</th>
			<th>{phrase var='newsletter.user'}</th>
			<th>{phrase var='newsletter.added'}</th>
			<th style="width:120px;">{phrase var='newsletter.state'}</th>
		</tr>
		{foreach from=$aNewsletters item=aNewsletter key=iKey name=newsletters}
		<tr id="js_newsletter_{$aNewsletter.newsletter_id}" class="checkRow{if is_int($iKey/2)} tr{/if}" {if $aNewsletter.state == 1} style="background-color:#9DE580;" {/if}>
			<td class="t_center">
				<a href="#" class="js_drop_down_link" title="Manage">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
				<div class="link_menu">
					<ul>
						{if $aNewsletter.state == 0}
							<li><a href="{url link='admincp.newsletter.add' id=$aNewsletter.user_id}">{phrase var='newsletter.edit_newsletter'}</a></li>
						{/if}
						{if $aNewsletter.state == 1 || $aNewsletter.state == 0}
							<li><a href="{url link='admincp.newsletter.add' job=$aNewsletter.newsletter_id}" title="{phrase var='newsletter.process_newsletter'}">{phrase var='newsletter.process_newsletter'}</a></li>
						{/if}
						<li><div class="user_delete">
								<a href="{url link='admincp.newsletter.manage' delete={$aNewsletter.newsletter_id}" title="{phrase var='newsletter.delete_newsletter_subject' subject=$aNewsletter.subject|clean}">{phrase var='newsletter.delete_newsletter'}</a>
						</div></li>
					</ul>
				</div>
			</td>
			<td>{$aNewsletter.subject}</td>
			<td>{$aNewsletter|user}</td>
			<td>{$aNewsletter.time_stamp|date:'core.global_update_time'}</td>
			<td>{if $aNewsletter.state == 0} {phrase var='newsletter.not_started'} {elseif $aNewsletter.state == 1} {phrase var='newsletter.already_started'} {else} {phrase var='newsletter.completed'} {/if}</td>
		</tr>
		{foreachelse}
		<tr>
			<td colspan="5">
				{phrase var='newsletter.no_newsletters_to_show'}
			</td>
		</tr>
		{/foreach}
	</table>
</div>