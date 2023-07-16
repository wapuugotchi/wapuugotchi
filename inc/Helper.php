<?php

namespace Wapuugotchi\Wapuugotchi;

use DateTime;
use DateTimeZone;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

class Helper
{
	const COLLECTION_API_URL = 'https://api.wapuugotchi.com/collection';
	const COLLECTION_STRUCTURE = array(
		'fur'   => '',
		'balls' => '',
		'caps'  => '',
		'items' => '',
		'coats' => '',
		'shoes' => '',
	);

	/**
	 * Formats the REST API url
	 *
	 * @return string
	 */
	static function get_rest_api() {
		$api      = get_rest_url( null, Api::REST_BASE );
		$find     = 'wp-json';
		$position = strpos( $api, $find );
		if ( $position === false ) {
			return $api;
		}

		return substr( $api, $position + strlen( $find ) );
	}

	static function getSecondsLeftUntilTomorrow() {
		$timezone = new DateTimeZone( wp_timezone_string() );

		$today = new DateTime('now', $timezone);
		$tomorrow = new DateTime('tomorrow', $timezone);

		return $tomorrow->getTimestamp() - $today->getTimestamp();
	}

	static function get_items () {
		$items = \get_transient( 'wapuugotchi_items' );
		return reset($items);
	}
}


