<div class="admincp_manager">
	<div class="am_top">
		<ul>
			<li><a href="#" class="no_ajax">Design</a></li>
			<li><a href="#" data-url="{url link='admincp.theme.manage' id=$theme.theme_id load='html'}" class="ajax">HTML</a></li>
			<li><a href="#" data-url="{url link='admincp.theme.manage' id=$theme.theme_id load='javascript'}" class="ajax">JavaScript</a></li>
			<li class="separator">CSS</li>
			<li><a href="#" data-url="{url link='admincp.theme.manage' id=$theme.theme_id load='css'}" class="ajax">Default</a></li>
		</ul>
	</div>
	<div class="am_content">
		<div class="admincp_design">
			test
		</div>
		<div class="ace_editor" data-ace-mode="html" data-ace-save="{url link='admincp.theme.manage' id=$theme.theme_id load='html'}" style="display:none;"></div>
	</div>
</div>
{literal}
<script>
	$Ready(function() {
		$('.am_top a').click(function() {
			if ($(this).hasClass('ajax')) {
				$('.admincp_design').hide();
				$('.ace_editor').show();
			}
			else {
				$('.admincp_design').show();
				$('.ace_editor').hide();
			}

			return false;
		});
	});
</script>
{/literal}