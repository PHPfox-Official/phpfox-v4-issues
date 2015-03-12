<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: activity.html.php 4631 2012-09-13 11:59:05Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div style="position:relative;">
	{foreach from=$aActivites key=sPhrase item=sValue}
	<div class="info">
		<div class="info_left">
			{$sPhrase}:
		</div>	
		<div class="info_right">
			{$sValue}
		</div>	
	</div>
	{/foreach}
</div>