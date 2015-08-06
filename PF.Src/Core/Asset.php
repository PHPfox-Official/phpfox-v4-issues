<?php

namespace Core;

class Asset {
	public function __construct($assets) {
		if (!is_array($assets)) {
			$assets = [$assets];
		}

		foreach ($assets as $asset) {
			if (substr($asset, 0, 7) == '@static') {
				\Phpfox_Template::instance()->delayedHeaders[] = [str_replace('@static/', '', $asset) => 'static_script'];
			}
			else {
				\Phpfox_Template::instance()->setHeader($asset);
			}
		}
	}
}