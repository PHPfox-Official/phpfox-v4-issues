<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: pending.html.php 1578 2010-05-07 09:38:07Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>

{if $iStatus == 1}
    {phrase var='user.this_site_is_very_concerned_about_security'}
{else}
    {phrase var='user.your_account_is_pending_approval'}
{/if}