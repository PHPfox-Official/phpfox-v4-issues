<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: profile.html.php 2633 2011-05-30 13:57:44Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="main-photo-albums" data-url="{url link=''$aUser.user_name'.photo.albums'}"></div>
<div id="main-photo-section" style="visibility:hidden;">
	{template file='photo.controller.index'}
</div>
{literal}
<script>
	$Ready(function() {
		var m = $('#main-photo-section'), a = $('#main-photo-albums');
		if (m.length && !a.hasClass('built')) {
			p(a.data('url'));
			$.ajax({
				url: a.data('url'),
				data: 'is_ajax=true',
				success: function(e) {
					p(e);
				}
			});
		}
	});
</script>
{/literal}