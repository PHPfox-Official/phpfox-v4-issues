<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: share.html.php 2525 2011-04-13 18:03:20Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="main_break"></div>
{if PHPFOX_IS_AJAX}
<div id="js_video_done" style="display:none;">
	<div class="valid_message">
		{phrase var='video.video_successfully_added'}
	</div>
</div>
{/if}
<div id="js_video_error" class="error_message" style="display:none;"></div>
<form method="post" action="{url link='video.share'}"{if PHPFOX_IS_AJAX} onsubmit="$(this).ajaxCall('video.addShare' {if defined('PHPFOX_GROUP_VIEW')}, 'bIsGroup=true'{/if}); return false;"{/if}>
	{if $sModule}
		<div><input type="hidden" name="val[module]" value="{$sModule}" /></div>
	{/if}
	{if $iItem}
		<div><input type="hidden" name="val[item]" value="{$iItem}" /></div>
	{/if}	
	{if !empty($sEditorId)}
		<div><input type="hidden" name="editor_id" value="{$sEditorId}" /></div>
	{/if}
	<div class="table">
		<div class="table">
			<div class="table_left">
			{required}<label for="category">{phrase var='video.category'}:</label>
			</div>
			<div class="table_right">
				{$sCategories}
			</div>
		</div>	
		<div class="table_left">
			{phrase var='video.video_url'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[url]" value="{value type='input' id='url'}" size="40" style="width:90%;" />
			<div class="extra_info">
			{*
				{phrase var='video.supported_sites'}: {$sSites|shorten:50:'View More Sites':true}
			*}
				Click <a href="#" onclick="$Core.box('video.supportedSites', 600); return false;">here</a> to view a list of supported sites you can import videos from.
			</div>
		</div>
	</div>	
	
	{if Phpfox::isModule('privacy')}
	<div class="table">
		<div class="table_left">
			{phrase var='blog.privacy'}:
		</div>
		<div class="table_right">	
			{module name='privacy.form' privacy_name='privacy' privacy_info='Control who can see this blog.'}
		</div>			
	</div>
	{/if}
		
	{if Phpfox::isModule('comment') && Phpfox::isModule('privacy')}
	<div class="table">
		<div class="table_left">
			Comment Privacy:
		</div>
		<div class="table_right">	
			{module name='privacy.form' privacy_name='privacy_comment' privacy_info='Control who can comment on this blog.' privacy_no_custom=true}
		</div>			
	</div>
	{/if}		
	
	<div class="table_clear">
		<input type="submit" value="{phrase var='video.add'}" class="button" />
	</div>
</form>