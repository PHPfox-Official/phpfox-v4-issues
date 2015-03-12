<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: profile.html.php 1124 2009-10-02 14:07:30Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aFavorites)}
{foreach from=$aFavorites item=aGroups}
	{module name='favorite.entry' favorite_title=$aGroups.title}	
{/foreach}
{else}
<div class="extra_info">
	{if $aUser.user_id == Phpfox::getUserId()}
	{phrase var='favorite.you_have_not_added_any_favorites_yet'}
	<br />
	<br />
	{phrase var='favorite.to_add_items_to_your_favorite_list_simply_view_public_items_on_the_site'}
	{else}
	{phrase var='favorite.user_link_has_not_added_any_favorites_yet' user=$aUser}
	{/if}
</div>
{/if}