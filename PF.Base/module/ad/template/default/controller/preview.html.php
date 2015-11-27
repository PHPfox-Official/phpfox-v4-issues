<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: preview.html.php 5538 2013-03-25 13:20:22Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div style="padding:10px;">
	<div id="js_preview_data"></div>
</div>
{literal}
<script type="text/javascript">
	$Behavior.ad_preview_1 = function()
	{
		$('#js_preview_data').html(window.opener.$('#html_code').val());
	};
</script>
{/literal}