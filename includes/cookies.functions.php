<?php

if(!function_exists('gb_getcookie')) {
	/**
	 * Wrapper function around the $_COOKIE super global which appreopriately deserializes the value if necessary.
	 *
	 * @param string $name The name of the cookie.
	 * @param mixed $default The default value if the cookie doesn't exist.
	 * @return mixed The value of the cookie.
	 */
	function gb_getcookie($name, $default = false) {
		$value = isset($_COOKIE[$name]) ? maybe_unserialize(stripslashes($_COOKIE[$name])) : $default;

		return apply_filters('gb_getcookie', $value);
	}
}

if(!function_exists('gb_setcookie')) {
	/**
	 * Wrapper function for `setcookie` which uses the appropriate path and domain values.
	 *
	 * @param string $name The name of the cookie.
	 * @param string $value The value of the cookie.
	 * @param int $expire The time the cookie expires.
	 * @return bool Return value of setcookie.
	 */
	function gb_setcookie($name, $value, $expire) {
		$value = maybe_serialize($value);

		return apply_filters('gb_setcookie', setcookie($name, $value, $expire, COOKIEPATH, COOKIE_DOMAIN));
	}
}
