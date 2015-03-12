<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Request
 * @version 		$Id: index.html.php 1300 2009-12-07 00:39:10Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="js_request_data">
	{plugin call='request.template_controller_index'}
</div>
{literal}
<script type="text/javascript">
	function requestCheckData()
	{
		if ($('#js_request_data').html().replace(/^\s+|\s+$/g, '') == '')
		{
			{/literal}
			$('#js_request_data').html('<div class="extra_info">{phrase var='request.there_are_no_new_requests' phpfox_squote=true}</a>');
			{literal}
		}
	}
	requestCheckData();
</script>
{/literal}