<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		PhpFox
 * @version 		$Id: email.html.php 1189 2009-10-16 19:05:19Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $bHtml}	
	{if isset($sName)}
	{phrase var='core.hello_name' name=$sName}
	{else}
	{phrase var='core.hello'}
	{/if},
	<br />
	<br />
	{$sMessage}
	<br />
	<br />
	{$sEmailSig}	
{else}	
	{if isset($sName)}
	{phrase var='core.hello_name' name=$sName}
	{else}
	{phrase var='core.hello'}
	{/if},
	{$sMessage}

	{$sEmailSig}	
{/if}