<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: warning.html.php 1953 2010-10-27 14:10:41Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{phrase var='photo.the_photo_you_are_about_to_view_may_contain_nudity_sexual_themes_violence_gore_strong_language_or_ideologically_sensitive_subject_matter'}
<p>
	{phrase var='photo.would_you_like_to_view_this_image'}
</p>
<ul class="action">
	<li><a href="{$sLink}">{phrase var='photo.yes'}</a></li>
	<li><a href="#" onclick="tb_remove(); return false;">{phrase var='photo.no_thanks'}</a></li>
</ul>