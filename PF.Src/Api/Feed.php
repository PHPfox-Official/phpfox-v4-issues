<?php

namespace Api;

class Feed extends \Core\Api {

	public function put($id) {
		$this->requires([
			'content'
		]);

		$content = $this->request->get('content');
		if (!is_string($content)) {
			$content = json_encode($content);
		}
		$this->db->update(':feed', ['content' => $content], ['feed_id' => $id]);

		return $this->get($id);
	}

	/**
	 * @return Feed\Object|Feed\Object
	 */
	public function post($post = []) {
		if ($post) {
			$this->assign($post);
		}
		$this->auth();
		$this->requires([
			'type_id',
			'content'
		]);

		// (new \Api\User())->get($this->request->get('user_id'));

		if (!$this->request->get('content')) {
			throw error('Add some content.');
		}

		$content = $this->request->get('content');
		if (!is_string($content)) {
			$content = json_encode($content);
		}

		$feedId = \Feed_Service_Process::instance()->add([
			'type_id' => $this->request->get('type_id'),
			'content' => $content
		]);

		return $this->get($feedId);
	}

	/**
	 * @return Feed\Object|Feed\Object[]
	 */
	public function get($params = null) {
		$this->auth();

		$feeds = [];
		$isSingle = false;
		if (is_numeric($params)) {
			$id = (int) $params;

			$params = [];
			$params['id'] = $id;
			$isSingle = true;
		}
		else if (is_string($params)) {
			$type = $params;
			$params = [];
			$params['type_id'] = $type;
		}

		if (isset($_GET['page'])) {
			$params['page'] = $_GET['page'];
		}

		if (isset($_GET['limit'])) {
			$params['limit'] = $_GET['limit'];
		}

		$params['is_api'] = true;
		$rows = \Feed_Service_Feed::instance()->get($params);

		// d($rows); exit;
		foreach ($rows as $row) {
			$object = [
				'id' => (int) $row['feed_id'],
				'content' => $row['content'],
				'total_likes' => (int) $row['feed_total_like'],
				'total_comments' => (int) (isset($row['total_comment']) ? $row['total_comment'] : 0),
				'user' => $row
			];

			if ($row['type_id'] != 'app') {
				$object['custom'] = [
					'item_id' => $row['item_id'],
					'url' => $row['feed_link'],
					'external_url' => (isset($row['feed_link_actual']) ? $row['feed_link_actual'] : ''),
					'title' => $row['feed_title'],
					'description' => (isset($row['feed_content']) ? $row['feed_content'] : null),
					'time_stamp' => $row['feed_time_stamp'],
					'image' => (isset($row['feed_image']) ? $row['feed_image'] : null),
					'type' => $row['type_id'],
					'privacy' => $row['privacy'],
					'likes' => $row['feed_total_like'],
					'is_liked' => $row['feed_is_liked'],
					'comments' => (isset($row['total_comment']) ? $row['total_comment'] : 0),
				];
			}

			$feeds[] = new Feed\Object($object);
		}

		if ($isSingle) {
			if (!isset($feeds[0])) {
				throw new \Exception('Unable to find this feed.');
			}

			$feed = $feeds[0];
			if (!$this->isApi() && $feed instanceof Feed\Object) {
				\Phpfox_Component::setPublicParam('aFeed', [
					'comment_type_id' => 'app',
					'privacy' => $feed->custom->privacy,
					'comment_privacy' => $feed->custom->privacy,
					'like_type_id' => 'app',
					'feed_is_liked' => $feed->custom->is_liked,
					'item_id' => $feed->custom->item_id,
					'user_id' => $feed->user->id,
					'total_comment' => $feed->custom->comments,
					'total_like' => $feed->custom->likes,
					'feed_link' => $feed->custom->url,
					'feed_title' => $feed->custom->title,
					'feed_display' => 'view',
					'feed_total_like' => $feed->custom->likes,
					'report_module' => $feed->custom->type,
					'report_phrase' => 'Report',
					'time_stamp' => $feed->custom->time_stamp
				]);
			}

			return $feed;
		}

		return $feeds;
	}
}