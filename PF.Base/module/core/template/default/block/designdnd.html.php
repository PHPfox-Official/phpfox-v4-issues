<?php

defined('PHPFOX') or exit('No dice!');
?>
{if $bEnabled == false}
	<a href="#" onclick="$.ajaxCall('core.designdnd', 'enable=1'); return false;"> 
		[ Enable DnD ]
	</a>
{else}
	<a href="#" onclick="$.ajaxCall('core.designdnd', 'enable=0'); return false;"> 
		[ Disable DnD ]
	</a>
{/if}