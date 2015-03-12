<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: detail.html.php 4158 2012-05-11 19:00:36Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{foreach from=$aPhotoDetails name=photodetails key=sKey item=sValue}
<div class="info">
	<div class="info_left">
		{$sKey}:
	</div>	
	<div class="info_right">
		{$sValue}
	</div>	
</div>
{/foreach}