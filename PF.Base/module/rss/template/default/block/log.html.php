<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: log.html.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aLogs)}
{if isset($bRssIsAdminCp)}
<div class="go_left" style="width:35%;">
	<div class="table_header">
		{phrase var='rss.feed_readers_aggregators_and_web_browsers'}
	</div>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th>{phrase var='rss.reader'}</th>
			<th class="t_center">{phrase var='rss.subscribers'}</th>
		</tr>
	{foreach from=$aLogs name=logs key=iKey item=aLog}
		<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
			<td>{$aLog.user_agent|parse}</td>
			<td class="t_center">{$aLog.total_agent_count}</td>
		</tr>
	{/foreach}
	</table>
</div>
<div class="t_center" style="margin-left:35%;">
	<img src="http://chart.apis.google.com/chart?chs=472x236&amp;chd=t:{$sCounts}&amp;cht=p&amp;chl={$sNames}&amp;chco=195B85" alt="" />
</div>
<div class="clear"></div>

{if count($aUsers)}
<div class="main_break"></div>
<div class="main_break"></div>
{pager}
<div class="table_header">
	{phrase var='rss.subscribers'}
</div>
<table cellpadding="0" cellspacing="0">
	<tr>
		<th>{phrase var='rss.ip_address'}</th>
		<th>{phrase var='rss.reader'}</th>
		<th>{phrase var='rss.date'}</th>
	</tr>
{foreach from=$aUsers name=users key=iKey item=aLog}
	<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
		<td>{$aLog.ip_address|parse}</td>
		<td>{$aLog.user_agent|parse}</td>
		<td>{$aLog.time_stamp|date}</td>
	</tr>
{/foreach}
</table>
{pager}
{/if}

{else}
<div class="t_center">
	<img src="http://chart.apis.google.com/chart?chs=472x236&amp;chd=t:{$sCounts}&amp;cht=p&amp;chl={$sNames}&amp;chco=195B85" alt="" />
</div>
<h3>{phrase var='rss.feed_readers_aggregators_and_web_browsers'}</h3>
{if PHPFOX_IS_AJAX}
<div class="label_flow" style="height:150px;">
{/if}
{foreach from=$aLogs name=logs item=aLog}
<div class="{if is_int($phpfox.iteration.logs/2)}row1{else}row2{/if}{if $phpfox.iteration.logs == 1} row_first{/if}">
	<div class="go_right">
		{$aLog.total_agent_count}
	</div>
	{$aLog.user_agent|parse}
</div>
{/foreach}
{if PHPFOX_IS_AJAX}
</div>
{/if}
{/if}
{else}
<div class="extra_info">
	{phrase var='rss.no_subscribers_found'}
</div>
{/if}