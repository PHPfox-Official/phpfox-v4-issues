<form method="post" id='header_search_form' action="{url link='search'}">
	<input type="text" name="q" placeholder="{phrase var='core.search_dot'}" id="header_sub_menu_search_input" autocomplete="off" class="js_temp_friend_search_input" />
</form>
{literal}
<script>
	$Ready(function() {
		if ($('#header_sub_menu_search_input').length) {
			$('#header_sub_menu_search_input').focus();
		}
	});
</script>
{/literal}