<?php

namespace Core\View;

class Functions {
	private $_method;
	private $_extra;

	public function __construct($method, $extra = null) {
		$this->_method = $method;
		$this->_extra = $extra;
	}

	public function __toString() {

		try {
			$Template = \Phpfox_Template::instance();

			switch($this->_method) {
				case 'search':
					\Phpfox::getBlock('search.panel');
					break;
				case 'footer':
					\Phpfox::getBlock('core.template-menufooter');
					break;
				case 'share':
					\Phpfox::getBlock('feed.form2', ['menu' => true]);
					break;
				case 'notify':
					\Phpfox::getBlock('core.template-notification');
					break;
				case 'menu':
					\Phpfox::getBlock('core.template-menu');
					break;
				case 'sticky_bar':
					\Phpfox::getBlock('core.template-notification');
					break;
				case 'menu_sub':
					\Phpfox::getBlock('core.template-menusub');
					break;
				case 'breadcrumb_menu':
					\Phpfox::getBlock('core.template-breadcrumbmenu');
					break;
				case 'nav':
					\Phpfox::getBlock('feed.form2', ['menu' => true]);
					\Phpfox::getBlock('core.template-notification');
					\Phpfox::getBlock('core.template-menu');
					break;
				case 'content':
					$isSearch = (\Phpfox_Request::instance()->get('page') ? true : false);
					if ($isSearch && PHPFOX_IS_AJAX_PAGE) {
						\Phpfox_Module::instance()->getControllerTemplate();
						$content = ob_get_contents(); ob_clean();
						return $content;
					}

					if (!PHPFOX_IS_AJAX_PAGE) {
						echo '<div class="_block_' . $this->_method . '">';
					}
					$this->_loadBlocks(2);
					if ($this->_extra) {
						echo $this->_extra;
					}
					else {
						try {
							\Phpfox_Module::instance()->getControllerTemplate();
						} catch (\Exception $e) {
							exit($e->getMessage());
						}
					}
					$this->_loadBlocks(4);
					if (!PHPFOX_IS_AJAX_PAGE) {
						echo '</div>';
					}
					if (PHPFOX_IS_AJAX_PAGE) {
						$content = ob_get_contents(); ob_clean();
						return $content;
					}
					break;
				case 'location_1':
					$this->_loadBlocks(1);
					break;
				case 'location_2':
					$this->_loadBlocks(2);
					break;
				case 'location_3':
					$this->_loadBlocks(3);
					break;
				case 'location_4':
					$this->_loadBlocks(4);
					break;
				case 'location_5':
					$this->_loadBlocks(5);
					break;
				case 'location_6':
					$this->_loadBlocks(6);
					break;
				case 'location_7':
					$this->_loadBlocks(7);
					break;
				case 'location_8':
					$this->_loadBlocks(8);
					break;
				case 'location_9':
					$this->_loadBlocks(9);
					break;
				case 'location_10':
					$this->_loadBlocks(10);
					break;
				case 'location_11':
					$this->_loadBlocks(11);
					break;
				case 'location_12':
					$this->_loadBlocks(12);
					break;
				case 'main_top':
					if (!PHPFOX_IS_AJAX_PAGE) {
						echo '<div class="_block_top">';
					}
					$Template->getLayout('search');
					if (!PHPFOX_IS_AJAX_PAGE) {
						echo '</div>';
					}

					$this->_loadBlocks(7);
					break;
				case 'top':
					$this->_loadBlocks(11);
					if (!PHPFOX_IS_AJAX_PAGE) {
						echo '<div class="_block_top">';
					}
					$Template->getLayout('search');
					if (!PHPFOX_IS_AJAX_PAGE) {
						echo '</div>';
					}

					$this->_loadBlocks(7);
					break;
				case 'errors':
					$Template->getLayout('error');
					break;
				case 'left':
					$this->_loadBlocks(1);
					break;
				case 'right':
					$this->_loadBlocks(3);
					break;
				case 'logo':
					\Phpfox::getBlock('core.template-logo');
					break;
				case 'breadcrumb':
					if (!PHPFOX_IS_AJAX_PAGE) {
						echo '<div class="_block_' . $this->_method . '">';
					}
					$Template->getLayout('breadcrumb');
					if (!PHPFOX_IS_AJAX_PAGE) {
						echo '</div>';
					}
					break;
				case 'title':
					echo $Template->getTitle();
					break;
				case 'h1':
					if (!PHPFOX_IS_AJAX_PAGE) {
						echo '<div class="_block_' . $this->_method . '">';
					}
					list($breadcrumbs, $title) = $Template->getBreadCrumb();
					if (count($title)) {
						echo '<h1><a href="' . $title[1] . '">' . \Phpfox_Parse_Output::instance()->clean($title[0]) . '</a></h1>';
					}
					if (!PHPFOX_IS_AJAX_PAGE) {
						echo '</div>';
					}
					break;
			}

		} catch (\Exception $e) {
			register_shutdown_function(function() use($e) {
				ob_clean();
				throw new \Exception($e->getMessage(), $e->getCode(), $e);
			});
		}

		return '';
	}

	private function _loadBlocks($location) {
		if (\Phpfox_Template::instance()->bIsSample) {
			echo '<div class="block_sample" onclick="window.parent.$(\'#location\').val(' . $location . '); window.parent.js_box_remove(window.parent.$(\'.js_box\').find(\'.js_box_content\')[0]);">[Block: ' . $location . ']</div>';
			return;
		}

		echo '<div class="_block location_'.$location.'" data-location="' . $location . '">';
		if ($location == 3) {
			echo \Phpfox_Template::instance()->getSubMenu();
		}
		$blocks = \Phpfox_Module::instance()->getModuleBlocks($location);

		foreach ($blocks as $block) {
			if (!is_string($block)) {
				$obj = null;
				if (isset($block['object']) && isset($block['callback'])) {
					$obj = $block['object'];
					if ($obj instanceof \Core\Block) {
						$html = call_user_func($block['callback'], $obj);
					}
				}

				if ($obj === null && is_array($block)) {
					$html = $block[0];
				}

				if (empty($html)) {
					$html = '
					<div class="block">
						' . ($obj->get('title') ? '<div class="title">' . $obj->get('title') . '</div>' : '') . '
						<div class="content">
							' . $obj->get('content') . '
						</div>
					</div>
					';
				}

				echo $html;
			}
			else {
				\Phpfox::getBlock($block);
			}
		}
		echo '</div>';
	}
}