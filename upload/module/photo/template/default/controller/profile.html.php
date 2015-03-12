<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: profile.html.php 2633 2011-05-30 13:57:44Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $sReq3 == 'albums'}
{template file='photo.controller.albums'}
{else}
{template file='photo.controller.index'}
{/if}