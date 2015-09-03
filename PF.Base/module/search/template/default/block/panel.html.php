<form method="get" id='header_search_form' action="{url link='search'}">
	<input type="text" name="q" placeholder="{phrase var='core.search_dot'}" id="header_sub_menu_search_input" autocomplete="off" class="js_temp_friend_search_input" />
</form>
{if Phpfox::isUser()}
{literal}
<script>
	$Ready(function() {
		if ($('#header_sub_menu_search_input').length) {
			$('#header_sub_menu_search_input').each(function() {
				var t = $(this);
				if (t.parents('#panel:first').length && !t.hasClass('in_focus')) {
					t.addClass('in_focus');
					t.focus();
				}
				$Core.searchFriendsInput.init({
					'id': 'header_sub_menu_search',
					'max_search': (getParam('bJsIsMobile') ? 5 : 10),
					'no_build': true,
					'global_search': true,
					'allow_custom': true,
					'panel_mode': true
				});
				$Core.searchFriendsInput.buildFriends(this);
			});
		}
	});
</script>
{/literal}
{/if}