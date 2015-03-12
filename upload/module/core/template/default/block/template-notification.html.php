<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: template-notification.html.php 2838 2011-08-16 19:09:21Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<ul>
									{if Phpfox::getUserBy('profile_page_id') <= 0}
									{if Phpfox::isModule('friend')}
									{module name='friend.notify'}
									{/if}
									{if Phpfox::isModule('mail')}
									{module name='mail.notify'}
									{/if}
									{/if}
									{if Phpfox::isModule('notification')}
									{module name='notification.notify'}
									{/if}
</ul>