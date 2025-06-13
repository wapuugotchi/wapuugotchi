<?php
/**
 * The Support Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Support;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Menu
 */
class Menu {

	/**
	 * Add html starting point to customizer menu page.
	 *
	 * @return void
	 */
	public static function support_page_template() {
		echo '<div class="wrap"><div id="wapuugotchi-submenu__support"></div></div>';
	}

	/**
	 * Add submenu for the support.
	 *
	 * @param array $submenus Array of quest objects.
	 *
	 * @return array
	 */
	public static function wapuugotchi_add_submenu( $submenus ) {
		$submenus[] = array(
			'title'    => \__( 'Support', 'wapuugotchi' ),
			'slug'     => 'wapuugotchi__support',
			'callback' => 'Wapuugotchi\Support\Menu::support_page_template',
		);

		return $submenus;
	}
}
