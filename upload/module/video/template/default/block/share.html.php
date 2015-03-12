<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: share.html.php 5588 2013-03-28 09:37:38Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="global_attachment_holder_section" id="global_attachment_video">	
	<div><input type="hidden" name="val[video_inline]" value="1" /></div>
	<div class="table">
		<div class="table_left">
			{phrase var='video.title'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[video_title]" style="width:90%;" id="js_form_video_title" />
		</div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='video.video'}:
		</div>
		<div class="table_right">	
			<div><input type="file" name="video" id="global_attachment_video_file_input" value="" onchange="$bButtonSubmitActive = true; $('.activity_feed_form_button .button').removeClass('button_not_active'); $Core.resetActivityFeedErrorMessage();" /></div>
			<div class="extra_info">
				{phrase var='video.select_a_video_to_attach'}
			</div>
		</div>
	</div>
</div>
{literal}
<script type="text/javascript">
$Behavior.video_block_share_activityfeedcompleted = function()
{
	$ActivityFeedCompleted.resetVideoForm = function()
	{
		$('#js_form_video_title').val('');
		$('#global_attachment_video_file_input').val('');
	}
};
</script>
{/literal}