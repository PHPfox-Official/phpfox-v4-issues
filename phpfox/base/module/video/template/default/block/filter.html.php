<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: filter.html.php 1126 2009-10-03 12:05:33Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{if empty($sCategoryUrl)}{url link=$sParentLink}{else}{url link=''$sParentLink'.category'$sCategoryUrl''}{/if}">
	{phrase var='video.keywords'}:
	<div class="p_4">
		{filter key='keyword'}
	</div>	
	
	<div class="p_top_4">
		{phrase var='video.sort'}:
		<div class="p_4">
			{filter key='sort'} {phrase var='video.in_sorting_order'} {filter key='sort_by'}
		</div>	
	</div>	
	
	<div class="p_top_8">
		<input name="search[submit]" value="{phrase var='video.submit'}" class="button" type="submit" />
		<input name="search[reset]" value="{phrase var='video.reset'}" class="button" type="submit" />
	</div>	
</form>