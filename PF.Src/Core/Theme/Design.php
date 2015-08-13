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

		$replacements = [
			'containerMaxWidthFull' => 'Container Width',
			'contentWidth' => 'Main Content Width',
			'lineHeightComputed' => 'Line Height Computed',
			'transition' => 'CSS Transitions',
			'borderRadiusBase' => 'Border Radius',
			'boxShadow' => 'Box Shadow',
			'linkColor' => 'Link Color',
			'linkHoverColor' => 'Link Color on Hover',
			'linkHoverDecoration' => 'Link Decoration',
			'linkFocus' => 'Important Link Color',
			'linkFocusHover' => 'Important Link Color on Hover',
			'brandPrimary' => 'Primary Brand Background',
			'brandPrimaryColor' => 'Primary Brand Color',
			'brandSuccess' => 'On Success Background Color',
			'brandInfo' => 'Info Background Color',
			'brandWarning' => 'Warning Background Color',
			'brandDanger' => 'Danger Background Color',
			'columnLeftWidth' => 'Secondary Panel Width',
			'columnWidth' => 'Main Panel Width',
			'navBg' => 'Navigation Background Color',
			'navColor' => 'Navigation Text Color',
			'navWidth' => 'Navigation Width',
			'headerBg' => 'Header Background Color',
			'headerColor' => 'Header Text Color',
			'headerHeight' => 'Header Height',
			'headerFontSize' => 'Header Font Size',
			'blockBg' => 'Block Background Color',
			'blockColor' => 'Block Text Color',
			'blockRadius' => 'Border Radius',
			'blockMarginBottom' => 'Margin Bottom',
			'blockBoxShadow' => 'Box Shadow',
			'blockBoxShadowLight' => '(light version) Box Shadow',
			'blockTitleBg' => 'Header Background Color',
			'blockTitlePadding' => 'Header Padding',
			'blockTitleColor' => 'Header Text Color',
			'blockTitleSize' => 'Header Font Size',
			'blockContentPadding' => 'Content Padding',
			'blockContentSize' => 'Content Font Size',
			'formBg' => 'Background Color',
			'formColor' => 'Text Color',
			'formBorder' => 'Border',
			'hoverCategories' => 'Hover on categories?'
		];

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
				preg_match('/^@([a-zA-Z0-9]+): (.*);(.*)$/is', $line, $matches);
				$matches = array_map('trim', $matches);
				if (!isset($matches[3])) {
					continue;
				}

				// $var = trim(trim($parts[0]), '@');
				$var = $matches[1];
				// $sub = explode('//', (isset($parts[1]) ? trim($parts[1]) : ''));
				// $value = rtrim(trim($sub[0]), ';');
				$value = $matches[2];
				// $title = (isset($sub[1]) ? trim($sub[1]) : $var);
				if (isset($matches[3])) {
					$matches[3] = str_replace('//', '', $matches[3]);
				}
				$title = (empty($matches[3]) ? $var : $matches[3]);

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

				if (substr($line, 0, 8) == '@logoUrl') {
					// $info = str_replace('// Logo', '', trim($parts[1]));
					$title = 'Logo';
					$type = '<input type="text" name="design[' . $var . ']" value="' . htmlspecialchars($value) . '">';
					$type .= '<div class="design-uploader">';
					$type .= '<i class="fa fa-upload"></i>';
					$type .= '<input type="file" name="image" class="ajax_upload" data-url="' . \Phpfox_Url::instance()->makeUrl('admincp.theme.manage', ['id' => $this->_theme->theme_id, 'logo' => 'upload']) . '" />';
					$type .= '</div>';
				}

				foreach ($replacements as $_key => $_value) {
					$title = preg_replace('/^' . $_key . '$/i', $_value, $title);
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