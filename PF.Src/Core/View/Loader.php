<?php

namespace Core\View;

class Loader extends \Twig_Loader_Filesystem {
	public function getSource($name) {
		if ($name == '@Theme/layout.html') {
			$Theme = \Phpfox_Template::instance()->theme()->get();
			$Service = new \Core\Theme\Service($Theme);

			return $Service->html()->get();
		}
		else if (substr($name, 0, 7) == '@Theme/') {
			$Theme = \Phpfox_Template::instance()->theme()->get();
			$name = str_replace('@Theme/', '', $name);
			$file = $Theme->getPath() . $name;

			if (!file_exists($file)) {
				$file = PHPFOX_DIR . 'theme/default/html/' . $name;
			}

			$html = file_get_contents($file);

			return $html;
		}

		return parent::getSource($name);
	}
}