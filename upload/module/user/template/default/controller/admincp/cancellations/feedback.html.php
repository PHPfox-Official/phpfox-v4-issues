<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_User
 * @version 		$Id: feedback.html.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */

?>
<div class="table_header">{phrase var='user.users'}</div>
<table>
	<tr>
		<th style="width:10px;"></th>
		<th> {phrase var='user.full_name'} </th>
		<th> {phrase var='user.e_mail'} </th>
		<th style="width:100px"> {phrase var='user.user_group'} </th>
		<th style="width:100px;"> {phrase var='user.reasons_given'} </th>
		<th style="width:220px;"> {phrase var='user.feedback_text'} </th>
		<th style="width:90px;"> {phrase var='user.deleted_on'} </th>
	</tr>
	{foreach from=$aFeedbacks item=aFeedback key=iKey name=feedback}
	<tr class="checkRow{if is_int($iKey/2)} tr{/if}" id="js_feedback_{$aFeedback.feedback_id}">
		<td align="t_center">			
				<a href="#" class="js_drop_down_link" title="Manage">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
				<div class="link_menu">
					<ul>
						<li><a href="#" onclick="$.ajaxCall('user.deleteFeedback', 'iFeedback={$aFeedback.feedback_id}')">{phrase var='user.delete_feedback'}</a></li>
					</ul>
				</div>			
		</td>
		<td>
			{$aFeedback.full_name}
		</td>
		<td>
			{$aFeedback.user_email}
		</td>
		<td>
			{$aFeedback.user_group_title}
		</td>
		<td>
			{if isset($aFeedback.reasons)}
			{foreach from=$aFeedback.reasons item=phrase_var}
			{phrase var=$phrase_var} <br>
			{/foreach}
			{/if}
		</td>
		<td>
			{$aFeedback.feedback_text|clean|shorten:'15':'View More':true|split:30}
		</td>
		<td>
			{$aFeedback.time_stamp|date:'core.global_update_time'}
		</td>
	</tr>

	{foreachelse}
	<tr> 
		<td colspan='7'>
			<div class="extra_info" style="text-align:center;">
				{phrase var='user.no_feedback_to_review'}
			</div>
		</td>
	</tr>

	{/foreach}
</table>