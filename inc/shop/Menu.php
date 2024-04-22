<?php
/**
 * The QuestStart Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Shop;

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
		\add_filter( 'wapuugotchi_add_submenu', array( $this, 'wapuugotchi_add_submenu' ), 10 );
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
			'title'    => \__( 'Shop', 'wapuugotchi' ),
			'slug'     => 'wapuugotchi',
			'callback' => 'Wapuugotchi\Shop\Menu::shop_page_template',
		);

		return $submenus;
	}

	/**
	 * Add html starting point to customizer manu page.
	 *
	 * @return void
	 */
	public static function shop_page_template() {
		echo '<div class="wrap"><div id="wapuugotchi-submenu__shop"></div></div>';
	}
}
