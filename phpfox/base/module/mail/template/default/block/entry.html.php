<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Mail
 * @version 		$Id: view.html.php 3369 2011-10-28 16:04:06Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="mail_thread_holder{if $aMail.user_id == Phpfox::getUserId()} is_user{/if}">
	{if !defined('PHPFOX_IS_ADMIN_NEW')}
	<div class="mail_user_image">
		{img user=$aMail suffix='_50_square' max_width=50 max_height=50}
	</div>
	{/if}
	<div class="mail_content">
		<div class="mail_time_stamp">
			{$aMail.time_stamp|convert_time}
		</div>
		<div class="mail_thread_user">
			{$aMail|user}
		</div>
		<div class="mail_text">
			{$aMail.text|parse}
		</div>
	</div>
</div>