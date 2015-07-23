<?php

namespace Core\View;

class Environment extends \Twig_Environment {
	public function render($name, array $params = array()) {

		$params['ActiveUser'] = (new \Api\User())->get(\Phpfox::getUserId());
		$params['isPager'] = (isset($_GET['page']) ? true : false);
		$params['Is'] = new \Core\Is();

		return $this->loadTemplate($name)->render($params);
	}
}