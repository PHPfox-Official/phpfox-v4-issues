<?php
$aUser = $this->getVar('aUser');
echo '<div class="info">';
echo '<div class="info_left">Space Usage PHP:</div><div class="info_right">' . Phpfox::getLib('phpfox.file')->filesize($aUser['space_total']) . '</div>';
echo '</div>';
?>