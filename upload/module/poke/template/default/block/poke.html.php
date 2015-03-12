<?php

defined('PHPFOX') or exit('No dice!');
?>

<div id="poke_{$aUser.user_id}_image" class="go_left">
	{if Phpfox::isMobile()}
	{img user=$aUser suffix='_50_square' max_width=50 max_height=50 class='v_middle'} 
	{else}
	{img user=$aUser suffix='_120_square' max_width=120 max_height=120 class='v_middle'} 
	{/if}
</div>
<div id="poke_{$aUser.user_id}_content">
	{phrase var='poke.you_are_about_to_poke_full_name' full_name=$aUser.full_name}
	<br />
	<br />
	<input type="button" class="button" onclick="$.ajaxCall('poke.doPoke', 'user_id={$aUser.user_id}', 'GET');tb_remove();" value="{phrase var='poke.poke' full_name=''}">
</div>
<div class="clear"></div>