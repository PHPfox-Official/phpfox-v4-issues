<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: my.html.php 2592 2011-05-05 18:51:50Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<ul class="block_listing">
{foreach from=$aMyListings name=minilistings item=aMiniListing}
	{template file='marketplace.block.mini'}
{/foreach}
</ul>
