<?php

if(!defined('ABSPATH')) { exit; }

if(!function_exists('gb_deep_access')) {
	/**
	 * Given an array of object, retrieve a key value (if available) using a period-delimited key string.
	 *
	 * @param object|array $data The data to access a property of.
	 * @param string|array $keys The period-delimited key string or an equivalent array.
	 * @param mixed $default The default value to return. Optional.
	 * @return mixed The value of the property if it exists and the default value otherwise.
	 */
	function gb_deep_access($data, $keys, $default = null) {
		$data = is_object($data) ? get_object_vars($data) : $data;
		$keys = is_array($keys) ? $keys : (is_string($keys) ? explode('.', $keys) : []);

		if(empty($keys)) { return $data; }

		$curr = array_shift($keys);

		if(is_array($data) && isset($data[$curr])) { return gb_deep_access($data[$curr], $keys, $default); }

		return $default;
	}
}

if(!function_exists('gb_get_ipaddress')) {
	/**
	 * Uses the `GB__CONF__ADDRESS_KEYS` constant to locate the user's IP address.
	 *
	 * @return string|bool The visitor's IP address or false if one cannot be found.
	 */
	function gb_get_ipaddress() {
		$keys = array_filter(array_map('trim', explode(',', GB__CONF__ADDRESS_KEYS)));

		foreach($keys as $key) {
			if(isset($_SERVER[$key])) { return $_SERVER[$key]; }
		}

		return false;
	}
}

if(!function_exists('gb_redirect')) {
	/**
	 * Wrapper function for wp_redirect which exits after redirecting.
	 *
	 * @param string $url The url to redirect to.
	 * @param int $code The status code to send with redirection. Optional.
	 * @return void
	 */
	function gb_redirect($url, $code = 302) {
		do_action('gb_redirect', $url, $code);

		wp_redirect($url, $code);

		exit;
	}
}
