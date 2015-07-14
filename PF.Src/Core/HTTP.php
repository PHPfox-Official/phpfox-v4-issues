<?php

namespace Core;

/**
 * Class HTTP
 * @package Core
 *
 * @method HTTP get()
 * @method HTTP post()
 * @method HTTP delete()
 * @method HTTP head()
 */
class HTTP {
	private $_data;
	private $_headers;
	private $_auth;
	private $_url;
	private $_method;
	private $_params = [];
	private $_replace = [];

	public function __construct($url) {
		$this->_url = $url;
	}

	public function header($key, $value) {
		$this->_headers[] = $key . ': ' . $value;

		return $this;
	}

	public function auth($user, $password) {
		$this->_auth = [$user, $password];

		return $this;
	}

	public function using($params) {
		$this->_params = array_merge($params, $this->_params);

		return $this;
	}

	public function each(callable $callback) {
		$response = $this->send();
		if (is_array($response) || is_object($response)) {
			$return = '';
			$returnArray = [];
			foreach ($response as $key => $value) {
				$callbackReturn = call_user_func($callback, $key, $value);
				if (is_string($callbackReturn)) {
					$return .= $callbackReturn;
				}
				else {
					$returnArray[] = $callbackReturn;
				}
			}

			if (count($returnArray)) {
				return $returnArray;
			}

			return $returnArray;
		} else {
			throw Error($response);
		}

		return [];
	}

	public function send() {

		$url = $this->_url;
		if (count($this->_replace)) {
			$url = vsprintf($url, $this->_replace);
		}

		if (!is_array($this->_params)) {
			$this->_params = [$this->_params];
		}
		$post = http_build_query($this->_params);

		$curl_url = (($this->_method == 'GET' && !empty($post)) ? $url . (strpos($url, '?') ? '&' : '?') . ltrim($post, '&') : $url);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $curl_url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		if ($this->_method != 'GET' || $this->_method != 'POST') {
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->_method);
		}

		if ($this->_headers) {
			curl_setopt($curl, CURLOPT_HTTPHEADER, $this->_headers);
		}

		if ($this->_auth) {
			curl_setopt($curl, CURLOPT_USERPWD, $this->_auth[0] . ':' . $this->_auth[1]);
		}

		curl_setopt($curl, CURLOPT_TIMEOUT, 10);

		if ($this->_method != 'GET') {
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
		}

		$this->_data = curl_exec($curl);

		// var_dump($this->_data); exit;

		curl_close($curl);

		$data = trim($this->_data);
		if (substr($data, 0, 1) == '{' || substr($data, 0, 1) == '[') {
			$data = json_decode($data);
			if (isset($data->error)) {
				// throw Error($data->error);
				\Phpfox_Error::set($data->error);
			}
		}

		return $data;
	}

	/**
	 * @param $method
	 * @param $url
	 * @return HTTP
	 */
	public function call($method) {
		$this->_method = $method;

		return $this->send();
	}

	public function __call($method, $args) {
		if (count($args) > 1) {
			unset($args[0]);
			foreach ($args as $key => $value) {
				$this->_replace[] = $value;
			}
		}

		$this->_method = strtoupper($method);

		return $this->send();
	}
}