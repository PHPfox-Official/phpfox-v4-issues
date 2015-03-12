<?php

defined('PHPFOX') or exit('No dice!');
?>
{foreach from=$aPokes item=aPoke}
<div class="p_bottom_10" id="poke_{$aPoke.user_id}" style="position:relative;">
	<div style="position:absolute; right:0px;" class="delete_btn" onclick="$.ajaxCall('poke.ignore', 'user_id={$aPoke.user_id}', 'GET');">&nbsp;</div>
	{$aPoke|user} - <span class="extra_info_link"><a href="#" onclick="$.ajaxCall('poke.dopoke', 'user_id={$aPoke.user_id}&amp;type=1', 'GET'); return false;">{phrase var='poke.poke_back'}</a></span>
</div>
{/foreach}
{if $iTotalPokes > 5 && !PHPFOX_IS_AJAX}
<div class="bottom">
	<ul>
		<li><a href="#" onclick="$.ajaxCall('poke.viewMore', '', 'GET'); return false;">{phrase var='poke.view_more_total' total=$iTotalPokes}</a></li>
	</ul>
</div>
{/if}