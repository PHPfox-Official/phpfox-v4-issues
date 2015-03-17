<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: template-notification.html.php 2838 2011-08-16 19:09:21Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<ul>
	<li>
		<a rel="_show" class="friend_notification notify_drop_link" href="#">{$aGlobalUser.full_name|clean}</a>
		<div class="holder_notify_drop">
			<div class="holder_notify_drop_content">
				{* <div class="holder_notify_drop_title">Friend Requests</div> *}
				<div class="holder_notify_drop_data feed_form_drop">
					{module name='feed.form2' menu=true}
				</div>
			</div>
		</div>
	</li>
	{if Phpfox::getUserBy('profile_page_id') <= 0}
	{if Phpfox::isModule('friend')}
	{module name='friend.notify'}
	{/if}
	{if Phpfox::isModule('mail')}
	{module name='mail.notify'}
	{/if}
	{/if}
	{if Phpfox::isModule('notification')}
	{module name='notification.notify'}
	{/if}
</ul>