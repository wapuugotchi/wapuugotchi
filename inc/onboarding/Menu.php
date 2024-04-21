<?php
/**
 * The QuestStart Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class Menu
 */
class Menu {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_add_submenu', array( $this, 'wapuugotchi_add_submenu' ), 30 );
		\add_action( 'current_screen', array( $this, 'force_redirect_to_dashboard' ) );

	}

	/**
	 * Initialization filter for QuestStart
	 *
	 * @param array $submenus Array of quest objects.
	 *
	 * @return array|Message[]
	 */
	public function wapuugotchi_add_submenu( $submenus ) {
		$submenus[] = array(
			'title'     => \__( 'Tour', 'wapuugotchi' ),
			'slug'      => 'wapuugotchi__tour',
			'callback'  => 'Wapuugotchi\Onboarding\Menu::onboarding_page_template'
		);

		return $submenus;
	}

	/**
	 * Add html starting point to quest manu page.
	 *
	 * @return void
	 */
	public static function onboarding_page_template() {
		echo '<div class="wrap"><div id="wapuugotchi-submenu__onboarding"></div></div>';
	}

	/**
	 * Redirect to onboarding page if onboarding_mode is not set.
	 *
	 * @return void
	 */
	public function force_redirect_to_dashboard() {
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
