<?php

defined('PHPFOX') or exit('No dice!');
?>

<div id="poke_{$aUser.user_id}_image" class="go_left">
	{img user=$aUser suffix='_50_square' max_width=50 max_height=50 class='v_middle'}
</div>
<div id="poke_{$aUser.user_id}_content">
	{phrase var='poke.you_are_about_to_poke_full_name' full_name=$aUser.full_name}
</div>
<div class="clear"></div>
<div class="p_top_15">
	<div class="table_clear">
		<input type="button" class="button" onclick="$.ajaxCall('poke.doPoke', 'user_id={$aUser.user_id}', 'GET');tb_remove();" value="{phrase var='poke.poke' full_name=''}">
	</div>
</div>