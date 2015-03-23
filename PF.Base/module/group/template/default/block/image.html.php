<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: image.html.php 829 2009-08-02 18:45:42Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !empty($aGroup.image_path)}
<div class="t_center" style="margin-bottom:10px;">
	{img thickbox=true server_id=$aGroup.server_id title=$aGroup.title path='group.url_image' file=$aGroup.image_path suffix='_200' max_width='200' max_height='200'}
</div>
{/if}