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

	/**
	 * Add the admin bar item for the mission.
	 *
	 * @param array $items The items to add to the admin bar.
	 *
	 * @return array
	 */
	public static function wapuugotchi_add_admin_bar_item( $items ) {
		$params  = \array_merge( $_GET, array( 'wapuugotchi_mission' => 'reset' ) );
		$items[] = array(
			'title' => \__( 'Reset Mission', 'wapuugotchi' ),
			'href'  => add_query_arg( $params, '' ),
			'meta'  => array(
				'class' => 'wapuugotchi_mission__reset',
			),
			'sub'   => true,
		);

		return $items;
	}
}
