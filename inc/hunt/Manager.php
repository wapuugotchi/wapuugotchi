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
		\add_action( 'rest_api_init', array( Api::class, 'create_rest_routes' ) );

		\add_action( 'admin_enqueue_scripts', array( $this, 'load_seek_scripts' ) );
	}

	/**
	 * Initialization Log
	 */
	public function init() {
		\add_filter( 'wapuugotchi_register_action__filter', array( $this, 'register_game' ) );
		\add_filter( 'wapuugotchi_hunt__filter', array( HuntData::class, 'add_wp_hunt' ) );
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

		$assets = include_once WAPUUGOTCHI_PATH . 'build/hide.asset.php';
		\wp_enqueue_style( 'wapuugotchi-hide', WAPUUGOTCHI_URL . 'build/hide.css', array(), $assets['version'] );
		\wp_enqueue_script( 'wapuugotchi-hide', WAPUUGOTCHI_URL . 'build/hide.js', $assets['dependencies'], $assets['version'], true );

		\wp_add_inline_script(
			'wapuugotchi-hide',
			\sprintf(
				"wp.data.dispatch('wapuugotchi/hunt').__initialize(%s)",
				\wp_json_encode(
					array(
						'avatar' => AvatarHandler::get_avatar(),
						'data'   => HuntHandler::get_current_hunt(),
						'nonces' => $this->get_nonces(),
					)
				)
			),
			'after'
		);

		\wp_set_script_translations( 'wapuugotchi-hunt', 'wapuugotchi', WAPUUGOTCHI_PATH . 'languages/' );
	}

	public function load_seek_scripts() {
		global $current_screen;
		$current_hunt = HuntHandler::get_current_hunt();

		if ( ! $current_hunt || ! isset( $current_hunt['started'] ) || ! isset( $current_hunt['page_name'] ) ) {
			return;
		}
		if ( $current_hunt['page_name'] !== $current_screen->id ) {
			return;
		}

		$assets = include_once WAPUUGOTCHI_PATH . 'build/seek.asset.php';
		\wp_enqueue_style( 'wapuugotchi-seek', WAPUUGOTCHI_URL . 'build/seek.css', array(), $assets['version'] );
		\wp_enqueue_script( 'wapuugotchi-seek', WAPUUGOTCHI_URL . 'build/seek.js', $assets['dependencies'], $assets['version'], true );

		\wp_add_inline_script(
			'wapuugotchi-seek',
			\sprintf(
				"wp.data.dispatch('wapuugotchi/hunt').__initialize(%s)",
				\wp_json_encode(
					array(
						'avatar' => AvatarHandler::get_avatar(),
						'data'   => $this->manipulate_hunt_data( $current_hunt ),
						'nonces' => $this->get_nonces(),
					)
				)
			),
			'after'
		);

		\wp_set_script_translations( 'wapuugotchi-hunt', 'wapuugotchi', WAPUUGOTCHI_PATH . 'languages/' );
	}

	private function manipulate_hunt_data( $data ) {
		$data['quest_text'] = \__( 'Well done! Mission completed!', 'wapuugotchi' );
		return $data;
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

	private function get_nonces() {
		return array(
			'wapuugotchi_hunt' => \wp_create_nonce( 'wapuugotchi_hunt' ),
			'wapuugotchi_seek' => \wp_create_nonce( 'wapuugotchi_seek' ),
		);
	}
}
