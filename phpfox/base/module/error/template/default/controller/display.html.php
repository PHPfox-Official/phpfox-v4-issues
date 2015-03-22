<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Error
 * @version 		$Id: display.html.php 4410 2012-06-28 08:51:00Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if isset($sErrorMessage)}
	{$sErrorMessage}
{/if}