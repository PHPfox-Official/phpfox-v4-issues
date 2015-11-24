<?php
  defined('PHPFOX') or exit('NO DICE!');
?>
<div class="user_rows_mini">
  {foreach from=$aPagesList name=pages item=aUser}
    {template file='user.block.rows'}
  {/foreach}
</div>