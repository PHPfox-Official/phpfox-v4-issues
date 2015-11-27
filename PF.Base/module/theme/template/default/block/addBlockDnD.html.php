<?php

defined('PHPFOX') or exit('No dice!');
?>
<div class="extra_info">
	{phrase var='theme.select_a_block_below_and_then_drag_it_to_any_of_the_available_positions'}
</div>
<div style="height:300px;" class="label_flow js_sortable_empty">
	{foreach from=$aModules key=sModule item=aModule}
	<div class="js_module_block_parent">
		<div class="module dnd_move_module" onclick="if (!$(this).hasClass('dnd_move_module_active')) {l}$(this).addClass('dnd_move_module_active'); $(this).parent().find('.dnd_move_component:first').slideDown('fast'); {r} else {l} $(this).removeClass('dnd_move_module_active'); $(this).parent().find('.dnd_move_component:first').slideUp('fast'); {r}">
			{$sModule}
		</div>
		<div id="{$sModule}_component" class="dnd_move_component">
			{foreach from=$aModule item=sComponent}
				<div class="js_can_move_blocks">
					<div class="component js_sortable do_not_count"  id="new_js_block_border_{$sModule}_{$sComponent}">
						<div class="js_sortable_header">
							{$sComponent}
						</div>
					</div>
				</div>
			{/foreach}
		</div>
	</div>
	{/foreach}
</div>

<script type="text/javascript">
	$Core.loadInit();
</script>