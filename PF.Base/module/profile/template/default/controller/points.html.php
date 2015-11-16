<?php
defined('PHPFOX') or exit('NO DICE!');

?>
<div class="_block_h1"><h1>
    <a href="{url link='current'}">
      {phrase var='profile.activity_points'}
    </a>
  </h1>
</div>
<div id="profile_activity_points_block">
  {foreach from=$aActivites key=sPhrase item=sValue}
  <div class="info">
    <div class="info_left">
      {$sPhrase}:
    </div>
    <div class="info_right">
      {$sValue}
    </div>
  </div>
  {/foreach}
</div>