<div class="user_block">
	<div class="content">
		<div class="feed_form_user">
			{img user=$aGlobalUser suffix='_50_square'}
			<div class="feed_form_user_info">
				{$aGlobalUser|user}
				<div>
					<a href="{url link='profile'}">View Profile</a>
				</div>
				<span class="feed_form_toggle"><i class="fa fa-toggle-down"></i></span>
			</div>
		</div>

		{if $bShowMenu}
		<div class="feed_form_menu">
			<a href="{url link='user.account'}">Account Settings</a>
			<a href="{url link='user.profile'}">Edit Profile</a>
			<a href="{url link='user.privacy'}">Privacy</a>
			<a href="{url link='user.logout'}" class="no_ajax logout">Logout</a>
		</div>
		{/if}

		<form class="feed_form" method="post" action="{url link='feed.stream'}">
			<div><input type="hidden" name="val[module_id]" value="user_status" class="feed_form_module_id" /></div>
			<div class="feed_form_textarea">
				<textarea name="val[content]" placeholder="What's up?"></textarea>
			</div>
			<div class="feed_form_actions">
				<a href="#" class="feed_form_share">Share</a>
			</div>
		</form>
	</div>
</div>