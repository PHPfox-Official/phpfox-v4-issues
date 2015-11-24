<?php

defined('PHPFOX') or exit('NO DICE!');

class Pages_Component_Controller_All extends Phpfox_Component {
  public function process() {
    $aUser = $this->getParam('aUser');
    list($iTotal, $aPages) = Phpfox::getService('pages')->getForProfile($aUser['user_id']);
    if (!$iTotal) {
      return false;
    }
    $this->template()->assign(array(
        'aPagesList' => $aPages,
      )
    );
  }

  public function clean() {
    (($sPlugin = Phpfox_Plugin::get('pages.component_block_profile_clean')) ? eval($sPlugin) : false);
  }
}