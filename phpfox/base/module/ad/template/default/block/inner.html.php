<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: inner.html.php 5840 2013-05-09 06:14:35Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $aAd.type_id == 1}
	<a href="{url link='ad' id=$aAd.ad_id}" target="_blank">{img file=$aAd.image_path path='ad.url_image' server_id=$aAd.server_id}</a>
{else}
	{$aAd.html_code}
{/if}
        

{if Phpfox::getParam('ad.ad_ajax_refresh')}
<script type="text/javascript">	
{if $aAd.type_id == 2}
{literal}
window.parent.$(function()
{
	{/literal}			
	if (window.parent.$('#js_ad_space_{$aAd.location}_frame').length > 0)
	{left_curly}
	setTimeout("window.parent.$('#js_ad_space_{$aAd.location}_frame').attr('src', '{url link='ad.iframe' id={$aAd.location}');", ({param var='ad.ad_ajax_refresh_time'} * 60000));
	{right_curly}
	else
	{left_curly}
	setTimeout("window.parent.$('#js_ad_space_{$aAd.location}').html('<iframe allowtransparency=\"true\" id=\"js_ad_space_{$aAd.location}_frame\" frameborder=\"0\" style=\"width:' + window.parent.$('#js_ad_space_{$aAd.location}').width() + 'px; height:' + window.parent.$('#js_ad_space_{$aAd.location}').height() + 'px;\"></iframe>'); window.parent.$('#js_ad_space_{$aAd.location}_frame').attr('src', '{url link='ad.iframe' id={$aAd.location}');", ({param var='ad.ad_ajax_refresh_time'} * 60000));
	{right_curly}		
	{literal}
});
{/literal}
{else}
	setTimeout('$.ajaxCall(\'ad.update\', \'block_id={$aAd.location}\', \'GET\');', ({param var='ad.ad_ajax_refresh_time'} * 60000));
{/if}
</script>
{/if}
{plugin call='ad.template_block_display__end'}