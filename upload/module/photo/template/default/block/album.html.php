<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: album.html.php 2724 2011-07-13 13:25:44Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $bAllowedAlbums}
<script type="text/javascript">
{literal}
	function addNewAlbum()
	{
	{/literal}
		if ({$sGetJsForm})
	{literal}
		{
			$('#js_create_new_album').ajaxCall('photo.addAlbum');	
		}
		
		return false;
	}
{/literal}
</script>
{$sCreateJs}
<div class="main_break"></div>
<form method="post" action="{url link='current'}" id="js_create_new_album" onsubmit="return addNewAlbum();">
	{if $sModule}
		<div><input type="hidden" name="val[module_id]" value="{$sModule}" /></div>
	{/if}
	{if $iItem}
		<div><input type="hidden" name="val[group_id]" value="{$iItem}" /></div>		
	{/if}	
	<div id="js_custom_privacy_input_holder_album"></div>
	{template file='photo.block.form-album'}
	<div class="table_clear">
		<input type="submit" value="{phrase var='photo.submit'}" class="button" />
	</div>
	{if Phpfox::getParam('core.display_required')}
	<div class="table_clear">
		{required} {phrase var='core.required_fields'}
	</div>
	{/if}	
</form>
{else}
{phrase var='photo.you_have_reached_your_limit_you_are_currently_unable_to_create_new_photo_albums'}
{/if}