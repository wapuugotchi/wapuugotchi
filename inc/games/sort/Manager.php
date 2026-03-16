<?php
/**
 * The Manager Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Sort;

use Wapuugotchi\Sort\Data\SortData;
use Wapuugotchi\Sort\Handler\AvatarHandler;
use Wapuugotchi\Sort\Handler\SortHandler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Manager
 */
class Manager {
	/**
	 * The Game ID
	 */
	const GAME_ID = 'game__b4f7e2a9-3d61-4c8e-9f5b-2a0d7c1e8f34';

	/**
	 * "Constructor" of this Class
	 */
	public function __construct() {
		// Check if the Wapuugotchi Mission Feature exists. This is necessary because "sort" is a pure mission extension.
		if ( ! \class_exists( 'Wapuugotchi\Mission\Menu' ) ) {
			return;
		}

		\add_action( 'load-toplevel_page_wapuugotchi', array( $this, 'init' ) );
	}

	/**
	 * Initialization
	 */
	public function init() {
		\add_filter( 'wapuugotchi_register_action__filter', array( $this, 'register_game' ) );
		\add_filter( 'wapuugotchi_sort__filter', array( SortData::class, 'add_wp_sort' ) );
		\add_action( 'wapuugotchi_mission__enqueue_scripts', array( $this, 'load_scripts' ) );
	}

	/**
	 * Load the scripts for the Sort page.
	 *
	 * @param string $action The action to load the scripts for.
	 */
	public function load_scripts( $action ) {
		if ( self::GAME_ID !== $action ) {
			return;
		}

		$assets = include_once WAPUUGOTCHI_PATH . 'build/sort.asset.php';
		\wp_enqueue_style( 'wapuugotchi-sort', WAPUUGOTCHI_URL . 'build/sort.css', array(), $assets['version'] );
		\wp_enqueue_script( 'wapuugotchi-sort', WAPUUGOTCHI_URL . 'build/sort.js', $assets['dependencies'], $assets['version'], true );

		\wp_add_inline_script(
			'wapuugotchi-sort',
			\sprintf(
				"wp.data.dispatch('wapuugotchi/sort').__initialize(%s)",
				\wp_json_encode(
					array(
						'avatar' => AvatarHandler::get_avatar(),
						'data'   => SortHandler::get_shuffled_sort_array(),
					)
				)
			),
			'after'
		);

		\wp_set_script_translations( 'wapuugotchi-sort', 'wapuugotchi', WAPUUGOTCHI_PATH . 'languages/' );
	}

	/**
	 * Register the Game
	 *
	 * @param array $games The games array.
	 *
	 * @return array
	 */
	public function register_game( $games ) {
		$games[] = array(
			'id'          => self::GAME_ID,
			'name'        => __( 'WordPress Sort', 'wapuugotchi' ),
			'description' => __( 'Sort WordPress concepts into the correct order.', 'wapuugotchi' ),
		);

		return $games;
	}
}
