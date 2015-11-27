<?php

if (!function_exists('memory_get_usage')) {
	function memory_get_usage() {}
}

if (function_exists('get_magic_quotes_runtime') && get_magic_quotes_runtime()) {
	if (preg_match('/5\.3\.(.*)/i', PHP_VERSION)) {
		ini_set('magic_quotes_runtime', 0);
	}
	else
	{
		set_magic_quotes_runtime(0);
	}
}

/**
 * Multibyte encoding fallback functions
 *
 * The PHP multibyte encoding extension is not enabled by default. In cases where it is not enabled,
 * these functions provide a fallback.
 *
 * Borrowed from MediaWiki, under the GPLv2. Thanks!
 */
if ( !function_exists( 'mb_strlen' ) ) {
	/**
	 * Fallback implementation of mb_strlen, hardcoded to UTF-8.
	 * @param string $str
	 * @param string $enc optional encoding; ignored
	 * @return int
	 */
	function mb_strlen( $str, $enc = '' ) {
		$counts = count_chars( $str );
		$total = 0;

		// Count ASCII bytes
		for( $i = 0; $i < 0x80; $i++ ) {
			$total += $counts[$i];
		}

		// Count multibyte sequence heads
		for( $i = 0xc0; $i < 0xff; $i++ ) {
			$total += $counts[$i];
		}
		return $total;
	}
}

if ( !function_exists( 'mb_strpos' ) ) {
	/**
	 * Fallback implementation of mb_strpos, hardcoded to UTF-8.
	 * @param $haystack String
	 * @param $needle String
	 * @param $offset String: optional start position
	 * @param $encoding String: optional encoding; ignored
	 * @return int
	 */
	function mb_strpos( $haystack, $needle, $offset = 0, $encoding = '' ) {
		$needle = preg_quote( $needle, '/' );

		$ar = array();
		preg_match( '/' . $needle . '/u', $haystack, $ar, PREG_OFFSET_CAPTURE, $offset );

		if( isset( $ar[0][1] ) ) {
			return $ar[0][1];
		} else {
			return false;
		}
	}
}

if ( !function_exists( 'mb_strrpos' ) ) {
	/**
	 * Fallback implementation of mb_strrpos, hardcoded to UTF-8.
	 * @param $haystack String
	 * @param $needle String
	 * @param $offset String: optional start position
	 * @param $encoding String: optional encoding; ignored
	 * @return int
	 */
	function mb_strrpos( $haystack, $needle, $offset = 0, $encoding = '' ) {
		$needle = preg_quote( $needle, '/' );

		$ar = array();
		preg_match_all( '/' . $needle . '/u', $haystack, $ar, PREG_OFFSET_CAPTURE, $offset );

		if( isset( $ar[0] ) && count( $ar[0] ) > 0 &&
			isset( $ar[0][count( $ar[0] ) - 1][1] ) ) {
			return $ar[0][count( $ar[0] ) - 1][1];
		} else {
			return false;
		}
	}
}