<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: info.html.php 602 2009-05-29 10:52:44Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div style="position:relative;">
	{foreach from=$aInfos key=sPhrase item=sValue}
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