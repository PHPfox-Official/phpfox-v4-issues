<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 1124 2009-10-02 14:07:30Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{phrase var='favorite.successfully_added_to_your_favorites'}
<ul class="action">
	<li><a href="{url link='profile.favorite'}">{phrase var='favorite.view_your_favorites'}</a></li>
	<li><a href="#" onclick="tb_remove(); return false;">{phrase var='favorite.close'}</a></li>
</ul>