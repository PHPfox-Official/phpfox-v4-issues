<?php

namespace Api;

class Feed extends \Core\Api {

	/**
	 * @return Feed\Object|Feed\Object[]
	 */
	public function get($params) {

		$feeds = [];
		$isSingle = false;
		if (is_numeric($params)) {
			$id = (int) $params;
			$params = [];
			$params['id'] = $id;
			$isSingle = true;
		}
		$rows = \Feed_Service_Feed::instance()->get($params);

		// d($rows); exit;
		foreach ($rows as $row) {
			$feeds[] = new Feed\Object([
				'id' => $row['feed_id'],
				'item_id' => $row['item_id'],
				'url' => $row['feed_link'],
				'external_url' => (isset($row['feed_link_actual']) ? $row['feed_link_actual'] : ''),
				'title' => $row['feed_title'],
				'description' => $row['feed_content'],
				'time_stamp' => $row['feed_time_stamp'],
				'image' => $row['feed_image'],
				'type' => $row['type_id'],
				'privacy' => $row['privacy'],
				'likes' => $row['feed_total_like'],
				'is_liked' => $row['feed_is_liked'],
				'comments' => $row['total_comment'],
				'user' => $row
			]);
		}

		if ($isSingle) {
			if (!isset($feeds[0])) {
				throw new \Exception('Unable to find this video.');
			}

			$feed = $feeds[0];
			if ($feed instanceof Feed\Object) {
				\Phpfox_Component::setPublicParam('aFeed', [
					'comment_type_id' => $feed->type,
					'privacy' => $feed->privacy,
					'comment_privacy' => $feed->privacy,
					'like_type_id' => $feed->type,
					'feed_is_liked' => $feed->is_liked,
					'item_id' => $feed->item_id,
					'user_id' => $feed->user->id,
					'total_comment' => $feed->comments,
					'total_like' => $feed->likes,
					'feed_link' => $feed->url,
					'feed_title' => $feed->title,
					'feed_display' => 'view',
					'feed_total_like' => $feed->likes,
					'report_module' => $feed->type,
					'report_phrase' => 'Report',
					'time_stamp' => $feed->time_stamp
				]);
			}

			return $feed;
		}

		return $feeds;
	}
}