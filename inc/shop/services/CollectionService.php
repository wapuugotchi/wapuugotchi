<?php
/**
 * The Api Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Shop\Services;

use DateTime;
use DateTimeZone;
use Exception;
use function get_transient;
use function is_wp_error;
use function set_transient;
use function wp_remote_get;
use function wp_remote_retrieve_body;
use function wp_timezone_string;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class CollectionService
 */
class CollectionService {
	const COLLECTION_API_URL  = 'https://api.wapuugotchi.com/collection';
	const ITEM_LIST_TRANSIENT = 'wapuugotchi_collection__alpha';

	/**
	 * Get the collection from the transient or fetch it from the remote server.
	 *
	 * @return mixed
	 * @throws Exception When the timezone is invalid.
	 */
	public static function get_collection() {
		$config = get_transient( self::ITEM_LIST_TRANSIENT );
		if ( false === $config ) {
			$config = self::fetch_and_store_collection();
		}

		return $config;
	}

	/**
	 * Fetches the collection from the remote server and stores it as a transient.
	 *
	 * @return bool Success or failure of the operation.
	 * @throws Exception When the timezone is invalid.
	 */
	private static function fetch_and_store_collection() {
		$response = wp_remote_get( self::COLLECTION_API_URL );

		if ( is_wp_error( $response ) ) {
			return false;
		}

		$body = wp_remote_retrieve_body( $response );
		if ( empty( $body ) ) {
			return false;
		}

		$config = json_decode( $body, true );
		if ( empty( $config ) || ! is_array( $config ) ) {
			return false;
		}

		if ( empty( $config['collections'] ) ) {
			return false;
		}

		set_transient( self::ITEM_LIST_TRANSIENT, $config['collections'], self::get_seconds_left_until_tomorrow() );

		return $config['collections'];
	}

	/**
	 * Get the seconds remaining until tomorrow 00:00.
	 *
	 * @return int The number of seconds until midnight.
	 * @throws Exception When the timezone is invalid.
	 */
	private static function get_seconds_left_until_tomorrow() {
		$timezone = new DateTimeZone( wp_timezone_string() );

		$current_date_time  = new DateTime( 'now', $timezone );
		$midnight_date_time = new DateTime( 'tomorrow midnight', $timezone );

		return $midnight_date_time->getTimestamp() - $current_date_time->getTimestamp();
	}
}
