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
		\add_filter( 'wapuugotchi_add_submenu', array( Menu::class, 'wapuugotchi_add_submenu' ), 30 );
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
	 * @param string $hook_suffix The internal page name.
	 *
	 * @return void
	 */
	public function load_scripts() {
		$mission_data = MissionHandler::getMissionUserData();
		if ( empty( $mission_data ) || empty( $mission_data['id'] ) ) {
			$mission_data = MissionHandler::initMissionUserData();
			if ( empty( $mission_data ) ) {
				return;
			}
		}

		$mission = MissionHandler::getMissionById( $mission_data['id'] );
		if ( empty( $mission ) ) {
			return;
		}

		$assets = include_once WAPUUGOTCHI_PATH . 'build/mission.asset.php';
		\wp_enqueue_style( 'wapuugotchi-missions', WAPUUGOTCHI_URL . 'build/mission.css', array(), $assets['version'] );
		\wp_enqueue_script( 'wapuugotchi-missions', WAPUUGOTCHI_URL . 'build/mission.js', $assets['dependencies'], $assets['version'], true );

		\wp_add_inline_script(
			'wapuugotchi-missions',
			sprintf(
				"wp.data.dispatch('wapuugotchi/mission').__initialize(%s)",
				\wp_json_encode(
					array(
						'progress' => $mission_data['progress'],
						'markers' => $mission->markers,
						'reward' => $mission->reward,
						'description' => $mission->description,
						'map' => MapHandler::getMapById( $mission->id ),

						'nonce' => \wp_create_nonce( 'wapuugotchi' ),
						'ajaxurl' => \admin_url( 'admin-ajax.php' ),
					)
				)
			)
		);

		\wp_set_script_translations( 'wapuugotchi-missions', 'wapuugotchi', WAPUUGOTCHI_PATH . 'languages/' );
	}

}
