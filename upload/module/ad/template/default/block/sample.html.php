<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>

{foreach from=$aPlans item=aPlan}
	{if defined('PHPFOX_NO_WINDOW_CLICK')}
		{if $sBlockLocation == 7}
		<div class="message">
			{phrase var='ad.click_on_the_ad_size_you_want_to_create_an_ad_for'}
		</div>
		{/if}
		{if $aPlan.sSizes !== false}
			<div class="sample">
				{if $aPlan.is_cpm}
					{phrase var='ad.block_location_cost_cpm_1_000_views' location=$sBlockLocation cost=$aPlan.default_cost|currency}
				{else}
					{phrase var='ad.block_location_cost_ppc' location=$sBlockLocation cost=$aPlan.default_cost|currency}
					
				{/if}
				<div class="extra_info">
				 ({$aPlan.sSizes})
				</div>
			</div>
		{/if}
	{else}
		<div class="extra_info">
			({$aPlan.sSizes})
		</div>
	{/if}
{/foreach}
