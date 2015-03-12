<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Search
 * @version 		$Id: index.html.php 6569 2013-09-03 06:48:49Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !PHPFOX_IS_AJAX}
<div class="main_search_bar">
	<form method="post" action="{url link='search'}">
		<input type="text" name="q" value="{if isset($sQuery)}{$sQuery|clean}{/if}" class="main_search_bar_input" /><input type="submit" value="Search" class="main_search_bar_button" />
	</form>
</div>
{/if}

{if isset($aSearchResults) && count($aSearchResults)}
{if PHPFOX_IS_AJAX}
<div class="search_result_new"></div>
{/if}
{foreach from=$aSearchResults item=aSearchResult}
<div class="search_result">
	<div class="search_result_image">
		{if isset($aSearchResult.profile_image)}
			{img user=$aSearchResult.profile_image suffix='_50_square' max_width=50 max_height=50}		
		{else}
			{img user=$aSearchResult suffix='_50_square' max_width=50 max_height=50}		
		{/if}
	</div>
	<div class="search_result_info">
		<div class="search_result_title">
			<a href="{$aSearchResult.item_link}" title="{$aSearchResult.item_title|clean}">{$aSearchResult.item_title|clean|shorten:'60':'...'}</a>
		</div>
		<div class="extra_info">
			<ul class="extra_info_middot"><li>{$aSearchResult.item_name}</li><li>&middot;</li><li>{$aSearchResult.item_time_stamp|convert_time}</li></ul>
		</div>
		{if isset($aSearchResult.item_display_photo)}
		<div class="search_result_photo">
			<a href="{$aSearchResult.item_link}">{$aSearchResult.item_display_photo}</a>
		</div>	
		{/if}		
	</div>
</div>
{/foreach}
<div id="feed_view_more">
		<a href="#" onclick="$(this).html($.ajaxProcess('{phrase var='feed.loading'}')); $.ajaxCall('search.viewMore', '{$sNextPage}', 'GET'); return false;" class="global_view_more no_ajax_link">{phrase var='search.view_more'}</a>
</div>
{else}
{if PHPFOX_IS_AJAX}
{phrase var='search.no_more_search_results_to_show'}
{else}
{phrase var='search.no_search_results_found'}
{/if}
{/if}
{if !PHPFOX_IS_AJAX}
	<div id="js_feed_content" class="js_feed_content"></div>
{/if}