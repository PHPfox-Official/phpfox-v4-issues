<?php

namespace Core\View;

class Functions {
	private $_method;

	public function __construct($method) {
		$this->_method = $method;
	}

	public function __toString() {
		$Template = \Phpfox_Template::instance();

		switch($this->_method) {
			case 'nav':
				\Phpfox::getBlock('feed.form2', ['menu' => true]);
				\Phpfox::getBlock('core.template-notification');
				\Phpfox::getBlock('core.template-menu');
				break;
			case 'content':
				// $this->_loadBlocks(2);
				\Phpfox_Module::instance()->getControllerTemplate();
				// $this->_loadBlocks(4);
				break;
			case 'top':
				// $this->_loadBlocks(11);
				$Template->getLayout('search');
				// $this->_loadBlocks(7);
				break;
			/*
			case 'left':
				$this->_loadBlocks(1);
				break;
			case 'right':
				$this->_loadBlocks(3);
				break;
			*/
			case 'logo':
				\Phpfox::getBlock('core.template-logo');
				break;
			case 'breadcrumb':
				$Template->getLayout('breadcrumb');
				break;
			case 'title':
				echo $Template->getTitle();
				break;
			case 'h1':
				list($breadcrumbs, $title) = $Template->getBreadCrumb();
				if (count($title)) {
					echo '<h1><a href="' . $title[1] . '">' . \Phpfox_Parse_Output::instance()->clean($title[0]) . '</a></h1>';
				}
				break;
		}

		return '';
	}
}