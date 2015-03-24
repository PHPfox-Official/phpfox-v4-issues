<?php

namespace Core\View;

class Loader extends \Twig_Loader_Filesystem {
	public function getSource($name) {
		if ($name == '@Base/layout.html') {
			$Theme = \Phpfox_Template::instance()->theme()->get();
			$Service = new \Core\Theme\Service($Theme);

			return $Service->html()->get();
		}

		return parent::getSource($name);
	}
}