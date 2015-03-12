<label for="js_category{$aItem.category_id}" id="js_category_label{$aItem.category_id}">
	{if (($aItem.user_id == Phpfox::getUserId() && Phpfox::getUserParam('blog.can_delete_own_blog_category')) || Phpfox::getUserParam('blog.can_delete_other_blog_category')) && $aItem.user_id != 0}
	<span class="go_left" style="width:90%;">
		<input value="{$aItem.category_id}" type="checkbox" name="val[category][]" id="js_category{$aItem.category_id}" class="checkbox v_middle" onclick="if (this.checked) $('#js_selected_categories').val($('#js_selected_categories').val() + this.value + ','); else $('#js_selected_categories').val($('#js_selected_categories').val().replace(this.value + ',', ''));" /> {$aItem.name|convert|clean}
	</span>
	<span>
		<a href="#" onclick="if (confirm(getPhrase('core.are_you_sure'))) $.ajaxCall('blog.deleteCategory', 'id={$aItem.category_id}'); return false;">{img theme='misc/delete.gif' alt='' class='delete_hover v_middle'}</a>
	</span>
	<div class="clear"></div>
	{else}
	<input value="{$aItem.category_id}" type="checkbox" name="val[category][]" id="js_category{$aItem.category_id}" class="checkbox v_middle" onclick="if (this.checked) $('#js_selected_categories').val($('#js_selected_categories').val() + this.value + ','); else $('#js_selected_categories').val($('#js_selected_categories').val().replace(this.value + ',', ''));" /> {$aItem.name|convert|clean}
	{/if}
</label>
<script type="text/javascript">
	$Behavior.loadBlogSelectCategories{$aItem.category_id} = function(){l}
	var aSelected = $('#js_selected_categories').val().split(',');
	for (var i in aSelected)
	{l}
	if (aSelected[i] == {$aItem.category_id})
	{l}
	$('#js_category{$aItem.category_id}').attr('checked', 'checked');
	{r}
	{r}
	{r}
</script>