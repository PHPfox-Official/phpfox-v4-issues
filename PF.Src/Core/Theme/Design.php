<?php

namespace Core\Theme;

class Design extends \Core\Model {
	private $_theme;
	private $_service;

	public function __construct(\Core\Theme\Object $Theme) {
		parent::__construct();

		$this->_theme = $Theme;
		$this->_service = new Service($this->_theme);
	}

	public function set($designs) {
		$less = $this->_service->css()->get(true);
		$css = $this->_service->css()->get();
		foreach ($designs as $key => $value) {
			$less = preg_replace('/\@' . $key . '\:(.*?);/i', '@' . $key . ': ' . $value . ';', $less);
		}

		return $this->_service->css()->set($css, $less);
	}

	public function get() {

		$less = $this->_service->css()->get(true);
		$design = [];
		foreach (explode("\n", $less) as $line) {
			$line = trim($line);
			if (empty($line)) {
				continue;
			}

			if (substr($line, 0, 7) == '@import') {
				continue;
			}

			if (substr($line, 0, 1) == '@') {
				// d($line);

				$parts = explode(':', $line);
				$var = trim(trim($parts[0]), '@');
				$sub = explode('//', (isset($parts[1]) ? trim($parts[1]) : ''));
				$value = rtrim(trim($sub[0]), ';');
				$title = (isset($sub[1]) ? trim($sub[1]) : $var);
				$subType = '';
				if (strpos($title, '|')) {
					list($title, $subType) = array_map('trim', explode('|', $title));
				}

				$type = '<input type="text" name="design[' . $var . ']" value="' . htmlspecialchars($value) . '">';
				if (substr($value, 0, 1) == '#' || $subType == 'color') {
					// $type = 'color';
					$type = '<input type="text" name="design[' . $var . ']" value="' . htmlspecialchars($value) . '" class="_colorpicker">';
					$type .= '<div class="_colorpicker_holder"></div>';
				}
				else if (substr($value, 0, 2) == '"\\') {
					// $type = 'font';
				}

				$design[] = [
					'var' => $var . ':',
					'value' => rtrim($value, ';'),
					'title' => $title,
					'type' => $type
				];
			}
			else if (substr($line, 0, 4) == '//==') {
				array_push($design, str_replace('//==', '', trim($line)));
			}
		}

		return $design;
	}
}