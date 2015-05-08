<?php

class Forum_Component_Controller_Recent extends Phpfox_Component {
	public function process() {
		header('Content-type: application/javascript');
		$ids = [];
		$forums = Forum_Service_Forum::instance()->getForums();
		foreach ($forums as $forum) {
			$ids[] = $forum['forum_id'];

			$childs = Forum_Service_Forum::instance()->id($forum['forum_id'])->getChildren();
			if ($childs) {
				foreach ($childs as $id) {
					$ids[] = $id;
				}
			}
		}

		$cond[] = 'ft.forum_id IN(' . implode(',', $ids) . ') AND ft.group_id = 0 AND ft.view_id >= 0';
		list($cnt, $threads) = Forum_Service_Thread_Thread::instance()
			->get($cond, 'ft.time_update DESC', 0, 20);
		$json = [];
		foreach ($threads as $thread) {
			$json[] = (object) [
				'thread_id' => $thread['thread_id'],
				'title' => $thread['title'],
				'permalink' => Phpfox::permalink('forum.thread', $thread['thread_id'], $thread['title']),
				'user' => htmlspecialchars($thread['full_name']),
				'created' => Phpfox::getLib('date')->convertTime($thread['time_stamp'])
			];
		}

		echo ';function __Threads(callback) { var threads = ' . json_encode($json) . '; if (typeof(callback) == \'function\') { callback(threads); } };';
		exit;
	}
}