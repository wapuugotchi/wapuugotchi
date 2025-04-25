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

		$params  = \array_merge( $_GET, array( 'onboarding_mode' => 'single' ) );
		$items[] = array(
			'title' => __( 'Page Overview', 'wapuugotchi' ),
			'href'  => add_query_arg( $params, '' ),
			'meta'  => array(
				'class' => 'wapuugotchi_onboarding__admin-menu',
			),
		);

		$items[] = array(
			'title' => __( 'WordPress Journey', 'wapuugotchi' ),
			'href'  => 'index.php?onboarding_mode=tour',
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
			if ( ! isset( $_GET['onboarding_mode'] ) ) {
				wp_safe_redirect(
					admin_url( 'index.php?onboarding_mode=tour' )
				);
				exit;
			}
		}
	}
}
