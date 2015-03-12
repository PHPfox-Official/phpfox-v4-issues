<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Display the image details when viewing an image.
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_User
 * @version 		$Id: detail.class.php 254 2009-02-23 12:36:20Z Miguel_Espinoza $
 */

?>
<div class="message" style="margin-top:5px; font-weight:normal;">
	<div class="error_message">
		{phrase var='user.username_is_not_available_here_are_other_suggestions_you_may_like'}
	</div>
	<ul class="action">
	{foreach from=$aNames name=sUser item=sItem}
		<li><a href="#" id="js_suggested_name" onclick="$Core.registration.useSuggested(this); return false;">{$sItem}</a></li>
	{/foreach}
	</ul>
</div>