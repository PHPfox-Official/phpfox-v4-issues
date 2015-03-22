<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: images.html.php 2817 2011-08-08 16:59:43Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="user_welcome_images">
	{foreach from=$aUserImages name=userimages item=aUserImage}{img user=$aUserImage suffix='_50_square' max_width=50 max_height=50}{/foreach}	
</div>