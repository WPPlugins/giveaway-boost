<?php

if(!defined('ABSPATH')) { exit; }

if(!function_exists('gb_get_date')) {
	/**
	 * Returns a DateTime object with the appropriate DateTimeZone for the current site.
	 *
	 * @param string|int|DateTime $datetime The date to transform into a DateTime object. If
	 * an int is passed, it is treated as a timestamp. If a DateTime object is passed, it is
	 * cloned and set to the correct timezone. Otherwise, the argument is passed to the
	 * DateTime constructor. If null is passed, the current DateTime is returned. Optional.
	 * @return DateTime A DateTime object with the appropriate DateTimezone set for the current site.
	 */
	function gb_get_date($datetime = null) {
		$timezone = gb_get_timezone();

		if($datetime instanceof \DateTime) {
			$datetime_tz = clone $datetime;
			$datetime_tz = $datetime_tz->setTimezone($timezone);
		} else if(is_int($datetime)) {
			$datetime_tz = gb_get_date();
			$datetime_tz = $datetime_tz->setTimestamp($datetime);
		} else {
			// We set the Timezone twice just in case a timezone is
			// provided as part of the $datetime string
			$datetime_tz = new \DateTime($datetime, $timezone);
			$datetime_tz = $datetime_tz->setTimezone($timezone);
		}

		return $datetime_tz;
	}
}

if(!function_exists('gb_get_timezone')) {
	/**
	 * Based on the current site's settings, returns a DateTimeZone object representing the
	 * site's current timezone.
	 *
	 * @return DateTimeZone The current site's timezone.
	 */
	function gb_get_timezone() {
		try {
			$timezone_string = get_option('timezone_string');
			$timezone_string = in_array($timezone_string, timezone_identifiers_list()) ? $timezone_string : 'UTC';

			$timezone = new DateTimeZone($timezone_string);
		} catch(Exception $e) {
			$timezone = new DateTimeZone('UTC');
		}

		return $timezone;
	}
}
