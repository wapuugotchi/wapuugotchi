<?php
/**
 * Contains classes for the shop menu.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Notification;

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
		echo '<div class="wrap"><div id="wapuugotchi-submenu__notification"></div></div>';
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
			'title'    => \__( 'Notification', 'wapuugotchi' ),
			'slug'     => 'wapuugotchi_notification',
			'callback' => 'Wapuugotchi\Notification\Menu::shop_page_template',
		);

		return $submenus;
	}
}
