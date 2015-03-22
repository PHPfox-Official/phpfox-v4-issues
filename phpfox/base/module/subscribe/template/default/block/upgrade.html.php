<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: upgrade.html.php 7107 2014-02-11 19:46:17Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if isset($bIsFree)}
<div class="extra_info">
	{phrase var='subscribe.your_membership_has_successfully_been_upgraded'}
	<ul class="action">
		<li><a href="{url link='subscribe.view' id=$iPurchaseId}">{phrase var='subscribe.view_your_subscription'}</a></li>
	</ul>
</div>
{else}
{module name='api.gateway.form' bIsThickBox=$bIsThickBox}
{/if}
