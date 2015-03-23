<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Bulletin
 * @version 		$Id: entry.html.php 2298 2011-02-07 15:41:02Z Miguel_Espinoza $
 */

defined('PHPFOX') or exit('NO DICE!');

?>
<div id="bulletin_header_{$aBulletin.bulletin_id}"></div>
<div id="bulletin_{$aBulletin.bulletin_id}" class="{if is_int($phpfox.iteration.bulletin/2)}row1{else}row2{/if}{if $phpfox.iteration.bulletin == 1} row_first{/if}{if $aBulletin.view_id == '1'} row_moderate{/if}">
	<div class="row_title">
		<div class="row_title_image">
			{img user=$aBulletin suffix='_50_square' max_width=50 max_height=50}
		</div>
		<div class="row_title_info">
			<a href="{url link='bulletin.view' id={$aBulletin.bulletin_id}" class="link">{$aBulletin.title|clean}</a>
			{if $aBulletin.total_attachment > 0}
				<a href="{url link='bulletin.view' id={$aBulletin.bulletin_id}#attachment" title="{phrase var='bulletin.view_attachments_total_count' total_count=$aBulletin.total_attachment}">{img theme='misc/attach.png' alt='Attachments' class='v_middle'}</a>
			{/if}			
			<div class="extra_info">
				{$aBulletin.posted_on}
			</div>
		</div>	
	</div>
	{if !isset($bNoExtraLinks)}
	<div id="delete_and_edit_{$aBulletin.bulletin_id}" class="t_right">
		<ul class="item_menu">
			{if $aBulletin.view_id == '1' && Phpfox::getUserParam('bulletin.can_approve_bulletins')}
			<li><a href="#" onclick="$.ajaxCall('bulletin.approve', 'bulletin_id={$aBulletin.bulletin_id}'); $('#bulletin_{$aBulletin.bulletin_id}').removeClass('row_moderate'); $(this).parent().remove(); return false;">{phrase var='bulletin.approve'}</a></li>
			{/if}
			{if Phpfox::isModule('report')}
				{if $aBulletin.user_id != Phpfox::getUserId()}<li><a href="#?call=report.add&amp;height=210&amp;width=400&amp;type=bulletin&amp;id={$aBulletin.bulletin_id}" class="inlinePopup" title="{phrase var='bulletin.report_a_bulletin'}">{phrase var='bulletin.report'}</a></li>{/if}
			{/if}		
			{if ((Phpfox::getUserParam('bulletin.bulletin_edit_own') && Phpfox::getUserId() == $aBulletin.user_id) || 
				Phpfox::getUserParam('bulletin.bulletin_can_edit_others'))}
				<li><a href="{url link='bulletin.add' id={$aBulletin.bulletin_id}">{phrase var='bulletin.edit'}</a></li>
			{/if}		
			{if ((Phpfox::getUserParam('bulletin.bulletin_can_delete_own') && Phpfox::getUserId() == $aBulletin.user_id) || Phpfox::getUserParam('bulletin.bulletin_can_delete_others'))}	
				<li><a href="{url link='bulletin' delete=$aBulletin.bulletin_id}" onclick="if (confirm(getPhrase('core.are_you_sure'))){literal}{return true;}else{return false;}{/literal}">{phrase var='bulletin.delete'}</a></li>
			{/if}
			{if $aBulletin.total_comment > 0 && Phpfox::isModule('comment') && Phpfox::getParam('bulletin.can_post_comments_on_bulletin')}
			<li><a href="{url link='bulletin.view' id=$aBulletin.bulletin_id}#comment" title="{phrase var='bulletin.view_comments'}">{phrase var='bulletin.comment_total' total=$aBulletin.total_comment}</a></li>
			{/if}
		</ul>
	</div>
	{/if}
</div>