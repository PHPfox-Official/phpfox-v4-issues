<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: build.html.php 2621 2011-05-22 20:09:22Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{foreach from=$aPrivacySettings item=aPrivacySetting}
<div><input type="hidden" name="val{if !empty($sPrivacyArray)}[{$sPrivacyArray}]{/if}[privacy_list][]" value="{$aPrivacySetting.friend_list_id}" class="privacy_list_array" /></div>
{/foreach}