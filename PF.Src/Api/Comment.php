<?php

namespace Api;

class Comment extends \Core\Api {
	public function post() {
		$this->auth();
		$this->requires([
			'comment',
			'feed_id'
		]);

		return \Comment_Service_Process::instance()->add([
			'parent_id' => 0,
			'type' => 'app',
			'item_id' => $this->request->get('feed_id'),
			'comment_user_id' => 0,
			'text' => $this->request->get('comment')
		]);
	}

	public function get($feedId = null) {
		if (!$feedId) {
			$feedId = $this->request->get('feed_id');
			$object = [];
			list($total, $comments) = \Comment_Service_Comment::instance()->get('cmt.*', [
				'cmt.type_id = \'app\' AND cmt.item_id = \'' . (int) $feedId . '\''
			]);

			foreach ($comments as $comment) {
				$object[] = new Comment\Object($comment);
			}
		}
		else {
			$comment = \Comment_Service_Comment::instance()->getComment($feedId);
			$object = new Comment\Object($comment);
		}

		return $object;
	}

	public function delete($commentId) {
		return \Comment_Service_Process::instance()->delete($commentId);
	}
}