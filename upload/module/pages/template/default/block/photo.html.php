<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="profile_image">
    <div class="profile_image_holder">
		{if $aPage.is_app}
		{img server_id=$aPage.image_server_id path='app.url_image' file=$aPage.aApp.image_path suffix='_120' max_width='175' max_height='300' title=$aPage.aApp.app_title}
		{else}
			{if Phpfox::getParam('core.keep_non_square_images')}
				{img thickbox=true server_id=$aPage.image_server_id title=$aPage.title path='core.url_user' file=$aPage.image_path suffix='_120' max_width='175' max_height='300'}
			{else}
				{img thickbox=true server_id=$aPage.image_server_id title=$aPage.title path='core.url_user' file=$aPage.image_path suffix='_120_square' max_width='175' max_height='300'}
			{/if}
		{/if}
	</div>
	<div class="profile_no_timeline">

		{if isset($aPage.title)}
		{template file='pages.block.joinpage'}
		{/if}

	</div>
</div>
{if $bCanViewPage}
<div class="sub_section_menu">
	<ul>		
		{foreach from=$aPageLinks item=aPageLink}
			<li class="{if isset($aPageLink.is_selected)} active{/if}">
				<a href="{$aPageLink.url}" class="ajax_link"{if isset($aPageLink.icon)} style="background-image:url('{if isset($aPageLink.icon_pass) && $aPageLink.icon_pass}{img thickbox=true server_id=$aPageLink.icon_server path='pages.url_image' file=$aPageLink.icon suffix='_16' return_url=true}{else}{img theme=$aPageLink.icon' return_url=true}{/if}');"{/if}>{$aPageLink.phrase}{if isset($aPageLink.total)}<span>({$aPageLink.total|number_format})</span>{/if}</a>				
				{if isset($aPageLink.sub_menu) && is_array($aPageLink.sub_menu) && count($aPageLink.sub_menu)}
				<ul>
				{foreach from=$aPageLink.sub_menu item=aProfileLinkSub}
					<li class="{if isset($aProfileLinkSub.is_selected)} active{/if}"><a href="{url link=$aPageLink.url}{$aProfileLinkSub.url}">{$aProfileLinkSub.phrase}{if isset($aProfileLinkSub.total) && $aProfileLinkSub.total > 0}<span class="pending">{$aProfileLinkSub.total|number_format}</span>{/if}</a></li>
				{/foreach}
				</ul>
				{/if}				
			</li>
		{/foreach}
	</ul>
    <div class="clear"></div>
</div>
{/if}
