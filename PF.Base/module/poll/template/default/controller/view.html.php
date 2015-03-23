<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Poll
 * @version 		$Id: view.html.php 2501 2011-04-04 20:13:13Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="item_view">
	{template file='poll.block.entry'}
	<div {if $aPoll.view_id == 1}style="display:none;" class="js_moderation_on"{/if}>
	{module name='feed.comment'}
	</div>
</div>