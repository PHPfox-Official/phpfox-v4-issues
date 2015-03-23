<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: image.html.php 5844 2013-05-09 08:00:59Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="t_center" style="margin-bottom:10px;">
	{img thickbox=true server_id=$aEvent.server_id title=$aEvent.title path='event.url_image' file=$aEvent.image_path suffix='_200' max_width='200' max_height='200' itemprop='image'}
</div>