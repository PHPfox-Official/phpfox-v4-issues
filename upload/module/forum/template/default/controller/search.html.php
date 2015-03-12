<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="main_break"></div>
<form method="post" action="{if $aCallback === false}{url link='forum.search'}{else}{url link='forum.search' module='pages' item=$aCallback.group_id}{/if}">
	{if $aCallback !== false}
	<div><input type="hidden" name="search[group_id]" value="{$aCallback.group_id}" /></div>
	{/if}
	<div class="table">
		<div class="table_left">
			{phrase var='forum.search_for_keyword_s'}:
		</div>
		<div class="table_right">
			{$aFilters.keyword}				
		</div>
	</div>	
	
	<div class="table">
		<div class="table_left">
			{phrase var='forum.search_for_author'}:
		</div>
		<div class="table_right">
			{$aFilters.user}	
		</div>
	</div>			

	<h3>{phrase var='forum.search_options'}</h3>
	{if $aCallback === false}
	<div class="table">
		<div class="table_left">
			{phrase var='forum.find_in_forum'}:
		</div>
		<div class="table_right">
			<select name="search[forum][]" style="width:90%;" multiple="multiple" size="10">
				{$sForumList}
			</select>
		</div>
	</div>	
	
	<div class="separate"></div>
	{/if}
	<div class="table">
		<div class="table_left">
			{phrase var='forum.display'}:
		</div>
		<div class="table_right">			
			{$aFilters.display}
		</div>
	</div>
	
	<div class="table">
		<div class="table_left">
			{phrase var='forum.sort'}:
		</div>
		<div class="table_right">			
			{$aFilters.sort} in {$aFilters.sort_by}
		</div>
	</div>
	
	<div class="table">
		<div class="table_left">
			{phrase var='forum.from'}:
		</div>
		<div class="table_right">			
			{$aFilters.days_prune}
		</div>
	</div>
	
	<div class="table">
		<div class="table_left">
			{phrase var='forum.display_results_as'}:
		</div>
		<div class="table_right">			
			{$aFilters.result}
		</div>
	</div>		

	<div class="table_clear">
		<input type="submit" name="search[submit]" value="{phrase var='forum.search'}" class="button" />
	</div>
</form>