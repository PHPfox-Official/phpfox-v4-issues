<span class="user_block_toggle"><i class="fa"></i></span>
<div class="user_block">
	<div class="content">
		<div class="feed_form_user">
			{img user=$aGlobalUser suffix='_50_square'}
			<div class="feed_form_user_info">
				{$aGlobalUser|user}
				<div>
					<a href="{url link='profile'}">{phrase var='feed.view_profile'}</a>
				</div>
				<span class="feed_form_toggle"><i class="fa fa-toggle-down"></i></span>
			</div>
		</div>

		{if $bShowMenu}
		<div class="feed_form_menu">
			<div>
				<a href="{url link='user.setting'}"><i class="fa fa-cog"></i>{phrase var='feed.account_settings'}</a>
				<a href="{url link='user.profile'}"><i class="fa fa-edit"></i>{phrase var='feed.edit_profile'}</a>
				<a href="{url link='friend'}"><i class="fa fa-group"></i>{phrase var='feed.manage_friends'}</a>
				<a href="{url link='user.privacy'}"><i class="fa fa-shield"></i>{phrase var='feed.privacy_settings'}</a>
				<a href="{url link='user.logout'}" class="no_ajax logout"><i class="fa fa-toggle-off"></i>{phrase var='feed.logout'}</a>
			</div>
		</div>
		{/if}
		<a href="#" class="_panel _load_is_feed" data-open="{url link='feed.form'}" data-class="is_feed">{phrase var='feed.what_s_up'}</a>

	</div>
</div>