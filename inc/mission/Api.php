<?php
/**
 * The Api Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Mission;

use Wapuugotchi\Mission\Handler\ActionHandler;
use Wapuugotchi\Mission\Handler\MissionHandler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Api
 */
class Api {

	/**
	 * The rest base path to the WapuuGotchi API.
	 */
	const REST_BASE = 'wapuugotchi/v1';

	/**
	 * Register all API endpoints.
	 *
	 * @return void
	 */
	public static function create_rest_routes() {
		\register_rest_route(
			self::REST_BASE,
			'/mission/set_completed',
			array(
				'methods'             => 'POST',
				'callback'            => array( self::class, 'set_completed' ),
				'permission_callback' => array( self::class, 'set_completed_permissions' ),
			)
		);
	}

	/**
	 * Permissions check.
	 *
	 * @return bool
	 */
	public static function set_completed_permissions() {
		return \is_user_logged_in();
	}

	public static function set_completed() {
		MissionHandler::raise_mission_step();
		return rest_ensure_response(
			new \WP_REST_Response(
				array(),
				200
			)
		);

	}
}
