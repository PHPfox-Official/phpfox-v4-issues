<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: redirect.html.php 1388 2010-01-11 20:17:18Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{phrase var='admincp.you_are_about_to_leave_our_site_to_visit' link=$sRedirectLink}
<ul class="action">
	<li><a href="{$sRedirectLink}">{phrase var='admincp.click_here_to_continue'}</a></li>
</ul>
{phrase var='admincp.note_we_are_in_no_way_affiliated' link=$sRedirectLink}