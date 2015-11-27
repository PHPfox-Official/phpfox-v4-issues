<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: filter.html.php 1121 2009-10-01 12:59:13Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{if empty($sCategoryUrl)}{url link=$sParentLink}{else}{url link=''$sParentLink'.'$sCategoryUrl''}{/if}">
	{phrase var='event.keywords'}:
	<div class="p_4">
		{filter key='keyword'}
	</div>
	
	<div class="p_top_4">
		{phrase var='event.location'}:
		<div class="p_4">
			{filter key='country'}
			{module name='core.country-child' country_child_filter=true country_child_type='browse'}
		</div>	
	</div>		
	
	<div class="p_top_4">
		{phrase var='event.city'}:
		<div class="p_4">
			{filter key='city'}
		</div>	
	</div>

	<div class="p_top_4">
		{phrase var='event.zip_postal_code'}:
		<div class="p_4">
			{filter key='zip'}
		</div>	
	</div>		
	
	<div class="p_top_4">
		{phrase var='event.sort'}:
		<div class="p_4">
			{filter key='sort'} in {filter key='sort_by'}
		</div>	
	</div>	
	
	<div class="p_top_8">
		<input name="search[submit]" value="{phrase var='event.submit'}" class="button" type="submit" />
		<input name="search[reset]" value="{phrase var='event.reset'}" class="button" type="submit" />	
	</div>	
</form>