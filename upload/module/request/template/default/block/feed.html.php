<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Request
 * @version 		$Id: feed.html.php 601 2009-05-28 15:03:41Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<ul class="action">
{foreach from=$aMessages item=sMessage}
{$sMessage}
{/foreach}
</ul>