{if $uninstall}
	<div class="error_message">
		To continue with uninstalling, please enter your Admin Login Details.
	</div>
	<form method="post" action="{url link='current'}" class="ajax_post">
		<div class="table">
			<div class="table_left">
				Email:
			</div>
			<div class="table_right">
				<input type="text" name="val[email]">
			</div>
		</div>
		<div class="table">
			<div class="table_left">
				Password:
			</div>
			<div class="table_right">
				<input type="password" name="val[password]">
			</div>
		</div>
		<div class="table_clear">
			<input type="submit" class="button" value="Submit">
		</div>
	</form>
{else}
	<div id="app-content-holder">
		{if $customContent}
		<div id="custom-app-content"><i class="fa fa-circle-o-notch fa-spin"></i></div>
		<script>
			var customContent = '{url link=$customContent}', contentIsLoaded = false;
		{literal}
			$Ready(function() {
				if (contentIsLoaded) {
					return;
				}

				contentIsLoaded = true;
				$.ajax({
					url: customContent,
					contentType: 'application/json',
					success: function(e) {
						$('#custom-app-content').html(e.content);
						$Core.loadInit();
					}
				});
			});
		{/literal}
		</script>
		{/if}

		{if isset($settings) && $settings}
		<section class="app_grouping">
			<h1>App Settings</h1>
			<form class="on_change_submit" method="post" action="{url link='current'}">
				{foreach from=$settings item=setting key=var}
				<div class="table_header2 settings">
					{$setting.info}
				</div>
				<div class="table3 settings">
					<div class="row_right">
						{if $setting.type == 'input:text'}
						<input type="text" name="setting[{$var}]" value="{$setting.value|clean}">
						{elseif $setting.type == 'input:radio'}
						<div class="item_is_active_holder">
							<span class="js_item_active item_is_active">
								<input type="radio"{if $setting.value == 1} checked="checked"{/if} name="setting[{$var}]" value="1"> Yes
							</span>
							<span class="js_item_active item_is_not_active">
								<input type="radio"{if $setting.value != 1} checked="checked"{/if} name="setting[{$var}]" value="0"> No
							</span>
						</div>
						{/if}
					</div>
				</div>
				{/foreach}
			</form>
		</section>
		{/if}

		{if isset($userGroupSettings) && $userGroupSettings}
		<section class="app_grouping">
			<form class="on_change_submit" method="post" action="{url link='current'}">
				<h1>User Group Settings</h1>
				{foreach from=$userGroupSettings item=group key=var}
					<div class="user_group_rows">
						<div class="_title">
							{$group.name}
						</div>
						<div class="_settings">
							{foreach from=$group.settings item=setting key=var}
							<div class="table_header2 ">
								{$setting.info}
							</div>
							<div class="table3 settings">
								<div class="row_right">
									{if $setting.type == 'input:text'}
									<input type="text" name="user_group_setting[{$group.id}][{$var}]" value="{$setting.value|clean}">
									{elseif $setting.type == 'input:radio'}
									<div class="item_is_active_holder">
									<span class="js_item_active item_is_active">
										<input type="radio"{if $setting.value == 1} checked="checked"{/if} name="user_group_setting[{$group.id}][{$var}]" value="1"> Yes
									</span>
									<span class="js_item_active item_is_not_active">
										<input type="radio"{if $setting.value != 1} checked="checked"{/if} name="user_group_setting[{$group.id}][{$var}]" value="0"> No
									</span>
									</div>
									{/if}
								</div>
							</div>
							{/foreach}
						</div>
					</div>
				{/foreach}
			</form>
		</section>
		{/if}
	</div>
	<div id="app-details">
		<ul>
			<li><a href="{$uninstallUrl}">Uninstall</a></li>
		</ul>

		<div class="app-copyright">
			{if $ActiveApp.vendor}
			©{$ActiveApp.vendor}
			{/if}
			{if $ActiveApp.credits}
			<div class="app-credits">
				<div>Credits</div>
				{foreach from=$ActiveApp.credits item=url key=name}
				<ul>
					<li><a href="{$url}">{$name|clean}</a></li>
				</ul>
				{/foreach}
			</div>
			{/if}
		</div>
	</div>
{/if}