<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: message.html.php 3344 2011-10-24 14:21:16Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="js_im_latest_message">
	{foreach from=$aMessages item=aMessage name=messages}
		{template file='im.block.text'}			
	{/foreach}
	<div id="js_latest_message"></div>		
	{if !$bLoggedIn}
	<div class="error_message">
		{phrase var='im.member_is_offline'}
	</div>
	{/if}
</div>