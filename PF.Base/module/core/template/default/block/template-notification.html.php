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
		<li>
			<a href="#" class="_panel" data-open="{url link='search.panel'}">
				<i class="fa fa-search"></i>
				Search
			</a>
			{*
			<form method="post" id='header_search_form' action="{url link='search'}">
				<input type="text" name="q" placeholder="{phrase var='core.search_dot'}" id="header_sub_menu_search_input" autocomplete="off" class="js_temp_friend_search_input" />
			</form>
			*}
		</li>
		<li>
			<a href="#" class="_panel" data-open="{url link='notification.panel'}">
				<i class="fa fa-bell"></i>
				Notifications
			</a>
		</li>
		<li>
			<a href="#" class="_panel" data-open="{url link='mail.panel'}">
				<i class="fa fa-envelope"></i>
				Messages
			</a>
		</li>
	</ul>
</nav>
{else}
<div class="guest_login">
	{module name='user.login-block'}
</div>
{/if}