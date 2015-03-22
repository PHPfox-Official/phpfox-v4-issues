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
<div id="js_rating_holder_{$aRatingCallback.type}">
	<form method="post" action="#">
		<div><input type="hidden" name="rating[type]" value="{$aRatingCallback.type}" /></div>
		<div><input type="hidden" name="rating[item_id]" value="{$aRatingCallback.item_id}" /></div>
		<div style="height:18px;">
			<div style="position:absolute;">		
			{foreach from=$aRatingCallback.stars key=sKey item=sPhrase}		
				<input type="radio" class="js_rating_star" id="js_rating_star_{$sKey}" name="rating[star]" value="{$sKey}|{$sPhrase}" title="{$sKey}{if $sPhrase != $sKey} ({$sPhrase}){/if}"{if $aRatingCallback.default_rating >= $sKey} checked="checked"{/if} />
			{/foreach}	
				<div class="clear"></div>
			</div>
		</div>
		{if isset($aRatingCallback.total_rating)}
		<div class="extra_info" style="padding:4px 0px 0px 4px;">
			<span class="js_rating_total">{$aRatingCallback.total_rating}</span>			
		</div>		
		{/if}
	</form>
</div>