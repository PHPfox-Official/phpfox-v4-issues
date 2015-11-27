<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: filter.html.php 1168 2009-10-09 14:20:37Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{if empty($sCategoryUrl)}{url link='music'$sParentLink'}{else}{url link='music'$sParentLink'.'$sCategoryUrl''}{/if}">
	{phrase var='music.keywords'}:
	<div class="p_4">
		{filter key='keyword'}
	</div>	
	
	<div class="p_top_4">
		{phrase var='music.sort'}:
		<div class="p_4">
			{filter key='sort'}
		</div>	
	</div>	
	
	<div class="p_top_4">
		{phrase var='music.by'}:
		<div class="p_4">
			{filter key='sort_by'}
		</div>	
	</div>		
	
	<div class="p_top_8">
		<input name="search[submit]" value="{phrase var='music.submit'}" class="button" type="submit" />
		<input name="search[reset]" value="{phrase var='music.reset'}" class="button" type="submit" />	
	</div>	
</form>