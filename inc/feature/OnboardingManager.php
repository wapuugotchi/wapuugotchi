<?php
/**
 * The Quest Manager Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class QuestManager
 */
class OnboardingManager {


	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
	}

	/**
	 * Get page specific tour data submitted using the filter.
	 *
	 * @return bool|mixed|null
	 */
	public static function get_page_data( $page = null ) {
		if ( empty( $page ) ) {
			return null;
		}
		$onboarding = self::get_global_data();

		if ( empty( $onboarding ) ) {
			return null;
		}

		foreach ( $onboarding as $key => $value ) {

			if ( $value->page !== $page ) {
				unset( $onboarding[ $key ] );
			}
		}

		// TODO - merge all the onboarding data into one array. consider the priority of the data and level of the single onboarding data information.
		return json_decode( wp_json_encode( $onboarding[0] ), true );
	}

	public static function get_global_data() {
		$onboarding = wp_cache_get( 'wapuugotchi_onboarding' );

		if ( ! empty( $onboarding ) ) {
			return $onboarding;
		}

		$onboarding = apply_filters( 'wapuugotchi_onboarding_filter', array() );

		wp_cache_set( 'wapuugotchi_quests', $onboarding );

		return $onboarding[0];
	}
}
