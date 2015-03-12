<div class="table">
	<div class="table_left">
		{phrase var='tag.topics'}:
	</div>
	<div class="table_right">
		<input type="text" name="val{if $iItemId}[{$iItemId}]{/if}[tag_list]" value="{value type='input' id='tag_list'}" size="30" />
		<div class="extra_info">
			{phrase var='tag.separate_multiple_topics_with_commas'}
		</div>
	</div>
	<div class="clear"></div>
</div>