<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 * @method put($file, $name = null)
 * @method remove($file)
 * @method getServerId()
 * @method getUrl($path)
 * @method setServerId()
 */
class Phpfox_Cdn {
	private static $_object;

	/**
	 * @return Phpfox_Cdn
	 */
	public static function instance() {
		return Phpfox::getLib('cdn');
	}

	public function &getInstance() {
		return $this;
	}

	public function __call($method, $args) {
		if (!self::$_object) {
			self::$_object = \Core\Event::trigger('lib_phpfox_cdn');
		}

		if (is_object(self::$_object)) {
			return call_user_func_array([self::$_object, $method], $args);
		}
	}
}