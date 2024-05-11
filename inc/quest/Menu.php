<?php
/**
 * The QuestStart Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Quest;

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
	public static function quests_page_template() {
		echo '<div class="wrap"><div id="wapuugotchi-submenu__quests"></div></div>';
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
			'title'    => \__( 'Quest Log', 'wapuugotchi' ),
			'slug'     => 'wapuugotchi__quests',
			'callback' => 'Wapuugotchi\Quest\Menu::quests_page_template',
		);

		return $submenus;
	}
}
