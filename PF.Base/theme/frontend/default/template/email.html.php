<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		PhpFox
 * @version 		$Id: email.html.php 4928 2012-10-23 06:12:51Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $bHtml}	
{if $bMessageHeader}
	{if isset($sMessageHello)}
	{$sMessageHello}
	{else}
	{phrase var='core.hello'}
	{/if},
	<br />
	<br />
{/if}
	{$sMessage}
	<br />
	<br />
	{$sEmailSig}	
{else}	
{if $bMessageHeader}
	{if isset($sMessageHello)}
	{$sMessageHello}
	{else}
	{phrase var='core.hello'}
	{/if},
{/if}	
	{$sMessage}

	{$sEmailSig}	
{/if}