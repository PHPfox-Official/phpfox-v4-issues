<?php

return function(Phpfox_Installer $Installer) {
  //https://github.com/moxi9/phpfox/issues/633
  $Installer->db->query("UPDATE ". Phpfox::getT('setting') ." SET `module_id` = 'user' WHERE `group_id` = 'registration' AND `var_name`='global_genders';");

  $Installer->db->query("DELETE FROM " . Phpfox::getT('setting') . " WHERE `module_id`='friend' AND `var_name`='birthdays_cache_time_out';");
  $Installer->db->query("DELETE FROM " . Phpfox::getT('user_group_setting') . " WHERE `module_id`='photo' AND `name`='can_rate_on_photos';");
  //Make bootstrap theme
  $iCnt = $Installer->db->select('COUNT(*)')
    ->from(':theme')
    ->where('name="bootstrap" OR folder="bootstrap"')
    ->count();
  if ($iCnt == 0 || empty($iCnt)){
    $Theme = new Core\Theme();
    $Theme->make([
      'name' => 'Bootstrap'
    ], null, false, 'bootstrap');
  }

};