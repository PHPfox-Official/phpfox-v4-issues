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
<nav class="notifications">
	<ul>
		<li>
			<a href="#" class="_search">
				<i class="fa fa-search"></i>
				Search
			</a>
			<form method="post" id='header_search_form' action="{url link='search'}">
				<input type="text" name="q" placeholder="{phrase var='core.search_dot'}" id="header_sub_menu_search_input" autocomplete="off" class="js_temp_friend_search_input" />
			</form>
		</li>
		<li>
			<a href="#">
				<i class="fa fa-bell"></i>
				Notifications
			</a>
		</li>
		<li>
			<a href="#">
				<i class="fa fa-envelope"></i>
				Messages
			</a>
		</li>
	</ul>
</nav>
{*
<ul>
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
*}