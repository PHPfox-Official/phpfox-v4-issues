<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: like.html.php 3332 2011-10-20 12:50:29Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !PHPFOX_IS_AJAX}
<div id="js_pages_like_join_holder">
{/if}
	{if count($aMembers)}
	{foreach from=$aMembers key=iKey name=users item=aUser}
		{template file='user.block.rows'}
	{/foreach}
	{/if}
{if !PHPFOX_IS_AJAX}
</div>
{/if}