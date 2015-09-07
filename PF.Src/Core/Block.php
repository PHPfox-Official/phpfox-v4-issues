<?php

namespace Core;

/**
 * Class Block
 * @package Core
 *
 * @method Block title($title)
 * @method Block content($content)
 */
class Block {
	public $db;
	public $request;
	public $url;
	public $active;

	private $_arg = [];

	public function __construct($controller, $location, $callback) {
		$this->request = new Request();
		$this->url = new Url();
		$this->active = (new \Api\User())->get(\Phpfox::getUserId());
		$this->db = new Db();

		/*
		$html = call_user_func($callback, $this);
		if (empty($html)) {
			$html = '
			<div class="block">
				' . (isset($this->_arg['title']) ? '<div class="title">' . $this->_arg['title'] . '</div>' : '') . '
				<div class="content">
					' . (isset($this->_arg['content']) ? $this->_arg['content'] : '') . '
				</div>
			</div>
			';
		}
		*/

		\Phpfox_Module::instance()->block($controller, $location, $callback, $this);
	}

	public function get($arg) {
		if (!isset($this->_arg[$arg])) {
			return '';
		}
		return $this->_arg[$arg];
	}

	public function __call($method, $args) {
		if ($method == 'content' && PHPFOX_IS_AJAX_PAGE) {
			echo $args[0];
			return;
		}

		$this->_arg[$method] = $args[0];
	}
}