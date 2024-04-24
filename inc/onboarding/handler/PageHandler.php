<?php
/**
 * The Onboarding Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding\Handler;

use Wapuugotchi\Onboarding\Models\Guide;
use function apply_filters;
use function wp_cache_get;
use function wp_cache_set;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class PageHandler
 */
class PageHandler {
	/**
	 * Get the onboarding order.
	 *
	 * @return array The onboarding order.
	 */
	public static function load_tour_files() {

		$data = apply_filters( 'wapuugotchi_onboarding_tour_files', array() );
		if ( ! is_array( $data ) ) {
			return false;
		}

		foreach ( $data as $class ) {
			if ( class_exists( $class ) ) {
				new $class();
			}
		}

		return $data;
	}

	/**
	 * Get current onboarding step.
	 */
	public static function get_current_tour_data() {
		global $current_screen;
		$tour = self::get_tour_data();
		if ( empty( $tour ) ) {
			return null;
		}

		foreach ( $tour as $data ) {
			if ( ! $data instanceof Guide ) {
				continue;
			}

			if ( $data->page !== $current_screen->id ) {
				continue;
			}

			return $data;
		}

		return null;
	}

	/**
	 * Get global onboarding data.
	 *
	 * @return mixed|null The onboarding data.
	 */
	public static function get_tour_data() {
		$tour = wp_cache_get( 'wapuugotchi_onboarding__quests' );

		if ( ! empty( $tour ) ) {
			return $tour;
		}

		$tour = apply_filters( 'wapuugotchi_onboarding_filter', array() );

		wp_cache_set( 'wapuugotchi_onboarding__quests', $tour );

		if ( empty( $tour ) ) {
			return null;
		}

		return $tour;
	}

	public static function get_last_tour_data() {
		global $current_screen;
		$tour = self::get_tour_data();
		if ( empty( $tour ) ) {
			return null;
		}

		$last = null;
		foreach ( $tour as $data ) {
			if ( ! $data instanceof Guide ) {
				continue;
			}

			if ( $data->page === $current_screen->id ) {
				break;
			}

			$last = $data;
		}

		return $last;
	}

	/**
	 * Get the next onboarding step.
	 */
	public static function get_next_tour_data() {
		global $current_screen;
		$tour = self::get_tour_data();
		if ( empty( $tour ) ) {
			return null;
		}
		$next  = null;
		$found = false;
		foreach ( $tour as $data ) {
			if ( ! $data instanceof Guide ) {
				continue;
			}

			if ( $found ) {
				$next = $data;
				break;
			}

			if ( $data->page === $current_screen->id ) {
				$found = true;
			}
		}

		return $next;
	}
}
