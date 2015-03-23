<?php 
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox
 * @version 		$Id: index.html.php 3830 2011-12-19 12:55:57Z Miguel_Espinoza $
 */

defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="announcements_holder">
	{if is_array($aAnnouncements) && empty($aAnnouncements)}
	<div class="extra_info">
		{phrase var='announcement.that_announcement_cannot_be_found'}
	</div>
	{elseif $aAnnouncements === false}
	<div class="extra_info">
		{phrase var='announcement.no_announcements_have_been_added'}
	</div>
	{else}
		{foreach from=$aAnnouncements item=aAnnouncement name=announcement}		
			<div class="js_announcement_{$aAnnouncement.announcement_id} {if is_int($phpfox.iteration.announcement/2)}row1{else}row2{/if}{if $phpfox.iteration.announcement == 1} row_first{/if}">
				<div class="js_announcement_{$aAnnouncement.announcement_id}_subject h3" style="font-size:12pt; font-weight:bold;">
					{if !empty($aAnnouncement.content_var) && !isset($aAnnouncement.is_specific)}
						<a href="{url link='announcement.view' id=$aAnnouncement.announcement_id}">
							{phrase var=$aAnnouncement.subject_var}
						</a>
					{/if}
					<div class="announcement_{$aAnnouncement.announcement_id}_date extra_info" style="font-size: 9pt; font-weight:normal;">
						{$aAnnouncement.posted_on}
					</div>
				</div>
				<div class="js_announcement_{$aAnnouncement.announcement_id}_content" style="">					
					{if count($aAnnouncements) > 1}
						{phrase var=$aAnnouncement.intro_var}						
					{else}
						{phrase var=$aAnnouncement.content_var}
					{/if}
					
					
					{*
					*}
				</div>
			</div>
			<div class="clear"></div>
		{/foreach}
	{/if}
</div>