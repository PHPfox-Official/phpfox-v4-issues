<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Friend
 * @version 		$Id: profile.html.php 6041 2013-06-10 18:50:19Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if isset($lists) && !PHPFOX_IS_AJAX}
<div class="row row-transparent">
	<div class="row-20">

		<div class="block">
			<div class="title">Custom Lists</div>
			<div class="block_content section_menu">

				<ul>
				{foreach from=$lists item=list}
					<li><a href="{url link=''$aUser.user_name'.friend' list=$list.list_id}"{if $activeList == $list.list_id} selected{/if}>{$list.name|clean}</a></li>
				{/foreach}
				</ul>
			</div>
		</div>

		<a href="#" class="manage_friends_link">Manage Friends</a>

		<script>
			var listName = 'selected_friends_{$activeList}';
			{literal}
			var selectedFriends = sessionStorage.getItem(listName);
			var checkSelectedTotals = function() {
				if (selectedFriends === null) {
					return;
				}

				var total = 0;
				for (var i in selectedFriends) {
					total++;
				}

				if (total) {
					$('.friends_info_message').show();
				}
				else {
					$('.friends_info_message').hide();
				}
			};
			var changeList = function(t) {
				t = $(t);
				$.ajax({
					url: t.data('url'),
					type: 'POST',
					data: t.serialize() + '&users=' + JSON.stringify(selectedFriends) + '&active_list=' + t.data('active-list'),
					success: function(e) {
						selectedFriends = {};
						sessionStorage.removeItem(listName);
						$('.list_manager').removeClass('active');
					}
				});
			};
			var editFriend = function(t) {
				m = $(t).parents('span:first').find('.list_manager_trigger');

				if (selectedFriends === null) {
					selectedFriends = {};
				}
				else {
					if (typeof(selectedFriends) == 'string') {
						selectedFriends = $.parseJSON(selectedFriends);
					}
				}

				var id = m.data('friend-id');
				if (isset(selectedFriends[id])) {
					delete selectedFriends[id];
				}
				else {
					selectedFriends[id] = true;
				}

				sessionStorage.setItem(listName, JSON.stringify(selectedFriends));
				$(t).toggleClass('active');

				checkSelectedTotals();

				return false;
			};

			$Ready(function() {
				if (selectedFriends !== null && typeof(selectedFriends) == 'string') {
					selectedFriends = $.parseJSON(selectedFriends);
				}

				// checkSelectedTotals();

				$('.manage_friends_link').click(function() {
					var t = $(this);

					if (t.hasClass('active')) {
						t.removeClass('active');
						$('.list_manager').hide();
						$('.friends_info_message').hide();

						return false;
					}
					t.addClass('active');
					$('.list_manager').show();
					// checkSelectedTotals();
					$('.friends_info_message').show();

					return false;
				});

				$('.list_manager_trigger:not(.built)').each(function() {
					var t = $(this), item = t.parent().find('.user_rows:first'), active = '';

					if (selectedFriends !== null && isset(selectedFriends[t.data('friend-id')])) {
						active = ' active';
					}

					t.addClass('built');
					item.prepend('<a style="display:none;" href="#" class="list_manager' + active + '" onclick="return editFriend(this);"><i class="fa fa-plus-circle"></i></a>');
				});
			});
			{/literal}
		</script>
	</div>
	<div class="row-80">

		<div class="friends_info_message margin-bottom-20" style="display:none;">
			<select name="list_id" onchange="changeList(this);" data-url="{url link='friend'}" data-active-list="{$activeList}">
				<option value="">With Selected:</option>
				<optgroup label="Move to...">
					{foreach from=$lists item=list}
					<option value="{$list.list_id}">{$list.name|clean}</option>
					{/foreach}
				</optgroup>
				{if $activeList}
				<optgroup label="Or...">
					<option value="remove_from_list">Remove this list</option>
				</optgroup>
				{/if}
			</select>
		</div>
{/if}

{if count($aFriends)}
	{foreach from=$aFriends name=friend item=aUser}
		{if isset($lists)}
		<span>
			<span class="list_manager_trigger" data-friend-id="{$aUser.user_id}"></span>
		{/if}
		{template file='user.block.rows'}
		{if isset($lists)}
		</span>
		{/if}
	{/foreach}
	{pager}
{else}

	{if isset($lists)}
	<div class="extra_info">
		No friends found here.
	</div>
	{else}
	<div class="extra_info">
		No friends have been added yet.
	</div>
	{/if}

{/if}
{if isset($lists) && !PHPFOX_IS_AJAX}
	</div>
</div>
{/if}