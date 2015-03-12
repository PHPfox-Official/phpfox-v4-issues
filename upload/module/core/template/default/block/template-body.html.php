<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: template-body.html.php 3335 2011-10-20 17:26:57Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	{plugin call='theme_template_body__start'}
	{if Phpfox::getParam('core.site_is_offline') && !Phpfox::getParam('core.site_offline_no_template')}
		<div id="site_offline">
			<a href="{url link='admincp.setting.edit.group-id_site_offline_online'}">{phrase var='core.the_site_is_currently_in_offline_mode'}</a>
		</div>
	{/if}		
		{module name='theme.design'}	
		{if PHPFOX_DESIGN_DND}
		<div id="designDnD">
			<div class="holder">
				<div id="designDnDLink">	
					<ul>
						<li><a href="#" onclick="$Core.box('theme.addBlockDnD', 300); return false;">{phrase var='core.add_new_block'}</a></li>
						<li><a href="#" onclick="$.ajaxCall('core.designdnd'); return false;">{phrase var='core.disable_dnd'}</a></li>
					</ul>
					<div class="clear"></div>
				</div>
				{phrase var='core.dnd_mode'}			
			</div>
		</div>
		{/if}