<?php
defined('PHPFOX') or exit('NO DICE!');

class Profile_Component_Controller_Points extends Phpfox_Component {
  /**
   * Controller
   */
  public function process() {
    $userName = Phpfox::getUserBy('user_name');
    if ($userName != $this->request()->get('req1')){
      $this->url()->send($userName);
    }
    $aUser = Phpfox::getService('user')->get(Phpfox::getUserId(), true);
    $aModules = Phpfox::massCallback('getDashboardActivity');
    $aActivites = array(
      Phpfox::getPhrase('core.total_items') => $aUser['activity_total'],
      Phpfox::getPhrase('core.activity_points') => $aUser['activity_points'] . (Phpfox::getParam('user.can_purchase_activity_points') ? '<span id="purchase_points_link">(<a href="#" onclick="$Core.box(\'user.purchasePoints\', 500); return false;">' . Phpfox::getPhrase('user.purchase_points') . '</a>)</span>' : ''),
    );
    foreach ($aModules as $aModule) {
      foreach ($aModule as $sPhrase => $sLink) {
        $aActivites[$sPhrase] = $sLink;
      }
    }
    $this->template()
      ->setBreadCrumb(Phpfox::getPhrase('profile.activity_points'))
      ->setTitle(Phpfox::getPhrase('profile.activity_points'))
      ->assign(array(
        'aActivites' => $aActivites
      )
    );
  }

  public function clean() {
    (($sPlugin = Phpfox_Plugin::get('profile.component_controller_points_clean')) ? eval($sPlugin) : false);
  }
}