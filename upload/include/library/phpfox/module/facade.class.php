<?php

/**
 * Class Phpfox_Module_Facade
 *
 * @api
 * @method Theme_Service_Style_Style theme_style()
 */
class Phpfox_Module_Facade {
	public function __call($method, $args) {
		$method = str_replace('_', '.', $method);
		return Phpfox::getService($method);
	}
}