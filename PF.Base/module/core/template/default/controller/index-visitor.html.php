<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Core
 * @version 		$Id: index-visitor.html.php 225 2009-02-13 13:24:59Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{*
{if isset($featured.server_id)}
<div id="main-banner">
	{img server_id=$featured.server_id path='photo.url_photo' file=$featured.destination suffix='_1024'}
</div>
*}
<div id="main-banner">
	<div class="image_load" data-src="{$image.image}"></div>
	<div class="image_info">
		{$image.info}
	</div>
</div>