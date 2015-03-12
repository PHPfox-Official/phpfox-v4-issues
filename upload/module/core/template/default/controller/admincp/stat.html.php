<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: stat.html.php 4095 2012-04-16 13:29:01Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !empty($sStartTime)}
Viewing stats from <strong>{$sStartTime}</strong> until <strong>{$sEndTime}</strong>.
{/if}
<table id="js_core_site_stat" cellpadding="0" cellspacing="0">
<tr>
	<th>{phrase var='core.name'}</th>
	<th>{phrase var='core.total'}</th>
	<th>{phrase var='core.daily_average'}</th>
</tr>
{if empty($aStats)}
<tr id="js_core_site_stat_build">
	<td colspan="3">
		{phrase var='core.building_site_stats_please_hold'}
		<script type="text/javascript">
			{literal}
			$Behavior.buildCoreSiteStats = function(){
				$.ajaxCall('core.buildStats', '', 'GET');
			}
			{/literal}
		</script>
	</td>
</tr>
{else}
{foreach from=$aStats name=stats item=aStat}
{template file='core.block.admin-stattr'}
{/foreach}
{/if}
</table>