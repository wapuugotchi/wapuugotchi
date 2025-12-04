<?php
/**
 * The Menu class of the Onboarding feature.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Menu
 */
class Menu {

	/**
	 * Adds a submenu item to the admin bar. The filter used is 'wapuugotchi_add_submenu'.
	 *
	 * @param array $items Submenu items.
	 *
	 * @return array
	 */
	public static function wapuugotchi_add_admin_bar_item( $items ) {

		$params = \filter_input_array( INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		if ( ! \is_array( $params ) ) {
			$params = array();
		}

		$params  = \array_merge(
			$params,
			array(
				'onboarding_mode'  => 'single',
				'onboarding_nonce' => Helper::get_nonce(),
			)
		);
		$items[] = array(
			'title' => __( 'Page Overview', 'wapuugotchi' ),
			'href'  => add_query_arg( $params, '' ),
			'meta'  => array(
				'class' => 'wapuugotchi_onboarding__admin-menu',
			),
		);

		$items[] = array(
			'title' => __( 'WordPress Journey', 'wapuugotchi' ),
			'href'  => add_query_arg(
				array(
					'onboarding_mode'  => 'tour',
					'onboarding_nonce' => Helper::get_nonce(),
				),
				'index.php'
			),
			'meta'  => array(
				'class' => 'wapuugotchi_onboarding__admin-menu',
			),
		);

		return $items;
	}

	/**
	 * Redirect to onboarding page if onboarding_mode is not set.
	 *
	 * @return void
	 */
	public static function force_redirect_to_dashboard() {
		global $current_screen;
		if ( isset( $current_screen->id ) && 'wapuugotchi_page_wapuugotchi__tour' === $current_screen->base ) {
			if ( ! filter_input( INPUT_GET, 'onboarding_mode', FILTER_SANITIZE_FULL_SPECIAL_CHARS ) ) {
				wp_safe_redirect(
					admin_url(
						add_query_arg(
							array(
								'onboarding_mode'  => 'tour',
								'onboarding_nonce' => Helper::get_nonce(),
							),
							'index.php'
						)
					)
				);
				exit;
			}
		}
	}
}
