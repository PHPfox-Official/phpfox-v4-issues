<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: my.html.php 2322 2011-03-02 11:00:01Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="video_user_link_holder"><a href="#" class="video_user_link" rel="{$aVideo.user_id}"><span>{$aVideo.full_name}</span>: {$aVideo.total_user_videos|number_format} Videos</a></div>
<div class="video_user_bar"><div class="video_user_bar_loader">Loading...</div></div>