<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: default.html.php 5350 2013-02-13 10:59:22Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="nb_message_holder">
	{$sMessage}
	{if isset($sNext)}
	 Please hold...
	<meta http-equiv="refresh" content="2;url={$sNext}" />
	{/if}
</div>

<div class="nb_message_image">
	{img theme='layout/ajax_loader_blue_128.gif'}
</div>