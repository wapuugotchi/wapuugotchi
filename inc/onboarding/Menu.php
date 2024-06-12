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
	 * Add html starting point to quest menu page.
	 *
	 * @return void
	 */
	public static function onboarding_page_template() {
		echo '<div class="wrap"><div id="wapuugotchi-submenu__onboarding"></div></div>';
	}

	/**
	 * Adds a submenu page to the admin menu. The filter used is 'wapuugotchi_add_submenu'.
	 *
	 * @param array $submenus Submenu items.
	 *
	 * @return array
	 */
	public static function wapuugotchi_add_submenu( $submenus ) {
		$submenus[] = array(
			'title'    => \__( 'Tour', 'wapuugotchi' ),
			'slug'     => 'wapuugotchi__tour',
			'callback' => 'Wapuugotchi\Onboarding\Menu::onboarding_page_template',
		);

		return $submenus;
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
					admin_url( 'admin.php?page=wapuugotchi__tour&onboarding_mode=true' )
				);
				exit;
			}
		}
	}
}
