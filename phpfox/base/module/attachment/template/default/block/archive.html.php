<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Attachment
 * @version 		$Id: archive.html.php 2196 2010-11-22 15:22:30Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="label_flow" style="height:200px;">
{if $sUsage > 0}
<div class="extra_info" style="text-align:right;">
	{phrase var='attachment.usage'}: {$sUsage|filesize}
</div>
{/if}
<ul class="defaultList">
{template file='attachment.block.current'}
</ul>
{pager}
<script type="text/javascript">$Core.loadInit();</script>