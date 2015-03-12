<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 3335 2011-10-20 17:26:57Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="error_message" id="js_friend_list_add_error" style="display:none;"></div>
<form method="post" action="#" onsubmit="$Core.processForm('#js_friend_list_add_submit'); $(this).ajaxCall('friend.addList'); return false;">
	<input type="text" name="name" value="" size="40" /> 
	<div class="extra_info">
		{phrase var='friend.enter_the_name_of_your_custom_friends_list'}
	</div>
	<div class="p_top_4" id="js_friend_list_add_submit">
		<ul class="table_clear_button">
			<li><input type="submit" value="{phrase var='friend.submit'}" class="button" /></li>
			<li class="table_clear_ajax"></li>
		</ul>
		<div class="clear"></div>
	</div>
</form>
