<?php 
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox
 * @version 		$Id: index.html.php 1168 2009-10-09 14:20:37Z Raymond_Benc $
 */

defined('PHPFOX') or exit('NO DICE!'); 

?>

{foreach from=$aNewsletters item=aNewsletter name=newsletter key=iKey}
<div class="js_newsletter_{$aNewsletter.newsletter_id} {if is_int($phpfox.iteration.newsletter/2)}row1{else}row2{/if}{if $phpfox.iteration.newsletter == 1} row_first{/if}">
	<div class="js_newsletter_{$aNewsletter.newsletter_id}_subject h3" style="font-size:12pt; font-weight:bold;">
		
		<a href="{url link='newsletter.view' id=$aNewsletter.newsletter_id}">{$aNewsletter.subject}</a>
		
		<div class="newsletter_{$aNewsletter.newsletter_id}_date extra_info" style="font-size: 9pt; font-weight:normal;">
			{phrase var='newsletter.posted_on_time_stamp_by_user_info' time_stamp=$aNewsletter.time_stamp|date user_info=$aNewsletter|user}
		</div>
		<div class="go_right" style="font-size: 9pt;font-weight: normal;">
			<a href="{url link='newsletter.view' id=$aNewsletter.newsletter_id}">{phrase var='newsletter.read_more'}</a>
		</div>
	</div>	
</div>
<div class="clear"></div>
{foreachelse}
<div>
	{phrase var='newsletter.no_newsletters_have_been_sent'}
</div>
{/foreach}