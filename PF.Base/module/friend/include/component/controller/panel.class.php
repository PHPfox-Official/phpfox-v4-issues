<?php

class Friend_Component_Controller_Panel extends Phpfox_Component {
	public function process() {
		Phpfox::isUser(true);

		list($iCnt, $aFriends) = Friend_Service_Request_Request::instance()->get(0, 100);
		foreach ($aFriends as $key => $friend) {
			if ($friend['relation_data_id']) {
				$sRelationShipName = Custom_Service_Relation_Relation::instance()->getRelationName($friend['relation_id']);
        if (!empty($sRelationShipName)){
          $aFriends[$key]['relation_name'] = $sRelationShipName;
        } else {
          //This relationship was removed
          unset($aFriends[$key]);
        }
			}
		}
		$this->template()->assign([
			'aFriends' => $aFriends
		]);
	}
}