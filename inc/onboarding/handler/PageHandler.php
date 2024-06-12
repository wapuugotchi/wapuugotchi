<?php
/**
 * The Onboarding Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding\Handler;

use Wapuugotchi\Onboarding\Models\Guide;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class PageHandler
 */
class PageHandler {
	/**
	 * Get the onboarding order.
	 *
	 * @return void
	 */
	public static function load_tour_files() {
		$data = \apply_filters( 'wapuugotchi_onboarding_tour_files', array() );

		if ( ! is_array( $data ) ) {
			return;
		}

		foreach ( $data as $class ) {
			if ( class_exists( $class ) ) {
				new $class();
			}
		}
	}

	/**
	 * Get current onboarding step.
	 *
	 * @return Guide|null
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
		$tour = \wp_cache_get( 'wapuugotchi_onboarding__tour' );

		if ( ! empty( $tour ) ) {
			return $tour;
		}

		$tour = \apply_filters( 'wapuugotchi_onboarding_filter', array() );

		if ( empty( $tour ) ) {
			return null;
		}

		\wp_cache_set( 'wapuugotchi_onboarding__tour', $tour );

		return $tour;
	}

	/**
	 * Get the previous onboarding step.
	 *
	 * @return mixed|null
	 */
	public static function get_previous_tour_data() {
		global $current_screen;
		$tour = self::get_tour_data();
		if ( empty( $tour ) ) {
			return null;
		}

		$previous = null;
		foreach ( $tour as $data ) {
			if ( ! $data instanceof Guide ) {
				continue;
			}

			if ( $data->page === $current_screen->id ) {
				break;
			}

			$previous = $data;
		}

		return $previous;
	}

	/**
	 * Get the next onboarding step.
	 *
	 * @return mixed|null
	 */
	public static function get_next_tour_data() {
		global $current_screen;
		$tour = self::get_tour_data();
		if ( empty( $tour ) ) {
			return null;
		}

		$found = false;
		foreach ( $tour as $data ) {
			if ( ! $data instanceof Guide ) {
				continue;
			}

			if ( $found ) {
				return $data;
			}

			if ( $data->page === $current_screen->id ) {
				$found = true;
			}
		}

		return null;
	}
}
