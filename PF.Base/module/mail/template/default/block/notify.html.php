<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: notify.html.php 3761 2011-12-12 12:43:35Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<li>
	<span class="holder_notify_count" id="js_total_new_messages">0</span>
	<a href="#" title="{phrase var='mail.messages_notify'}" class="message notify_drop_link" rel="mail.getLatest">{phrase var='mail.messages_notify'}</a>
	<div class="holder_notify_drop">
		<div class="holder_notify_drop_content">
			<div class="holder_notify_drop_title">
				{if Phpfox::isModule('friend')}
				<div class="holder_notify_drop_title_link">
					<a href="#" onclick="$Core.composeMessage(); return false;">{phrase var='mail.send_a_new_message'}</a>
				</div>
				{/if}
				{phrase var='mail.messages_notify'}			
			</div>
			<div class="holder_notify_drop_data">
				<div class="holder_notify_drop_loader">{img theme='ajax/add.gif'}</div>													
			</div>
		</div>											
	</div>
</li>