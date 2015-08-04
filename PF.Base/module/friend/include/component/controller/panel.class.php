<?php

class Friend_Component_Controller_Panel extends Phpfox_Component {
	public function process() {
		Phpfox::isUser(true);

		list($iCnt, $aFriends) = Friend_Service_Request_Request::instance()->get(0, 100);
		foreach ($aFriends as $key => $friend) {
			if ($friend['relation_data_id']) {
				$aFriends[$key]['relation_name'] = Custom_Service_Relation_Relation::instance()->getRelationName($friend['relation_id']);
			}
		}
		$this->template()->assign([
			'aFriends' => $aFriends
		]);
	}
}