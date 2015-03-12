<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Feed
 * @version 		$Id: display.html.php 2284 2011-02-01 15:58:18Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
				<div class="global_attachment_holder_section" id="global_attachment_link">	
					<div class="js_preview_content_holder_action" id="global_attachment_link_holder">
						<div>
							<input type="text" name="val[link][url]" value="http://" style="width:{if (defined('PHPFOX_IS_USER_PROFILE') || defined('PHPFOX_IS_PAGES_VIEW')) && Phpfox::getService('profile')->timeline()}230{else}400{/if}px;" id="js_global_attach_value" onfocus="if (this.value == 'http://') {l} this.value = ''; {r}" onblur="if (this.value == '') {l} this.value = 'http://' {r}" class="global_link_input" /><input type="button" value="{phrase var='link.attach'}" id="js_global_attach_link" class="button global_link_input_button" />							
						</div>			
						<div class="extra_info">
							{phrase var='link.paste_a_link_you_would_like_to_attach'}
						</div>
					</div>
					<div class="js_preview_content_holder" id="js_preview_link_attachment"></div>
					<div id="js_global_attachment_link_cancel" class="p_4 t_right" style="display:none;">
						<a href="#" onclick="$('#js_preview_link_attachment').html(''); $('#global_attachment_link_holder').show(); $('#activity_feed_submit').attr('disabled','disabled').addClass('button_not_active');$('#js_global_attach_value').val('http://'); return false;">{phrase var='link.cancel'}</a>
					</div>
				</div>	