<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 1321 2009-12-15 18:19:30Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if Phpfox::getParam('subscribe.enable_subscription_packages')}
{if count($aPackages)}
{foreach from=$aPackages item=aPackage name=packages}
	{template file='subscribe.block.entry-package'}
{/foreach}
{else}
<div class="extra_info">
	{phrase var='subscribe.no_packages_available'}
</div>
{/if}
{else}
<div class="extra_info">
	{phrase var='subscribe.the_feature_or_section_you_are_attempting_to_use_is_not_permitted_with_your_membership_level'}
</div>
{/if}