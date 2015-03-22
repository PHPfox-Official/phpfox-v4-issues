<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: mini.html.php 5521 2013-03-19 12:58:06Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>			<div style="display:none;">{select_date prefix='end_' start_year='current_year' end_year='+1' field_separator=' / ' field_order='MDY' default_all=true add_time=true start_hour='+4' time_separator='event.time_separator'}</div>
				
			<div class="block_event_sub">
				{select_date prefix='start_' start_year='current_year' end_year='+1' field_separator=' / ' field_order='MDY' default_all=true add_time=true start_hour='+1' time_separator='event.time_separator'}
			</div>

			<div class="block_event_sub">
				<div id="js_quick_event_default_where" style="display:none;">{phrase var='event.where'}</div>
				<input class="block_event_form_input block_event_form_input_off" type="text" name="val[location]" value="{phrase var='event.where'}" onfocus="if (this.value == $('#js_quick_event_default_where').html()) {l} this.value = ''; $(this).removeClass('block_event_form_input_off'); {r}" />
			</div>

			<div class="block_event_sub">
				<input type="submit" class="button" value="{phrase var='event.create_event'}" />
			</div>
		