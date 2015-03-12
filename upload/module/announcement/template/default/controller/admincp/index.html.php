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
 * @package  		Module_Announcement
 * @version 		$Id: index.html.php 979 2009-09-14 14:05:38Z Raymond_Benc $
 */
?>
{if count($aAnnouncements)}
<div class="table_header">
	{phrase var='announcement.announcements'}	
</div>
<div id="js_announcements">
	{module name='announcement.manage' sLanguage=$sDefaultLanguage}
</div>
{else}
<div class="extra_info">
	{phrase var='announcement.no_announcements_have_been_created'}
	<ul class="action">
		<li><a href="{url link='admincp.announcement.add'}">{phrase var='announcement.create_a_new_announcement'}</a></li>
	</ul>
</div>
{/if}