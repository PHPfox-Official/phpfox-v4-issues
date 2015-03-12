<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: invite.html.php 2595 2011-05-09 14:01:09Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<ul class="block_listing">
{foreach from=$aEventInvites name=minilistings item=aMiniListing}
	{template file='marketplace.block.mini'}
{/foreach}
</ul>