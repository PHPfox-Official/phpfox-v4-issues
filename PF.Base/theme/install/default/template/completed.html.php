<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: completed.html.php 5350 2013-02-13 10:59:22Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="completed_message">
	{if $bIsUpgrade}
	Successfully upgraded to PHPfox version {$sUpgradeVersion}.
	{else}
	Successfully installed PHPfox {$sUpgradeVersion}.
	{/if}
</div>

<a href="./" class="installed_link">View Your Site</a>