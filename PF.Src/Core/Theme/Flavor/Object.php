<?php

namespace Core\Theme\Flavor;

class Object extends \Core\Objectify {
	public $style_id;
	public $name;
	public $folder;
	public $is_selected = false;
	public $image;
	public $theme_name;

	private $_theme;
	private $_db;

	public function __construct(\Core\Theme\Object $Theme, $keys) {
		parent::__construct($keys);


		$this->theme_name = $Theme->name;
		$this->_theme = $Theme;
		$this->_db = new \Core\Db();

		$currentImage = $this->image;
		$this->image = new \Core\Objectify(function() use ($currentImage) {

			// class="image_load" data-src="{$theme.image}"
			$html = '';
			if ($currentImage) {
				$html = 'class="image_load" data-src="' . $currentImage . '"';
			}
			else {
				$hex = function($color) {
					$color = trim($color);
					$color = preg_replace('/(lighten|darken)\(\#(.*), (.*)\)/i', '#\\2', $color);

					return '<span style="background:' . $color . ';"></span>';
				};

				// $flavor = (new \Core\Theme\Flavor($this))->getDefault();
				$path = $this->_theme->getPath() . 'flavor/' . $this->folder . '.less';
				if (file_exists($path)) {
					$colors = [];
					$lines = file($path);
					foreach ($lines as $line) {
						// p($line);
						if (preg_match('/@brandPrimary\:(.*?);/s', $line, $matches)) {
							$colors[] = $hex($matches[1]);
						}
						else if (preg_match('/@bodyBg\:(.*?);/s', $line, $matches)) {
							$colors[] = $hex($matches[1]);
						}
						else if (preg_match('/@blockBg\:(.*?);/s', $line, $matches)) {
							$colors[] = $hex($matches[1]);
						}
						else if (preg_match('/@headerBg\:(.*?);/s', $line, $matches)) {
							$colors[] = $hex($matches[1]);
						}
					}

					if ($colors) {
						$colors = implode('', $colors);
						$html = '><div class="theme_colors">' . $colors . '<' . "/div";
					}
				}
			}

			return $html;
		});
	}

	public function delete() {
		$file = $this->_theme->getPath() . 'flavor/';
		@unlink($file . $this->folder . '.less');
		@unlink($file . $this->folder . '.css');
		$this->_db->delete(':theme_style', ['style_id' => $this->style_id]);
	}

	public function __toArray() {

	}
}