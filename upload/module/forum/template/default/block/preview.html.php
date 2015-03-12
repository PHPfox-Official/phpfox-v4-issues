<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Forum
 * @version 		$Id: preview.html.php 296 2009-03-20 08:02:22Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	<div class="forum_outer">
		<div class="forum_user_info">
			<div>
				{$aPost|user}
			</div>		
		</div>
		<div class="forum_main" style="position:relative;">
			<div class="forum_header">
				{$aPost.time_stamp|date:'forum.forum_time_stamp'}		
			</div>
			<div class="forum_content">
				{$aPost.text|parse}
			</div>
		</div>
	</div>