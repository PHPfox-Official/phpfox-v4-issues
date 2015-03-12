<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 6839 2013-10-31 18:23:03Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !$iPlacementCount}
	<div class="message">
		{phrase var='ad.no_ad_placements_have_been_created_check_back_here_shortly'}
	</div>
{else}
	{if $bIsEdit}
		<form method="post" action="{url link='ad.add' id=$aForms.ad_id}">
			<div><input type="hidden" name="val[id]" value="{$aForms.ad_id}" /></div>
			<div class="main_break">
				<div class="table">
					<div class="table_left">
						{phrase var='ad.campaign_name'}:
					</div>
					<div class="table_right">
						<input type="text" name="val[name]" value="{value type='input' id='name'}" size="25" id="name" />
					</div>
					<div class="clear"></div>
				</div>	
				
				{template file='ad.block.targetting'}
				<div class="table_clear">
					<input type="submit" value="{phrase var='ad.submit'}" class="button" />
				</div>		
			</div>
		</form>
	{else}
		{if $bCompleted}
			<div class="main_break"></div>
			{if isset($bIsFree) && $bIsFree == true}
				<div class="message">
					{phrase var='ad.your_ad_has_been_created'}
				</div>
			{else}
				<div class="message">
					{phrase var='ad.your_ad_has_successfully_been_submitted_to_complete_the_process_continue_with_paying_below'}
				</div>
				<h3>{phrase var='ad.payment_methods'}</h3>
				{module name='api.gateway.form'}
			{/if}
			
		{else}
			<div id="js_upload_image_holder_frame" style="z-index:999; background:#fff;">	
				<div id="js_upload_image_holder" style="z-index:999;" class="ajax_link_reset">
					<form method="post" action="{url link='ad.image'}" target="upload_ad_iframe" enctype="multipart/form-data">			
						<div><input type="hidden" name="ad_size" value="728x90" id="js_upload_ad_size" /></div>
						<input id="js_form_upload_file" type="file" name="image" onchange="$('#js_upload_image_holder').hide(); $('#js_image_holder_message').show(); $(this).parent('form').submit();$('#js_upload_image_holder_frame').hide();$('#link_show_image_uploader').hide();" />
					</form>
				</div>
				<iframe framewidth="400" frameheight="200" name="upload_ad_iframe" id="upload_ad_iframe" style="display:none;"></iframe>
			</div>	

			<form method="post" action="{url link='ad.add'}" id="js_custom_ad_form" enctype="multipart/form-data">
				<div><input type="hidden" name="val[image_path]" value="{value type='input' id='image_path'}" id="js_image_id" /></div>	
				<div><input type="hidden" name="val[type_id]" value="{value type='input' id='type_id' default='2'}" id="type_id" /></div>	
				<div><input type="hidden" name="val[color_bg]" value="{value type='input' id='color_bg' default='fff'}" id="js_colorpicker_drop_bg" /></div>
				<div><input type="hidden" name="val[color_border]" value="{value type='input' id='color_border' default='bcccd1'}" id="js_colorpicker_drop_border" /></div>
				<div><input type="hidden" name="val[color_text]" value="{value type='input' id='color_text' default='1280c9'}" id="js_colorpicker_drop_text" /></div>
				<div><input type="hidden" name="val[ad_size]" value="{value type='input' id='ad_size'}" id="js_upload_ad_size_find" /></div>
				<div style="display:none;"><textarea cols="40" rows="6" name="val[html_code]" id="html_code">{value type='textarea' id='html_code'}</textarea></div>
				
				{if Phpfox::getParam('ad.multi_ad') == true}
					<div id="js_sample_multi_ad_holder">
						<div class="ad_unit_holder_title">Sample Ad</div>
						<div class="ad_unit_multi_ad">
							<div class="ad_unit_multi_ad_title"></div>
							<div class="ad_unit_multi_ad_url"></div>
							<div class="ad_unit_multi_ad_content">
								<div class="ad_unit_multi_ad_image js_ad_image"></div>
								<div class="ad_unit_multi_ad_text"></div>
							</div>
							
						</div>
					</div>
				{else}
					<div id="js_sample_ad_create_holder">			
						<div>
							<div id="js_sample_ad_form_728_90" class="js_ad_holder" style="display:none; width:728px; height:90px; background:#fff; border:1px #bcccd1 solid; text-align:left; overflow:hidden;">
								<div style="padding:5px;">
									<div class="js_ad_image" style="padding-top:6px; float:left; width:125px; text-align:center; font-size:12pt; font-weight:bold;">
										<span class="js_image_place_holder"></span>
										{phrase var='ad.image_placement'}
									</div>
									<div style="margin-left:130px; padding-left:6px;">
										<div style="font-size:12pt; font-weight:bold;">
											<a href="#ad-link" class="js_ad_title js_ad_text" style="color:#1280c9;">{phrase var='ad.example_ad'}</a>
										</div>				
										<div class="js_ad_body js_ad_text" style="padding:6px 0px 0px 0px; color:#1280c9;">
											{phrase var='ad.this_is_a_sample_ad'}
										</div>
									</div>
									<div class="clear"></div>
								</div>
							</div>
						</div>			
						
						<div>	
							<div id="js_sample_ad_form_160_600" class="js_ad_holder" style="display:none; width:160px; height:600px; background:#fff; border:1px #000 solid; text-align:left; text-align:center; overflow:hidden;">
								<div style="padding:5px;">					
									<div style="font-size:12pt; font-weight:bold;"><a href="#ad-link" class="js_ad_title js_ad_text" style="color:#1280c9;">{phrase var='ad.example_ad'}</a></div>							
									<div class="js_ad_image" style="padding-top:6px; font-size:12pt; font-weight:bold;"><span class="js_image_place_holder"></span>{phrase var='ad.image_placement'}</div>
									<div class="js_ad_body js_ad_text" style="padding:6px 0px 0px 0px; color:#1280c9;">
										{phrase var='ad.this_is_a_sample_ad'}
									</div>
								</div>
							</div>
						</div>								
					</div>
				{/if}
				
				
				
				
				
				
				
				
				<div id="step_1">
					<h3>{phrase var='ad.1_ad_design'}</h3>	
					
					{if Phpfox::getParam('ad.multi_ad') != true}
						<div class="page_section_menu">
							<ul>
								<li class="active"><a href="#" class="js_create_ad">{phrase var='ad.create_an_ad'}</a></li>
								<li><a href="#" class="js_upload_ad">{phrase var='ad.upload_an_ad'}</a></li>
							</ul>
							<div class="clear"></div>
						</div>
					
					
						<div class="table">
							<div class="table_left">
								{phrase var='ad.ad_placement'}:
							</div>
							<div class="table_right">
								<div><input type="hidden" name="val[block_id]" value="" id="js_block_id" /></div>
								<select name="val[location]" id="location" style="display:none;">	
									{for $i = 1; $i <= 10; $i++}
										<option value="{$i}"{value type='select' id='location' default=$i}>{phrase var='admincp.block' x=$i}</option>
									{/for}
								</select>
								<span id="js_ad_position_selected" style="display:none;">
										<span></span> 
										(<a href="#?call=ad.sample&amp;no-click&amp;width=scan" class="inlinePopup" title="{phrase var='admincp.sample_layout'}">
											{phrase var='ad.change'}
										</a>)
								</span>
								<span id="js_ad_position_select">
									<a href="#?call=ad.sample&amp;no-click&amp;width=scan" class="inlinePopup" title="{phrase var='admincp.sample_layout'}">
										{phrase var='ad.select_a_position'}
									</a>
								</span>
							</div>
							<div class="clear"></div>
						</div>
					{else}
						<div id="multi_ad_enabled"> 
							<input type="hidden" name="val[location]" id="location" value="50" />							
						</div>
						<div><input type="hidden" name="val[block_id]" value="50" id="js_block_id" /></div>
					{/if}
					
					<div id="js_create_ad" class="hide_sub_block">
						{if Phpfox::getParam('ad.multi_ad') != true}						
							<div class="table">
								<div class="table_left">
									{phrase var='ad.background_color'}:
								</div>
								<div class="table_right">
									<a href="#?var=backgroundColor&amp;class=js_ad_holder&amp;id=js_colorpicker_drop_bg" class="colorpicker_select">{phrase var='ad.select'}</a>
								</div>
								<div class="clear"></div>
							</div>		
							
							<div class="table">
								<div class="table_left">
									{phrase var='ad.border_color'}:
								</div>
								<div class="table_right">
									<a href="#?var=borderColor&amp;class=js_ad_holder&amp;id=js_colorpicker_drop_border" class="colorpicker_select">{phrase var='ad.select'}</a>
								</div>
								<div class="clear"></div>
							</div>		
							
							<div class="table">
								<div class="table_left">
									{phrase var='ad.text_color'}:
								</div>
								<div class="table_right">
									<a href="#?var=color&amp;class=js_ad_text&amp;id=js_colorpicker_drop_text" class="colorpicker_select">{phrase var='ad.select'}</a>
								</div>
								<div class="clear"></div>
							</div>		
						{/if}
						
						<div class="table">
							<div class="table_left">
								{phrase var='ad.title'}:
							</div>
							<div class="table_right">
								<input type="text" name="val[title]" value="{value type='input' id='title'}" size="25" maxlength="25" id="title" />
								<div id="js_ad_title_form_limit" class="extra_info">
									{phrase var='ad.25_character_limit'}
								</div>
							</div>
							<div class="clear"></div>
						</div>	
						<div class="table">
							<div class="table_left">
								{phrase var='ad.body_text'}:
							</div>
							<div class="table_right">
								<textarea cols="40" rows="6" name="val[body_text]" id="body_text">{value type='textarea' id='body_text'}</textarea>
								<div id="js_ad_body_text_form_limit" class="extra_info">
									{phrase var='ad.135_character_limit'}
								</div>
							</div>
							<div class="clear"></div>
						</div>			
						
						<div class="table">
							<div class="table_left">
								{if Phpfox::getParam('ad.multi_ad')}
									{phrase var='ad.image'}:
								{else}
									{phrase var='ad.image_optional'}:
								{/if}
							</div>
							<div class="table_right">
								<a href="#" id="link_show_image_uploader" style="z-index:1;" onclick="var thisPosition = $(this).position(); $('#js_upload_image_holder_frame').css({l}'top': thisPosition.top + 'px', 'left': '0px', 'z-index': '1000px'{r}); $('#js_upload_image_holder_frame').show(); return false;"> {phrase var='ad.choose_image'} </a>
								<div id="js_image_holder"></div>
								<div id="js_image_holder_link" style="display:none;">
									<a href="#">{phrase var='ad.change_image'}</a>
								</div>
								<div id="js_image_holder_message" style="display:none;">{img theme='ajax/small.gif'}</div>
								<div class="extra_info" style="padding-top:35px;">				
									<div id="js_image_error" style="display:none;">
										<div class="error_message" style="width:60%;">
											{phrase var='ad.we_only_accept_the_following_extensions_gif_jpg_and_png'}
										</div>
									</div>
									{phrase var='ad.supported_extensions_gif_jpg_and_png'}
									{if Phpfox::getParam('ad.multi_ad')}
									&middot; Recommended image dimensions are 100x72 pixels.
									{/if}
								</div>
							</div>
							<div class="clear"></div>
						</div>		
					</div>
					
					<div id="js_upload_ad" class="hide_sub_block" style="display:none;">
						<div class="table">
							<div class="table_left">
								{phrase var='ad.image'}:
							</div>
							<div class="table_right">
								<input type="file" name="image" />
								<div class="extra_info">				
									{phrase var='ad.supported_extensions_gif_jpg_and_png'}		
								</div>
							</div>
							<div class="clear"></div>
						</div>			
					</div>
					
					
					
					<div class="table">
						<div class="table_left">
							{phrase var='ad.destination_url'}:
						</div>
						<div class="table_right">
							<input type="text" name="val[url_link]" value="{value type='input' id='url_link'}" size="50" id="url_link" />
							<div class="extra_info">
								{phrase var='ad.example_http_www_yourwebsite_com'}
							</div>
						</div>
						<div class="clear"></div>
					</div>	
					
					<div class="table_clear" id="js_ad_continue_form_button">
						<input type="button" value="{phrase var='ad.continue'}" class="button" id="js_ad_continue_form" />
					</div>	
				</div>
				<div id="js_ad_continue_next_step" style="display:none;">
					<div class="main_break"></div>
					
					<h3>{phrase var='ad.2_targeting'}</h3>
					
					<div class="main_break"></div>
					
					{template file='ad.block.targetting'}
					
					<div class="main_break"></div>
					
					<h3>{phrase var='ad.3_campaigns_and_pricing'}</h3>
					
					<div class="main_break"></div>
					
					<div class="table">
						<div class="table_left">
							{phrase var='ad.campaign_name'}:
						</div>
						<div class="table_right">
							<input type="text" name="val[name]" value="{value type='input' id='name'}" size="25" id="name" />
						</div>
						<div class="clear"></div>
					</div>		
					
					<div class="table">
						<div class="table_left">
							<span id="js_ad_cpm"></span>
						</div>
						<div class="table_right">
							<div><input type="hidden" name="val[ad_cost]" value="" size="15" id="js_total_ad_cost" /></div>
							<div><input type="hidden" name="val[is_cpm]" value="" size="15" id="js_is_cpm" /></div>
							<input type="text" name="val[total_view]" value="{value type='input' id='total_view' default='1000'}" size="15" id="total_view" /> 
							<span id="js_ad_cost" style="font-weight:bold;"></span>
							<span id="js_ad_cost_recalculate" style="display:none;">
								<a href="#" onclick="$Core.Ad.recalculate();return false;">
									{phrase var='ad.recalculate_costs'}
								</a>
							</span>
							<div class="extra_info" id="js_ad_info_cost">
							
							</div>
						</div>
						<div class="clear"></div>
					</div>		
						
					<div class="table">
						<div class="table_left">
							{phrase var='ad.start_date'}:
						</div>
						<div class="table_right">
							{select_date prefix='start_' start_year='current_year' end_year='+10' field_separator=' / ' field_order='MDY' default_all=true add_time=true time_separator='core.time_separator'}
							<div class="extra_info">
								{phrase var='ad.note_the_time_is_set_to_your_registered_time_zone'}
							</div>
						</div>
						<div class="clear"></div>
					</div>		
					
					<div class="table_clear">
						<input type="submit" value="{phrase var='ad.submit'}" class="button" id="js_submit_button" />
					</div>
				</div>
				
			</form>
		{/if}
	{/if}
{/if}
