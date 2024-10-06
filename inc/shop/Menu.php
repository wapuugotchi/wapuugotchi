<?php
/**
 * Contains classes for the shop menu.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Shop;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Adds a new submenu to the Wapuugotchi menu.
 */
class Menu {

	/**
	 * Add html starting point to customizer menu page.
	 *
	 * @return void
	 */
	public static function shop_page_template() {
		echo '<div class="wrap"><div id="wapuugotchi-submenu__shop"></div></div>';
	}

	/**
	 * Is used by the Manager class to add the submenu to the Wapuugotchi menu.
	 *
	 * @param array $submenus Array of submenus.
	 *
	 * @return array
	 */
	public static function wapuugotchi_add_submenu( $submenus ) {
		$submenus[] = array(
			'title'    => \__( 'Shop', 'wapuugotchi' ),
			'slug'     => 'wapuugotchi__shop',
			'callback' => 'Wapuugotchi\Shop\Menu::shop_page_template',
		);

		return $submenus;
	}
}
