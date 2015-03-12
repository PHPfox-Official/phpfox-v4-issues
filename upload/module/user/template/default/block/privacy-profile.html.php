<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_User
 * @version 		$Id: privacy.html.php 628 2009-06-02 14:06:59Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>		
		{if ($sPrivacy != 'rss.can_subscribe_profile') || !Phpfox::getParam('core.friends_only_community')}
		<div class="table">
			<div class="table_left">
				{$aProfile.phrase}
			</div>
			<div class="table_right">
				<select name="val[privacy][{$sPrivacy}]">
				{if !isset($aProfile.anyone) && !Phpfox::getParam('core.friends_only_community')}					
						<option value="0"{if $aProfile.default == '0'} selected="selected"{/if}>{phrase var='user.anyone'}</option>
				{/if}
				{if !isset($aProfile.no_user)}
					{if !Phpfox::getParam('core.friends_only_community')}
						<option value="1"{if $aProfile.default == '1'} selected="selected"{/if}>{phrase var='user.community'}</option>									
					{/if}
					{if Phpfox::isModule('friend')}
					<option value="2"{if $aProfile.default == '2'} selected="selected"{/if}>{phrase var='user.friends_only'}</option>
					{/if}
				{/if}
					<option value="4"{if $aProfile.default == '4'} selected="selected"{/if}>{phrase var='user.no_one'}</option>
				</select>				
			</div>			
		</div>		
		{/if}