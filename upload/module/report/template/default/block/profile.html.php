<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: profile.html.php 5077 2012-12-13 09:05:45Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if Phpfox::isModule('report')}
{if $aUser.user_id != Phpfox::getUserId() || isset($bShowRssFeedForUser)}
<div class="pages_view_sub_menu">
	<ul>
		{if $aUser.user_id != Phpfox::getUserId()}<li><a href="#?call=report.add&amp;height=220&amp;width=400&amp;type=user&amp;id={$aUser.user_id}" class="inlinePopup" title="{phrase var='report.report_this_user'}">{phrase var='report.report_this_user'}</a></li>{/if}
		{if isset($bShowRssFeedForUser)}
		<li><a href="{url link=''$aUser.user_name'.rss'}" class="no_ajax_link">{phrase var='rss.subscribe_via_rss'}</a></li>
		{/if}
	</ul>
</div>
{/if}
{/if}