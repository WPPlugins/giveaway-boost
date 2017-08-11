<?php

if(!defined('ABSPATH')) { exit; }

if(!function_exists('gb_get_csv')) {
	/**
	 * Given a set of headers and a multi-dimensional array of data, format the output as a CSV using the given
	 * field and line delimiters.
	 *
	 * @param array $headers A single dimensions array of ordered header names. Pass false to not include headers.
	 * @param array $data A multi dimensional array of arrays containing the data to use.
	 * @param string $field_delimiter A string to use as between fields in a row. Defaults to ','. Optional.
	 * @param string $line_delimiter A string to use between rows. Defaults to "\n". Optional.
	 * @return string A string containing the CSV output.
	 */
	function gb_get_csv($headers, $data, $field_delimiter = ',', $line_delimiter = "\n") {
		$columns_count = is_array($headers) ? count($headers) : (isset($data[0]) && is_array($data[0]) ? count($data[0]) : 0);

		$rows = is_array($headers) ? array_merge(array($headers), $data) : $data;
		$rows = array_map(function($row) use($columns_count, $field_delimiter) {
			$row = array_slice($row, 0, $columns_count);

			return implode($field_delimiter, array_map(function($field) {
				return sprintf('"%s"', str_replace(array('"', "\n"), array('""', "\r\n"), $field));
			}, $row));
		}, $rows);

		return implode($line_delimiter, $rows);
	}
}

if(!function_exists('gb_send_csv')) {
	/**
	 * Given a filename, a set of headers, and an array of data, send the headers and content
	 * required to download the data in CSV form.
	 *
	 * @param string $filename The name of the file to be sent.
	 * @param array $headers A single dimensional array of header names (e.g. ['Column 1', 'Column 2', 'Column 3', 'Column 4']).
	 * @param array $data A multi dimensional array of arrays containing the data to export. Arrays in excess length of provided headers will be trimmed.
	 * @return void
	 */
	function gb_send_csv($filename, $headers, $data) {
		$outs     = gb_get_csv($headers, $data, "\t", "\n");
		$encoding = function_exists('mb_convert_encoding') ? 'UTF-16LE' : 'UTF-8';

		if(function_exists('mb_convert_encoding')) {
			// UTF-16LE BOM
			$outs = chr(255) . chr(254) . mb_convert_encoding($outs, 'UTF-16LE', 'UTF-8');
		} else {
			// UTF-8 BOM
			$outs = "\xEF\xBB\xBF" . $outs;
		}

		header("Content-Encoding: {$encoding}");
		header("Content-Type: text/csv; charset={$encoding}");
		header(sprintf('Content-Disposition: attachment; filename="%s.csv"', str_replace('"', '\"', $filename)));
		header('Pragma: no-cache');
		header('Expires: 0');

		echo $outs;

		exit;
	}
}
