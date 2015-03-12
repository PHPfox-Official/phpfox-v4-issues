<?php 
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: sponsored.html.php 3214 2011-09-30 12:05:14Z Raymond_Benc $
 */

defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="t_center">
    <a href="{url link='ad.sponsor' view=$aSponsorPhoto.sponsor_id}" title="{$aSponsorPhoto.title|clean}">
	    {img server_id=$aSponsorPhoto.server_id path='photo.url_photo' file=$aSponsorPhoto.destination suffix='_240' max_width=240 max_height=240}
    </a>
</div>