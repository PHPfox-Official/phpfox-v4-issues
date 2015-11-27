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
		<div class="table">
			<div class="table_left">
				{$aNotification.phrase}
			</div>
			<div class="table_right">			
				<div class="item_is_active_holder">	
					<span class="js_item_active item_is_active"><input type="radio" value="0" name="val[notification][{$sNotification}]" {if $aNotification.default} checked="checked"{/if} class="checkbox" /> {phrase var='user.yes'}</span>
					<span class="js_item_active item_is_not_active"><input type="radio" value="1" name="val[notification][{$sNotification}]" {if !$aNotification.default} checked="checked"{/if} class="checkbox" /> {phrase var='user.no'}</span>
				</div>
			</div>
		</div>