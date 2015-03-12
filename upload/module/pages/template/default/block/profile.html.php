<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: profile.html.php 5840 2013-05-09 06:14:35Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>

{foreach from=$aPagesList name=pages item=aPageDetails}
<div class="pages_profile_block"{if $phpfox.iteration.pages > 6} style="display:none;"{/if}>
	<a href="{$aPageDetails.url}" title="{$aPageDetails.title|clean}">
		{if $aPageDetails.is_app}
			{img server_id=0 path='app.url_image' file=$aPageDetails.aApp.image_path suffix='_200' max_width=75 max_height=75 force_max=true no_link=true}
		{else}		
			{if isset($aPageDetails.image_overwrite)}
				<img src="{$aPageDetails.image_overwrite}" width=75 height=75>
			{else}
				{img user=$aPageDetails suffix='_200' max_width=75 max_height=75 no_link=true is_page_image=true}
			{/if}
		{/if}
	</a>
	<div>		
		<a href="{$aPageDetails.url}" title="{$aPageDetails.title|clean}">{$aPageDetails.title|clean|shorten:20:'...'}</a>
	</div>
</div>
{if is_int($phpfox.iteration.pages/5)}
<div class="clear"></div>
{/if}
{/foreach}
<div class="clear"></div>
{if count($aPageDetails)}
<a href="#" class="pages_profile_view_more" onclick="$('.pages_profile_block').show(); $(this).hide(); return false;">{phrase var='pages.more'}</a>
{/if}