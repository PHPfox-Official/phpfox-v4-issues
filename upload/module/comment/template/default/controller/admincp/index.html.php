<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 981 2009-09-15 13:53:22Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aComments)}
{foreach from=$aComments item=aRow}
	{template file='comment.block.entry'}
{/foreach}
{pager}
{else}
{phrase var='comment.no_comments'}
{/if}