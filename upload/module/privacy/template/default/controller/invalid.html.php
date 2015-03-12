<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Privacy
 * @version 		$Id: invalid.html.php 3661 2011-12-05 15:42:26Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="message">
	{phrase var='privacy.the_item_or_section_you_are_trying_to_view_has_specific_privacy_settings_enabled_and_cannot_be_viewed_at_this_time'}
</div>
<ul>
	<li><a href="#" onclick="history.back(); return false;">{phrase var='privacy.go_back'}</a></li>
	<li><a href="{url link=''}">{phrase var='privacy.go_to_our_homepage'}</a></li>
</ul>