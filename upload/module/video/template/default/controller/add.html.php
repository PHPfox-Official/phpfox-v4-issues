<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 4901 2012-10-17 06:29:50Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $bIsVideoUploading}
<div id="js_upload_video_file">
	{module name='video.file'}
</div>
{else}
<div id="js_upload_video_url">
	{module name='video.url'}
</div>
{/if}