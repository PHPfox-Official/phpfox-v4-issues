<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: request.html.php 1129 2009-10-03 12:42:56Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="main_break"></div>
{phrase var='friend.in_order_to_view_this_item_posted_by_user_link_you_need_to_be_on_their_friends_list' user=$aUser}
<ul class="action">
	<li><a href="#?call=friend.request&amp;user_id={$aUser.user_id}&amp;width=420&amp;height=250" class="inlinePopup" title="Add to Friends">{phrase var='friend.send_a_friends_request_to_full_name' full_name=$aUser.full_name}</a></li>
</ul>