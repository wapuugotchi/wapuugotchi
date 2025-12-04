<?php
/**
 * Support menu and page template.
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
	 * Add html starting point to the support submenu page.
	 *
	 * @return void
	 */
	public static function support_page_template() {
		echo '<div class="wrap"><div id="wapuugotchi-submenu__support"></div></div>';
	}

	/**
	 * Add submenu entry for the support page.
	 *
	 * @param array $submenus Array of submenus.
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
