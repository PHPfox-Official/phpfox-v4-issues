<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: parent.html.php 1174 2009-10-11 13:56:13Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aPhotos)}
{template file='photo.block.new'}
{else}
<div class="extra_info">
	{phrase var='photo.no_photos_added_yet'}
	<ul>
		<li><a href="{url link='photo.upload' module='group' item=$aGroup.group_id}">{phrase var='photo.click_here_to_upload_a_photo'}</a></li>
	</ul>
</div>
{/if}