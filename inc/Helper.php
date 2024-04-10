<?php
/**
 * The Helper Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Wapuugotchi;

use DateTime;
use DateTimeZone;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class Helper
 */
class Helper {

	const COLLECTION_API_URL   = 'https://api.wapuugotchi.com/collection';
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
	public static function get_rest_api() {
		$api      = get_rest_url( null, Api::REST_BASE );
		$find     = 'wp-json';
		$position = strpos( $api, $find );
		if ( false === $position ) {
			return $api;
		}

		return substr( $api, $position + strlen( $find ) );
	}

	/**
	 * Get the seconds who are left until tomorrow 00:00
	 *
	 * @return int
	 * @throws \Exception If something went wrong.
	 */
	public static function get_seconds_left_until_tomorrow() {
		$timezone = new DateTimeZone( wp_timezone_string() );

		$today    = new DateTime( 'now', $timezone );
		$tomorrow = new DateTime( 'tomorrow', $timezone );

		return $tomorrow->getTimestamp() - $today->getTimestamp();
	}

	public static function is_mobile_device() {
		$user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
		return ( strpos($user_agent, 'mobile') !== false || strpos($user_agent, 'android') !== false );
	}

	/**
	 * Get all wearable items.
	 *
	 * @return array
	 */
	public static function get_items() {
		$items = \get_transient( 'wapuugotchi_items' );
		if ( is_array( $items ) && ! empty( $items ) ) {
			return reset( $items );
		}

		return array();
	}
}
