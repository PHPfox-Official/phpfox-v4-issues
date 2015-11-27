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
{if Phpfox::isUser()}
<nav class="notifications">
	<ul>
		<li class="_panel_search">
			<a href="#" class="_panel" data-open="{url link='search.panel'}">
				<i class="fa fa-search"></i>
				Search
			</a>
		</li>
		<li>
			<a href="#" class="_panel" data-open="{url link='friend.panel'}">
				<i class="fa fa-user-plus"></i>
				Requests
				<span id="js_total_new_friend_requests"></span>
			</a>
		</li>
		<li>
			<a href="#" class="_panel" data-open="{url link='notification.panel'}">
				<i class="fa fa-bell"></i>
				Notifications
				<span id="js_total_new_notifications"></span>
			</a>
		</li>
		<li>
			<a href="#" class="_panel" data-open="{url link='mail.panel'}">
				<i class="fa fa-envelope"></i>
				Messages
				<span id="js_total_new_messages"></span>
			</a>
		</li>
	</ul>
</nav>
{else}
<div class="guest_login">
	{module name='user.login-block'}
</div>
{/if}