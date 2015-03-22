<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: private.html.php 5074 2012-12-06 10:37:26Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !Phpfox::isMobile()}
{if !Phpfox::getService('profile')->timeline()}
<div class="go_left t_center" style="width:125px;">
	{img user=$aUser suffix='_120' max_width='120' max_height='120'}
</div>
<div style="margin-left:125px;">
{/if}
{/if}
	<div class="extra_info">
		{phrase var='profile.profile_is_private'}
	</div>
{if !Phpfox::isMobile()}
{if !Phpfox::getService('profile')->timeline()}
</div>
<div class="clear"></div>
{/if}
{/if}