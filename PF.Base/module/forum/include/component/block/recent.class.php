<?php

class Forum_Component_Block_Recent extends Phpfox_Component {
	public function process() {
		if ($this->request()->segment(2) == 'search') {
			return false;
		}
		$title = '';
		$threads = [];
		$type = 'threads';
		if (Phpfox_Module::instance()->getFullControllerName() == 'forum.forum') {
			$title = 'Recent Posts';
			$threads = Forum_Service_Post_Post::instance()->getRecentForForum($this->request()->segment(2));
			$type = 'posts';
		}
		else {
			$title = 'Recent Discussions';
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
		}

		$this->template()->assign([
			'sHeader' => $title,
			'threads' => $threads,
			'type' => $type
		]);

		return 'block';
	}
}