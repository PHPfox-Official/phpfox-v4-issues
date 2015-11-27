<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: upload.html.php 3346 2011-10-24 15:20:05Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $bIsEdit}
<div class="view_item_link">
	<a href="{permalink module='music' id=$aForms.song_id title=$aForms.title}">{phrase var='music.view_song'}</a>
</div>
{/if}

{$sCreateJs}
<div id="js_actual_upload_form">
	{if $bIsEdit}
	<form method="post" action="{url link='music.upload'}">
	<div><input type="hidden" name="id" value="{$aForms.song_id}" /></div>
	<div><input type="hidden" name="upload_via_song" value="1" /></div>
	{else}
	<form method="post" action="{url link='music.upload'}" id="js_music_form" enctype="multipart/form-data" onsubmit="return $Core.music.upload({$sGetJsForm});" target="js_upload_frame">
	{/if}
	{if isset($sModule) && $sModule}
		<div><input type="hidden" name="val[callback_module]" value="{$sModule}" /></div>
	{/if}
	{if isset($iItem) && $iItem}
		<div><input type="hidden" name="val[callback_item_id]" value="{$iItem}" /></div>
	{/if}		
		<div id="js_music_upload_song">
			<div><input type="hidden" name="val[method]" value="{$sMethod}"></div>
			{template file='music.block.upload'}
			{if $bIsEdit}
			<div class="table_clear">
				<input type="submit" value="{phrase var='music.update'}" class="button" />
			</div>			
			{/if}
		</div>
	</form>
</div>