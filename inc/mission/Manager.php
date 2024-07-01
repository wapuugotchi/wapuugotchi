<?php
/**
 * The Missions Manager Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Mission;

use Wapuugotchi\Mission\Data\Missions;
use Wapuugotchi\Mission\Handler\ActionHandler;
use Wapuugotchi\Mission\Handler\MissionHandler;
use Wapuugotchi\Mission\Handler\MapHandler;
use Wapuugotchi\Mission\Api;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Log
 */
class Manager {

	/**
	 * "Constructor" of this Class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_add_submenu', array( Menu::class, 'wapuugotchi_add_submenu' ), 30 );
		\add_action( 'rest_api_init', array( Api::class, 'create_rest_routes' ) );
		\add_action( 'load-wapuugotchi_page_wapuugotchi__mission', array( $this, 'init' ), 100 );
	}

	/**
	 * Initialization Log
	 */
	public function init() {
		\add_filter( 'wapuugotchi_mission_filter', array( Missions::class, 'add_wapuugotchi_filter' ), 10, 1 );
		\add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );
	}

	/**
	 * Initialization Manager
	 *
	 * @return void
	 */
	public function load_scripts() {
		$user_data = MissionHandler::get_user_data();
		if ( ! MissionHandler::validate_user_data( $user_data ) ) {
			$user_data = MissionHandler::init_mission();
		}

		$mission = MissionHandler::get_mission_by_id( $user_data['id'] );
		if ( empty( $mission ) ) {
			return null;
		}

		$progress = max( $user_data['progress'], 0 );
		$action = $user_data['actions'][ $progress ] ?? '';
		$svg = MapHandler::get_map_svg_by_id( $mission->id );

		$assets = include_once WAPUUGOTCHI_PATH . 'build/mission.asset.php';
		\wp_enqueue_style( 'wapuugotchi-missions', WAPUUGOTCHI_URL . 'build/mission.css', array(), $assets['version'] );
		\wp_enqueue_script( 'wapuugotchi-missions', WAPUUGOTCHI_URL . 'build/mission.js', $assets['dependencies'], $assets['version'], true );
		\wp_add_inline_script(
			'wapuugotchi-missions',
			sprintf(
				"wp.data.dispatch('wapuugotchi/mission').__initialize(%s)",
				\wp_json_encode(
					array(
						'progress'    => $user_data['progress'],
						'locked'      => MissionHandler::is_mission_locked( $user_data ),
						'markers'     => $mission->markers,
						'reward'      => $mission->reward,
						'description' => $mission->description,
						'map'         => MapHandler::get_map_svg_by_id( $mission->id ),
						'action'      => $action,
						'nonce_list'  => $this->get_nonces(),
					)
				)
			),
			'after'
		);

		\wp_set_script_translations( 'wapuugotchi-missions', 'wapuugotchi', WAPUUGOTCHI_PATH . 'languages/' );

		// set an entrypoint to load the script of the selected action (for example minigames).
		do_action( 'wapuugotchi_mission__enqueue_scripts', $action );

	}

	private function get_nonces() {
		return array(
			'wapuugotchi_mission' => \wp_create_nonce( 'wapuugotchi_mission' ),
		);

	}
}
