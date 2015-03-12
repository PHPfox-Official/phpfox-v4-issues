<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: stat.html.php 2635 2011-06-01 18:58:25Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="info">
	<div class="info_left">
		{phrase var='forum.threads'}:
	</div>
	<div class="info_right">
		{$aStats.thread|number_format}
	</div>
</div>
<div class="info">
	<div class="info_left">
		{phrase var='forum.posts'}:
	</div>
	<div class="info_right">
		{$aStats.post|number_format}
	</div>
</div>