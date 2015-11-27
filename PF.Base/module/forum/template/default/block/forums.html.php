
{template file='forum.block.entry'}

{if isset($aThreads) && isset($bIsSearch) && count($aThreads) && !$bIsSearch}
<div class="forum_header_menu">

	{if Phpfox::isUser()}
	<div class="block">
		<div class="title">{phrase var='forum.forum_tools'}</div>
		<div class="content">
			<ul>
				{if $aCallback === null}
				<li><a href="{url link='forum.read' forum=$aForumData.forum_id}">{phrase var='forum.mark_this_forum_read'}</a></li>
				{else}
				<li><a href="{url link='forum.read' module=$aCallback.module_id item=$aCallback.item_id}">{phrase var='forum.mark_this_forum_read'}</a></li>
				{/if}
			</ul>
		</div>
	</div>
	{/if}

	<div class="block">
		<div class="title">{phrase var='forum.search_this_forum'}</div>
		<div class="content">
			<form method="post" action="{if $aCallback !== null}{url link='forum.search' module=$aCallback.module_id item=$aCallback.item_id}{else}{url link='forum.search'}{/if}">
				{if $aCallback === null}
				<div><input type="hidden" name="search[forum][]" value="{$aForumData.forum_id}" /></div>
				{else}
				<div><input type="hidden" name="search[item_id]" value="{$aCallback.item_id}" /></div>
				{/if}
				<div class="div_menu">
					<input type="text" name="search[keyword]" value="" class="v_middle" />
				</div>
				<div class="div_menu">
					<label><input type="radio" name="search[result]" value="0" class="v_middle checkbox" checked="checked" /> {phrase var='forum.show_threads'}</label>
					<label><input type="radio" name="search[result]" value="1" class="v_middle checkbox" /> {phrase var='forum.show_posts'}</label>
				</div>
			</form>
			<ul>
				{if $aCallback === null}
				<li><a href="{url link='forum.search' id=$aForumData.forum_id}">{phrase var='forum.advanced_search'}</a></li>
				{else}
				<li><a href="{url link='forum.search' module=$aCallback.module_id item=$aCallback.item_id}">{phrase var='forum.advanced_search'}</a></li>
				{/if}
			</ul>
		</div>
	</div>
	<div>
		<a href="{if $aCallback === null}{url link='forum.rss' forum=$aForumData.forum_id}{else}{url link='forum.rss' pages=$aCallback.item_id}{/if}" title="{phrase var='forum.subscribe_to_this_forum'}" class="no_ajax_link">
			{img theme='rss/tiny.png' class='v_middle'}
		</a>
	</div>
</div>
{/if}