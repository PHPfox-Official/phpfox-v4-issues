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
	{if $aPage.page_type == '1'}
	{if count($aMembers)}
	<ul class="block_listing">
	{foreach from=$aMembers key=iKey name=members item=aMember}
		<li>
			<div class="block_listing_image">
				{img user=$aMember suffix='_50_square' max_width=50 max_height=50}
			</div>
			<div class="block_listing_title" style="padding-left:56px;">
				{$aMember|user:'':'':'':12:true}
			</div>
			<div class="clear"></div>
		</li>
	{/foreach}
	</ul>
	{else}
	<div class="extra_info">
		{phrase var='pages.no_members_yet'}
	</div>
	{/if}
	{else}
	<div class="global_like_number">
		{$aPage.total_like|number_format}
	</div>
	<div class="global_like_link">	
		<a href="#" onclick="return $Core.box('like.browse', 400, 'type_id=pages&amp;item_id={$aPage.page_id}&amp;force_like=1');">{if $aPage.total_like == 1}{phrase var='pages.person_likes_this'}{else}{phrase var='pages.people_like_this'}{/if}</a>
	</div>
	{/if}
{if !PHPFOX_IS_AJAX}
</div>
{/if}