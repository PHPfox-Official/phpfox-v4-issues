<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Report
 * @version 		$Id: add.html.php 3533 2011-11-21 14:07:21Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $bCanReport}
<div id="js_report_body">
{phrase var='report.you_are_about_to_report_a_violation_of_our_a_href_link_target_blank_terms_of_use_a' link=$sTermsUrl}
<div class="p_4">
	{phrase var='report.all_reports_are_strictly_confidential'}
	<div class="p_top_8">
		<div class="table">
			<div class="table_left">
				{phrase var='report.reason'}:
			</div>
			<div class="table_right">
				<select name="reason" id="js_report">
				<option value="">{phrase var='report.choose_one'}</option>
				{foreach from=$aOptions item=aOption}
					<option value="{$aOption.report_id}">{$aOption.message|convert}</option>
				{/foreach}
				</select>
			</div>
			<div class="table_left">
				{phrase var='report.a_comment_optional'}:
			</div>
			<div class="table_right">
				<textarea name="feedback" id="feedback" cols="19" rows="3"></textarea>
			</div>			
		</div>
		<div class="table">
			<div class="table_left"></div>
			<div class="table_right">			
				<input type="button" value="{phrase var='core.submit'}" class="button" onclick="if ( ($('#js_report').val() != '' || $('#feedback').val() != '' ) && confirm('{phrase var='core.are_you_sure' phpfox_squote=true}')) {left_curly} $.ajaxCall('report.insert', 'id={$iItemId}&amp;type={$sType}&amp;report=' + $('#js_report').val() + '&feedback='+$('#feedback').val()); tb_remove(); {right_curly}" />
			</div>
		</div>
			
	</div>
</div>
</div>
{else}
{phrase var='report.you_have_already_reported_this_item'}
{/if}