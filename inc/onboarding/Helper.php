<?php
/**
 * The Onboarding Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding;

use Wapuugotchi\Onboarding\Handler\PageHandler;
use Wapuugotchi\Onboarding\Models\Guide;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Helper
 */
class Helper {

	/**
	 * The expected WordPress version.
	 *
	 * @var string
	 */
	const EXPECTED_WP_VERSION = '6.5';

	/**
	 * Get the next page path.
	 *
	 * @return string|null
	 */
	public static function get_next_page_path() {
		$next_data = PageHandler::get_next_tour_data();
		if ( empty( $next_data ) ) {
			return null;
		}

		if ( ! $next_data instanceof Guide ) {
			return null;
		}

		return $next_data->file;
	}

	/**
	 * Get the first tour step of the current page.
	 *
	 * @return string|null
	 */
	public static function get_first_index_of_current_page() {
		$item_list = self::get_current_page_item_list();
		if ( empty( $item_list ) ) {
			return false;
		}

		$keys = array_keys( $item_list );
		if ( count( $keys ) < 1 ) {
			return false;
		}

		return $keys[0];
	}

	/**
	 * Get a list of items for the current page.
	 *
	 * @return string|null
	 */
	public static function get_current_page_item_list() {
		$current_data = PageHandler::get_current_tour_data();
		if ( empty( $current_data ) ) {
			return null;
		}

		if ( ! $current_data instanceof Guide ) {
			return null;
		}

		return $current_data->item_list;
	}

	/**
	 * Check if the current version of WordPress is 6.5 or higher.
	 *
	 * @return bool
	 */
	public static function is_valid_version() {
		return version_compare( get_bloginfo( 'version' ), self::EXPECTED_WP_VERSION, '>=' );
	}
}
