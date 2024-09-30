<?php
/**
 * The Missions Manager Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Mission;

use Wapuugotchi\Mission\Data\Missions;
use Wapuugotchi\Mission\Handler\MissionHandler;
use Wapuugotchi\Mission\Handler\MapHandler;

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
		\add_filter( 'wapuugotchi_add_submenu', array( Menu::class, 'wapuugotchi_add_submenu' ), 5 );
		\add_action( 'rest_api_init', array( Api::class, 'create_rest_routes' ) );
		\add_action( 'load-toplevel_page_wapuugotchi', array( $this, 'init' ), 100 );
	}

	/**
	 * Initialization log
	 */
	public function init() {
		\add_filter( 'wapuugotchi_mission_filter', array( Missions::class, 'add_wapuugotchi_filter' ), 10, 1 );
		\add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );
	}

	/**
	 * Load Scripts
	 */
	public function load_scripts() {
		// Get the user data.
		$user_data = MissionHandler::get_user_data();

		// If the user data is not valid or the mission is locked, initialize a new mission.
		// If the mission is locked, the mission will be initialized tomorrow.
		if ( ! MissionHandler::validate_user_data( $user_data ) && false === MissionHandler::is_mission_locked( $user_data ) ) {
			$user_data = MissionHandler::init_mission();
		}

		$mission = MissionHandler::get_mission_by_id( $user_data['id'] );
		if ( empty( $mission ) ) {
			return null;
		}

		$progress = max( $user_data['progress'], 0 );
		$action   = $user_data['actions'][ $progress ] ?? '';
		$svg      = MapHandler::get_map_svg_by_id( $mission->id );

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
						'markers'     => \count( $mission->markers ),
						'reward'      => $mission->reward,
						'description' => $mission->markers[ $user_data['progress'] ] ?? '',
						'map'         => MapHandler::get_map_svg_by_id( $mission->id ),
						'action'      => $action,
						'nonce_list'  => $this->get_nonces(),
						'completed'   => false,
					)
				)
			),
			'after'
		);

		\wp_set_script_translations( 'wapuugotchi-missions', 'wapuugotchi', WAPUUGOTCHI_PATH . 'languages/' );

		// set an entrypoint to load the script of the selected action (for example minigames).
		do_action( 'wapuugotchi_mission__enqueue_scripts', $action );
	}

	/**
	 * Get Nonces
	 *
	 * @return array
	 */
	private function get_nonces() {
		return array(
			'wapuugotchi_mission' => \wp_create_nonce( 'wapuugotchi_mission' ),
			'wapuugotchi_balance' => \wp_create_nonce( 'wapuugotchi_balance' ),
		);
	}
}
