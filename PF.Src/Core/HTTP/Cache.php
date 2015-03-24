<?php

namespace Core\HTTP;

class Cache {
	private $_request;
	private $_cache;

	public function __construct() {
		$this->_request = \Phpfox_Request::instance();
		$this->_cache = new \Core\Cache();
	}

	public function cacheId() {
		$id = $this->_request->uri();

		return 'request_is_cached_' . md5($id . \Phpfox::internalVersion());
	}

	public function checkCache() {
		return false;

		if (($cache = $this->_cache->get($this->cacheId())) && $this->cache($cache['type'], $cache['modified'], $cache['days'])) {
			header('IS-FROM-CACHE: 1');
			exit;
		}
	}

	public function cache($type, $modified, $days) {
		$id = $this->_request->uri();
		$expires = 60 * 60 * 24 * $days;

		header('Pragma: public');
		header('Cache-Control: max-age=' . $expires);
		header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . ' GMT');
		header('Content-Type: ' . $type);

		$last_modified  = $modified;
		$modified_since = ( isset( $_SERVER["HTTP_IF_MODIFIED_SINCE"] ) ? strtotime( $_SERVER["HTTP_IF_MODIFIED_SINCE"] ) : false );
		$etagHeader     = ( isset( $_SERVER["HTTP_IF_NONE_MATCH"] ) ? trim( $_SERVER["HTTP_IF_NONE_MATCH"] ) : false );
		$etag = sprintf('"%s-%s"', $last_modified, md5($id));

		header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $last_modified) . ' GMT');
		header('Etag: ' . $etag);

		$key = $this->cacheId();
		if ((int) $modified_since === (int) $last_modified && $etag === $etagHeader && $this->_cache->get($key)) {
			// header('HTTP/1.1 304 Not Modified');

			// return true;
		}

		$this->_cache->set($key, [
			'type' => $type,
			'modified' => $modified,
			'days' => $days,
			'created' => PHPFOX_TIME
		]);

		return false;
	}
}