<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: footer.html.php 6518 2013-08-28 11:21:49Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
			

			<div class="footer_bar_block_holder" id="footer_bar"{if Phpfox::getUserBy('footer_bar')} style=""{/if}>					
				<div style="position:absolute; right:0; background-color: #E5E5E5; border-bottom: 1px solid #B5B5B5; border-top: 1px solid #B5B5B5;">
					<ul class="right">
						{if Phpfox::isModule('im') && Phpfox::getParam('im.enable_im_in_footer_bar')}
							{module name='im.footer'}
						{/if}						
						
						{if Phpfox::isModule('notification') && Phpfox::getParam('notification.notify_on_new_request')}
							{module name='notification.link'}
						{/if}
						
						<li style="position: relative; width: 150px;">							
							<div style="width: 50px; height: 50px;">
								<a href="#" onclick="$('#footer_bar').find('a').removeClass('focus').removeClass('is_already_open'); $('#footer_bar').hide(); $('.js_footer_holder').hide(); $('#footer_bar_open').show(); $.ajaxCall('user.updateFooterBar', 'type_id=1'); return false;" title="{phrase var='core.hide_the_footer_bar'}">{img theme='layout/hide.gif' alt='' class='v_middle'}</a>
							</div>
						</li>
					</ul>
				</div>
				{*
				<ul class="left">
					<li><a href="#" id="js_footer_start_button">{img theme='layout/logo_small.png' alt='Start' class='v_middle'} {param var='core.footer_bar_site_name'}</a></li>
					<li><a href="{url link=''}" title="{phrase var='core.dashboard'}">{img theme='layout/dashboard.png' alt='' class='v_middle'}</a></li>
					
				</ul>
				*}
			</div>	
		
			<div class="footer_bar_block_holder" id="footer_bar_open"{if !Phpfox::getUserBy('footer_bar')}  style="display:none;"{/if}>
				<ul class="right">					
					<li><a href="#" onclick="$('#footer_bar').show(); $('#footer_bar_open').hide();  $.ajaxCall('user.updateFooterBar', 'type_id=0'); return false;" title="{phrase var='core.show_the_footer_bar'}">{img theme='layout/open.gif' alt='' class='v_middle'}</a></li>					
				</ul>			
			</div>