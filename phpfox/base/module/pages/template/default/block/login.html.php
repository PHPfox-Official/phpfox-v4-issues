<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aPages)}
<div class="extra_info">{phrase var='pages.select_switch_below_to_use_this_site_as_a_page'}</div>
<br />
<div style="height:300px;" class="label_flow">
	<div id="pages_pager">
		{pager}
	</div>
	{foreach from=$aPages name=pages item=aPage}
	<div class="row1{if $phpfox.iteration.pages == 1} row_first{/if}">
		<div class="go_left" style="width:55px; text-align:center;">
			{img user=$aPage suffix='_50_square' max_width=50 max_height=50}
		</div>	
		<div style="margin-left:55px; position:relative;">
			<div style="position:absolute; right:10px; top:8px;">
				<div><input type="button" name="switch" value="{phrase var='pages.switch'}" class="button" onclick="$.ajaxCall('pages.processLogin', 'page_id={$aPage.page_id}', 'GET')" /></div>
			</div>
			<div style="width:200px;">
				<a href="{$aPage.link}">{$aPage.title|clean|split:20}</a>
			</div>
		</div>
		<div class="clear"></div>	
	</div>
	{/foreach}
</div>
{else}
<div class="extra_info">
	{phrase var='pages.you_currently_do_not_have_any_pages' link=$sLink}
</div>
{/if}

<script type="text/javascript">
	$( document ).ready(function()
	{l}
		if(!$('#pages_pager').is(':empty'))
		{l}
			if({$iCurrentPage} == 1)
			{l}
				$('.pager_next_link').attr("href", "#");
				var iCurrentPage = {$iCurrentPage}+1;
				$('.pager_next_link').attr("onclick", 'ajaxCallSearch('+iCurrentPage+'); return false;');
			}
			else if({$iCurrentPage} == {$iTotalPages})
			{l}
				$('.pager_previous_link').attr("href", "#");
				var iCurrentPage = {$iCurrentPage}-1;
				$('.pager_previous_link').attr("onclick", 'ajaxCallSearch('+iCurrentPage+'); return false;');
			{r}
			else
			{l}
				$('.pager_next_link').attr("href", "#");
				var iCurrentPage = {$iCurrentPage}+1;
				$('.pager_next_link').attr("onclick", 'ajaxCallSearch('+iCurrentPage+'); return false;');
				
				$('.pager_previous_link').attr("href", "#");
				var iCurrentPage = {$iCurrentPage}-1;
				$('.pager_previous_link').attr("onclick", 'ajaxCallSearch('+iCurrentPage+'); return false;');
			{r}
		{r}
	{r});
	
	function ajaxCallSearch(iCurrentPage)
	{l}
		$.ajaxCall('pages.loginSearch', 'page='+iCurrentPage+'&total={$iTotal}');
	{r}
</script>
