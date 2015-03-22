<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: genre-form.html.php 2217 2010-11-29 12:33:01Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="js_genre_update_form">
	<form method="post" action="#" onsubmit="$('#js_updating_genre').show(); $(this).ajaxCall('music.updateUserGenre'); return false;">
		<div class="message">
			{phrase var='music.please_select_a_genre_for_your_music'}
		</div>
		{module name='music.genre'}
		<div class="table_clear">
			<input type="submit" value="{phrase var='music.update'}" class="button" /> <span id="js_updating_genre" style="display:none;">{img theme='ajax/small.gif' class='v_middle'}</span>
		</div>
		<div class="extra_info">
			{phrase var='music.note_that_you_can_edit_your_genre' link=$sProfileEditLink}
		</div>
	</form>
</div>