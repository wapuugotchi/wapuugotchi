<?php
/**
 * The Manager Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Hunt;

use Wapuugotchi\Hunt\Data\HuntData;
use Wapuugotchi\Hunt\Handler\AvatarHandler;
use Wapuugotchi\Hunt\Handler\HuntHandler;

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
	const GAME_ID = 'game__4ca5d813-e3dc-484d-b264-55aa1cbb59dd';

	/**
	 * "Constructor" of this Class
	 */
	public function __construct() {
		\add_action( 'load-toplevel_page_wapuugotchi', array( $this, 'init' ) );
	}

	/**
	 * Initialization Log
	 */
	public function init() {
		\add_filter( 'wapuugotchi_register_action__filter', array( $this, 'register_game' ) );
		//\add_filter( 'wapuugotchi_quiz__filter', array( HuntData::class, 'add_wp_hunt' ) );
		\add_action( 'wapuugotchi_mission__enqueue_scripts', array( $this, 'load_scripts' ) );
	}

	/**
	 * Load the scripts for the Hunt page.
	 *
	 * @param string $action The action to load the scripts for.
	 */
	public function load_scripts( $action ) {
		if ( self::GAME_ID !== $action ) {
			return;
		}

		$assets = include_once WAPUUGOTCHI_PATH . 'build/hunt.asset.php';
		\wp_enqueue_style( 'wapuugotchi-hunt', WAPUUGOTCHI_URL . 'build/hunt.css', array(), $assets['version'] );
		\wp_enqueue_script( 'wapuugotchi-hunt', WAPUUGOTCHI_URL . 'build/hunt.js', $assets['dependencies'], $assets['version'], true );

		\wp_add_inline_script(
			'wapuugotchi-hunt',
			\sprintf(
				"wp.data.dispatch('wapuugotchi/hunt').__initialize(%s)",
				\wp_json_encode(
					array(
						'avatar' => AvatarHandler::get_avatar(),
						//'data'   => HuntHandler::get_shuffled_quiz_array(),
					)
				)
			),
			'after'
		);

		\wp_set_script_translations( 'wapuugotchi-hunt', 'wapuugotchi', WAPUUGOTCHI_PATH . 'languages/' );
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
			'name'        => __( 'WordPress Hunt', 'wapuugotchi' ),
			'description' => __( 'How well do you really know your WordPress?', 'wapuugotchi' ),
		);

		return $games;
	}
}
