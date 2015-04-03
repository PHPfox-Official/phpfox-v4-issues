<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Admincp
 * @version 		$Id: index.html.php 4481 2012-07-06 08:05:15Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.user.group.add'}" onsubmit="$('#js_setting_saved').html($.ajaxProcess('Saving')).show(); $(this).ajaxCall('user.updateSettings'); return false;">
	<div id="content_editor_holder">
		<div id="content_editor_menu">
			<ul>
				{foreach from=$aBlocks key=sUrl item=aModules}
				<li><a href="#" onclick="$.ajaxCall('admincp.getBlocks', 'm_connection={$sUrl}', 'GET'); $(this).blur(); $('#content_editor_menu a').removeClass('cem_active'); $(this).addClass('cem_active'); return false;">{if empty($sUrl)}{phrase var='admincp.site_wide'}{else}{$sUrl}{/if}</a></li>
				{/foreach}
			</ul>
			{literal}
			<script>
				var blockIsDefaulted = false;
				$Ready(function() {
					if (blockIsDefaulted === false) {
						blockIsDefaulted =  true;
						$('#content_editor_menu li a').each(function() {
							var t = $(this);
							if (t.html() == 'core.index-member') {
								t.parent().addClass('cem_active');
								eval(t.attr('onclick').replace('return false;', ''));
							}
						});
					}
				});
			</script>
			{/literal}
		</div>
		<div id="content_editor_text">
			<div id="js_setting_block"></div>
		</div>
	</div>
</form>