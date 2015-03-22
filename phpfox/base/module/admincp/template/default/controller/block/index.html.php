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
<a href="#" onclick="$.ajaxCall('core.designdnd', 'enable=1'); return false;" id="admincp_enabled_dnd">{phrase var='admincp.enable_dnd_mode'}</a>
<form method="post" action="{url link='admincp.user.group.add'}" onsubmit="$('#js_setting_saved').html($.ajaxProcess('Saving')).show(); $(this).ajaxCall('user.updateSettings'); return false;">	
	<div class="table_header">
		{phrase var='admincp.controllers'}<span id="js_editing_block" style="display:none;"> - <span id="js_editing_block_text"></span></span>
	</div>	
	<div id="content_editor_holder">
		<div id="content_editor_menu">
			<ul>
				{foreach from=$aBlocks key=sUrl item=aModules}
				<li><a href="#" onclick="$.ajaxCall('admincp.getBlocks', 'm_connection={$sUrl}', 'GET'); $(this).blur(); $('#content_editor_menu a').removeClass('cem_active'); $(this).addClass('cem_active'); return false;">{if empty($sUrl)}{phrase var='admincp.site_wide'}{else}{$sUrl}{/if}</a></li>
				{/foreach}
			</ul>
		</div>
		<div id="content_editor_text">
			<div id="js_setting_block">
				<div class="extra_info">
					{phrase var='admincp.to_your_left_you_will_find_all_the_available'}
				</div>
			</div>			
		</div>
		<div class="clear"></div>
	</div>
</form>