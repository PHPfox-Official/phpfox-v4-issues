<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: stat.html.php 2632 2011-05-26 19:28:02Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="js_photo_average_rating">
	{$sPhotoAverageRating}
	<div class="extra_info">
		{$sPhotoRatingPhrase}
	</div>
</div>
{plugin call='photo.template_block_stat'}