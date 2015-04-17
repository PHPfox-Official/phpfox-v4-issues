<?php

namespace Api;

class Comment extends \Core\Api {
	public function post($appId, $itemId) {
		return \Comment_Service_Process::instance()->add([
			'parent_id' => 0,
			'type' => $appId,
			'item_id' => $itemId,
			'comment_user_id' => 0,
			'text' => $this->request->get('comment')
		]);
	}
}