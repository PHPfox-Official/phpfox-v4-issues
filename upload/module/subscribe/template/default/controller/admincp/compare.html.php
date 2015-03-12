<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 
	[feature-id][title]
	[feature-id][package][package-id] = array
	[feature-id][package][package-id][radio] = [0|1|2]
	[feature-id][package][package-id][text] = text
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form action="{url link='admincp.subscribe.compare'}" method="post">
	{template file='subscribe.block.compare'}
	<input type="submit" class="button" value="{phrase var='subscribe.save'}">
</form>