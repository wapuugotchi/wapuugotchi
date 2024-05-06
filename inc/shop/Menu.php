<?php
/**
 * The QuestStart Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Shop;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Menu
 */
class Menu {

	/**
	 * Add html starting point to customizer manu page.
	 *
	 * @return void
	 */
	public static function shop_page_template() {
		echo '<div class="wrap"><div id="wapuugotchi-submenu__shop"></div></div>';
	}

	/**
	 * Initialization filter for QuestStart
	 *
	 * @param array $submenus Array of quest objects.
	 *
	 * @return array|Message[]
	 */
	public static function wapuugotchi_add_submenu( $submenus ) {
		$submenus[] = array(
			'title'    => \__( 'Shop', 'wapuugotchi' ),
			'slug'     => 'wapuugotchi',
			'callback' => 'Wapuugotchi\Shop\Menu::shop_page_template',
		);

		return $submenus;
	}
}
