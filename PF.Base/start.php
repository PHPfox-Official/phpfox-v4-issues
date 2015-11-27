<?php
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: index.php 7004 2013-12-20 14:23:28Z Raymond_Benc $ 
 */

if (version_compare(phpversion(), '5.4', '<') === true)
{
	exit('PHPfox 4 or higher requires PHP 5.4 or newer.');
}

ob_start();

if (!defined('PHPFOX')) {
	define('PHPFOX', true);
	define('PHPFOX_DS', DIRECTORY_SEPARATOR);
	define('PHPFOX_DIR', dirname(__FILE__) . PHPFOX_DS);
	define('PHPFOX_START_TIME', array_sum(explode(' ', microtime())));
}

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
	exit('Dependencies for PHPfox missing. Make sure to run composer first.');
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'DELETE') {
	parse_str(file_get_contents('php://input'), $_REQUEST);
}

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/include/init.inc.php');

/**
 * @param $element
 * @return \Core\jQuery
 */
function j($element) {
	return new \Core\jQuery($element);
}

function param($key) {
	return Phpfox::getParam($key);
}

function setting($key, $default = null) {
	$Setting = new \Core\Setting();
	return $Setting->get($key, $default);
}

/**
 * @param null $key
 * @param null $default
 * @param null $userGroupId
 * @return \Api\User\Object|\Api\User\Object[]
 * @throws Exception
 */
function user($key = null, $default = null, $userGroupId = null) {
	if ($key === null) {
		return (new \Api\User())->get(\Phpfox::getUserId());
	}

	$Setting = new \Core\User\Setting();
	return $Setting->get($key, $default, $userGroupId);
}

function phrase() {
	$Reflect = (new ReflectionClass('Phpfox_Locale'))->newInstanceWithoutConstructor();

	return call_user_func_array([$Reflect, 'phrase'], func_get_args());
}

function _p() {
	return call_user_func_array(['Core\Phrase', 'get'], func_get_args());
}

function error() {
	$Reflect = (new ReflectionClass('Core\Exception'))->newInstanceWithoutConstructor();

	return call_user_func_array([$Reflect, 'toss'], func_get_args());
}

if (!defined('PHPFOX_NO_RUN')) {
	try {
		(new Core\App());

		Phpfox::run();
	} catch (\Exception $e) {

		if (\Core\Route\Controller::$isApi) {
			http_response_code(400);
			$content = [
				'error' => [
					'message' => $e->getMessage()
				]
			];
			header('Content-type: application/json');
			echo json_encode($content, JSON_PRETTY_PRINT);
			exit;
		}

		if (PHPFOX_IS_AJAX_PAGE || Phpfox_Request::instance()->get('is_ajax_post')) {
			header('Content-type: application/json');

			$msg = $e->getMessage();
			if (Phpfox_Request::instance()->get('is_ajax_post')) {
				$msg = '<div class="error_message">' . $msg . '</div>';
			}
			echo json_encode([
				'error' => $msg
			]);
			exit;
		}

		header('Content-type: text/html');

		if (!PHPFOX_DEBUG) {
			new Core\Route('*', function(Core\Controller $controller) {
				http_response_code(400);

				return $controller->render('@Base/layout.html', [
					'content' => '<div class="error_message">Something went wrong here. We have notified the village elders about the issue.</div>'
				]);
			});

			if (($View = (new Core\Route\Controller())->get())) {
				echo $View->getContent();
			}

			exit;
		}

		throw new Exception($e->getMessage(), $e->getCode(), $e);
	}
}