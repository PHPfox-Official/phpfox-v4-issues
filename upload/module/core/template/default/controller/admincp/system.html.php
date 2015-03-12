<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: system.html.php 982 2009-09-16 08:11:36Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table_header">
	{phrase var='admincp.server_overview'}
</div>
{foreach from=$aStats key=sKey item=sValue}
<div class="table">
	<div class="table_left">
		{$sKey}:
	</div>
	<div class="table_right_text">
		{$sValue}
	</div>
	<div class="clear"></div>
</div>
{/foreach}
<div class="table_clear"></div>