<?php
/**
 * The Missions Menu Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Mission;

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
	public static function missions_page_template() {
		echo '<div class="wrap"><div id="wapuugotchi-submenu__mission"></div></div>';
	}

	/**
	 * Add submenu for the quest log.
	 *
	 * @param array $submenus Array of quest objects.
	 *
	 * @return array
	 */
	public static function wapuugotchi_add_submenu( $submenus ) {
		$submenus[] = array(
			'title'    => \__( 'Missions', 'wapuugotchi' ),
			'slug'     => 'wapuugotchi',
			'callback' => 'Wapuugotchi\Mission\Menu::missions_page_template',
		);

		return $submenus;
	}
}
