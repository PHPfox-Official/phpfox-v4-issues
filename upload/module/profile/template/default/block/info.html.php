<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Profile
 * @version 		$Id: info.html.php 3335 2011-10-20 17:26:57Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !PHPFOX_IS_AJAX}
<div id="js_basic_info_data">
{/if}
{if !Phpfox::isMobile() && Phpfox::isModule('rate') && Phpfox::getParam('profile.can_rate_on_users_profile') && Phpfox::getService('user.privacy')->hasAccess('' . $aUser.user_id . '', 'rate.can_rate')}
	<div class="info">
		<div class="info_left">
			{phrase var='profile.rating'}:
		</div>	
		<div class="info_right">
			{module name='rate.display'}
		</div>	
	</div>
{/if}	
	{if Phpfox::getParam('user.enable_relationship_status') && $sRelationship != ''}
	<div class="info">
	    <div class="info_left">
		{phrase var='profile.relationship_status'}:
	    </div>
	    <div class="info_right">
		{$sRelationship}
	    </div>
	</div>
	{/if}
	{foreach from=$aUserDetails key=sKey item=sValue}
	{if !empty($sValue)}
	<div class="info">
		<div class="info_left">
			{$sKey}:
		</div>	
		<div class="info_right">
			{if Phpfox::isMobile()}{$sValue|strip_tags}{else}{$sValue}{/if}
		</div>	
	</div>
	{/if}
	{/foreach}
	{module name='custom.display' type_id='user_panel' template='info'}
	{plugin call='profile.template_block_info'}
{if !PHPFOX_IS_AJAX}
</div>
<div id="js_basic_info_form"></div>
{/if}