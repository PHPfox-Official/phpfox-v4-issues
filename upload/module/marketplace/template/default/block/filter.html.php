<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: filter.html.php 1784 2010-08-31 18:31:24Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{if empty($sCategoryUrl)}{url link=''$sUserLinkProfile'marketplace'}{else}{url link=''$sUserLinkProfile'marketplace.'$sCategoryUrl''}{/if}">
	{phrase var='marketplace.keywords'}:
	<div class="p_4">
		{filter key='keyword'}
	</div>
	
	<div class="p_top_4">
		{phrase var='marketplace.location'}:
		<div class="p_4">
			{filter key='country'}
			{module name='core.country-child' country_child_filter=true country_child_type='browse'}
		</div>	
	</div>		
	
	<div class="p_top_4">
		{phrase var='marketplace.city'}:
		<div class="p_4">
			{filter key='city'}
		</div>	
	</div>

	<div class="p_top_4">
		{phrase var='marketplace.zip_postal_code'}:
		<div class="p_4">
			{filter key='zip'}
		</div>	
	</div>		
	
	<div class="p_top_4">
		{phrase var='marketplace.sort'}:
		<div class="p_4">
			{filter key='sort'} in {filter key='sort_by'}
		</div>	
	</div>	
	
	<div class="p_top_8">
		<input name="search[submit]" value="{phrase var='marketplace.submit'}" class="button" type="submit" />
		<input name="search[reset]" value="{phrase var='marketplace.reset'}" class="button" type="submit" />	
	</div>	
</form>