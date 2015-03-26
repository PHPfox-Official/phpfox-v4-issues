<div class="admincp_manager">
	<div class="am_top">
		<a href="{url link='admincp.theme'}" class="title">
			{$theme.name|clean}
		</a>
		<ul>
			<li><a href="#" class="no_ajax active">Design</a></li>
			<li><a href="#" data-url="{url link='admincp.theme.manage' id=$theme.theme_id load='html'}" class="ajax">HTML</a></li>
			<li><a href="#" data-url="{url link='admincp.theme.manage' id=$theme.theme_id load='javascript'}" class="ajax">JavaScript</a></li>
			<li><a href="#" data-url="{url link='admincp.theme.manage' id=$theme.theme_id load='css'}" class="ajax">CSS</a></li>
		</ul>
	</div>
	<div class="am_content">
		<div class="admincp_design_info">
			<div>
				<div><a href="{url link='admincp.theme.flavor' theme=$theme.theme_id}" class="popup">New Flavor</a></div>
				<select name="flavors" class="goJump">
					<option value="">Flavor:</option>
				{foreach from=$flavors item=flavor}
					<option value="{url link='admincp.theme.manage' id=$theme.theme_id flavor=$flavor.style_id}"{if $flavor.is_selected} selected="selected"{/if}>{$flavor.name}</option>
				{/foreach}
				</select>
			</div>
			<div class="theme_actions">
				<ul>
					<li><a href="{url link='admincp.theme.manage' id=$theme.theme_id default=$theme.flavor_id}" class="ajax">Set as default</a></li>
					<li><a href="{url link='admincp.theme.manage' id=$theme.theme_id export=1}" target="_blank">Export theme</a></li>
				</ul>
			</div>
		</div>
		<div class="admincp_design">
			<div class="p_10">
				<form method="post" action="{url link='admincp.theme.manage' id=$theme.theme_id}">
				{foreach from=$design item=info}
					{if is_array($info)}
					<div class="table">
						<div class="table_left">
							{$info.title}
						</div>
						<div class="table_right">
							{$info.type}
						</div>
					</div>
					{else}
					<div class="table_header">
						{$info}
					</div>
					{/if}
				{/foreach}
				</form>
			</div>
		</div>
	</div>
	<div class="ace_editor_loader">
		<div class="ace_editor" data-ace-mode="html" data-ace-save="{url link='admincp.theme.manage' id=$theme.theme_id load='html'}"></div>
	</div>
</div>
{literal}
<script>
	$Ready(function() {
		$('._colorpicker:not(.built').each(function() {
			var t = $(this),
				h = t.parent().find('._colorpicker_holder');

			t.addClass('built');
			h.css('background-color', t.val());

			h.colpick({
				layout: 'hex',
				submit: false,
				onChange: function(hsb,hex,rgb,el,bySetColor) {
					t.val('#' + hex);
					h.css('background-color', '#' + hex);
				},
				onHide: function() {
					t.trigger('change');
				}
			});
		});

		$('.admincp_design input').change(function() {
			var t = $(this);
			$.ajax({
				url: t.parents('form:first').attr('action'),
				type: 'POST',
				data: '' + t.attr('name') + '=' + encodeURIComponent(t.val()),
				success: function(e) {
					// p(e);
				}
			});
		});

		$('.am_top > ul a').click(function() {
			var t = $(this);

			$('.am_top a.active').removeClass('active');
			t.addClass('active');
			if (t.hasClass('ajax')) {
				$('.admincp_design_info, .admincp_design').hide();
				$('.ace_editor_loader').show();
			}
			else {
				$('.admincp_design_info, .admincp_design').show();
				$('.ace_editor_loader').hide();
			}

			return false;
		});
	});
</script>
{/literal}