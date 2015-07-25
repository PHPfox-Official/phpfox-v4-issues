<span class="user_block_toggle"><i class="fa"></i></span>
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
			<div>
				<a href="{url link='user.setting'}"><i class="fa fa-cog"></i>Account Settings</a>
				<a href="{url link='user.profile'}"><i class="fa fa-edit"></i>Edit Profile</a>
				<a href="{url link='friend'}"><i class="fa fa-group"></i>Manage Friends</a>
				<a href="{url link='user.privacy'}"><i class="fa fa-shield"></i>Privacy Settings</a>
				<a href="{url link='user.logout'}" class="no_ajax logout"><i class="fa fa-toggle-off"></i>Logout</a>
			</div>
		</div>
		{/if}
		<a href="#" class="_panel _load_is_feed" data-open="{url link='feed.form'}" data-class="is_feed">What's up?</a>

	</div>
</div>