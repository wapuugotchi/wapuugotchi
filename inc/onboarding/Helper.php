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
	const NONCE_ACTION        = 'wapuugotchi_onboarding_mode';

	/**
	 * Get the next page path.
	 *
	 * @return string|null
	 */
	public static function get_next_page_path() {
		if ( self::get_mode() !== 'tour' ) {
			return null;
		}

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

	/**
	 * Create nonce for onboarding actions.
	 *
	 * @return string
	 */
	public static function get_nonce() {
		return wp_create_nonce( self::NONCE_ACTION );
	}

	/**
	 * Verify the onboarding nonce.
	 *
	 * @param string $nonce Nonce to verify.
	 *
	 * @return bool
	 */
	public static function is_valid_nonce( $nonce ) {
		return (bool) wp_verify_nonce( $nonce, self::NONCE_ACTION );
	}

	/**
	 * Get the current onboarding mode.
	 *
	 * @return string|null
	 */
	public static function get_mode() {
		$mode  = filter_input( INPUT_GET, 'onboarding_mode', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		$nonce = filter_input( INPUT_GET, 'onboarding_nonce', FILTER_SANITIZE_FULL_SPECIAL_CHARS );

		if ( empty( $mode ) ) {
			return null;
		}

		if ( empty( $nonce ) || ! self::is_valid_nonce( $nonce ) ) {
			return null;
		}

		return $mode;
	}
}
