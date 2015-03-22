<?php

namespace Core\View;

class Functions {
	private $_method;

	public function __construct($method) {
		$this->_method = $method;
	}

	public function __toString() {
		switch($this->_method) {
			case 'nav':
				\Phpfox::getBlock('core.template-menu');
				break;
			case 'content':
				$this->_loadBlocks(2);
				\Phpfox_Module::instance()->getControllerTemplate();
				$this->_loadBlocks(4);
				break;
			case 'top':
				$this->_loadBlocks(11);
				echo '<div class="_block_search">';
				\Phpfox_Template::instance()->getLayout('search');
				echo '</div>';
				$this->_loadBlocks(7);
				break;
			case 'left':
				$this->_loadBlocks(1);
				break;
			case 'right':
				$this->_loadBlocks(3);
				break;
		}

		return '';
	}

	private function _loadBlocks($location) {
		$blocks = \Phpfox_Module::instance()->getModuleBlocks($location);
		foreach ($blocks as $block) {
			\Phpfox::getBlock($block);
		}
	}
}