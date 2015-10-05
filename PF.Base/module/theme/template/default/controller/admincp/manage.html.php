{if ($theme.internal_id)}
<div class="phpfox-product" data-internal-id="{$theme.internal_id}" data-version="{$theme.version}"></div>
{/if}
<div class="admincp_manager">
	<div class="am_top">
		<a href="{url link='admincp.theme'}" class="title no_ajax">
			{$theme.name|clean}<span class="am_version">v{$theme.version}</span>
		</a>
		<ul>
			<li><a href="#" class="no_ajax active"><i class="fa fa-cog"></i>Settings</a></li>
			<li><a href="#" data-url="{url link='admincp.theme.manage' id=$theme.theme_id load='html'}" class="ajax"><i class="fa fa-html5"></i>HTML</a></li>
			<li><a href="#" data-url="{url link='admincp.theme.manage' id=$theme.theme_id load='javascript'}" class="ajax"><i class="fa fa-code"></i>JavaScript</a></li>
			<li><a href="#" data-url="{url link='admincp.theme.manage' id=$theme.theme_id load='css'}" class="ajax"><i class="fa fa-css3"></i>CSS</a></li>
		</ul>
	</div>
	<div class="am_content">
		<div class="admincp_design_info">
			<div class="theme_flavors">
				<select name="flavors" class="goJump">
					<option value="">Flavor:</option>
				{foreach from=$flavors item=flavor}
					<option value="{url link='admincp.theme.manage' id=$theme.theme_id flavor=$flavor.style_id}"{if $flavor.is_selected} selected="selected"{/if}>{$flavor.name}</option>
				{/foreach}
				</select>
			</div>
			<div class="theme_actions">
				<ul>
					<li><a href="{url link='admincp.theme.manage' id=$theme.theme_id default=$theme.flavor_id}" class="ajax" data-add-process="true"><i class="fa fa-check"></i>Set as default</a></li>
					<li><a href="{url link='admincp.theme.flavor' theme=$theme.theme_id}" class="popup"><i class="fa fa-diamond"></i>New Flavor</a></li>
					<li><a href="{url link='admincp.theme.manage' id=$theme.theme_id export=1}" target="_blank" class="no_ajax"><i class="fa fa-download"></i>Export theme</a></li>
					<li><a href="{url link='admincp.theme.delete' id=$theme.theme_id sure='yes'}" class="sJsConfirm is_delete"><i class="fa fa-remove"></i>Remove theme</a></li>
					<li><a href="{url link='admincp.theme.manage' id=$theme.theme_id rebuild='yes'}" class="ajax" data-add-process="true"><i class="fa fa-clone"></i>Sync CSS</a></li>
					{if $theme.name == 'Neutron'}
					<li><a href="{url link='admincp.theme.manage' id=$theme.theme_id merge='yes'}" class="ajax" data-add-process="true"><i class="fa fa-rotate-left"></i>Revert theme</a></li>
					{else}
					<li><a href="{url link='admincp.theme.manage' id=$theme.theme_id flavor-delete=$theme.flavor_id}" class="sJsConfirm is_delete"><i class="fa fa-remove"></i> Remove Flavor</a></li>
					{/if}
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

		$('.admincp_design input:not(.ajax_upload)').change(function() {
			var t = $(this);

			$Core.processing();
			$.ajax({
				url: t.parents('form:first').attr('action'),
				type: 'POST',
				data: '' + t.attr('name') + '=' + encodeURIComponent(t.val()),
				success: function(e) {
					// p(e);
					$Core.processingEnd();
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